<?php

require_once('../config/setup.php');
require_once('../config/verify.php');

if (isset($_POST['password']) && !empty($_POST['password']) && isset($_POST['username']) && !empty($_POST['username']) ){
	$username = $_POST['username'];
	$password = encryption($_POST['password']);

	$sql = $con->prepare("SELECT `username`, `password`, `verified`, `user_id` FROM `camagru`.`users`");
	// $sql->bindParam(':username', $username);
	// $sql->bindParam(':password', $password);
	$sql->execute();
	$sql->setFetchMode(PDO::FETCH_ASSOC);

	$val = $sql->fetchAll();
	$check = 0;
	// echo $password."<br/>";
	// echo $sql->rowcount();
	// echo "<pre>";
	// print_r($val);
	// echo "</pre>";
	foreach($val as $row){
		// echo "<pre>";
		// print_r($row);
		// echo "</pre>";
		// echo "<br/>".$username."<br/>".$password."<br/>";
		// echo strlen($row['password']);
		// echo $username."<br/>".$password."<br/>";
		// echo password_verify($password, $row['password']);
		if (strtolower($row['username']) === strtolower($username) && $password === $row['password']){
			if ($row['verified']){
				session_start();
				$_SESSION['logged'] = "user";
				$_SESSION['current'] = $row['user_id'];
				$check = 1;
			}
			else{
				$check = -1;
			}
		}
	}
	if ($check == 1){
		header('Location: ../index.php');
	}
	else if (!$check){
		header('Location: ../login.php?error=invalid_user');
	}
	else{
		header('Location: ../login.php?error=verify');
	}
}

?>
