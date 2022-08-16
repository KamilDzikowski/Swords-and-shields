<?php
require_once('../../../Classes/hero.php');
require_once('../../../Classes/encounter.php');
session_start();
$_SESSION['encounter']->hero['direction'] *= -1;
$_SESSION['encounter']->hero['mobility'] -= 1;
if($_SESSION['encounter']->hero['mobility'] == 0) $_SESSION['encounter']->battlefield['turn'] = 0;
header('Location: battle.php');
?>
