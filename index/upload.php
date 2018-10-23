<?php
require_once('../setup/install.php');
session_start();

if(isset($_FILES['image'])){
    $errors= array();
    $file_name = $_FILES['image']['name'];
    $file_size = $_FILES['image']['size'];
    $file_tmp = $_FILES['image']['tmp_name'];
    $file_type = $_FILES['image']['type'];
    $file_ext = strtolower(end(explode('.',$_FILES['image']['name'])));
    
    $ext = array("jpeg","jpg","png");
    
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
            
            $profile = md5($username.$file_name).'.'.$file_ext;
            if (!empty($username)) {
                //echo $user_id;
                
                $sql = $con->prepare("SELECT * FROM `camagru`.`images`");
                $sql->execute();
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                
                $val = $sql->fetchAll();
                
                $clear = 1;
                foreach($val as $row){
                    if ($row['user_id'] === $user_id && $row['img_name'] === $profile){
                        $clear = 0;
                        break ;
                    }
                }
                
                if ($clear) {
                    $sql = "INSERT INTO `camagru`.`images` (`user_id`, `img_name`)
                            VALUES ('".$user_id."', '".$profile."')";
                    $con->exec($sql);
                    move_uploaded_file($file_tmp, "../images/".$profile);
                    echo "Upload Success!";
                }
                else {
                    echo "An image with that name already exists";
                }
                
            }
        }
        else {
            header('Location: ../profile/login.php');
        }
    }
    else{
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