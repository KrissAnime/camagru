<?php

require('../functions/verify.php');

if (isset($_POST['password']) && !empty($_POST['password']) && isset($_POST['username']) && !empty($_POST['username']) ){
	$con = new PDO("mysql:host=".'localhost', 'root', 'Asuka.2016');
	$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$username = $_POST['username'];
	$password = encryption($_POST['password']);

	echo $password;

	$sql = $con->prepare("SELECT `users`.`user_id`, `users`.`username`, `users`.`password` FROM `camagru`.`users`"); 
	$sql->execute();
	$sql->setFetchMode(PDO::FETCH_ASSOC); 

	while ($row = $sql->fetch()){
		if ($row['username'] === $username && $row['password'] === $password){
			$con = NULL;
			$_SESSION['logged'] = "user";
			$_SESSION['current'] = $row['user_id'];
			header('Location: ../index/index.php');
		}
	}
	$con = NULL;
	header('Location: login.php?error=invalid_user');
}

?>