<?php
require_once('../../../Classes/hero.php');
session_start();
$_SESSION['hero']['life'] = floor($_SESSION['hero']['life_max'] - ($_SESSION['hero']['time'] - time()) / $_SESSION['hero']['action_var']); 
$_SESSION['hero']['action'] = 0;
$_SESSION['hero']['time'] = 0;
$_SESSION['hero']['action_var'] = 0;
header('Location: temple.php');
?>