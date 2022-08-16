<!DOCtypeE html
	PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.batman.com">
<LINK rel="stylesheet" href="../../../Style/style_trade.css" typee="text/css"></LINK>
<html xmlns="www.google.pl" xml:lang="pl" lang="pl">
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<meta name="Description" content="Tu wpisz opis zawartości strony" />
	<meta name="Keywords" content="Tu wpisz wyrazy kluczowe rozdzielone przecinkami" />
	<title>Start</title>
</head>
<div id="page">
	<div id="tabs">
            <a href='storehouse.php?type=armor' >Zbroje</a>
            <a href='storehouse.php?type=shield' >Tarcze</a>
            <a href='storehouse.php?type=weapon_melee_1' >Broń Jednoręczna</a>
            <a href='storehouse.php?type=weapon_melee_2' >Broń Dwuręczna</a>
            <a href='storehouse.php?type=weapon_ranged' >Broń Dystansowa</a><br>
            <?php
                  $type = '';
                  if(isset($_GET['type'])) $type = $_GET['type'];
                  echo '<a href="insertion.php?type='.$type.'">Wkładanie</a>';
            ?>
            <a href="../../../zone.php" >Miasto</a><br>
      </div>
	<?php
		require_once('../../../Classes/hero.php');
            session_start();
		include_once('../../Functions/show_ownership.php');
		$_SESSION['tech']['path'] = 'PHP/Zones/Storehouse/';
		$_SESSION['tech']['file'] = 'storehouse.php';
		$pdo = new PDO('mysql:host=localhost;dbname=konta', 'root', 'lampa123', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
		$pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  		if($type == 'armor')
            {
                  show_armor($pdo, $_SESSION['hero'], '../../../', array('level'), array('Poziom'), NULL, NULL, 1, 'withdraw.php', 'Wyjmij', $_SESSION['hero']['armor'], '', 'Założone');
   		}
   		else if($type == 'shield')
   		{
   		      show_shield($pdo, $_SESSION['hero'], '../../../', array('level'), array('Poziom'), NULL, NULL, 1, 'withdraw.php', 'Wyjmij', $_SESSION['hero']['hand_left'], '', 'Założone');
            }
   		else if($type == 'weapon_melee_1')
   		{
   		      show_weapon_melee($pdo, $_SESSION['hero'], '../../../', array('level'), array('Poziom'), NULL, NULL, 1, 'withdraw.php', 'Wyjmij', $_SESSION['hero']['hand_right'], '', 'Założone', 1);
	      }
		else if($type == 'weapon_melee_2')
   		{
   		      show_weapon_melee($pdo, $_SESSION['hero'], '../../../', array('level'), array('Poziom'), NULL, NULL, 1, 'withdraw.php', 'Wyjmij', $_SESSION['hero']['hand_right'], '', 'Założone', 2);
		}
   		else if($type == 'weapon_ranged')
   		{
   		      show_weapon_ranged($pdo, $_SESSION['hero'], '../../../', array('level'), array('Poziom'), NULL, NULL, 1, 'withdraw.php', 'Wyjmij', $_SESSION['hero']['hand_right'], '', 'Założone');
   		}
   		else if($type == 'ammo')
   		{
   		      show_ammo($pdo, $_SESSION['hero'], '../../../', array('level'), array('Poziom'), NULL, NULL, 1, 'withdraw.php', 'Wyjmij', $_SESSION['hero']['ammo'], '', 'Założone');
   		}
  		$_SESSION['tech']['file'] .= '?type='.$type;
	?>
</div>
