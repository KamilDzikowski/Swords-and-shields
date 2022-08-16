<?php
function prize($ownership, $item, $arguments)
{
      echo '<td>'.round(($item['value'] + $ownership['level']*$item['value_improve']) * $arguments).'</td>';
}
function chance_improve($ownership, $item, $arguments)
{
      echo '<td>'.(100 - 10*$ownership['level']).'%</td>';
}
function costs_repare($ownership, $item, $arguments)
{
      echo '<td>'.floor($item['value'] * $ownership['level'] * (1 - $ownership['durability'] / $item['durability'])).'</td>';
}
/**********************************************************************************/
/**********************************************************************************/
/**********************************************************************************/
function write_tabel($arguments_item_pl, $arguments_ownership_pl, $special_name, $additional = NULL)
{
      echo '<table border="2">';
      echo '<tr>';
      echo '<td><b>Nazwa</b></td>';
	for($i=0; $i<count($arguments_item_pl); ++$i) echo '<td><b>'.$arguments_item_pl[$i].'</b></td>';
      for($i=0; $i<count($arguments_ownership_pl); ++$i) echo '<td><b>'.$arguments_ownership_pl[$i].'</b></td>';
      if($additional != NULL) for($i=0; $i<count($additional); ++$i) echo '<td><b>'.$additional[$i].'</b></td>';
      if($special_name != NULL) for($i=0; $i<count($special_name); ++$i) echo '<td><b>'.$special_name[$i].'</b></td>';
      echo '</tr>';
}
/**********************************************************************************/
/**********************************************************************************/
/**********************************************************************************/
function show_armor($pdo, $hero, $path_out, $arguments_ownership_ang, $arguments_ownership_pl, $arguments_item_ang, $arguments_item_pl, $stored, $link1, $text1, $condition, $link2, $text2, $special_function = NULL, $special_name = NULL ,$special_arguments = NULL)
{
	echo '<div class="item"><font size="5">Zbroje</font></div><br><br>';
	//wypisywanie 1. wiersza tabeli
      write_tabel($arguments_item_pl, $arguments_ownership_pl, $special_name, array('Wytrzymałość'));
      //pobieranie z ownership
      $pdo_arguments = 'id, item_id, durability';
	for($i=0; $i<count($arguments_ownership_ang); ++$i) $pdo_arguments .= ', '.$arguments_ownership_ang[$i];
      $stmt = $pdo -> query("SELECT ".$pdo_arguments." FROM ownership WHERE hero_id = ".$hero['id']." AND item_type = 'armor' AND stored = ".$stored." ORDER BY item_id");
      //przygotowanie argumentow item
	$pdo_arguments = 'id, name, durability';
	for($i=0; $i<count($arguments_item_ang); ++$i) $pdo_arguments .= ', '.$arguments_item_ang[$i];
	$counter = 1;
      foreach($stmt as $ownership)
      {
            //pobieranie i wypisywanie
		$stmt2 = $pdo -> query("SELECT $pdo_arguments FROM item_armor WHERE id = ".$ownership['item_id']);
		$item = $stmt2 -> fetch();
		$stmt2 -> closeCursor();
		echo '<tr>';
		echo '<td>'.$item['name'].'</td>';
		for($i=0; $i<count($arguments_item_pl); ++$i) echo '<td>'.$item[$arguments_item_ang[$i]].'</td>';
		for($i=0; $i<count($arguments_ownership_pl); ++$i) echo '<td>'.$ownership[$arguments_ownership_ang[$i]].'</td>';
		echo '<td>'.$ownership['durability'].'/'.$item['durability'].'</td>';		
		if(isset($special_function)) $special_function($ownership, $item, $special_arguments);
		if($ownership['id'] != $condition)
		{
			$_SESSION['tech']['link'.$counter] = $link1.'?id='.$ownership['id'];
			echo '<td><a href="'.$path_out.'links.php?nr='.$counter.'">'.$text1.'</a></td>';
		}
		else if($link2 != '') echo '<td><a href="'.$link2.'?id='.$ownership['id'].'">'.$text2.'</a></td>';
		else echo '<td>'.$text2.'</td>';
            echo '</tr>';
		++$counter;
      }
      echo '</table>';
      $stmt -> closeCursor();
}
/**********************************************************************************/
/**********************************************************************************/
/**********************************************************************************/
function show_shield($pdo, $hero, $path_out, $arguments_ownership_ang, $arguments_ownership_pl, $arguments_item_ang, $arguments_item_pl, $stored, $link1, $text1, $condition, $link2, $text2, $special_function = NULL, $special_name = NULL, $special_arguments = NULL)
{
	echo '<div class="item"><font size="5">Tarcze</font></div><br><br>';
	//wypisywanie 1. wiersza tabeli
      write_tabel($arguments_item_pl, $arguments_ownership_pl, $special_name, array('Wytrzymałość'));
      //pobieranie z ownership
      $pdo_arguments = 'id, item_id, durability';
	for($i=0; $i<count($arguments_ownership_ang); ++$i) $pdo_arguments .= ', '.$arguments_ownership_ang[$i];
      $stmt = $pdo -> query("SELECT ".$pdo_arguments." FROM ownership WHERE hero_id = ".$hero['id']." AND item_type = 'shield' AND stored = ".$stored." ORDER BY item_id");
      //przygotowanie argumentow item
	$pdo_arguments = 'id, name, durability';
	for($i=0; $i<count($arguments_item_ang); ++$i) $pdo_arguments .= ', '.$arguments_item_ang[$i];
	$counter = 1;
      foreach($stmt as $ownership)
      {
            //pobieranie i wypisywanie
		$stmt2 = $pdo -> query("SELECT $pdo_arguments FROM item_shield WHERE id = ".$ownership['item_id']);
		$item = $stmt2 -> fetch();
		$stmt2 -> closeCursor();
		echo '<tr>';
		echo '<td>'.$item['name'].'</td>';
		for($i=0; $i<count($arguments_item_pl); ++$i) echo '<td>'.$item[$arguments_item_ang[$i]].'</td>';
		for($i=0; $i<count($arguments_ownership_pl); ++$i) echo '<td>'.$ownership[$arguments_ownership_ang[$i]].'</td>';
		echo '<td>'.$ownership['durability'].'/'.$item['durability'].'</td>';
		if(isset($special_function)) $special_function($ownership, $item, $special_arguments);
		if($ownership['id'] != $condition)
		{
			$_SESSION['tech']['link'.$counter] = $link1.'?id='.$ownership['id'];
			echo '<td><a href="'.$path_out.'links.php?nr='.$counter.'">'.$text1.'</a></td>';
		}
		else if($link2 != '') echo '<td><a href="'.$link2.'?id='.$ownership['id'].'">'.$text2.'</a></td>';
		else echo '<td>'.$text2.'</td>';
            echo '</tr>';
		++$counter;
      }
      echo '</table>';
      $stmt -> closeCursor();
}
/**********************************************************************************/
/**********************************************************************************/
/**********************************************************************************/
function show_weapon_melee($pdo, $hero, $path_out, $arguments_ownership_ang, $arguments_ownership_pl, $arguments_item_ang, $arguments_item_pl, $stored, $link1, $text1, $condition, $link2, $text2, $handedness, $special_function = NULL, $special_name = NULL, $special_arguments = NULL)
{
	echo '<div class="item"><font size="5">Broń '.(($handedness == 1)? 'jednoręczna' : 'dwuręczna' ).'</font></div><br><br>';
	//wypisywanie 1. wiersza tabeli
      write_tabel($arguments_item_pl, $arguments_ownership_pl, $special_name, array('Wytrzymałość'));
      //pobieranie z ownership
      $pdo_arguments = 'id, item_id, durability';
	for($i=0; $i<count($arguments_ownership_ang); ++$i) $pdo_arguments .= ', '.$arguments_ownership_ang[$i];
      $stmt = $pdo -> query("SELECT ".$pdo_arguments." FROM ownership WHERE hero_id = ".$hero['id']." AND item_type = 'weapon_melee' AND stored = ".$stored." ORDER BY item_id");
      //przygotowanie argumentow item
	$pdo_arguments = 'id, name, durability';
	for($i=0; $i<count($arguments_item_ang); ++$i) $pdo_arguments .= ', '.$arguments_item_ang[$i];
	$counter = 1;
      foreach($stmt as $ownership)
      {
            //pobieranie i wypisywanie
		$stmt2 = $pdo -> query("SELECT $pdo_arguments FROM item_weapon_melee WHERE id = ".$ownership['item_id']." AND handedness = ".$handedness);
		$item = $stmt2 -> fetch();
		$stmt2 -> closeCursor();
		if($item == NULL) continue;
		echo '<tr>';
		echo '<td>'.$item['name'].'</td>';
		for($i=0; $i<count($arguments_item_pl); ++$i) echo '<td>'.$item[$arguments_item_ang[$i]].'</td>';
		for($i=0; $i<count($arguments_ownership_pl); ++$i) echo '<td>'.$ownership[$arguments_ownership_ang[$i]].'</td>';
		echo '<td>'.$ownership['durability'].'/'.$item['durability'].'</td>';		
		if(isset($special_function)) $special_function($ownership, $item, $special_arguments);
		if($ownership['id'] != $condition)
		{
			$_SESSION['tech']['link'.$counter] = $link1.'?id='.$ownership['id'];
			echo '<td><a href="'.$path_out.'links.php?nr='.$counter.'">'.$text1.'</a></td>';
		}
		else if($link2 != '') echo '<td><a href="'.$link2.'?id='.$ownership['id'].'">'.$text2.'</a></td>';
		else echo '<td>'.$text2.'</td>';
            echo '</tr>';
		++$counter;
      }
      echo '</table>';
      $stmt -> closeCursor();
}
/**********************************************************************************/
/**********************************************************************************/
/**********************************************************************************/
function show_weapon_ranged($pdo, $hero, $path_out, $arguments_ownership_ang, $arguments_ownership_pl, $arguments_item_ang, $arguments_item_pl, $stored, $link1, $text1, $condition, $link2, $text2, $special_function = NULL, $special_name = NULL, $special_arguments = NULL)
{
	echo '<div class="item"><font size="5">Broń miotająca</font></div><br><br>';
	//wypisywanie 1. wiersza tabeli
      write_tabel($arguments_item_pl, $arguments_ownership_pl, $special_name, array('Wytrzymałość'));
      //pobieranie z ownership
      $pdo_arguments = 'id, item_id, durability';
	for($i=0; $i<count($arguments_ownership_ang); ++$i) $pdo_arguments .= ', '.$arguments_ownership_ang[$i];
      $stmt = $pdo -> query("SELECT ".$pdo_arguments." FROM ownership WHERE hero_id = ".$hero['id']." AND item_type = 'weapon_ranged' AND stored = ".$stored." ORDER BY item_id");
      //przygotowanie argumentow item
	$pdo_arguments = 'id, name, durability';
	for($i=0; $i<count($arguments_item_ang); ++$i) $pdo_arguments .= ', '.$arguments_item_ang[$i];
	$counter = 1;
      foreach($stmt as $ownership)
      {
            //pobieranie i wypisywanie
		$stmt2 = $pdo -> query("SELECT $pdo_arguments FROM item_weapon_ranged WHERE id = ".$ownership['item_id']);
		$item = $stmt2 -> fetch();
		$stmt2 -> closeCursor();
		echo '<tr>';
		echo '<td>'.$item['name'].'</td>';
		for($i=0; $i<count($arguments_item_pl); ++$i) echo '<td>'.$item[$arguments_item_ang[$i]].'</td>';
		for($i=0; $i<count($arguments_ownership_pl); ++$i) echo '<td>'.$ownership[$arguments_ownership_ang[$i]].'</td>';
		echo '<td>'.$ownership['durability'].'/'.$item['durability'].'</td>';		
		if(isset($special_function)) $special_function($ownership, $item, $special_arguments);
		if($ownership['id'] != $condition)
		{
			$_SESSION['tech']['link'.$counter] = $link1.'?id='.$ownership['id'];
			echo '<td><a href="'.$path_out.'links.php?nr='.$counter.'">'.$text1.'</a></td>';
		}
		else if($link2 != '') echo '<td><a href="'.$link2.'?id='.$ownership['id'].'">'.$text2.'</a></td>';
		else echo '<td>'.$text2.'</td>';
            echo '</tr>';
		++$counter;
      }
      echo '</table>';
      $stmt -> closeCursor();
}
/**********************************************************************************/
/**********************************************************************************/
/**********************************************************************************/
function show_ammo($pdo, $hero, $path_out, $arguments_ownership_ang, $arguments_ownership_pl, $arguments_item_ang, $arguments_item_pl, $stored, $link1, $text1, $condition, $link2, $text2, $group = false, $special_function = NULL, $special_name = NULL, $special_arguments = NULL)
{
	echo '<div class="item"><font size="5">Amunicja</font></div><br><br>';
	//wypisywanie 1. wiersza tabeli
      write_tabel($arguments_item_pl, $arguments_ownership_pl, $special_name);
      //pobieranie z ownership
      $pdo_arguments = 'id, item_id';
	for($i=0; $i<count($arguments_ownership_ang); ++$i) $pdo_arguments .= ', '.$arguments_ownership_ang[$i];
      $stmt = $pdo -> query("SELECT ".$pdo_arguments." FROM ownership WHERE hero_id = ".$hero['id']." AND item_type = 'ammo' AND stored = ".$stored." ORDER BY item_id");
      //przygotowanie argumentow item
	$pdo_arguments = 'id, name';
	for($i=0; $i<count($arguments_item_ang); ++$i) $pdo_arguments .= ', '.$arguments_item_ang[$i];
	$counter = 1;
      foreach($stmt as $ownership)
      {
            //pobieranie i wypisywanie
		$stmt2 = $pdo -> query("SELECT $pdo_arguments FROM item_ammo WHERE id = ".$ownership['item_id']);
		$item = $stmt2 -> fetch();
		$stmt2 -> closeCursor();
		echo '<tr>';
		echo '<td>'.$item['name'].'</td>';
		for($i=0; $i<count($arguments_item_pl); ++$i) echo '<td>'.$item[$arguments_item_ang[$i]].'</td>';
		for($i=0; $i<count($arguments_ownership_pl); ++$i) echo '<td>'.$ownership[$arguments_ownership_ang[$i]].'</td>';	
		if(isset($special_function)) $special_function($ownership, $item, $special_arguments);
		if($ownership['id'] != $condition)
		{
			$_SESSION['tech']['link'.$counter] = $link1.'?id='.$ownership['id'];
			echo '<td><a href="'.$path_out.'links.php?nr='.$counter.'">'.$text1.'</a></td>';
		}
		else if($link2 != '') echo '<td><a href="'.$link2.'?id='.$ownership['id'].'">'.$text2.'</a></td>';
		else echo '<td>'.$text2.'</td>';
            if($group) echo '<td><a href="'.$path_out.'PHP/Temp_pages/grouping.php?id='.$ownership['id'].'">Grupuj</a></td>';
            echo '</tr>';
		++$counter;
      }
      echo '</table>';
      $stmt -> closeCursor();
}
/**********************************************************************************/
/**********************************************************************************/
/**********************************************************************************/
function show_tool($pdo, $hero, $path_out, $arguments_ownership_ang, $arguments_ownership_pl, $arguments_item_ang, $arguments_item_pl, $stored, $link1, $text1, $condition, $link2, $text2, $special_function = NULL, $special_name = NULL ,$special_arguments = NULL)
{
	echo '<div class="item"><font size="5">Narzędzia</font></div><br><br>';
	//wypisywanie 1. wiersza tabeli
      write_tabel($arguments_item_pl, $arguments_ownership_pl, $special_name, array('Wytrzymałość'));
      //pobieranie z ownership
      $pdo_arguments = 'id, item_id, durability';
	for($i=0; $i<count($arguments_ownership_ang); ++$i) $pdo_arguments .= ', '.$arguments_ownership_ang[$i];
      $stmt = $pdo -> query("SELECT ".$pdo_arguments." FROM ownership WHERE hero_id = ".$hero['id']." AND item_type = 'tool' AND stored = ".$stored." ORDER BY item_id");
      //przygotowanie argumentow item
	$pdo_arguments = 'id, name, durability';
	for($i=0; $i<count($arguments_item_ang); ++$i) $pdo_arguments .= ', '.$arguments_item_ang[$i];
	$counter = 1;
      foreach($stmt as $ownership)
      {
            //pobieranie i wypisywanie
		$stmt2 = $pdo -> query("SELECT $pdo_arguments FROM item_tool WHERE id = ".$ownership['item_id']);
		$item = $stmt2 -> fetch();
		$stmt2 -> closeCursor();
		echo '<tr>';
		echo '<td>'.$item['name'].'</td>';
		for($i=0; $i<count($arguments_item_pl); ++$i) echo '<td>'.$item[$arguments_item_ang[$i]].'</td>';
		for($i=0; $i<count($arguments_ownership_pl); ++$i) echo '<td>'.$ownership[$arguments_ownership_ang[$i]].'</td>';
		echo '<td>'.$ownership['durability'].'/'.$item['durability'].'</td>';
            if(isset($special_function)) $special_function($ownership, $item, $special_arguments);
		if($ownership['id'] != $condition)
		{
			$_SESSION['tech']['link'.$counter] = $link1.'?id='.$ownership['id'];
			echo '<td><a href="'.$path_out.'links.php?nr='.$counter.'">'.$text1.'</a></td>';
		}
		else if($link2 != '') echo '<td><a href="'.$link2.'?id='.$ownership['id'].'">'.$text2.'</a></td>';
		else echo '<td>'.$text2.'</td>';
            echo '</tr>';
		++$counter;
      }
      echo '</table>';
      $stmt -> closeCursor();
}
/**********************************************************************************/
/**********************************************************************************/
/**********************************************************************************/
function show_resource($pdo, $hero, $path_out, $arguments_ownership_ang, $arguments_ownership_pl, $arguments_item_ang, $arguments_item_pl, $stored, $group = false, $special_function = NULL, $special_name = NULL ,$special_arguments = NULL)
{
	echo '<div class="item"><font size="5">Surowce</font></div><br><br>';
	//wypisywanie 1. wiersza tabeli
      write_tabel($arguments_item_pl, $arguments_ownership_pl, $special_name);
      //pobieranie z ownership
      $pdo_arguments = 'id, item_id';
	for($i=0; $i<count($arguments_ownership_ang); ++$i) $pdo_arguments .= ', '.$arguments_ownership_ang[$i];
      $stmt = $pdo -> query("SELECT ".$pdo_arguments." FROM ownership WHERE hero_id = ".$hero['id']." AND item_type = 'resource' AND stored = ".$stored." ORDER BY item_id");
      //przygotowanie argumentow item
	$pdo_arguments = 'id, name';
	for($i=0; $i<count($arguments_item_ang); ++$i) $pdo_arguments .= ', '.$arguments_item_ang[$i];
	$counter = 1;
      foreach($stmt as $ownership)
      {
            //pobieranie i wypisywanie
		$stmt2 = $pdo -> query("SELECT $pdo_arguments FROM item_resource WHERE id = ".$ownership['item_id']);
		$item = $stmt2 -> fetch();
		$stmt2 -> closeCursor();
		echo '<tr>';
		echo '<td>'.$item['name'].'</td>';
		for($i=0; $i<count($arguments_item_pl); ++$i) echo '<td>'.$item[$arguments_item_ang[$i]].'</td>';
		for($i=0; $i<count($arguments_ownership_pl); ++$i) echo '<td>'.$ownership[$arguments_ownership_ang[$i]].'</td>';
            if(isset($special_function)) $special_function($ownership, $item, $special_arguments);
		if($group) echo '<td><a href="'.$path_out.'grouping.php?id='.$ownership['id'].'">Grupuj</a></td>';
            echo '</tr>';
		++$counter;
      }
      echo '</table>';
      $stmt -> closeCursor();
}
?><hr />
