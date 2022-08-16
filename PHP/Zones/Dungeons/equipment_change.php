<!DOCTYPE html
	PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.batman.com">
<LINK rel="stylesheet" href="../../../Style/style_zone.css" type="text/css"></LINK>
<html xmlns="www.google.pl" xml:lang="pl" lang="pl">
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<meta name="Description" content="Tu wpisz opis zawartości strony" />
	<meta name="Keywords" content="Tu wpisz wyrazy kluczowe rozdzielone przecinkami" />
	<!--<meta http-equiv="Refresh" content="5" /> -->
	<title>Start</title>
</head>
<div id="page">
	<div id="tabs">
            <a href="equipment_change.php?type=armor">Zbroje</a>
            <a href="equipment_change.php?type=shield">Tarcze</a>
            <a href="equipment_change.php?type=weapon_melee_1">Broń Jednoręczna</a>
            <a href="equipment_change.php?type=weapon_melee_2">Broń Dwuręczna</a>
            <a href="equipment_change.php?type=weapon_ranged">Broń Dystansowa</a>
            <a href="equipment_change.php?type=ammo">Amunicja</a><br>
            <a href="battle.php">Powrót</a>
      </div>
	<?php
	require_once('../../../Classes/hero.php');
	require_once('../../../Classes/encounter.php');
	require_once('../../Functions/show_ownership.php');
	session_start();
	$type = '';
	if(isset($_GET['type'])) $type = $_GET['type'];
	$_SESSION['tech']['path'] = 'PHP/Zones/Dungeons/';
	$_SESSION['tech']['file'] = 'equipment_change.php?type='.$type;
	$pdo = new PDO('mysql:host=localhost;dbname=konta', 'root', 'lampa123', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
	$pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	if($type == 'armor')
      {
		show_armor($pdo, $_SESSION['hero'], '../../../', array('level'), array('Poziom'), array('constitution_requirements'), array('Budowa'), 0, 'item_replace.php', 'Załóż', $_SESSION['hero']['armor'], '', 'Założone');
      }
   	else if($type == 'shield')
   	{
   		show_shield($pdo, $_SESSION['hero'], '../../../', array('level'), array('Poziom'), array('dexterity_requirements'), array('Zręczność'), 0, 'item_replace.php', 'Załóż', $_SESSION['hero']['hand_left'], '', 'Założone');
      }
   	else if($type == 'weapon_melee_1')
   	{
   		show_weapon_melee($pdo, $_SESSION['hero'], '../../../', array('level'), array('Poziom'), array('strength_requirements', 'dexterity_requirements'), array('Siła', 'Zręczność'), 0, 'item_replace.php', 'Załóż', $_SESSION['hero']['hand_right'], '', 'Założone', 1);
      }
	else if($type == 'weapon_melee_2')
   	{
   		show_weapon_melee($pdo, $_SESSION['hero'], '../../../', array('level'), array('Poziom'), array('strength_requirements', 'dexterity_requirements'), array('Siła', 'Zręczność'), 0, 'item_replace.php', 'Załóż', $_SESSION['hero']['hand_right'], '', 'Założone', 2);
      }
   	else if($type == 'weapon_ranged')
   	{
   		show_weapon_ranged($pdo, $_SESSION['hero'], '../../../', array('level'), array('Poziom'), array('strength_requirements', 'dexterity_requirements'), array('Siła', 'Zręczność'), 0, 'item_replace.php', 'Załóż', $_SESSION['hero']['hand_right'], '', 'Założone');
      }
      else if($type == 'ammo')
   	{
   		show_ammo($pdo, $_SESSION['hero'], '../../../', array('level', 'amount'), array('Poziom', 'Ilość'), NULL, NULL, 0, 'item_replace.php', 'Załóż', $_SESSION['hero']['ammo'], '', 'Założone', false);
      }
?>
</div>
