<?php

session_start();

$admin_name = 'root';
$admin_server = 'localhost';
$admin_password = 'Asuka.2016';
$admin_db = 'camagru';

$_SESSION['current'] = "start_up";

try {
	$con = new PDO("mysql:host=".$admin_server, $admin_name, $admin_password);
	$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$sql = "CREATE DATABASE IF NOT EXISTS $admin_db";
//	echo "Camagru database created created<br>";
	$con->exec($sql);
	
	$sql = "CREATE TABLE IF NOT EXISTS `camagru`.`users` (
			`user_id` INT(6) NOT NULL AUTO_INCREMENT PRIMARY KEY,
			`firstname` VARCHAR(30) NOT NULL ,
			`lastname` VARCHAR(30) NOT NULL ,
			`username` VARCHAR(50) NOT NULL ,
			`email` VARCHAR(50) NOT NULL ,
			`password` VARCHAR(1000) NOT NULL)";
	$con->exec($sql);
//	echo "Camagru user table created";
}
catch(PDOException $e) {
	echo "Connection failed: " . $e->getMessage();
}

/* ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

echo "Connection testing\n";
try {
	$connect = new PDO("mysql:host=".$server.";dbname=db_cbester", $admin_name, $password);
	echo "Connection successful";
	$connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	//$query = "CREATE DATABASE IF NOT EXISTS db_camagru";

	// $connect->exec($query);
	echo "Database created successfully<br>";
}
catch (PDOException $e){
	echo "<br>".$e->getMessage();
}

$connect = null;
*/
?> 