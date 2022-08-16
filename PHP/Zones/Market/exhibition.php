<!DOCtypeE html
	PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.batman.com">
<LINK rel="stylesheet" href="../../../Style/style_trade.css" type="text/css"></LINK>
<html xmlns="www.google.pl" xml:lang="pl" lang="pl">
<head>
	<meta http-equiv="content-typee" content="text/html; charset=UTF-8" />
	<meta name="Description" content="Tu wpisz opis zawartości strony" />
	<meta name="Keywords" content="Tu wpisz wyrazy kluczowe rozdzielone przecinkami" />
	<title>Start</title>
</head>
<div id="page">
      <div id="tabs">
   	<a href="exhibition.php?type=armor" >Zbroje</a>
   	<a href="exhibition.php?type=shield" >Tarcze</a>
   	<a href="exhibition.php?type=weapon_melee_1" >Broń Jednoręczna</a>
	<a href="exhibition.php?type=weapon_melee_2" >Broń Dwuręczna</a>
   	<a href="exhibition.php?type=weapon_ranged" >Broń Dystansowa</a><br>
   	<a href="gamble.php" >Hazard</a>
   	<?php
  		$type = '';
   		if(isset($_GET['type'])) $type = $_GET['type'];
   		echo '<a href="market.php?type='.$type.'" >Oferty</a> ';
   	?>
   	<a href="../../../zone.php">Miasto</a>
      </div>
   <?php
   	include_once('show_ownership.php');
   	require_once('../../../Classes/hero.php');
      session_start();
   	$_SESSION['tech']['path'] = 'PHP/Zones/Market/';
	$_SESSION['tech']['file'] = 'exhibition.php';
   	$pdo = new PDO('mysql:host=localhost;dbname=konta', 'root', 'lampa123', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
   	if($type == 'armor')
   	{
   		show_armor($pdo, $_SESSION['hero']);
   	}
   	else if($type == 'shield')
   	{
   		show_shield($pdo, $_SESSION['hero']);
   	}
   	else if($type == 'weapon_melee_1')
   	{
   		show_weapon_melee($pdo, $_SESSION['hero'], 1);
	}
	else if($type == 'weapon_melee_2')
   	{
   		show_weapon_melee($pdo, $_SESSION['hero'], 2);
	}
   	else if($type == 'weapon_ranged')
   	{
   		show_weapon_ranged($pdo, $_SESSION['hero']);
   	}
   	$_SESSION['tech']['file'].= '?type='.$type;
   ?>
</div>
