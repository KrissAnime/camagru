<?php

require_once('../setup/install.php');

$sql = $con->prepare(
	"SELECT `img_name`
	FROM `camagru`.`images`
	ORDER BY
	`images`.`date` DESC");
$sql->execute();
$sql->setFetchMode(PDO::FETCH_ASSOC);
$val = $sql->fetchAll();
	
echo "<div class='central_grid' l3 s2>";
$x = 0;
$i = 0;
	
foreach($val as $row){
	$src = "../images/".$row['img_name'];
	// echo $src;
	echo "<div class='central_grid_item' style=\"background-image:url('$src')\"></div>";
	$x++;
}
echo "</div>";
	
?>