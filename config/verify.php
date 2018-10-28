<?php

function add_user($data, $con){
	// echo "<pre>";
	// print_r($data);
	// echo "</pre>";
	$pass = encryption($data['password']);
	$password = password_hash($pass, PASSWORD_DEFAULT);
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
	}
	else if ($length < 8){
		$part1 = $enc_key.substr($password, 0, 3);
		$part2 = $enc_key3.substr($password, 3);
		$new = $part1.$enc_key2.$part2;
	}
	else{
		$part1 = $enc_key.substr($password, 0, $length / 2);
		$part2 = $enc_key3.substr($password, $length / 2);
		$new = $part2.$enc_key2.$part1;
	}
	return $new;
}

function verify_email($email){
	$verification_link = md5(getRandomWord(strlen($email)));
	$receiver = $email;
	$subject = 'Camagru Email Verification';
	$message = 'Copy the following link into your url.'.'localhost:8080/camagru/verification.php?verify='.$verification_link.'   KrissAdmin Camagru.';
	$header = 'From: no-reply@krissadmin.camagru';
	mail($receiver, $subject, $message);
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
