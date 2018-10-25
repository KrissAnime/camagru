<?php

session_start();
require('../config/setup.php');

session_unset();
session_destroy();

$con = NULL;

header('Location: ../index.php');


?>
