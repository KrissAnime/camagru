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
$x = 0;
$i = 0;

foreach($val as $row){
	$src = "images/".$row['img_name'];
	// echo $src;
	if (file_exists($src)){

		echo "<div class='central_grid_item' style=\"background-image:url('$src')\"></div>";
	}
	$x++;
}
echo "</div>";
 echo "<!-- Trigger/Open The Modal -->
<button id='myBtn'>Open Modal</button>

<!-- The Modal -->
<div id='myModal' class='modal'>

  <!-- Modal content -->
  <div class='modal-content'>
    <span class='close'>&times;</span>
    <p>Some text in the Modal..</p>
  </div>

</div>

<script>
// Get the modal
var modal = document.getElementById('myModal');

// Get the button that opens the modal
var btn = document.getElementById('myBtn');

// Get the <span> element that closes the modal
var span = document.getElementsByClassName('close')[0];

// When the user clicks the button, open the modal
btn.onclick = function() {
    modal.style.display = 'block';
}

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = 'none';
}

// When the user clicks anywhere outside of the modal, close it
window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = 'none';
    }
}
</script>";
?>

<!-- echo "<img src='$src' style='width:30%;cursor:zoom-in'
  onclick='document.getElementById('modal01').style.display='block''>

  <div id='modal01' class='w3-modal' onclick='this.style.display='none''>
	<span class='w3-button w3-hover-red w3-xlarge w3-display-topright'>&times;</span>
	<div class='w3-modal-content w3-animate-zoom'>
	  <img src='$src' style='width:100%'>
	</div>
  </div>"; -->
