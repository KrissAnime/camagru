<?php

require('config/setup.php');
require('header.php');
require('menu_bar.php');

if (isset($_GET)){
    if (isset($_GET['verify']) && $_GET['verify'] !== 'new_user'){
        $stmt = $con->prepare("SELECT `email`, `link` FROM `camagru`.`verification` WHERE `link` = :link");
        $link = $_GET['verify'];
        $stmt->bindParam(":link", $link);
        $stmt->execute();
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $val = $stmt->fetchAll();

    
        if ($stmt->rowCount() > 0){
            foreach ($val as $row) {
                $email = $row['email'];   
            }
            $stmt = $con->prepare("UPDATE `camagru`.`users` SET `verified` = 1 WHERE `email` = :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            $stmt = $con->prepare("DELETE FROM `camagru`.`verification` WHERE `email`= :email");
            $stmt->bindParam(':email', $email);
            $stmt->execute();

            echo "<div class='success'>
            <div><h3>Your Account Has Been Authorised, Please <a href='login.php'>Login </a>To Continue<h3/></div>
            </div>";
        }
        else{
            echo "<img id='veri_zergling' src='https://i.imgur.com/2TOVEkn.png' alt='verification_art1' />
            <div class='verifcation_class'>
                <div><h3>A verification link has been sent to your email address! Please verify your email to continue</h3></div>
            </div>";
        }
    }
    else{
        echo "<img id='veri_zergling' src='https://i.imgur.com/2TOVEkn.png' alt='verification_art1' />
        <div class='verifcation_class'>
            <div><h3>A verification link has been sent to your email address! Please verify your email to continue</h3></div>
        </div>";
    }
}

require('footer.php');

?>


