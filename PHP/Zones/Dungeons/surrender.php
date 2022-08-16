<?php
session_start();
unset($_SESSION['encounter']);
header('Location: entrance.php');
?>
