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
	
	echo "<div class='w3-display-container w3-black'>";
	$x = 0;
	$i = 0;
	
	foreach($val as $row){
		if ($x > 4){
			echo "<div><br/></div>";
			$x = 0;
		}
		if ($x == 0){
			echo "<div class='w3-row-padding m2 l4'>";
		}
		if ($x == 4){
			echo "</div>";
			$x++;
		}
		$src = "../images/".$row['img_name'];
		echo "<div class='w3-col s4'><img width='90%' src='$src'></div>";
		$x++;
	}
	echo "</div>";
	
	?>
	
	<!-- <div class="central_box">
	<div class="w3-row-padding m2 l4">
	
	<div class="w3-col s4"><img width="100%" src="../images/WhatsApp_Image_2018-10-22_09.01.03.jpeg"></div>
	<div class="w3-col s4"><img width="100%" src="../images/WhatsApp_Image_2018-10-22_09.01.03.jpeg"></div>
	
	<div><br/></div>
	<div class="w3-row-padding m2 l4">
	<div class="w3-col s4"><img width="100%" src="../images/WhatsApp_Image_2018-10-22_09.01.03.jpeg"></div>
	<div class="w3-col s4"><img width="100%" src="../images/WhatsApp_Image_2018-10-22_09.01.03.jpeg"></div>
	<div class="w3-col s4"><img width="100%" src="../images/WhatsApp_Image_2018-10-22_09.01.03.jpeg"></div>
	</div>
	</div> -->