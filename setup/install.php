<?php



$servername = "localhost:3306";
$admin_name = "root";
$password = "Asuka2016";

try {
    $conn = new PDO("mysql:host=$servername", $admin_name, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully"; 
    }
catch(PDOException $e)
    {
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