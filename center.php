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
else if ($page == 1 || !isset($_GET)){
	$offset = 0;
}

$sql = $con->prepare(
	"SELECT `img_name`, `edited`
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
		// print_r($row);
		// echo $name;
		// echo $src;
		if (file_exists($src) && $row['edited'] == 1){
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
								<div onclick='blowup(event, \"$name\");' style=\"height: 100%; width: 100%\">
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
		if ($num == $page) {
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
	<script>
	// Get the modal
	
	// Get the image and insert it inside the modal - use its "alt" text as a caption
	// var image = document.getElementById('myImg');
	
	var modalImg = document.getElementById("modal_image");
	var captionText = document.getElementById("caption");
	var modal = document.getElementById('myModal');
	
	function submit_comment(event) {
		var user_comment = document.getElementById('user_comment').value;
		var modal_img = document.getElementById('modal_img_name');
		var img_name = modal_img.value;
		var xhttp = new XMLHttpRequest();
		
		document.getElementById('user_comment').value = "";
		xhttp.open("POST", "functions/submit_comment.php", true);
		xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				var comments = document.getElementById('my_comments');
				if (this.responseText === "empty"){
					window.alert("You Need to Actually Add A Comment");
				}
				else if (this.responseText === "too_long"){
					window.alert("Comment Limited To 400 Characters");
					user_comment = "";
				}
				else{
					comments.innerHTML = this.responseText;
					user_comment = "";
					// console.log(event);
				}
			}
  		}
  		xhttp.send("user_comment="+user_comment+"&img_name="+img_name);
		  user_comment = "";
		return false;
		  
	}

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
						location.reload();
					}
					else{
						heart.classList.remove('far', 'fa-heart');
						heart.classList.add('fas', 'fa-heart');
						location.reload();
					}
				}
			}
  		};
		  xhttp.send("like="+like+"&source="+source);
		  
	}

	function blowup(event, img){
		var heart = event.target;
		var xhttp = new XMLHttpRequest();
		var user_comment = document.getElementById('user_comment').value;
		user_comment = "";

		xhttp.open("POST", "functions/comments.php", true);
		xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		
		xhttp.onreadystatechange = function() {
			if (this.readyState == 4 && this.status == 200) {
				var comments = document.getElementById('my_comments');
				if (this.responseText !== "fail"){
					comments.innerHTML = this.responseText;
					user_comment = "";
				}
			}
		}

		// console.log(img);
		var modal_img = document.getElementById('modal_img_name');
		modal_img.value = img;
		modal.style.display = "block";
		modalImg.style.backgroundImage = 'url(images/' + img +')';

		xhttp.send("img_name="+img);
		user_comment = "";
	}
	
	// Get the <span> element that closes the modal
	var span = document.getElementsByClassName("close")[0];
	
	// When the user clicks on <span> (x), close the modal
	span.onclick = function() { 
		modal.style.display = "none";
    }

	</script>