<?php
function show($pdo, $hero, $name_ang, $name_pl, $arguments_ownership_ang, $arguments_ownership_pl, $arguments_item_ang, $arguments_item_pl, $stored, $link1, $text1, $condition, $link2, $text2)
{
	echo '<div class="item"><font size="5">'.$name_pl.'</font><br><br></div>';
	$pdo_arguments = 'id, id_item';
	$amount1 = count($arguments_ownership_ang);
	$amount2 = count($arguments_item_ang);
	for($i=0; $i<$amount1; ++$i) $pdo_arguments .= ', '.$arguments_ownership_ang[$i];
      $stmt = $pdo -> query("SELECT ".$pdo_arguments." FROM ownership WHERE id_hero = ".$hero['id']." AND type_item = '".$name_ang."' AND stored = ".$stored." ORDER BY id_item");
      //pobieranie z ownership
      echo '<table border="2">';
      echo '<tr>';
      echo '<td><b>Nazwa</b></td>';
	for($i=0; $i<$amount2; ++$i) echo '<td><b>'.$arguments_item_pl[$i].'</b></td>';
      for($i=0; $i<$amount1; ++$i) echo '<td><b>'.$arguments_ownership_pl[$i].'</b></td>';
      echo '</tr>';
      //wypisywanie 1. wiersza tabeli
	$pdo_arguments = 'id, name';
	for($i=0; $i<$amount1; ++$i) $pdo_arguments .= ', '.$arguments_item_ang[$i];
	//argumenty pdo
	$counter = 1;
      foreach($stmt as $ownership)
      {
		$stmt2 = $pdo -> query("SELECT $pdo_arguments FROM item_$name_ang WHERE id = ".$ownership['id_item']);
		$item = $stmt2 -> fetch();
		$stmt2 -> closeCursor();
		echo '<tr>';
		echo '<td>'.$item['name'].'</td>';
		for($i=0; $i<$amount2; ++$i) echo '<td>'.$item[$arguments_item_ang[$i]].'</td>';
		for($i=0; $i<$amount1; ++$i) echo '<td>'.$ownership[$arguments_ownership_ang[$i]].'</td>';
		//pobieranie i wypisywanie
		if($ownership['id'] != $condition)
		{
			$_SESSION['tech']['link'.$counter] = $link1.'?type='.$name_ang.'&id='.$ownership['id'];
			echo '<td><a href="../../links.php?nr='.$counter.'">'.$text1.'</a></td>';
		}
		else if($link2 != '') echo '<td><a href="'.$link2.'?type='.$name_ang.'&id='.$ownership['id'].'">'.$text2.'</a></td>';
		else echo '<td>'.$text2.'</td>';
            echo '</tr>';
		++$counter;
      }
      echo '</table>';
      $stmt -> closeCursor();
}
?>
