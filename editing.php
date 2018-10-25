<?php

require('header.php');
require('menu_bar.php');
require('side.php');
require_once('config/setup.php');
session_start();

if ($_SESSION['logged'] && ($_SESSION['logged'] === "user" || $_SESSION['logged'] === "admin") && $_SESSION['current'] && !empty($_SESSION['current'])) {
    echo "";
}
else{
    header('Location: login.php');
}
?>

<div>
            <div class='camera'>
                <video id='video' autoplay></video>
            </div>
        <div>
            <button type='button' id='capture'>Capture Photo</button>
            </div>
        </div>
    <script src='js/camera.js'></script>

<?php

require('footer.php');

?>