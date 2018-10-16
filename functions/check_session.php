<?php

if (isset($_SESSION)){
	if ($_SESSION['logged'] === "start_up"){
		header('Location: ../profile/login.php');
	}
	else if ($_SESSION['logged'] === "user"){
		header('Location: ../profile/profile.php');
	}
	else if ($_SESSION['logged'] === "new_user"){
		header('Location: ../profile/login.php');
	}
	else if ($_SESSION['logged'] === "admin"){
		header('Location: ../profile/admin.php');
	}
}

?>