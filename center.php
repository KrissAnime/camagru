<?php

require_once('config/setup.php');

$sql = $con->prepare(
	"SELECT `img_name`
	FROM `camagru`.`images`
	ORDER BY
	`images`.`date` DESC");
$sql->execute();
$sql->setFetchMode(PDO::FETCH_ASSOC);
$val = $sql->fetchAll();

echo "<div class='central_grid' l3 s2>";

foreach($val as $row){
	$src = "images/".$row['img_name'];
	// echo $src;
	if (file_exists($src)){
		echo "<div  id='myModal' class='modal'>
				<span class='close'>&times;</span>
				<div id='myImg' class='central_grid_item' style=\"background-image:url('$src')\"></div>
			</div>";
	}
}
echo "</div";
?>



<?php

require('footer.php');

?>
