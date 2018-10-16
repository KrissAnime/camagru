<?php
	require('../setup/install.php');
?>
<!DOCTYPE html>
<html>
	<head>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="../css_files/login.css" />
		<link rel="stylesheet" href="../css_files/header.css" />
		<title>Registration</title>
	</head>
	<body>
		<div class="header_class">
			<a href="../index/index.php"><h1>Home</h1></a>
		</div>
		<div class="registration">
			<form action="new_user.php" method="post" id="registration_form" name="registration_form">
				<h4>Name:</h4> <input type="text" size="30" id="firstname" name="firstname"><br/>
				<h4>Surname:</h4> <input type="text" size="30" id="lastname" name="lastname"><br/>
				<h4>Email:</h4> <input type="text" size="30" id="email" name="email"><br/>
				<h4>Username:</h4> <input type="text" size="30" id="username" name="username"><br/>
				<h4>Password:</h4> <input type="password" minlength=6 size="30" id="password" name="password"><br/>
				<h4>Repeat Password:</h4> <input type="password" minlength=6 size="30" id="mpassword" name="mpassword"><br/>
				<br/><button type="submit" id="login">Register</button>
				<a href="./login.php">Already Registered? Log In Now!</a>
			</form>
			<div id="error">
				<?php
					if (isset($_GET['error'])) {
						if ($_GET['error'] === 'user_exist') {
							echo "<br>"."User Already Exists";
						}
						if ($_GET['error'] === 'password') {
							echo "<br>"."Passwords Do Not Match";
						}
						if ($_GET['error'] === 'short') {
							echo "<br>"."Password Is Too Short";
						}
						if ($_GET['error'] === 'empty_fields') {
							echo "<br>"."All Fields Are Compulsory";
						}
					}
				?>
			</div>
		</div>	
		
	</body>
</html>
