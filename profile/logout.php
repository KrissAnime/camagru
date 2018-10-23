<?php

session_start();
require('../setup/install.php');

session_unset();
session_destroy();

$con = NULL;

header('Location: ../index/index.php');


?>
