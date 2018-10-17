<?php

function add_user($data, $con){
	$password = encryption($data['password']);
	$sql = "INSERT INTO `camagru`.`users` (firstname, lastname, username, email, `password`, verified, `admin`)
	 	VALUES ('".$data['firstname']."', '".$data['lastname']."', '".$data['username']."', '".$data['email']."', '".$password."', 0, 0);";
	$con->exec($sql);
}

function is_new_user($username, $email, $con) {
    $sql = $con->prepare("SELECT `users`.`username`, `users`.`email` FROM `camagru`.`users`"); 
	$sql->execute();
	$sql->setFetchMode(PDO::FETCH_ASSOC); 

	while ($row = $sql->fetch()){
		if ($row['username'] === $username || $row['email'] === $email){
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
		$new = $part1.$enc_key2.$part2;
		$key = hash(whirlpool, $new);
	}
	else if ($length < 8){
		$part1 = $enc_key.substr($password, 0, 3);
		$part2 = $enc_key3.substr($password, 3);
		$new = $part1.$enc_key2.$part2;
		$key = hash(whirlpool, $new);
	}
	else{
		$part1 = $enc_key.substr($password, 0, $length / 2);
		$part2 = $enc_key3.substr($password, $length / 2);
		$new = $part1.$enc_key2.$part2;
		$key = hash(whirlpool, $new);
	}
	return $key;
}

?>