<?php
require_once('../../../Classes/hero.php');
session_start();
try
{
      $pdo = new PDO('mysql:host=localhost;dbname=konta', 'root', 'lampa123', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
      $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$stmt = $pdo -> query("SELECT hero_id FROM ownership WHERE id =".$_GET['id']);
	$ownership = $stmt -> fetch();
	$stmt -> closeCursor();
	if($ownership['hero_id'] != $_SESSION['hero']['id']) throw new Exception('Nie jesteś właścicielem.');
	$pdo -> exec("UPDATE ownership SET stored = 1 WHERE id=".$_GET['id']);
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
