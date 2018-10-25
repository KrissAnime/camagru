<?php

require('header.php');
require('menu_bar.php');
require('side.php');

?>

<!DOCTYPE html>
<html>
<head>
</head>
<body>
    <div>
        <div class="camera">
            <video id='video' autoplay></video>
        </div>
        <div>
            <button type="button" id="capture">Capture Photo</button>
        </div>
    </div>
    <script src="js/camera.js"></script>
</body>
</html>
