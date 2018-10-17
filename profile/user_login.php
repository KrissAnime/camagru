<?php

require('../setup/install.php');
require('../functions/verify.php');

if (isset($_POST['password']) && !empty($_POST['password']) && isset($_POST['username']) && !empty($_POST['username']) ){
	$username = trim($_POST['username']);
	$password = encryption(trim($_POST['password']));

	$sql = $con->prepare("SELECT `users`.`user_id`, `users`.`username`, `users`.`password` FROM `camagru`.`users`"); 
	$sql->execute();
	$sql->setFetchMode(PDO::FETCH_ASSOC); 

	while ($row = $sql->fetch()){
		if ($row['username'] == $username && $row['password'] == $password){
			$_SESSION['logged'] = "user";
			$_SESSION['current'] = $row['user_id'];
			header('Location: ../index/index.php');
		}
	}
	header('Location: login.php?error=invalid_user');
}

?>