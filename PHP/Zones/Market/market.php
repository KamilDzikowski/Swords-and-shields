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
            <a href="market.php?type=armor" >Zbroje</a>
   	      <a href="market.php?type=shield" >Tarcze</a>
   	      <a href="market.php?type=weapon_melee_1" >Broń Jednoręczna</a>
   	      <a href="market.php?type=weapon_melee_2" >Broń Dwuręczna</a>
   	      <a href="market.php?type=weapon_ranged" >Broń Dystansowa</a>
            <a href="market.php?type=ammo" >Amunicja</a><br>
   	      <a href="gamble.php" >Hazard</a>
   	      <?php
   		      $type = '';
   		      if(isset($_GET['type'])) $type = $_GET['type'];
   		      echo '<a href="exhibition.php?type='.$type.'" >Wystawianie</a> ';
   	      ?>
   	      <a href="../../../zone.php">Miasto</a>
      </div>
	<?php
	      session_start();
		$_SESSION['tech']['path'] = 'PHP/Zones/Market/';
		$_SESSION['tech']['file'] = 'market.php';
		$pdo = new PDO('mysql:host=localhost;dbname=konta', 'root', 'lampa123', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
		if($type == 'armor')
		{
			echo '<div class="item"><font size="5">Zbroje</font><br></div>';
			$stmt = $pdo -> query("SELECT * FROM auction WHERE type = 'armor'");
			echo '<table border="2">';
			echo '<tr><td><b>Nazwa</b></td><td><b>Cena</b></td><td><b>Koniec</b></td><td><b>Kup</b></td></tr>';
			$counter = 1;
			if($stmt != NULL) foreach($stmt as $auction)
			{
				$time = $auction['end']-time();
				if($time <= 0)
				{
					$pdo -> exec("DELETE FROM auction WHERE id =".$auction['id']);
					$pdo -> exec("UPDATE ownership SET id_post = ".$auction['id_owner']." WHERE id = ".$auction['id_ownership']);
					continue;
				}
				$stmt2 = $pdo -> query("SELECT * FROM ownership WHERE id =".$auction['id_ownership']);
				$ownership = $stmt2 -> fetch();
				$stmt2 -> closeCursor();
				$stmt2 = $pdo -> query("SELECT * FROM item_armor WHERE id =".$ownership['id_item']);
				$item = $stmt2 -> fetch();
				$stmt2 -> closeCursor();
				echo '<tr>';
				echo '<td>'.$item['name'].'</td>';
				echo '<td>'.$auction['value'].'</td>';
				if($time < 60) echo '<td>'.$time.' sekund</td>';
				else if($time < 3600) echo '<td>'.ceil($time/60).'  minut</td>';
				else if($time < 86400) echo '<td>'.ceil($time/3600).' godzin</td>';
				else echo '<td>'.ceil($time/86400).'    dni</td>';
				$_SESSION['tech']['link'.$counter] = 'purchase.php?type=armor&id='.$auction['id'];
				echo '<td><a href="../../../links.php?nr='.$counter.'">Kup</a></td>';
				echo '</tr>';
				++$counter;
			}
			echo '</table>';
		}
		else if($type == 'shield')
		{
			echo '<div class="item"><font size="5">Tarcze</font><br></div>';
			$stmt = $pdo -> query("SELECT * FROM auction WHERE type = 'shield'");
			echo '<table border="2">';
			echo '<tr><td><b>Nazwa</b></td><td><b>Cena</b></td><td><b>Koniec</b></td><td><b></b></td></tr>';
			$counter = 1;
			if($stmt != NULL) foreach($stmt as $auction)
			{
				$time = $auction['end']-time();
				if($time <= 0)
				{
					$pdo -> exec("DELETE FROM auction WHERE id =".$auction['id']);
					$pdo -> exec("UPDATE ownership SET id_post = ".$auction['id_owner']." WHERE id = ".$auction['id_ownership']);
					continue;
				}
				$stmt2 = $pdo -> query("SELECT * FROM ownership WHERE id =".$auction['id_ownership']);
				$ownership = $stmt2 -> fetch();
				$stmt2 -> closeCursor();
				$stmt2 = $pdo -> query("SELECT * FROM item_shield WHERE id =".$ownership['id_item']);
				$item = $stmt2 -> fetch();
				$stmt2 -> closeCursor();
				echo '<tr>';
				echo '<td>'.$item['name'].'</td>';
				echo '<td>'.$auction['value'].'</td>';
				if($time < 60) echo '<td>'.$time.' sekund</td>';
				else if($time < 3600) echo '<td>'.ceil($time/60).'  minut</td>';
				else if($time < 86400) echo '<td>'.ceil($time/3600).' godzin</td>';
				else echo '<td>'.ceil($time/86400).'    dni</td>';
				$_SESSION['tech']['link'.$counter] = 'purchase.php?type=shield&id='.$auction['id'];
				echo '<td><a href="../../../links.php?nr='.$counter.'">Kup</a></td>';
				echo '</tr>';
			}
			echo '</table>';
		}
		else if($type == 'weapon_melee_1' || $type == 'weapon_melee_2')
		{
		      if($type == 'weapon_melee_1') $handedness = 1;
		      else if($type == 'weapon_melee_2') $handedness = 2;
			echo '<div class="item"><font size="5">Broń '.(($handedness == 1)? 'jednoręczna' : 'dwuręczna').'</font><br></div>';
			$stmt = $pdo -> query("SELECT * FROM auction WHERE type = 'weapon_melee'");
			echo '<table border="2">';
			echo '<tr><td><b>Nazwa</b></td><td><b>Cena</b></td><td><b>Koniec</b></td><td><b></b></td></tr>';
			$counter = 1;
			if($stmt != NULL) foreach($stmt as $auction)
			{
				$time = $auction['end']-time();
				if($time <= 0)
				{
					$pdo -> exec("DELETE FROM auction WHERE id =".$auction['id']);
					$pdo -> exec("UPDATE ownership SET id_post = ".$auction['id_owner']." WHERE id = ".$auction['id_ownership']);
					continue;
				}
				$stmt2 = $pdo -> query("SELECT * FROM ownership WHERE id =".$auction['id_ownership']);
				$ownership = $stmt2 -> fetch();
				$stmt2 -> closeCursor();
				$stmt2 = $pdo -> query("SELECT * FROM item_weapon_melee WHERE id =".$ownership['id_item']." AND handedness = ".$handedness);
				$item = $stmt2 -> fetch();
				$stmt2 -> closeCursor();
				if($item == NULL) continue;
                        echo '<tr>';
				echo '<td>'.$item['name'].'</td>';
				echo '<td>'.$auction['value'].'</td>';
				if($time < 60) echo '<td>'.$time.' sekund</td>';
				else if($time < 3600) echo '<td>'.ceil($time/60).'  minut</td>';
				else if($time < 86400) echo '<td>'.ceil($time/3600).' godzin</td>';
				else echo '<td>'.ceil($time/86400).'    dni</td>';
				$_SESSION['tech']['link'.$counter] = 'purchase.php?type=weapon_melee&id='.$auction['id'];
				echo '<td><a href="../../../links.php?nr='.$counter.'">Kup</a></td>';
				echo '</tr>';
			}
			echo '</table>';
		}
		else if($type == 'weapon_ranged')
		{
			echo '<div class="item"><font size="5">Broń dystansowa</font><br></div>';
			$stmt = $pdo -> query("SELECT * FROM auction WHERE type = 'weapon_ranged'");
			echo '<table border="2">';
			echo '<tr><td><b>Nazwa</b></td><td><b>Atak</b></td><td><b>Ręczność</b></td><td><b>Cena</b></td><td><b>Koniec</b></td><td><b></b></td></tr>';
			$counter = 1;
			if($stmt != NULL) foreach($stmt as $auction)
			{
				$time = $auction['end']-time();
				if($time <= 0)
				{
					$pdo -> exec("DELETE FROM auction WHERE id =".$auction['id']);
					$pdo -> exec("UPDATE ownership SET id_post = ".$auction['id_owner']." WHERE id = ".$auction['id_ownership']);
					continue;
				}
				$stmt2 = $pdo -> query("SELECT * FROM ownership WHERE id =".$auction['id_ownership']);
				$ownership = $stmt2 -> fetch();
				$stmt2 -> closeCursor();
				$stmt2 = $pdo -> query("SELECT * FROM item_weapon_ranged WHERE id =".$ownership['id_item']);
				$item = $stmt2 -> fetch();
				$stmt2 -> closeCursor();
				echo '<tr>';
				echo '<td>'.$item['name'].'</td>';
				echo '<td>'.$auction['value'].'</td>';
				if($time < 60) echo '<td>'.$time.' sekund</td>';
				else if($time < 3600) echo '<td>'.ceil($time/60).'  minut</td>';
				else if($time < 86400) echo '<td>'.ceil($time/3600).' godzin</td>';
				else echo '<td>'.ceil($time/86400).'    dni</td>';
				$_SESSION['tech']['link'.$counter] = 'purchase.php?type=weapon_ranged&id='.$auction['id'];
				echo '<td><a href="../../../links.php?nr='.$counter.'">Kup</a></td>';
				echo '</tr>';
			}
			echo '</table>';
		}
		$_SESSION['tech']['file'] .= '?type='.$type;
	?>
</div>
