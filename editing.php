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
                <div id="upload_image" style="position: absolute; background-size: cover; background-position: center; width:500px; height:300px"></div>
                <div id="overlay" style="position: absolute; background-size: cover; background-position: center; width:500px; height:300px"></div>
                <video id='video' width="500" height="300" autoplay></video><br/>
                <button type='button' id='capture'  disabled>Capture Photo</button>
                <form action="functions/camera.php" method="POST" enctype="multipart/form-data" "">
                    <input type="hidden" name="sticker_2" id="sticker_2" value=""/>
                    <input type="hidden" name="main_image" id="main_image" value=""/>
                    <input type="submit" name="submit" id="submit_image"disabled/>
                </form>
        </div>
        <canvas id="canvas" width="500" height="300">
        </canvas>
        <canvas id="canvas_2" width="500" height="300" style="display:none">
        </canvas>
</div>

            <?php
                $sql = $con->prepare("SELECT * FROM `camagru`.`stickers`");
                $sql->execute();
                $sql->setFetchMode(PDO::FETCH_ASSOC);
                $val = $sql->fetchAll();

                echo    "<div class='central_grid_mini' > ";
                foreach ($val as $row){
                    $src = "stickers_borders/".$row['img_name'];
                    $name = $row['img_name'];
                
                    if (file_exists($src)){
                        // <div onclick='blowup(event);' style=\"width: 80%\">
                        //             </div>
                        echo	"<div onclick='sticker(event);' class='central_grid_item_mini' style=\"background-image:url('$src')\">
					            </div>";
                    }
                }
                echo    "</div>";
                $user = $_SESSION['current'];

                $sql = $con->prepare(
                    "SELECT `img_name`, `user_id`
                    FROM `camagru`.`images`
                    ORDER BY
                    `images`.`date` DESC");
                    $sql->execute();
                    $sql->setFetchMode(PDO::FETCH_ASSOC);
                    $val = $sql->fetchAll();
                
                echo    "<div class='central_grid_mini'>";
                foreach ($val as $row){
                    if ($row['user_id'] === $user){
                        $src = "images/".$row['img_name'];
                        $name = $row['img_name'];
                    
                        if (file_exists($src)){
                            // <div onclick='blowup(event);' style=\"width: 80%\">
                            //             </div>
                            echo	"<div onclick='background_image(event);' class='central_grid_item_mini' style=\"background-image:url('$src')\">
                                    </div>";
                        }
                    }
                }
                echo    "</div>";
            ?>
        
    <script src='js/camera.js'>

    </script>

<?php

require('footer.php');

?>
