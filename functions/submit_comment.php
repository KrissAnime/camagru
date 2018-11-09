<?php

require_once('../config/setup.php');

if (!isset($_SESSION)){
    session_start();
}
if (isset($_SESSION['current']) && isset($_POST['user_comment']) && !empty($_POST['user_comment']) && isset($_POST['img_name']) && !empty($_POST['img_name'])){
    if (strlen($_POST['user_comment']) <= 400){
        $comment = $_POST['user_comment'];
        $user_id = $_SESSION['current'];
        $img_name = $_POST['img_name'];
        
        $stmt = $con->prepare("INSERT INTO `camagru`.`comments` (user_id, img_name, comment) 
        VALUES (:user_id, :img_name, :comment)");
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':img_name', $img_name);
        $stmt->bindParam(':comment', $comment);
        $stmt->execute();

        $sql = $con->prepare("SELECT `user_id` FROM `camagru`.`images` WHERE `img_name` = :img_name");
        $sql->bindParam('img_name', $img_name);
        $sql->execute();
    
        $val = $sql->fetchAll();
    
        $user_id2 = $val[0]['user_id'];
    
        $sql = $con->prepare("SELECT `email` FROM `camagru`.`users` WHERE `user_id` = :user_id2");
        $sql->bindParam('user_id2', $user_id2);
        $sql->execute();
        $val = $sql->fetchAll();
    
        $email = $val[0]['email'];
        
        $sql = $con->prepare("SELECT `username` FROM `camagru`.`users` WHERE `user_id` = :user_id");
        $sql->bindParam('user_id', $user_id);
        $sql->execute();
        $val = $sql->fetchAll();
    
        $username = $val[0]['username'];

        $receiver = $email;
        $subject = 'Camagru Email Notification';
        $message = $username.' commented on a picture you uploaded: '.$comment.'

KrissAdmin Camagru.';
        $header = 'From: no-reply@krissadmin.camagru';
        mail($receiver, $subject, $message);


        
        $sql = $con->prepare("SELECT * FROM `camagru`.`comments` WHERE `img_name` = :img_name");
        $sql->bindParam('img_name', $img_name);
        $sql->execute();
        $val = $sql->fetchAll();
        
        $output = "";
        foreach ($val as $row){
            $user_id = $row['user_id'];
            $sql = $con->prepare("SELECT `username` FROM `camagru`.`users` WHERE `user_id` = :user_id");
            $sql->bindParam('user_id', $user_id);
            $sql->execute();
            $users = $sql->fetchAll();

            $name = $users[0]['username'];
            $comment = $row['comment'];
            $date = $row['date'];
            $output .= "<div id='comment_list'>";
            $output .= "<div id='comment_name'>".$name."  ".$date."</div>";
            $output .= "<p id='comment'>$comment</p></div>";
        }
        echo $output;
        return (1);
    }
    echo "too_long";
    return (1);
}
else{
    echo "empty";
    return (0);
}

?>