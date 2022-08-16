<?php
require_once('../../Classes/hero.php');
session_start();
session_unset();
header("Location: ../../main.php");
?>
