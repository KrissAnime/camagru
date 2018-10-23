<div class="w3-bar w3-black">
	<a href="../index/index.php" class="w3-bar-item w3-button">Home</a>
	<a href="../index/editing.php" class="w3-bar-item w3-button">Edit</a>
	<a href="../index/upload.php" class="w3-bar-item w3-button">Upload</a>
	<div class="w3-container" id="profile_drop">
		<div class="w3-dropdown-hover">
	   		<button class="w3-button w3-black">User</button>
			<div class="w3-dropdown-content w3-bar-block w3-border">
			<?php
				
				if ($_SESSION['logged'] === "user" || $_SESSION['logged'] === "admin") {
					?>
						<a href="../profile/profile.php" class="w3-bar-item w3-button">Profile</a>
						<a href="../profile/logout.php" class="w3-bar-item w3-button">Sign Out</a>
					<?php
				}
				else {
					?>
						<a href="../profile/login.php" class="w3-bar-item w3-button">Sign In</a>
   						<a href="../profile/registration.php" class="w3-bar-item w3-button">Register</a>
					<?php
				}
			?>
	   		</div>
		</div>
	<br/></div>
</div>
