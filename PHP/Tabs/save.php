<?php
require_once('../../Classes/hero.php');
session_start();
$_SESSION['hero']->save();
header('Location: ../../main.php');
?>
