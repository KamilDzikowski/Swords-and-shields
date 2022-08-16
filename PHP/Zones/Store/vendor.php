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
            <a href='vendor.php?type=armor'>Zbroje</a>
            <a href='vendor.php?type=shield'>Tarcze</a>
            <a href='vendor.php?type=weapon_melee_1'>Broń Jednoręczna</a>
            <a href='vendor.php?type=weapon_melee_2'>Broń Dwuręczna</a>
            <a href='vendor.php?type=weapons_ranged'>Broń Dystansowa</a>
            <a href='vendor.php?type=ammo'>Amunicja</a>
            <a href='vendor.php?type=tool'>Narzędzia</a><br>
            <?php
                  $type = '';
                  if(isset($_GET['type'])) $type = $_GET['type'];
                  echo '<a href="merchant.php?type='.$type.'">Kupiec</a>';
            ?>
            <a href="../../../zone.php">Miasto</a>
      </div>
	<?php
		require_once('../../../Classes/hero.php');
		session_start();
		$_SESSION['tech']['path'] = 'PHP/Zones/Store/';
		$_SESSION['tech']['file'] = 'vendor.php';
		$pdo = new PDO('mysql:host=localhost;dbname=konta', 'root', 'lampa123', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
		$pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		if($type == 'armor')
		{
			echo '<div class="item"><font size="5">Zbroje</font><br><br></div>';
			echo '<table border="2">';
			echo '<tr><td><b>Nazwa</b></td><td><b>Budowa</b></td><td><b>Cena</b></td><td><b>Kup</b></td></tr>';
			$stmt = $pdo -> query("SELECT id, name, constitution_requirements, value FROM item_armor ORDER BY value");
			foreach($stmt as $item)
			{
				echo '<tr>';
				echo '<td>'.$item['name'].'</td>';
				echo '<td>'.$item['constitution_requirements'].'</td>';
				echo '<td>'.$item['value'].'</td>';
				echo '<td><a href="purchase.php?type=armor&id='.$item['id'].'">Kup</a></td>';
				echo '</tr>';
  			}
			$stmt -> closeCursor();
  			echo '</table>';
		}
            else if($type == 'shield')
            {
         		echo '<div class="item"><font size="5">Tarcze</font><br><br></div>';
                  echo '<table border="2">';
			echo '<tr><td><b>Nazwa</b></td><td><b>Zręczność</b></td><td><b>Cena</b></td><td><b>Kup</b></td></tr>';
			$stmt = $pdo -> query("SELECT id, name, dexterity_requirements, value FROM item_shield ORDER BY value");
			foreach($stmt as $item)
   		      {
				echo '<tr>';
				echo '<td>'.$item['name'].'</td>';
				echo '<td>'.$item['dexterity_requirements'].'</td>';
				echo '<td>'.$item['value'].'</td>';
				echo '<td><a href="purchase.php?type=shield&id='.$item['id'].'">Kup</a></td>';
				echo '</tr>';
  			}
  			$stmt -> closeCursor();
  			echo '</table>';
  		}
   	      else if($type == 'weapon_melee_1')
            {
                  echo '<div class="item"><font size="5">Broń jednoręczna</font><br><br></div>';
			echo '<table border="2">';
			echo '<tr><td><b>Nazwa</b></td><td><b>Siła</b></td><td><b>Zręczność</b></td></td><td><b>Cena</b></td><td><b>Kup</b></td></tr>';
			$stmt = $pdo -> query("SELECT id, name, strength_requirements, dexterity_requirements, value FROM item_weapon_melee WHERE handedness = 1 ORDER BY value");
			foreach($stmt as $item)
                  {
				echo '<tr>';
				echo '<td>'.$item['name'].'</td>';
				echo '<td>'.$item['strength_requirements'].'</td>';
				echo '<td>'.$item['dexterity_requirements'].'</td>';
				echo '<td>'.$item['value'].'</td>';
				echo '<td><a href="purchase.php?type=weapon_melee&id='.$item['id'].'">Kup</a></td>';
				echo '</tr>';
  			}
  			$stmt -> closeCursor();
			echo '</table>';
  		}
  		else if($type == 'weapon_melee_2')
  		{
  			echo '<div class="item"><font size="5">Broń dwuręczna</font><br><br></div>';
			echo '<table border="2">';
			echo '<tr><td><b>Nazwa</b></td><td><b>Siła</b></td><td><b>Zręczność</b></td><td><b>Cena</b></td><td><b>Kup</b></td></tr>';
			$stmt = $pdo -> query("SELECT id, name, strength_requirements, dexterity_requirements, value FROM item_weapon_melee WHERE handedness = 2 ORDER BY value");
			foreach($stmt as $item)
                  {
				echo '<tr>';
				echo '<td>'.$item['name'].'</td>';
				echo '<td>'.$item['strength_requirements'].'</td>';
				echo '<td>'.$item['dexterity_requirements'].'</td>';
				echo '<td>'.$item['value'].'</td>';
                        echo '<td><a href="purchase.php?type=weapon_ranged&id='.$item['id'].'">Kup</a></td>';
				echo '</tr>';
  			}
  			$stmt -> closeCursor();
			echo '</table>';
  		}
            else if($type == 'weapons_ranged')
		{
			echo '<div class="item"><font size="5">Broń dystansowa</font><br><br></div>';
			echo '<table border="2">';
			echo '<tr><td><b>Nazwa</b></td><td><b>Siła</b></td><td><b>Zręczność</b></td><td><b>Cena</b></td><td><b>Kup</b></td></tr>';
			$stmt = $pdo -> query("SELECT id, name, strength_requirements, dexterity_requirements, value FROM item_weapon_ranged ORDER BY value");
			foreach($stmt as $item)
                  {
				echo '<tr>';
				echo '<td>'.$item['name'].'</td>';
				echo '<td>'.$item['strength_requirements'].'</td>';
				echo '<td>'.$item['dexterity_requirements'].'</td>';
				echo '<td>'.$item['value'].'</td>';
				echo '<td><a href="purchase.php?type=weapon_ranged&id='.$item['id'].'">Kup</a></td>';
				echo '</tr>';
  			}
  			$stmt -> closeCursor();
  			echo '</table>';
  		}
		else if($type == 'ammo')
		{
			echo '<div class="item"><font size="5">Narzędzia</font><br><br></div>';
			echo '<table border="2">';
			echo '<tr><td><b>Nazwa</b></td><td><b>Cena</b></td><td><b>Ilość</b></td><td><b>Kup</b></td></tr>';
			$stmt = $pdo -> query("SELECT id, name, value, stack FROM item_ammo ORDER BY value");
			foreach($stmt as $item)
			{
				echo '<tr>';
				echo '<td>'.$item['name'].'</td>';
				echo '<td>'.$item['value'].'</td>';
				echo '<td>'.$item['stack'].'</td>';
				echo '<td><a href="purchase.php?type=ammo&id='.$item['id'].'">Kup</a></td>';
				echo '</tr>';
  			}
			$stmt -> closeCursor();
  			echo '</table>';
		}
		else if($type == 'tool')
		{
			echo '<div class="item"><font size="5">Amunicja</font><br><br></div>';
			echo '<table border="2">';
			echo '<tr><td><b>Nazwa</b></td><td><b>Cena</b></td><td><b>Kup</b></td></tr>';
			$stmt = $pdo -> query("SELECT id, name, value, stack FROM item_tool ORDER BY value");
			foreach($stmt as $item)
			{
				echo '<tr>';
				echo '<td>'.$item['name'].'</td>';
				echo '<td>'.$item['value'].'</td>';
				echo '<td><a href="purchase.php?type=tool&id='.$item['id'].'">Kup</a></td>';
				echo '</tr>';
  			}
			$stmt -> closeCursor();
  			echo '</table>';
		}
  		$_SESSION['tech']['file'] .= '?type='.$type;
	?>
</div>
