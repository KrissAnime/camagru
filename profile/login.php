<?php
	require('../setup/install.php');
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="../css_files/login.css" />
	<link rel="stylesheet" href="../css_files/header.css" />
	<title>Login</title>
</head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<body>
	<div class="header_class">
		<a href="../index/index.php"><h1>Home</h1></a>
	</div>
	<div class="login_class">
		<form  id="login_form">
			<h3>Username:</h3> <input type="text" size="30" id="user" name="username"><br/>
			<h3>Password:</h3> <input type="password" size="30" id="pass" name="password"><br/><br/>
			<button onclick="check_login()" type="button" id="login">Login</button>
			<a href="./registration.php">New Account? Register Here!</a>
		</form>
	</div>
</body>
</html>