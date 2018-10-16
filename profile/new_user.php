<?php

require('../functions/verify.php');

if (isset($_POST['firstname']) && !empty($_POST['firstname']) && isset($_POST['surname']) && !empty($_POST['surname'])
	&& isset($_POST['email']) && !empty($_POST['email']) && isset($_POST['username']) && !empty($_POST['username'])
	&& isset($_POST['password']) && !empty($_POST['password'])){
	
	$con = new PDO("mysql:host=".'localhost', 'root', 'Asuka.2016');
	$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	$data = array('firstname' => $_POST['firstname'],
			'surname' => $_POST['surname'],
			'username' => $_POST['username'],
			'email' => $_POST['email'],
			'password' => $_POST['password'],
	);

	echo strlen($data['password']);
	if (!verify_user($data)){
		header('Location: registration.php?error=password');
	}
	else if (!strlen($data['password']) <= 5){
		echo "failed<br>";
		header('Location: registration.php?error=short');
	}
	else if (is_new_user($data['username'], $data['email'], $con)){
		add_user($data, $con);
		header('Location: verification.php');
	}
	else{
		header('Location: registration.php?error=user_exist');
	}
}
else {
	echo "Data is missing";
	header('Location: registration.php?error=empty_fields');
}

?>