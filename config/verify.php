<?php

function add_user($data, $con){
	// echo "<pre>";
	// print_r($data);
	// echo "</pre>";
	$password = encryption($data['password']);

	// echo "before";
	$sql = $con->prepare("INSERT INTO `camagru`.`users`
	(`firstname`, `lastname`, `username`, `email`, `password`, `verified`, 	`admin`, `profile`)
	VALUES	(:firstname, :lastname, :username, :email, :pass, 0, 0, NULL)");
	$sql->bindParam(':firstname', $data['firstname']);
	$sql->bindParam(':lastname', $data['lastname']);
	$sql->bindParam(':username', $data['username']);
	$sql->bindParam(':email', $data['email']);
	$sql->bindParam(':pass', $password);
	$sql->execute();
}

function is_new_user2($email, $con) {
    $sql = $con->prepare("SELECT `email` FROM `camagru`.`users`");
	$sql->execute();
	$sql->setFetchMode(PDO::FETCH_ASSOC);
	$val = $sql->fetchAll();
	foreach($val as $row){
		if ($row['email'] === $email){
			return TRUE;
		}
	}
	return FALSE;
}

function is_new_user($username, $email, $con) {
    $sql = $con->prepare("SELECT `username`, `email` FROM `camagru`.`users`");
	$sql->execute();
	$sql->setFetchMode(PDO::FETCH_ASSOC);
	$val = $sql->fetchAll();
	foreach($val as $row){
		if (strtolower($row['username']) === strtolower($username) || $row['email'] === $email){
			return FALSE;
		}
	}
	return TRUE;
}

function verify_user($data){
	if ($data['password'] === $data['mpassword']){
		return TRUE;
	}
	return FALSE;
}

function encryption($password) {
	$enc_key = "YJd9Zm";
    $enc_key2 = "s1Asso";
	$enc_key3 = "b59fda1";
	$length = strlen($password);

	if ($length >= 8 && $length < 20){
		$part1 = $enc_key.substr($password, 0, 4);
		$part2 = $enc_key3.substr($password, 4);
		$new = $part1.$part2.$enc_key2;
		$key = hash('whirlpool', $new);
	}
	else if ($length < 8){
		$part1 = $enc_key.substr($password, 0, 3);
		$part2 = $enc_key3.substr($password, 3);
		$new = $part1.$enc_key2.$part2;
		$key = hash('whirlpool', $new);
	}
	else{
		$part1 = $enc_key.substr($password, 0, $length / 2);
		$part2 = $enc_key3.substr($password, $length / 2);
		$new = $part2.$enc_key2.$part1;
		$key = hash('whirlpool', $new);
	}
	return $key;
}

function verify_email($email, $subject, $message){
	$verification_link = md5(getRandomWord(strlen($email)));
	$receiver = $email;
	$subject = 'Camagru Email Verification';
	$message .= $verification_link.'
	
	KrissAdmin Camagru.';
	$header = 'From: no-reply@krissadmin.camagru';
	mail($receiver, $subject, $message);

	$admin_name = 'root';
	$admin_server = 'localhost';
	$admin_password = 'Asuka2016';
	$admin_db = 'camagru';

	$con = new PDO("mysql:host=".$admin_server, $admin_name, $admin_password);
	$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$stmt = $con->prepare("SELECT `user_id` FROM `camagru`.`users` WHERE `email` = :email");
	$stmt->bindParam(":email", $email);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
    $val = $stmt->fetchAll();
	
	// if (isset($_SESSION['current'])){
	// 	$id = $_SESSION['current'];
	// }
	// foreach ($val as $row){
	// 	$id = $row['user_id'];
	// }

	$stmt = $con->prepare("SELECT `email` FROM `camagru`.`verification` WHERE `email` = :email");
	$stmt->bindParam(":email", $email);
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);
	$val = $stmt->fetchAll();
	
	$check = 1;
	foreach ($val as $row){
		$check = 0;
	}
	if ($check){
		$sql = $con->prepare("INSERT INTO `camagru`.`verification`
		(`email`, `link`)
		VALUES (:email, :verification_link)");
		$sql->bindParam(':email', $email);
		$sql->bindParam(':verification_link', $verification_link);
		$sql->execute();
	}
}

function new_link($email, $con){
	$stmt = $con->prepare("SELECT `email` FROM `camagru`.`verification` WHERE `email` = :email");
	$stmt->bindParam(":email", $email);
	$stmt->execute();

	if($stmt->rowCount() > 0)
	{
		verify_email($email);
		return TRUE;
	}
	return FALSE;
}

function getRandomWord($len) {
    $word = array_merge(range('a', 'z'), range('A', 'Z'));
    shuffle($word);
    return substr(implode($word), 0, $len);
}

?>
