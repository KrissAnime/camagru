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