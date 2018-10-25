<?php
	require('config/setup.php');
	require('header.php');
	require('menu_bar.php');
?>
<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" href="css_files/login.css" />
	<link rel="stylesheet" href="css_files/header.css" />
	<title>Login</title>
</head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<body>
	<div class="login_class">
		<form action="functions/user_login.php" method="post" id="login_form" name="login_form">
			<h3>Username:</h3> <input type="text" size="30" id="username" name="username"><br/>
			<h3>Password:</h3> <input type="password" size="30" id="password" name="password"><br/><br/>
			<button type="submit" id="login">Login</button>
			<a href="registration.php">New Account? Register Here!</a>
		</form>
	</div>
	<div id="error">
		<?php
			if (isset($_GET['error'])) {
				if ($_GET['error'] === 'invalid_user') {
					echo "<br>"."Invalid User Name Or Password";
				}
			}
		?>
	</div>
<?php

require('footer.php');

?>
