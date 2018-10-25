<?php

require('../templates/header.php');
require('../templates/menu_bar.php');
require_once('../setup/install.php');
session_start();

$pic = "../images/profile/no_profile.png";

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
            $pic = "../images/profile/".$row['profile'];
            break ;
		}
    }
    
}


echo    "<div class='w3-w3-border w3-padding' alt='profile' id='profile'>
            <img src='".$pic."' alt='profile' width='300px'/><br/>
            <a href='../functions/upload_profile.php' class='upload'>Upload</a>
        </div>
        ";

require('../templates/footer.php');
?>