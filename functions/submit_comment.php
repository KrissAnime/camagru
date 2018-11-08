<?php

require_once('../config/setup.php');

if (!isset($_SESSION)){
    session_start();
}
if (isset($_SESSION['current'])){
    if (isset($_SESSION['logged']) && $_SESSION['logged'] && $_SESSION['logged'] === "user" || $_SESSION['logged'] === "admin"){
        if (strlen($_POST['user_comment']) <= 400){
            $comment = $_POST['user_comment'];
            $user_id = $_SESSION['current'];
            $img_id = $_POST['modal_img_name'];

            $stmt = $con->prepare("INSERT INTO `camagru`.`comments` (user_id, img_name, comment) 
            VALUES (:user_id, :img_name, :comment)");
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':img_name', $img_id);
            $stmt->bindParam(':comment', $comment);
            $stmt->execute();
            
            echo "success";
            return (1);
        }
    }
}
else{
    echo "login";
    return (0);
}

?>