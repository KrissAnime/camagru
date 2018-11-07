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
		$name = $row['img_name'];
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
								<div onclick='blowup(event, \"$name\");' style=\"height: 60%\">
							</div>
						</div>";
			}
			else{
				echo	"<i onclick='like_event(event, \"$name\");' id='heart' class='far fa-heart' style=\"color: white\">$num</i>			
								<div onclick='blowup(event, \"$name\");' style=\"width: 60%\">
							</div>
						</div>";
			}
						
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
			<?php
				// $sql = "SELECT * FROM `camagru`.`comments`"
			
			?>
			</div>
			<br/>
			<form action="" method="POST" id="input_comment" name="input_comment">
				<input type="hidden" name="modal_img_name" value=""/>
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
	
	function like_event(event, source){
		var heart = event.target;
		var xhttp = new XMLHttpRequest();
  		
		if (heart.classList.contains('fas', 'fa-heart')){
			var like = 'yes';
		}
		else{
			var like = 'no';
		}
		
		xhttp.open("POST", "functions/likes.php", true);
		xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				if (this.responseText === "fail"){
					window.alert("You Need To Login First");
				}
				else{
					if (heart.classList.contains('fas', 'fa-heart')){
						heart.classList.remove('fas', 'fa-heart');
						heart.classList.add('far', 'fa-heart');
					}
					else{
						heart.classList.remove('far', 'fa-heart');
						heart.classList.add('fas', 'fa-heart');
					}
				}
			}
  		};
  		xhttp.send("like="+like+"&source="+source);
		
		location.reload();
		// echo "<meta http-equiv='refresh' content='0;URL='index.php'>";
		// console.log(source);
		// console.log(heart.classList);
		
	}

	function blowup(event, img){
		// img = event.target.style.backgroundImage.slice(12, -2);
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
		if (isset($_SESSION)){
			if (isset($_SESSION['current'])){
				if ($_SESSION['logged'] && $_SESSION['logged'] === "user" || $_SESSION['logged'] === "admin"){
					if (strlen($_POST['user_comment']) <= 120){
						$comment = $_POST['user_comment'];
						$user_id = $_SESSION['current'];


						$stmt = $con->prepare("INSERT INTO `camagru`.`comments` (user_id, img_id, comment) 
						VALUES (:user_id, :img_id, :comment)");
						$stmt->bindParam(':user_id', $user_id);
						$stmt->bindParam(':img_id', $img_id);
						$stmt->bindParam(':comment', $comment);
					}
				}
				else{
					header('Location: login.php');
				}
			}
		}
		else{
			header('Location: login.php');
		}
	}
	else{
		header('Location: index.php');
	}
?>