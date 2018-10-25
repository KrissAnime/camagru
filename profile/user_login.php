<?php

require_once('../setup/install.php');
require_once('../functions/verify.php');

if (isset($_POST['password']) && !empty($_POST['password']) && isset($_POST['username']) && !empty($_POST['username']) ){
	$username = trim($_POST['username']);
	$password = encryption(trim($_POST['password']));

	$con = new PDO("mysql:host=".$admin_server, $admin_name, $admin_password);
	$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	// echo $username."<br>".$password."<br>";
	// echo "blank test <br>";

	$sql = $con->prepare("SELECT * FROM `camagru`.`users`");
	$sql->execute();
	$sql->setFetchMode(PDO::FETCH_ASSOC);

	$val = $sql->fetchAll();
	$check = 0;
	foreach($val as $row){
		if (strtolower($row['username']) === strtolower($username) && $row['password'] === $password){
			session_start();
			$_SESSION['logged'] = "user";
			$_SESSION['current'] = $row['user_id'];
			$check = 1;
		}
	}
	if ($check){
		header('Location: ../index/index.php');
	}
	else{
		header('Location: login.php?error=invalid_user');
	}
	// echo "string";
}

?>
