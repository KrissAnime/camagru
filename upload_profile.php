<?php

require('header.php');
require('menu_bar.php');
require_once('config/setup.php');
// session_start();

if(isset($_FILES['image'])){
    $errors= array();
    $file_name = $_FILES['image']['name'];
    $file_size = $_FILES['image']['size'];
    $file_tmp = $_FILES['image']['tmp_name'];
    $file_type = $_FILES['image']['type'];
    $file_ext = strtolower(end(explode('.',$_FILES['image']['name'])));

    $enc = "d7cz5j7";
    $ext = array("jpeg","jpg","png");

    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $_FILES['image']['tmp_name']);
    if ($mime != 'image/jpeg' && $mime != 'image/png') {
        $errors[] = "extension not allowed, please choose a JPEG, JPG or PNG file.";
    }

    finfo_close($finfo);

    if(in_array($file_ext,$ext) === false){
        $errors[]="extension not allowed, please choose a JPEG, JPG or PNG file.";
    }

    if($file_size > 4194304){
        $errors[]='File size must not be greater than 4 MB';
    }

    if(empty($errors) === true){
        $user_id = $_SESSION['current'];

        if (!empty($user_id)){
            $con = new PDO("mysql:host=".$admin_server, $admin_name, $admin_password);
            $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

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

            $profile = md5($user_id.$enc.$file_name).'.'.$file_ext;

            if (!empty($username)) {
                try {
                    $sql = "UPDATE `camagru`.`users`
                    SET `profile` = '".$profile."'
                    WHERE `camagru`.`users`.`user_id` = '".$user_id."'";
                    $con->exec($sql);
                    move_uploaded_file($file_tmp, "images/profile/".$profile);
                    echo "Upload Success!";
                    header('Location: profile.php');
                }
                catch(PDOException $e) {
                    echo "Connection failed: " . $e->getMessage();
                }
            }
        }
        else {
            header('Location: login.php');
        }
    }
    else {
        foreach ($errors as $error) {
            echo $error."<br/>";
        }
    }
}
?>

<html>
<body>
<form action="" method="POST" enctype="multipart/form-data">
<input type="file" name="image" />
<input type="submit"/>
</form>

</body>
</html>
