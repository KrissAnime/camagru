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
	<form  id="registration_form">
			<h4>Name:</h4> <input type="text" size="30" id="name" name="username"><br/>
			<h4>Surname:</h4> <input type="text" size="30" id="surname" name="password"><br/>
			<h4>email:</h4> <input type="text" size="30" id="email" name="password"><br/>
			<h4>Username:</h4> <input type="text" size="30" id="user" name="username"><br/>
			<h4>Password:</h4> <input type="password" size="30" id="pass" name="password"><br/>
			<button onclick="check_new_login()" type="button" id="login">Register</button>
			<a href="./login.php">Already Registered? Log In Now!</a>
		</form>
	</div>
	<script></script>
</body>
</html>
