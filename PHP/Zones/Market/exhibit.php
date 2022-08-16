<?php
require_once('../../../Classes/hero.php');
session_start();
if(!isset($_POST['value']) || !is_numeric($_POST['value']) || !isset($_GET['id']) || !is_numeric($_GET['id'])) header('Location: exhibition.php');
else if($_GET['type'] != 'armor' && $_GET['type'] != 'shield' && $_GET['type'] != 'weapon_melee' && $_GET['type'] != 'weapon_ranged') header('Location: exhibition.php');
else
{
	$pdo = new PDO('mysql:host=localhost;dbname=konta', 'root', 'lampa123', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
	$pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$pdo -> exec("INSERT INTO auction (id_owner, end, value, type, id_ownership, zone) VALUES (".$_SESSION['hero']['id'].", ".(time() + 172800).", ".$_POST['value'].", '".$_GET['type']."', ".$_GET['id']." , ".$_SESSION['hero']['zone'].")");
	$pdo -> exec("UPDATE ownership SET id_hero = 0 WHERE id = ".$_GET['id']);
}
header('Location: '.$_SESSION['tech']['file']);
?>
