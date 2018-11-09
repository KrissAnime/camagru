<?php

require_once('../config/setup.php');

if (isset($_POST['source']) && !empty($_POST['source'])){
    $img_name = $_POST['source'];
    $sql = $con->prepare("DELETE FROM `camagru`.`images` WHERE `img_name` = :img_name");
    $sql->bindParam('img_name', $img_name);
    $sql->execute();
    echo "success";
    unlink('../images/'.$img_name);
    return (1);
}

echo 'fail';


?>