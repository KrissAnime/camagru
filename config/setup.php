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
			`date` TIMESTAMP DEFAULT CURRENT_TIMESTAMP)";

			$con->exec($sql);
			$enc = "d7cz5j7";

			for ($x = 1; $x < 7; $x++){
				$sql = $con->prepare("SELECT * FROM `camagru`.`images`");
                $sql->execute();
                $sql->setFetchMode(PDO::FETCH_ASSOC);
				$val = $sql->fetchAll();

				$name = "KrissAdmin_00".$x;
				$clear = 1;
				$user = 1;
				if ($x == 4 || $x == 5){
					$image = md5($user.$enc.$name).".png";
				}
				else{
					$image = md5($user.$enc.$name).".jpg";
				}
				foreach($val as $row){
					if ($row['user_id'] == $user && $row['img_name'] == $image){
						$clear = 0;
						break ;
					}
				}
				if ($clear){
					$sql = "INSERT INTO `camagru`.`images` (`user_id`, `img_name`)
					VALUES ('".$user."', '".$image."')";
					$con->exec($sql);
				}
			}

			$sql = "CREATE TABLE IF NOT EXISTS `camagru`.`comments` (
				`user_id` INT(6) NOT NULL ,
				`img_name` VARCHAR(40) NOT NULL PRIMARY KEY,
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
					$krissenc  = encryption('FroZ3nC@tSn1per');
					$krissadmin = password_hash($krissenc, PASSWORD_DEFAULT);
					$rootenc = encryption('user123');
					echo $rootenc;
					$rootadmin = password_hash($rootenc, PASSWORD_DEFAULT);
					$sql = $con->prepare("INSERT INTO `camagru`.`users` (
						firstname, lastname, username, email, `password`, verified, `admin`)
						VALUES ('Kriss', 'Anime', 'KrissAdmin', 'krissultimatum@gmail.com', :pass1, 1, 1),
						('user', 'test', 'user', 'user@setup.com', :pass2, 1, 0)");
						$sql->bindParam(':pass1', $rootadmin);
						$sql->bindParam(':pass2', $krissadmin);
						$sql->execute();
					}
					//	 echo "Admin users created<br>";
					//	echo "Camagru user table created<br>";
				}
				catch(PDOException $e) {
					echo "Connection failed: " . $e->getMessage();
				}
?>
