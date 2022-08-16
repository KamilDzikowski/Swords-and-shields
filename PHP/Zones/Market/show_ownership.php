<?php
function show_armor($pdo, $hero)
{
   echo '<div class="item"><font size="5">Zbroje</font><br><br></div>';
   $stmt = $pdo -> query("SELECT id_item, id FROM ownership WHERE id_hero = ".$hero['id']." AND type_item = 'armor' AND stored = 0 ORDER BY id_item");
   echo '<table border="2">';
   echo '<tr><td><b>Nazwa</b></td><td><b>Cena w sklepie</b></td><td><b>Twoja cena</b></td><td><b>exhibit</b></td></tr>';
   $counter = 1;
   foreach($stmt as $ownership)
   {
		$stmt2 = $pdo -> query("SELECT * FROM item_armor WHERE id = ".$ownership['id_item']);
		$item = $stmt2 -> fetch();
		$stmt2 -> closeCursor();
		echo '<tr>';
		echo '<td>'.$item['name'].'</td>';
		echo '<td>'.$item['value'].'</td>';
		if($ownership['id'] != $hero['armor'])
		{
			echo '<form method="post" action="exhibit.php?type=armor&id='.$ownership['id'].'">';
			echo '<td><input type="text" name="value" value="0" style="width:100px;"></td>';
			echo '<td><input type="submit" value="Wystaw" style="width:100px;"></td>';
			echo '</form>';
		}
		else echo '<td>-</td><td>Założone</td>';
		echo '</tr>';
		++$counter;
   }
   echo '</table>';
   $stmt -> closeCursor();
}
function show_shield($pdo, $hero)
{
   echo '<div class="item"><font size="5">Tarcze</font><br><br></div>';
   $stmt = $pdo -> query("SELECT id_item, id FROM ownership WHERE id_hero = ".$hero['id']." AND type_item = 'shield' AND stored = 0  ORDER BY id_item");
   echo '<table border="2">';
   echo '<tr><td><b>Nazwa</b></td><td><b>Cena w sklepie</b></td><td><b>Twoja cena</b></td><td><b>exhibit</b></td></tr>';
   $counter = 1;
   foreach($stmt as $ownership)
   {
		$stmt2 = $pdo -> query("SELECT * FROM item_shield WHERE id = ".$ownership['id_item']);
		$item = $stmt2 -> fetch();
		$stmt2 -> closeCursor();
		echo '<tr>';
		echo '<td>'.$item['name'].'</td>';
		echo '<td>'.$item['value'].'</td>';
		if($ownership['id'] != $hero['hand_left'])
		{
			echo '<form method="post" action="exhibit.php?type=shield&id='.$ownership['id'].'">';
			echo '<td><input type="text" name="value" value="0" style="width:100px;"></td>';
			echo '<td><input type="submit" value="Wystaw" style="width:100px;"></td>';
			echo '</form>';
		}
		else echo '<td>-</td><td>Założone</td>';
		echo '</tr>';
		++$counter;
   }
   echo '</table>';
   $stmt -> closeCursor();
}
/***************************************************************************/
/***************************************************************************/
/***************************************************************************/
function show_weapon_melee($pdo, $hero, $handedness)
{
   echo '<div class="item"><font size="5">Broń '.($handedness == 1? 'jednoręczna':'dwuręczna').'</font><br><br></div>';
   $stmt = $pdo -> query("SELECT id_item, id FROM ownership WHERE id_hero = ".$hero['id']." AND type_item = 'weapon_melee' AND stored = 0  ORDER BY id_item");
   echo '<table border="2">';
   echo '<tr><td><b>Nazwa</b></td><td><b>Cena w sklepie</b></td><td><b>Twoja cena</b></td><td><b>exhibit</b></td></tr>';
   $counter = 1;
   foreach($stmt as $ownership)
   {
		$stmt2 = $pdo -> query("SELECT * FROM item_weapon_melee WHERE handedness = $handedness AND id = ".$ownership['id_item']);
		$item = $stmt2 -> fetch();
		$stmt2 -> closeCursor();
		if($item == NULL) continue;
		echo '<tr>';
		echo '<td>'.$item['name'].'</td>';
		echo '<td>'.$item['value'].'</td>';
		if($ownership['id'] != $hero['hand_right'])
		{
			echo '<form method="post" action="exhibit.php?type=weapon_melee&id='.$ownerhisp['id'].'">';
			echo '<td><input type="text" name="value" value="0" style="width:100px;"></td>';
			echo '<td><input type="submit" value="Wystaw" style="width:100px;"></td>';
			echo '</form>';
		}
		else echo '<td>-</td><td>Założone</td>';
		echo '</tr>';
		++$counter;
   }
   $stmt -> closeCursor();
   echo '</table>';
}
/***************************************************************************/
/***************************************************************************/
/***************************************************************************/
function show_weapon_ranged($pdo, $hero)
{
   echo '<div class="item"><font size="5">Broń dystansowa</font><br><br></div>';
   $stmt = $pdo -> query("SELECT id_item, id FROM ownership WHERE id_hero = ".$hero['id']." AND type_item = 'weapon_ranged' AND stored = 0  ORDER BY id_item");
   echo '<table border="2">';
   echo '<tr><td><b>Nazwa</b></td><td><b>Cena w sklepie</b></td><td><b>Twoja cena</b></td><td><b>exhibit</b></td></tr>';
   $counter = 1;
   foreach($stmt as $ownership)
   {
		$stmt2 = $pdo -> query("SELECT * FROM item_weapon_ranged WHERE id = ".$ownership['id_item']);
		$item = $stmt2 -> fetch();
		$stmt2 -> closeCursor();
		echo '<tr>';
		echo '<td>'.$item['name'].'</td>';
		echo '<td>'.$item['value'].'</td>';
		if($ownership['id'] != $hero['hand_right'])
		{
			echo '<form method="post" action="exhibit.php?type=weapon_ranged&id='.$ownership['id'].'">';
			echo '<td><input type="text" name="value" value="0" style="width:100px;"></td>';
			echo '<td><input type="submit" value="Wystaw" style="width:100px;"></td>';
			echo '</form>';
		}
		else echo '<td>-</td><td>Założone</td>';
		echo '</tr>';
		++$counter;
   }
   echo '</table>';
   $stmt -> closeCursor();
   echo '</table>';
}
/***************************************************************************/
/***************************************************************************/
/***************************************************************************/
?>
