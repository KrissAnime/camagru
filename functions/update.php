<?php

require_once('../config/setup.php');
require_once('../config/verify.php');

if (!isset($_SESSION)){
    session_start();
    
}

$user_id = $_SESSION['current'];
    // print_r($_SESSION);
    // echo $_POST['username'];
    // echo "empty";
    if (isset($_POST['email']) && !empty($_POST['email'])){
        $email = $_POST['email'];
        $username = $_POST['username'];
        if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === $_POST['email']){
            $subject = 'Camagru Email Verification';
            $message = 'Copy the following link into your url: '.'http://localhost:8080/camagru/functions/update.php?verify=';
            verify_email($email, $subject, $message);
            $stmt = $con->prepare("UPDATE `camagru`.`users` SET `verified` = 0 WHERE `user_id` = :user_id");
            $stmt->bindParam(':user_id', $user_id);
            $stmt->execute();
        }
    }
    if (isset($_POST['password']) && !empty($_POST['password'])){
        $password = encryption($_POST['username']);
        $stmt = $con->prepare("UPDATE `camagru`.`users` SET `password` = :password WHERE `user_id` = :user_id");
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':password', $password);
            $stmt->execute();
    }
    if (isset($_POST['username']) && !empty($_POST['username'])){
        $username = $_POST['username'];
        $stmt = $con->prepare("UPDATE `camagru`.`users` SET `username` = :username WHERE `user_id` = :user_id");
            $stmt->bindParam(':user_id', $user_id);
            $stmt->bindParam(':username', $username);
            $stmt->execute();
    }
    header('Location: ../profile.php');


?>