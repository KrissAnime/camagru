<div class="w3-bar w3-black">
	<a href="index.php" class="w3-bar-item w3-button">Home</a>
	<a href="editing.php" class="w3-bar-item w3-button">Edit</a>
	<a href="upload.php" class="w3-bar-item w3-button">Upload</a>
	<div class="w3-container" id="profile_drop">
		<div class="w3-dropdown-hover">
	   		<button class="w3-button w3-black">User</button>
			<div class="w3-dropdown-content w3-bar-block w3-border">
			<?php
				session_start();
				if (isset($_SESSION['logged'])){
					if ($_SESSION['logged'] && $_SESSION['logged'] === "user" || $_SESSION['logged'] === "admin") {
						echo "<a href='profile.php' class='w3-bar-item w3-button'>Profile</a>
							<a href='functions/logout.php' class='w3-bar-item w3-button'>Sign Out</a>";
				}
					else {
						echo "<a href='login.php' class='w3-bar-item w3-button'>Sign In</a>
   							<a href='registration.php' class='w3-bar-item w3-button'>Register</a>";
					}
				}
				else {
					echo "<a href='login.php' class='w3-bar-item w3-button'>Sign In</a>
						   <a href='registration.php' class='w3-bar-item w3-button'>Register</a>";
				}

			?>
	   		</div>
		</div>
	<br/></div>
</div>
