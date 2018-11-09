<?php
	require('config/setup.php');
	require('header.php');
    require('menu_bar.php');
    require_once('config/verify.php');

    if (isset($_POST) && !empty($_POST['email']) && isset($_POST['password']) && !empty($_POST['password'])
        && isset($_POST['mpassword']) && !empty($_POST['mpassword'])){
        
        $data = array('email' => $_POST['email'],
			'password' => $_POST['password'],
			'mpassword' => $_POST['mpassword'],
        );

        $password = encryption($data['password']);
        if (!is_new_user2($data['email'], $con)){
            header('Location: forgot_password.php?error=user');
        }
        else if (!verify_user($data)){
            header('Location: forgot_password.php?error=password');
        }
        else if (filter_var($data['email'], FILTER_VALIDATE_EMAIL) === $data['email']){
            $subject = 'Camagru Email Verification';
			$message = 'Copy the following link into your url to verify password change:
			
			'.'http://localhost:8080/camagru/forgot_password.php?verify=';
            verify_email($data['email'], $subject, $message);
            $stmt = $con->prepare("UPDATE `camagru`.`users` SET `password` = :password WHERE `email` = :email");
            $stmt->bindParam(':email', $data['email']);
            $stmt->bindParam(':password', $password);
            $stmt->execute();
            header('Location: verification.php');
        }
    }

    if (isset($_GET)){
        if (isset($_GET['error']) && $_GET['error'] === 'password'){
            echo "<div class='remember_class'>
                <form action='' method='post' id='login_form' name='login_form'>
                    <h3>Email:</h3><input type='text' size='30' id='email' name='email'><br/>
                    <h3>Password:</h3><input type='password' size='30' id='password' name='password'><br/><br/>
                    <h3>Password:</h3><input type='password' size='30' id='mpassword' name='mpassword'><br/><br/>
                    <button type=submit id='login'>Send Link</button>
                </form>
            </div>";
            echo "Invalid Password";
        }
        else if (isset($_GET['error']) && $_GET['error'] === 'user'){
            echo "<div class='remember_class'>
                <form action='' method='post' id='login_form' name='login_form'>
                    <h3>Email:</h3><input type='text' size='30' id='email' name='email'><br/>
                    <h3>Password:</h3><input type='password' size='30' id='password' name='password'><br/><br/>
                    <h3>Password:</h3><input type='password' size='30' id='mpassword' name='mpassword'><br/><br/>
                    <button type=submit id='login'>Send Link</button>
                </form>
            </div>";
            echo "Invalid User";
        }
        else if (isset($_GET['verify']) && $_GET['verify']){
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
    
                $sql = $con->prepare("DELETE FROM `camagru`.`verification` WHERE `email`= :email");
                $sql->bindParam(':email', $email);
                $sql->execute();
    
                echo "<div class='success'>
                        <div><h3>Your Account Password Has Been Changed, Please <a href='login.php'>Login </a>To Continue<h3/></div>
                    </div>";
                header('Location: login.php');
            }
        }
    }
    else{
        echo "<div class='remember_class'>
        <form action='' method='post' id='login_form' name='login_form'>
            <h3>Email:</h3><input type='text' size='30' id='email' name='email'><br/>
            <h3>Password:</h3><input type='password' size='30' id='password' name='password'><br/><br/>
            <h3>Password:</h3><input type='password' size='30' id='mpassword' name='mpassword'><br/><br/>
            <button type=submit id='login'>Send Link</button>
        </form>
    </div>";
    }
?>