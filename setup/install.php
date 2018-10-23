<?php

$admin_name = 'root';
$admin_server = 'localhost';
$admin_password = 'Asuka2016';
$admin_db = 'camagru';

include ('../functions/verify.php');


try {
	$con = new PDO("mysql:host=".$admin_server, $admin_name, $admin_password);
	$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$sql = "CREATE DATABASE IF NOT EXISTS $admin_db";
	//echo "Camagru database created created<br>";
	$con->exec($sql);

	$sql = "CREATE TABLE IF NOT EXISTS `camagru`.`users` (
			`user_id` INT(6) NOT NULL AUTO_INCREMENT PRIMARY KEY,
			`firstname` VARCHAR(30) NOT NULL ,
			`lastname` VARCHAR(30) NOT NULL ,
			`username` VARCHAR(50) NOT NULL ,
			`email` VARCHAR(50) NOT NULL ,
			`password` VARCHAR(1000) NOT NULL,
			`verified` INT(1),
			`admin` INT (1) ,
			`profile` VARCHAR(36))";

	$con->exec($sql);

	$sql = "CREATE TABLE IF NOT EXISTS `camagru`.`images` (
		`user_id` INT(6) NOT NULL PRIMARY KEY,
		`img_name` VARCHAR(37) NOT NULL ,
		`date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP)";

	$con->exec($sql);

	$sql = "CREATE TABLE IF NOT EXISTS `camagru`.`comments` (
		`user_id` INT(6) NOT NULL PRIMARY KEY,
		`img_name` VARCHAR(37) NOT NULL ,
		`comment` VARCHAR (120) NOT NULL ,
		`date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP)";

	$con->exec($sql);

	if (!file_exists('../images/')){
		mkdir('../images/');
	}
	
	if (!file_exists('../images/profile/')){
		mkdir('../images/profile/');
	}

	$sql = $con->prepare("SELECT `camagru`.`users`.`username` FROM `camagru`.`users`");
	$sql->execute();
	$sql->setFetchMode(PDO::FETCH_ASSOC);

	$i = 1;
	while ($row = $sql->fetch()){
		if ($row['username'] === 'KrissAdmin'){
			$i = 0;
			break;
		}
	}

	if ($i){
		$krissadmin = encryption('FroZ3nC@tSn1per');
		$rootadmin = encryption('user123');
		$sql = "INSERT INTO `camagru`.`users` (
			firstname, lastname, username, email, `password`, verified, `admin`)
			VALUES ('Kriss', 'Anime', 'KrissAdmin', 'krissultimatum@gmail.com', '".$krissadmin."', 1, 1),
			('user', 'test', 'user', 'user@setup.com', '".$rootadmin."', 1, 0)";
		$con->exec($sql);
	}
//	 echo "Admin users created<br>";
//	echo "Camagru user table created<br>";
}
catch(PDOException $e) {
	echo "Connection failed: " . $e->getMessage();
}

//echo "finished installation<br>";

?>
