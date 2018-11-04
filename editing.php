<?php

require('header.php');
require('menu_bar.php');
require('side.php');
require_once('config/setup.php');
// session_start();

if ($_SESSION['logged'] && ($_SESSION['logged'] === "user" || $_SESSION['logged'] === "admin") && $_SESSION['current'] && !empty($_SESSION['current'])) {
    echo "";
}
else{
    header('Location: login.php');
}
?>

<div>
        <div class='camera'>
                <video id='video' width="640" height="480" autoplay></video><br/>
                <button type='button' id='capture'>Capture Photo</button>
        </div>
        <div class='stickers_borders' right="20px">
            <?php
                $sql = "SELECT * FROM `camagru`.`stickers`";


            ?>
        </div>
        <canvas id="canvas" width="640" height="480">
            <div id="overlay"></div>
        </canvas>
</div>
        <form action="functions/camera.php" method="POST" enctype="multipart/form-data">
            <input type="file" name="image" />
            <input type="submit"/>
        </form>
        <canvas class="output">
        </canvas>
    <script src='js/camera.js'></script>

<?php

require('footer.php');

?>
