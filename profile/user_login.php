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

	$sql = $con->prepare("SELECT `camagru`.`users`.`user_id`, `camagru`.`users`.`username`, `camagru`.`users`.`password` FROM `camagru`.`users`");
	$sql->execute();
	$sql->setFetchMode(PDO::FETCH_ASSOC);

	$i = 1;
	while ($row = $sql->fetch()){
		if ($row['username'] === $username && $row['password'] === $password){
			$_SESSION['logged'] = "user";
			$_SESSION['current'] = $row['user_id'];
			header('Location: ../index/index.php');
		}
		header('Location: ../index/index.php');
	}

	header('Location: login.php?error=invalid_user');
}

?>
