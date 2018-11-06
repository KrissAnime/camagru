<?php

require('header.php');
require('menu_bar.php');
require_once('config/setup.php');
// session_start();

$pic_org = "images/profile/no_profile.png";

if ($_SESSION['logged'] === "user" || $_SESSION['logged'] === 'admin') {
    $user = $_SESSION['current'];
    
    $con = new PDO("mysql:host=".$admin_server, $admin_name, $admin_password);
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $sql = $con->prepare("SELECT * FROM `camagru`.`users`");
    $sql->execute();
    $sql->setFetchMode(PDO::FETCH_ASSOC);
    
    $i = 1;
    $pic = "";
    $username = "";
    $email = "";
    $val = $sql->fetchAll();
    foreach($val as $row){
        if ($row['user_id'] === $user && !empty($row['profile'])){
            $pic = "images/profile/".$row['profile'];
            // $firstname = $row['firstname'];
            // $lastname = $row['lastname'];
            $username = $row['username'];
            $email = $row['email'];
            break ;
        }
    }
    
    $sql = $con->prepare(
        "SELECT `img_name`, `user_id`
        FROM `camagru`.`images`
        ORDER BY
        `images`.`date` DESC");
        $sql->execute();
        $sql->setFetchMode(PDO::FETCH_ASSOC);
        $val = $sql->fetchAll();
        
        if (!file_exists($pic)){
            $pic = $pic_org;
        }
        if (!empty($_GET)){
            if ($_GET['edit'] === "true" || $_GET['update'] === "true"){
                echo "<div class='central_grid' l3 s2 style='margin-right:300px'>";
        
                foreach($val as $row){
                    // echo $src;
                    if ($row['user_id'] === $user){
                        $src = "images/".$row['img_name'];
                        if (file_exists($src)){
                            echo "<div class='central_grid_item' style=\"background-image:url('$src')\"></div>";
                        }
                    }
                    
                }
                echo "</div>";

                //Is the begining of the profile sidebar
                
                echo    "<div class='w3-sidebar w3-bar-block w3-grey' style='width:300px;right:2px;top:2px'";
                
                //Shows the user profile picture
                echo    "   <div class='w3-w3-border w3-padding' alt='profile' id='profile'>
                                <img src='".$pic."' alt='profile' width='300px'/><br/>
                                <a href='upload_profile.php' class='upload'>Upload</a>
                                <div style='margin-right:20%' style='min-height: 100%;'>
                                </div>";
                
                //Shows form for updating user details
    
                echo "              <div>
                                        <form action='functions/update.php' method='post' id='update_profile' name='update_profile'>
                                            <h4>Email:</h4> <input type='text' size='30' id='email' name='email'><br/>
                                            <h4>Username:</h4> <input type='text' size='30' id='username' name='username'><br/>
                                            <h4>Password:</h4> <input type='password' minlength=6 size='30' id='password' name='password'><br/>
                                            <br/><button type='submit' id='save_details'>Save Details</button>
                                            <a href='profile.php' class='upload'>Cancel</a>
                                            <br/><a href='profile.php>Cancel</button></a>
                                        </form>
                                    </div>
                            </div>
                        </div>";
            }
            
            
        }
        else{
            echo    "<div class='w3-sidebar w3-bar-block w3-grey' style='width:300px;right:2px;top:2px'>
            <div class='w3-w3-border w3-padding' alt='profile' id='profile'>
            <img src='".$pic."' alt='profile' width='270px'/><br/>
            <a href='upload_profile.php' class='upload'>Upload</a>
            </div>
            <div style='margin-right:20%' style='min-height: 100%;'></div>";
            echo    "<table class='profile_details'> 
            <tr>
            <th>User: </th>
            <th>$username</th>
            </tr>
            <tr>
            <th>Email: </th>
            <th>$email</th>
            </tr>
            </table>
            <br/><a href='profile.php?edit=true 'button type='submit' id='login'>Edit Details</button></a></div>";
            echo "<div class='central_grid' l3 s2 style='margin-right:300px'>";
        
            foreach($val as $row){
                if ($row['user_id'] === $user){
                    $src = "images/".$row['img_name'];
                    if (file_exists($src)){
                        echo "<div class='central_grid_item' style=\"background-image:url('$src')\"></div>";
                    }
                }
                
            }
            echo "</div>";
        }
    }
        require('footer.php');
        ?>
        