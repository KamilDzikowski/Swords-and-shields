<?php
session_start();
unset($_SESSION['duel']);
$pdo = new PDO('mysql:host=localhost;dbname=konta', 'root', 'lampa123', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
$pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$pdo -> exec("UPDATE INTO arena_duel (turn) VALUES (0)");
header('Location: arena.php');
?>
