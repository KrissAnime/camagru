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
        <div id='camera'>
                <video id='video' width="500" height="300" autoplay></video><br/>
                <button type='button' id='capture'>Capture Photo</button>
        </div>
        <div id='drawn_sticker'>
        </div>
            <?php
                $sql = $con->prepare("SELECT * FROM `camagru`.`stickers`");
                $sql->execute();
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $val = $sql->fetchAll();

                echo    "<div class='central_grid' l3 s2>";
                foreach ($val as $row){
                    $src = "stickers_borders/".$row['img_name'];
                
                    if (file_exists($src)){
                        // <div onclick='blowup(event);' style=\"width: 80%\">
                        //             </div>
                        echo	"<div onclick='sticker(event);' class='central_grid_item' style=\"background-image:url('$src')\">
					            </div>";
                    }
                }
                echo    "</div>";
            ?>
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
    <script src='js/camera.js'>
        // function sticker(event){
        //     var sticker = document.getElementById('drawn_sticker');
        //     context.drawImage(sticker, 0, 0, 500, 500);
        // }
    </script>

<?php

require('footer.php');

?>
