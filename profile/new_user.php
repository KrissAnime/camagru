<?php

echo "Before requirement<br>";

require('../setup/install.php');
require_once('../functions/verify.php');

if (isset($_POST['firstname']) && !empty($_POST['firstname']) && isset($_POST['lastname']) && !empty($_POST['lastname'])
	&& isset($_POST['email']) && !empty($_POST['email']) && isset($_POST['username']) && !empty($_POST['username'])
	&& isset($_POST['password']) && !empty($_POST['password'])){

	$data = array('firstname' => $_POST['firstname'],
			'lastname' => $_POST['lastname'],
			'username' => $_POST['username'],
			'email' => $_POST['email'],
			'password' => $_POST['password'],
			'mpassword' => $_POST['mpassword'],
	);

	if (!verify_user($data)){
		header('Location: registration.php?error=password');
	}
	else if (is_new_user($data['username'], $data['email'], $con)){
		add_user($data, $con);
		$_SESSION['logged'] = "new_user";
		header('Location: verification.php');
	}
	else{
		header('Location: registration.php?error=user_exist');
	}
}
else {
	header('Location: registration.php?error=empty_fields');
}

?>
