<?php

require('../setup/install.php');

session_unset($_SESSION['current']);
session_unset($_SESSION['logged']);

$con = NULL;

header('Location: ../index/index.php');


?>
