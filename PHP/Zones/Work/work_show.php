<!DOCTYPE html
	PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.batman.com">
<LINK rel="stylesheet" href="../../../Style/style_zone.css" type="text/css"></LINK>
<html xmlns="www.google.pl" xml:lang="pl" lang="pl">
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<meta name="Description" content="Tu wpisz opis zawartości strony" />
	<meta name="Keywords" content="Tu wpisz wyrazy kluczowe rozdzielone przecinkami" />
	<title>Start</title>
</head>

<div id="page">
<table border='2'>
<tr>
	<td><b>Praca</b></td> <td><b>Rodzaj pracy</b></td> <td><b>Wymagany poziom</b></td>
</tr>
	<?php
		require_once('../../../Classes/hero.php');
		require_once('../../../Classes/zone.php');
		session_start();
		$_SESSION['tech']['path'] = 'PHP/Zones/Work/';
		$_SESSION['tech']['file'] = 'work_show.php';
		$pdo = new PDO('mysql:host=localhost;dbname=konta', 'root', 'lampa123', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
		$pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$counter = 1;
		/*
                        TEMPORAL		
	      */
	      $stmt2 = $pdo -> query("SELECT * FROM zone_work ORDER BY type");      //TEMP
            //while(isset($_SESSION['zone']['work'.$counter]))   TEMP
            foreach($stmt2 as $work)                             //TEMP
		{
			/*$stmt = $pdo -> query("SELECT * FROM zone_work WHERE id=".$_SESSION['zone']['work'.$counter]);
			$work = $stmt -> fetch();        TEMPORAL
			$stmt -> closeCursor();*/
			echo '<tr>';
			if($_SESSION['hero'][$work['type']] >= $work['threshold'])
			{
                        echo '<td><a href="../../../links.php?nr='.$counter.'">'.$work['name_show'].'</a></td>';
			      $_SESSION['tech']['link'.$counter] = 'job_show.php?work_id='.$work['id'];
                  }
                  else echo '<td>'.$work['name_show'].'</td>';
                  echo '<td>'.$work['type'].'</td>';
                  echo '<td>'.$work['threshold'].' / '.$_SESSION['hero'][$work['type']].'</td>';
			echo '</tr>';
			++$counter;
		}
		$stmt2 -> closeCursor(); //temp
		echo '<br>';
	?>
      </table>
	<a href="../../../zone.php">Miasto</a>
</div>
