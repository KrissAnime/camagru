<?php

require('../templates/header.php');
require('../templates/menu_bar.php');
require_once('../setup/install.php');
session_start();

$pic = "/camagru/images/no_profile.png";

if ($_SESSION['logged'] === "user" || $_SESSION['logged'] === 'admin') {
    $user = $_SESSION['current'];

    $con = new PDO("mysql:host=".$admin_server, $admin_name, $admin_password);
	$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sql = $con->prepare("SELECT * FROM `camagru`.`users`");
	$sql->execute();
	$sql->setFetchMode(PDO::FETCH_ASSOC);

	$i = 1;
	$val = $sql->fetchAll();
	foreach($val as $row){
		if ($row['user_id'] === $user && !empty($row['profile'])){
            $pic = $row['profile'];
            // $username = $row['username'];
            // $lastname = $row['lastname'];
            // $firstname = $row['firstname'];
            // $email = $row['email'];
            break ;
		}
    }
    
}

echo $pic;

echo    "<div class='w3-card' style='width:15%'>
                <img src='".$pic."' alt='profile' width='200px'/><br/>
                <a href='../index/upload_profile.php'>Edit</a>
        </div>
        "
       



?>