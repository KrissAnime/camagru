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
			echo	"<div onclick='blowup(event);' class='central_grid_item' style=\"background-image:url('$src')\">
						<i onclick='like_event(event);' id='heart' class='fas fa-heart'></i>
					</div>";
		}
	}
	echo "</div>";
	?>
	<div id='myModal' class='modal'>
		<br/>
		<span class='close'>&times;</span>
		<div id="image_box">
			<div id="modal_image">
			</div>
			<br/>
			<div id="comment_list">
			</div>
			<br/>
			<form action="" method="POST" id="input_comment" name="input_comment">
				<textarea id="user_comment" name="user_comment"></textarea>
				<br/><button type="submit" id="sub_comment"></button>
			</form>
		</div>
		<div id='caption'>
		</div>
	</div>
	<script>
	// Get the modal
	
	// Get the image and insert it inside the modal - use its "alt" text as a caption
	// var image = document.getElementById('myImg');
	var modalImg = document.getElementById("modal_image");
	var captionText = document.getElementById("caption");
	var modal = document.getElementById('myModal');
	
	function like_event(event){
		var heart = document.getElementById('heart');

		if (heart.classList.contains('fas fa-heart')){
			heart.classList.toggle('far fa-heart');
		}
		else{
			heart.classList.toggle('fas fa-heart');
		}
	}

	function blowup(event){
		img = event.target.style.backgroundImage.slice(12, -2);
		modal.style.display = "block";
		modalImg.style.backgroundImage = 'url(images/' + img +')';
	}
	
	// Get the <span> element that closes the modal
	var span = document.getElementsByClassName("close")[0];
	
	// When the user clicks on <span> (x), close the modal
	span.onclick = function() { 
		modal.style.display = "none";
	}
	</script>

<?php
	if (isset($_POST['user_comment']) && !empty($_POST['user_comment'])){
		if ($_SESSION['logged'] && $_SESSION['logged'] === "user" || $_SESSION['logged'] === "admin"){
			$stmt = $conn->prepare("INSERT INTO `camagru`.`comments` (firstname, lastname, email) 
			VALUES (:firstname, :lastname, :email)");
			$stmt->bindParam(':firstname', $firstname);
		}
		else{
			header('Location: login.php');
		}
	}
?>