<?php

require_once('../config/setup.php');

if (isset($_POST['img_name']) && !empty($_POST['img_name'])){

	$img_name = $_POST['img_name'];

	$sql = $con->prepare("SELECT * FROM `camagru`.`comments` WHERE `img_name` = :img_name");
	$sql->bindParam('img_name', $img_name);
	$sql->execute();
	$val = $sql->fetchAll();
	
	$output = "";
	
	
	foreach ($val as $row){
		$user_id = $row['user_id'];
		$sql = $con->prepare("SELECT `username` FROM `camagru`.`users` WHERE `user_id` = :user_id");
		$sql->bindParam('user_id', $user_id);
		$sql->execute();
		$users = $sql->fetchAll();
		
		$name = $users[0]['username'];
		$comment = $row['comment'];
		$date = $row['date'];
		$output .= "<div id='comment_list'>";
		$output .= "<div id='comment_name'>".$name."  ".$date."</div>";
		$output .= "<p id='comment'>$comment</p></div>";
	}
	echo $output;
	return (1);
}

echo "FALSE";



?>