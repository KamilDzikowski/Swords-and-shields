<?php
require_once('../../../Classes/hero.php');
require_once('../../../Classes/duel.php');
session_start();
$pdo = new PDO('mysql:host=localhost;dbname=konta', 'root', 'lampa123', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
$pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
if($_SESSION['hero']['number'] == 1)
{
      $stmt = $pdo -> query("SELECT direction_challenger, turn FROM arana_duel WHERE id_challenger = ".$_SESSION['hero']['id']);
      $data = $stmt -> fetch();
      $stmt -> closeCursor();
      $direction = $data['position_challenger'] *= -1;      
      $pdo -> exec("UPDATE INTO arena_duel (direction_challenger) VALUES (".$direction.")");
}
else if($_SESSION['hero']['number'] == 2)
{
      $stmt = $pdo -> query("SELECT direction_challenged, turn FROM arana_duel WHERE id_challenged = ".$_SESSION['hero']['id']);
      $data = $stmt -> fetch();
      $stmt -> closeCursor();
      $direction = $data['direction_challenged'] + $data['direction_challenged'];      
      $pdo -> exec("UPDATE INTO arena_duel (direction_challenged) VALUES (".$direction.")");
}
$_SESSION['duel']->hero['mobility'] = $_SESSION['duel']->hero['mobility'] - 1;
if($_SESSION['duel']->hero['mobility'] == 0) $turn = 3 - $data['turn'];
$pdo -> exec("UPDATE INTO arena_duel (turn) VALUES (".$turn.")");
header('Location: battle.php');
?>
	
