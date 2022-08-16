<?php
require_once('../../../Classes/hero.php');
session_start();
$_SESSION['hero']['action'] = 0;
$_SESSION['hero']['time'] = 0;
$_SESSION['hero']['action_var'] = 0;
header('Location: ../../../zone.php');
?>
