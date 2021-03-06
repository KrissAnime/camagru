<?php

require_once('../config/setup.php');
require_once('../config/verify.php');

if (!isset($_SESSION)){
    session_start();
}

if (isset($_POST['sticker_2']) && !empty($_POST['sticker_2']) && isset($_POST['main_image']) && !empty($_POST['main_image'])){
    $type_1 = substr($_POST['sticker_2'], -3, 3);
    $type_2 = substr($_POST['main_image'], -3, 3);

    if (strcmp($type_1, "png")){
        $src = imagecreatefromjpeg('../stickers_borders/'.$_POST['sticker_2']);
    }
    else{
        $src = imagecreatefrompng('../stickers_borders/'.$_POST['sticker_2']);
    }
    $user_id = $_SESSION['current'];
    $enc = "d7cz5j7";
    $file_name = getRandomWord(strlen($enc));

    $check = substr($_POST['main_image'], 0, 5);
    if (!strcmp($check, "data:")){
        $base_to_php = explode(',', $_POST['main_image']);
            // the 2nd item in the base_to_php array contains the content of the image
        $data = base64_decode($base_to_php[1]);
        // here you can detect if type is png or jpg if you want
        $filepath = "../images/image.jpg"; // or image.jpg

        // Save the image in a defined path
        file_put_contents($filepath,$data);
        $_POST['main_image'] = "images/image.jpg";
        // echo $_POST['main_image'];
        // imagecopy($dest, $src, 0, 0, 0, 0, 800, 800);
    }
    // echo $check;
    
    if (strcmp($type_2, "png")){
        $dest = imagecreatefromjpeg('../'.$_POST['main_image']);
        $main = "png";
    }
    else{
        $dest = imagecreatefrompng('../'.$_POST['main_image']);
        $main = "jpg";
    }
    imagecopy($dest, $src, 0, 0, 0, 0, 1200, 1200);

    $profile = md5($user_id.$enc.$file_name).'.'.$main;

    if ($main == "png"){
        imagepng($dest, '../images/'.$profile);
    }
    else{
        imagejpeg($dest, '../images/'.$profile);
    }
    imagedestroy($dest);
    if (!strcmp($_POST['main_image'], "images/image.jpg")){
        unlink('../images/image.jpg');
    }
    
    if (!empty($user_id)){
        $sql = $con->prepare("SELECT * FROM `camagru`.`users`");
        $sql->execute();
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        
        $val = $sql->fetchAll();
        
        $username = "";
        foreach($val as $row){
            if ($row['user_id'] === $user_id){
                $username = $row['username'];
                break ;
            }
        }
        
        if (!empty($username)) {
            
            $sql = $con->prepare("SELECT * FROM `camagru`.`images`");
            $sql->execute();
            $sql->setFetchMode(PDO::FETCH_ASSOC);
            
            $clear = 1;
            $val = $sql->fetchAll();
            foreach($val as $row){
                if ($row['user_id'] === $user_id && $row['img_name'] === $profile){
                    $clear = 0;
                    break ;
                }
            }
            
            if ($clear) {
                try {
                    $sql = "INSERT INTO `camagru`.`images` (`user_id`, `img_name`, `edited`)
                    VALUES ('".$user_id."', '".$profile."', 1)";
                    $con->exec($sql);
                    echo "Upload Success!";

                }
                catch(PDOException $e) {
                    echo "Connection failed: " . $e->getMessage();
                }
            }
            else {
                echo "An image with that name already exists";
            }
            header('Location: ../index.php');
        }
    }
}
else{
    header('Location: ../editing.php');
}

?>