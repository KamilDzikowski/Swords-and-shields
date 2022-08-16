<?php
require_once('../../../Classes/hero.php');
session_start();
$pdo = new PDO('mysql:host=localhost;dbname=konta', 'root', 'lampa123', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
$pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
if(!is_numeric($_POST['restriction']) || !is_numeric($_POST['bid'])) header('Location: arena.php');
else if($_SESSION['hero']['cash'] < $_POST['bid'])
{
	$_SESSION['tech']['text'] = 'Nie masz wystarczającej ilości gotówki';
	$_SESSION['tech']['link'] = 'PHP/Czynnosci/Arena/arena.php';
	header('Location: ../../../communication.php');
}
else
{
	$pdo -> exec("INSERT INTO arena_notification (hero_id, zone, bid, restriction) VALUES (".$_SESSION['hero']['id'].", ".$_SESSION['hero']['zone'].", ".$_POST['bid'].", ".$_POST['restriction'].")");
	$stmt = $pdo -> query("SELECT id FROM arena_notification WHERE hero_id = ".$_SESSION['hero']['id']);
	$notification = $stmt -> fetch();
      $stmt -> closeCursor();
      $_SESSION['hero']['action_var'] = $notification['id'];
      header('Location: arena.php');
}
?>                       