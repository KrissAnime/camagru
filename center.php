<?php

require_once('config/setup.php');

$page = 1;
if (isset($_GET['page'])){
	$page = $_GET['page'];
}

// $elem = 1;
// $elem = $page * 6;

// echo $page;
	$sql = $con->prepare("SELECT COUNT(*) as total
					FROM `camagru`.`images`");
	$sql->execute();
	$sql->setFetchMode(PDO::FETCH_ASSOC);
	$val = $sql->fetchAll();
	$max = $val[0]['total'];

$elem = 6;
$pages = ceil($max / $elem);

// echo $pages;
if ($page < 1){
	$page = 1;
}
else if ($page > $pages){
	$page = $pages;
}

// echo "  ".$max;
$offset = $page * $elem;
if ($pages == $page || $page > 1){
	$offset -= 6;
}
else if ($page == 1){
	$offset = 0;
}

$sql = $con->prepare(
	"SELECT `img_name`
	FROM `camagru`.`images`
	ORDER BY
	`images`.`date` DESC
	LIMIT 6
    OFFSET $offset");

	// $sql->bindParam(':elem', $elem);
	$sql->execute();
	$sql->setFetchMode(PDO::FETCH_ASSOC);
	$val = $sql->fetchAll();
	
	echo "<div class='central_grid' l3 s2>";
	foreach($val as $row){
		$src = "images/".$row['img_name'];
		$name = $row['img_name'];
		// echo $name;
		// echo $src;
		if (file_exists($src)){
			$num = 0;
			$sql = $con->prepare("SELECT COUNT(*) as total
					FROM `camagru`.`likes`
					WHERE `img_name` = :name");
			$sql->bindParam(':name', $name);
			$sql->execute();
			$sql->setFetchMode(PDO::FETCH_ASSOC);
			$val = $sql->fetchAll();
			$num = $val[0]['total'];

			$img_name = $name;
			$num2 = 0;
			if (isset($_SESSION)){
				if (isset($_SESSION['current'])){
					$user_id = $_SESSION['current'];
					$sql = $con->prepare("SELECT COUNT(*) as other
					FROM `camagru`.`likes`
					WHERE `user_id` = :user_id
					AND `img_name` = :img_name");
            
					$sql->bindParam(':user_id', $user_id);
					$sql->bindParam(':img_name', $img_name);
					$sql->execute();
					$sql->setFetchMode(PDO::FETCH_ASSOC);
					$val = $sql->fetchAll();
					$num2 = $val[0]['other'];
				}
			}
			
			// echo    $num2;
			echo	"<div class='central_grid_item' style=\"background-image:url('$src')\">";
			if ($num2){
				echo	"<i onclick='like_event(event, \"$name\");' id='heart' class='fas fa-heart' style=\"color: white\">$num</i>			
								<div onclick='blowup(\"$name\");' style=\"height: 100%; width: 100%\">
							</div>
						</div>";
			}
			else{
				echo	"<i onclick='like_event(event, \"$name\");' id='heart' class='far fa-heart' style=\"color: white\">$num</i>			
								<div onclick='blowup(event, \"$name\");' style=\"height: 100%; width: 100%\">
							</div>
						</div>";
			}
						
		}
	}
	echo "</div>";

	$elem = 6;
	$pages = ceil($max / $elem);
	
	if ($page < 1){
		$page = 1;
	}
	else if ($page > $pages){
		$page = $pages;
	}

	$prev = 0;
	if ($page > 1){
		$prev = $page - 1;
	}

	$next = $page + 1;
	if ($next > $pages){
		$next = 0;
	}

	// $num = 1;
	// echo "   ".$entries;
	// echo $page;
	echo "<div class='pagination'>";
	if ($prev){
		echo "<a href='index.php?page=$prev'>&laquo;</a>";
	}
	for ($num = 1; $num < $pages; $num++) {
		if ($num == $page && $page > 1) {
			echo "<a class='active' href='index.php?page=$num'>$num</a>";
		}
		else{
			if ($num > 1 && $page < $pages){
				echo "<a href='index.php?page=$num'>$num</a>";
			}
		}
	}
	if ($next) {
		echo "<a href='index.php?page=$next'>&raquo;</a>";
	}
	if ($page == $pages){
		echo "<a class='active' href='index.php?page=$page'>$page</a>";
	}
	echo "</div>";
	?>
			<div id='myModal' class='modal' style='overflow: scroll;'>
			<br/>
			
				<div id='image_box'>
					<span class='close' style='color: white'>&times;</span>
						<div id='modal_image'>
						</div>
						<br/>
					<div id="my_comments">
					</div>
					<br/>
					<form action="" method="POST" id="input_comment" name="input_comment" onsubmit="return submit_comment(event)">
						<input type="hidden" id ="modal_img_name" name="modal_img_name" value=""/>
						<textarea id="user_comment" name="user_comment"></textarea>
						<br/><button type="submit" class='w3-button w3-white' id="sub_comment">Comment</button>
					</form>
				</div>
			</div>
	<script src="js/images.js">
	// Get the modal
	
	// Get the image and insert it inside the modal - use its "alt" text as a caption
	// var image = document.getElementById('myImg');
	
	</script>