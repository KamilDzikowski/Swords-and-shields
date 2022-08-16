<!DOCTYPE html
	PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.batman.com">
<LINK rel="stylesheet" href="../../../Style/style_zone.css" type="text/css"></LINK>
<html xmlns="www.google.pl" xml:lang="pl" lang="pl">
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<meta name="Description" content="Tu wpisz opis zawartości strony" />
	<meta name="Keywords" content="Tu wpisz wyrazy kluczowe rozdzielone przecinkami" />
	<title>Koszary</title>
</head>
<div id="page">
      <table border="2">
            <tr><td><b>Nazwa</b></td><td><b>Poziom</b></td><td><b>Koszt</b></td><td><b>Ćwicz</b></td></tr>
            <?php
                  require_once('../../../Classes/hero.php');
                  session_start();
                  $_SESSION['tech']['path'] = 'PHP/Zones/Barracks/';
                  $_SESSION['tech']['file'] = 'barracks.php';
                  echo '<tr><td>Siła</td>';
                  echo '<td>'.$_SESSION['hero']['strength'].'</td>';
                  echo '<td>'.($_SESSION['hero']['strength'] * 10).'</td>';
                  echo '<td><a href="train_start.php?type=strength">Ćwicz</a></td></tr>';
                  echo '<tr><td>Zręczność</td>';
                  echo '<td>'.$_SESSION['hero']['dexterity'].'</td>';
                  echo '<td>'.($_SESSION['hero']['dexterity'] * 10).'</td>';
                  echo '<td><a href="train_start.php?type=dexterity">Ćwicz</a></td></tr>';
                  echo '<tr><td>Szybkość</td>';
                  echo '<td>'.$_SESSION['hero']['speed'].'</td>';
                  echo '<td>'.($_SESSION['hero']['speed'] * 10).'</td>';
                  echo '<td><a href="train_start.php?type=speed">Ćwicz</a></td></tr>';
                  echo '<tr><td>Budowa</td>';
                  echo '<td>'.$_SESSION['hero']['constitution'].'</td>';
                  echo '<td>'.($_SESSION['hero']['constitution'] * 10).'</td>';
                  echo '<td><a href="train_start.php?type=constitution">Ćwicz</a></td></tr>';
            ?>
      </table>
      <a href="../../../zone.php">Miasto</a>
</div>
