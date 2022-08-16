<!DOCTYPE html
	PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.batman.com">
<LINK rel="stylesheet" href="../../../Style/style_trade.css" type="text/css"></LINK>
<html xmlns="www.google.pl" xml:lang="pl" lang="pl">
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<meta name="Description" content="Tu wpisz opis zawartości strony" />
	<meta name="Keywords" content="Tu wpisz wyrazy kluczowe rozdzielone przecinkami" />
	<title>Start</title>
</head>
<div id="page">
	<div id="tabs">
   	<a href="market.php" >Targowisko</a>
   	<a href="exhibition.php" >Wystawianie</a><br>
   	<a href="../../../zone.php">Miasto</a>
  </div>
      Witaj, wybierz kubek. Jak ci się poszczęści to wygrasz 5 sz. Jak ci się nie uda to musisz zapłacić 3 sz.<br>
	<?php
		require_once('../../../Classes/hero.php');
		session_start();
		$pdo = new PDO('mysql:host=localhost;dbname=konta', 'root', 'lampa123', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
		$pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$_SESSION['tech']['path'] = 'PHP/Zones/Market/';
		$_SESSION['tech']['file'] = 'gamble.php';
		if($_SESSION['hero']['cash'] >= 3)
		{
			echo '<a href="rand.php">Kubek nr 1</a><br>';
			echo '<a href="rand.php">Kubek nr 2</a><br>';
			echo '<a href="rand.php">Kubek nr 3</a><br>';
		}
		else 
		{
			echo 'Jesteś spłukany. Możesz się tylko przyglądać jak inni próbują szczęścia.<br>';
		}
	?>
</div>
