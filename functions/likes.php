<?php

require_once('../config/setup.php');
// echo "from likes.php";

if (isset($_POST['like']) && !empty($_POST['like']) && isset($_POST['source']) && !empty($_POST['source'])){
    if (!isset($_SESSION)){
        session_start();
        if (isset($_SESSION['current'])){
            $like = $_POST['like'];
            $src = $_POST['source'];
            $user_id = $_SESSION['current'];
            
            $num = 0;
            $sql = $con->prepare("SELECT COUNT(*) as total
					FROM `camagru`.`likes`
                    WHERE `user_id` = :user_id
                    AND `img_name` = :src");
            
            $sql->bindParam(':user_id', $user_id);
            $sql->bindParam(':src', $src);
			$sql->execute();
			$sql->setFetchMode(PDO::FETCH_ASSOC);
			$val = $sql->fetchAll();
            $num = $val[0]['total'];
            // echo $num;
            
            if (!$num){
                $sql = $con->prepare("INSERT INTO `camagru`.`likes` (`user_id`, img_name)
                        VALUES (:user_id, :src)");
                $sql->bindParam(':user_id', $user_id);
                $sql->bindParam(':src', $src);
                $sql->execute();
            }
            else{
                $sql = $con->prepare("DELETE FROM `camagru`.`likes`
                WHERE `user_id`= :user_id
                AND `img_name` = :src");
                $sql->bindParam(':user_id', $user_id);
                $sql->bindParam(':src', $src);
                $sql->execute();
            }
            echo "pass";
            return (1);
        }
    }
    echo "fail";
    return (0);
}
// echo "other";

?>