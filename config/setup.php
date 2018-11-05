<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include('verify.php');
include('database.php');

try {
	$con = new PDO("mysql:host=".$admin_server, $admin_name, $admin_password);
	$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$sql = "CREATE DATABASE IF NOT EXISTS $admin_db";

	$con->exec($sql);

	$sql = "CREATE TABLE IF NOT EXISTS `camagru`.`users` (
		`user_id` INT(6) NOT NULL AUTO_INCREMENT PRIMARY KEY,
		`firstname` VARCHAR(30) NOT NULL ,
		`lastname` VARCHAR(30) NOT NULL ,
		`username` VARCHAR(50) NOT NULL ,
		`email` VARCHAR(50) NOT NULL ,
		`password` VARCHAR(255) NOT NULL,
		`verified` INT(1) ,
		`admin` INT (1) ,
		`profile` VARCHAR(36))";

	$con->exec($sql);

	$sql = "CREATE TABLE IF NOT EXISTS `camagru`.`verification` (
		`user_id` INT(6) NOT NULL PRIMARY KEY,
		`email` VARCHAR(50) NOT NULL ,
		`link` VARCHAR(50) NOT NULL )
		ENGINE = InnoDB;";

	$con->exec($sql);

	$sql = "CREATE TABLE IF NOT EXISTS `camagru`.`images` (
			`user_id` INT(6) NOT NULL ,
			`img_name` VARCHAR(40) NOT NULL PRIMARY KEY,
			`img_enc` VARCHAR(300),
			`edited` INT(1) DEFAULT 0,
			`date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP)";

	$con->exec($sql);
	$enc = "d7cz5j7";

	if (!file_exists('../images/')){
		mkdir('../images/');
		if (!file_exists('../images/profile/')){
			mkdir('../images/profile/');
		}
		if (!file_exists('../images/temp/')){
			mkdir('../images/temp/');
		}
	}

	$image = array('3587e272e12292b0cff5623ad3f7f343.jpg',
		'4709f2f52d18bee285efece84cc037f4.jpg',
		'5db401ce155bf4552f7a54a3bdc629b3.jpg',
		'770e140cab2b1e9c8d1e17b86912cc9f.jpg',
		'776c4fbea6af63d852e13ac6c2a0772e.jpg',
		'b6d35a326127c92dfaf26ef84e502161.png',
		'c1bcc6eb2f5ce5f7c2380dd37a7e4b0a.jpg',
		'e8beb8a677355dc397a11a0a82cc55ee.jpg',
		'c2d3b343becd315553cf3b5a80645113.png',
		'f37772a8ef9a2eedb720d258b3429b6b.jpg',
		'628ebd43091137e45efadf6e3dc431c6.jpg',
		'7b1f9f4ba156983b3700d476096927d5.jpg',
		'802b42dd93f08a4335528c0f0f1ca320.jpg',
		'd9d21f384bd3b5ab0a16af8b7fd67c3f.jpg');

	$total = sizeof($image);
	for ($y = 0; $y < $total; $y++){
		$sql = $con->prepare("SELECT * FROM `camagru`.`images`");
		$sql->execute();
		$sql->setFetchMode(PDO::FETCH_ASSOC);
		$val = $sql->fetchAll();
		$clear = 1;
		$user = 1;
		$file = $image[$y];
		if (file_exists('../images/'.$image[$y])){
			foreach($val as $row){
				if ($row['user_id'] == $user && $row['img_name'] == $file){
					$clear = 0;
					break ;
				}
			}
			if ($clear){
				$sql = "INSERT INTO `camagru`.`images` (`user_id`, `img_name`)
					VALUES ('".$user."', '".$file."')";
				$con->exec($sql);
			}
		}
	}

	$sql = "CREATE TABLE IF NOT EXISTS `camagru`.`stickers` (
		`img_name` VARCHAR(40) NOT NULL PRIMARY KEY)";

	$con->exec($sql);
	
	$sql = "CREATE TABLE IF NOT EXISTS `camagru`.`comments` (
		`user_id` INT(6) NOT NULL ,
		`img_name` VARCHAR(40) NOT NULL PRIMARY KEY,
		`comment` VARCHAR (120) NOT NULL ,
		`date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP)";
	$con->exec($sql);
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
		$krissadmin  = encryption('FroZ3nC@tSn1per');
		$rootadmin = encryption('user123');
		$sql = $con->prepare("INSERT INTO `camagru`.`users` (
			firstname, lastname, username, email, `password`, verified, `admin`)
			VALUES ('Kriss', 'Anime', 'KrissAdmin', 'krissultimatum@gmail.com', :pass1, 1, 1),
			('user', 'test', 'user', 'user@setup.com', :pass2, 1, 0)");
		$sql->bindParam(':pass1', $krissadmin);
		$sql->bindParam(':pass2', $rootadmin);
		$sql->execute();
	}
}
catch(PDOException $e) {
	echo "Connection failed: " . $e->getMessage();
}
?>
