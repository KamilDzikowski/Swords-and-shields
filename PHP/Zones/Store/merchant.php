<!DOCtypeE html
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
            <a href='merchant.php?type=armor' >Zbroje</a>
            <a href='merchant.php?type=shield' >Tarcze</a>
            <a href='merchant.php?type=weapon_melee_1' >Broń Jednoręczna</a>
            <a href='merchant.php?type=weapon_melee_2' >Broń Dwuręczna</a>
            <a href='merchant.php?type=weapon_ranged' >Broń Dystansowa</a>
            <a href='merchant.php?type=ammo' >Amunicja</a><br>
            <?php
                  require_once('../../../Classes/hero.php');
                  session_start();
                  $_SESSION['tech']['path'] = 'PHP/Zones/Store/';
                  $_SESSION['tech']['file'] = 'merchant.php';
                  $type = '';
                  if(isset($_GET['type'])) $type = $_GET['type'];
                  echo '<a href="vendor.php?type='.$type.'" >Sprzedawca</a> ';
            ?>
            <a href="../../../zone.php">Miasto</a>
      </div>
      <?php
            $pdo = new PDO('mysql:host=localhost;dbname=konta', 'root', 'lampa123', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            include_once('../../Functions/show_ownership.php');
            if($type == 'armor')
            {
                  show_armor($pdo, $_SESSION['hero'], '../../../', array('level'), array('Poziom'), array('value', 'value_improve'), NULL, 0, 'sell.php', 'Sprzedaj', $_SESSION['hero']['armor'], '', 'Założone', 'prize', array('Cena sprzedaży'), 0.5);
   		}
   		else if($type == 'shield')
   		{
   		      show_shield($pdo, $_SESSION['hero'], '../../../', array('level'), array('Poziom'), array('value', 'value_improve'), NULL, 0, 'sell.php', 'Sprzedaj', $_SESSION['hero']['hand_left'], '', 'Założone', 'prize', array('Cena sprzedaży'), 0.5);
            }
   		else if($type == 'weapon_melee_1')
   		{
   		      show_weapon_melee($pdo, $_SESSION['hero'], '../../../', array('level'), array('Poziom'), array('value', 'value_improve'), NULL, 0, 'sell.php', 'Sprzedaj', $_SESSION['hero']['hand_right'], '', 'Założone', 1, 'prize', array('Cena sprzedaży'), 0.5);
	      }
		else if($type == 'weapon_melee_2')
   		{
   		      show_weapon_melee($pdo, $_SESSION['hero'], '../../../', array('level'), array('Poziom'), array('value', 'value_improve'), NULL, 0, 'sell.php', 'Sprzedaj', $_SESSION['hero']['hand_right'], '', 'Założone', 2, 'prize', array('Cena sprzedaży'), 0.5);
		}
   		else if($type == 'weapon_ranged')
   		{
   		      show_weapon_ranged($pdo, $_SESSION['hero'], '../../../', array('level'), array('Poziom'), array('value', 'value_improve'), NULL, 0, 'sell.php', 'Sprzedaj', $_SESSION['hero']['hand_right'], '', 'Założone', 'prize', array('Cena sprzedaży'), 0.5);
   		}
   		else if($type == 'ammo')
   		{
   		      show_ammo($pdo, $_SESSION['hero'], '../../../', array('level'), array('Poziom'), array('value', 'value_improve'), NULL, 0, 'sell.php', 'Sprzedaj', $_SESSION['hero']['ammo'], '', 'Założone', false, 'prize', array('Cena sprzedaży'), 0.5);
   		}
            $_SESSION['tech']['file'] .= '?type='.$type;
      ?>
</div>
