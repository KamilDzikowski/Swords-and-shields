<?php
require_once('../../../Classes/hero.php');
require_once('../../Functions/equipment.php');
session_start();
try
{
      $pdo = new PDO('mysql:host=localhost;dbname=konta', 'root', 'lampa123', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
      $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	if(is_equipped($_GET['id']) == true) throw new Exception('Nosisz to.');
      $stmt = $pdo -> query("SELECT hero_id, item_type, item_id, level FROM ownership WHERE id =".$_GET['id']);
	$ownership = $stmt -> fetch();
	$stmt -> closeCursor();
	if($ownership['hero_id'] != $_SESSION['hero']['id']) throw new Exception('Nie jesteś właścicielem.');
	$stmt = $pdo -> query("SELECT value, value_improve FROM item_".$ownership['item_type']." WHERE id =".$ownership['item_id']);
	$item = $stmt -> fetch();
	$stmt -> closeCursor();
	$pdo -> exec("DELETE FROM ownership WHERE id =".$_GET['id']);
	$_SESSION['hero']['cash'] += round(($item['value'] + $ownership['level']*$item['value_improve'])/2);
	header('Location: '.$_SESSION['tech']['file']);
}
catch(PDOException $e)
{
      $_SESSION['tech']['text'].= 'Błąd PDO';
      header('Location: ../../../error.php');
}
catch(Exception $e)
{
      $_SESSION['tech']['text'].= $e -> getMessage();
      header('Location: ../../../error.php');
}
?>
