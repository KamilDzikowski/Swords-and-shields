<?php
function show_equipment($pdo, $hero)
{
	echo '<div class="item"><font size="5">Ekwipunek</font></div><br><br><div class="item"></div>';
      if($hero['armor'] != 0)
	{
		$stmt = $pdo -> query("SELECT item_id, level, durability FROM ownership WHERE id = ".$hero['armor']);
		$ownership = $stmt -> fetch();
		$stmt -> closeCursor();
		$stmt = $pdo -> query("SELECT name, durability FROM item_armor WHERE id = ".$ownership['item_id']);
		$item = $stmt -> fetch();
		$stmt -> closeCursor();
		echo '<div class="item">';
		echo '<strong>'.$item['name'].'</strong><br>';
		echo 'Poziom: '.$ownership['level'].'<br>';
		echo 'Wytrzymałość: '.$ownership['durability'].'/'.$item['durability'].'<br>';
		echo '<a href="remove.php?id='.$hero['armor'].'">Zdejmij</a><br>';
		echo '</div>';
	}
	if($hero['hand_right'] != 0)
	{
		$stmt = $pdo -> query("SELECT item_type, item_id, level, durability FROM ownership WHERE id = ".$hero['hand_right']);
		$ownership = $stmt -> fetch();
		$stmt -> closeCursor();
		$stmt = $pdo -> query("SELECT name, durability FROM item_".$ownership['item_type']." WHERE id = ".$ownership['item_id']);
		$item = $stmt -> fetch();
		$stmt -> closeCursor();
		echo '<div class="item">';
		echo '<strong>'.$item['name'].'</strong><br>';
		echo 'Poziom: '.$ownership['level'].'<br>';
		if($ownership['item_type'] == 'weapon_melee')
		{
		      //echo 'Broń jest'.
		}
		else if($ownership['item_type'] == 'weapon_ranged')
		{
			//
		}
		echo 'Wytrzymałość: '.$ownership['durability'].'/'.$item['durability'].'<br>';
		echo '<a href="remove.php?id='.$hero['hand_right'].'">Zdejmij</a><br>';
		echo '</div>';
	}
	if($hero['hand_left'] != 0)
	{
		$stmt = $pdo -> query("SELECT item_type, item_id, level, durability FROM ownership WHERE id = ".$hero['hand_left']);
		$ownership = $stmt -> fetch();
		$stmt -> closeCursor();
		$stmt = $pdo -> query("SELECT name, durability FROM item_".$ownership['item_type']." WHERE id = ".$ownership['item_id']);
		$item = $stmt -> fetch();
		$stmt -> closeCursor();
		echo '<div class="item">';
		echo '<strong>'.$item['name'].'</strong><br>';
		echo 'Poziom: '.$ownership['level'].'<br>';
		if($ownership['item_type'] == 'shield')
		{
			//
		}
		echo 'Wytrzymałość: '.$ownership['durability'].'/'.$item['durability'].'<br>';
		echo '<a href="remove.php?id='.$hero['hand_left'].'">Zdejmij</a><br>';	
		echo '</div>';
	}
	if($hero['ammo'] != 0)
	{
		$stmt = $pdo -> query("SELECT item_id, level, amount FROM ownership WHERE id = ".$hero['ammo']);
		$ownership = $stmt -> fetch();
		$stmt -> closeCursor();
		$stmt = $pdo -> query("SELECT name, stack FROM item_ammo WHERE id = ".$ownership['item_id']);
		$item = $stmt -> fetch();
		$stmt -> closeCursor();
		echo '<div class="item">';
		echo '<strong>'.$item['name'].'</strong><br>';
		echo 'Poziom: '.$ownership['level'].'<br>';
		echo 'Ilość: '.$ownership['amount'].'/'.$item['stack'].'<br>';
		echo '<a href="../Temp_pages/grouping.php?id='.$hero['ammo'].'">Grupuj</a><br>';	
		echo '<a href="remove.php?id='.$hero['ammo'].'">Zdejmij</a><br>';
		echo '</div>';
	}
	if($hero['tool'] != 0)
	{
		$stmt = $pdo -> query("SELECT item_id, level, durability FROM ownership WHERE id = ".$hero['tool']);
		$ownership = $stmt -> fetch();
		$stmt -> closeCursor();
		$stmt = $pdo -> query("SELECT name, durability FROM item_tool WHERE id = ".$ownership['item_id']);
		$item = $stmt -> fetch();
		$stmt -> closeCursor();
		echo '<div class="item">';
		echo '<strong>'.$item['name'].'</strong><br>';
		echo 'Poziom: '.$ownership['level'].'<br>';
		echo 'Wytrzymałość: '.$ownership['durability'].'/'.$item['durability'].'<br>';
		echo '<a href="remove.php?id='.$hero['tool'].'">Zdejmij</a><br>';	
		echo '</div>';
	}
}
?>
