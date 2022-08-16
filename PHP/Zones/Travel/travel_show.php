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
	<?php
            require_once('../../../Classes/hero.php');
		session_start();
		$_SESSION['tech']['path'] = 'PHP/Zones/Travel/';
		$_SESSION['tech']['file'] = 'travel_show.php';
		try
		{
                  $pdo = new PDO('mysql:host=localhost;dbname=konta', 'root', 'lampa123', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
		      $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		      $stmt = $pdo -> query("SELECT * FROM zone_travel WHERE id =".$_SESSION['hero']['zone']);
		      $travel = $stmt -> fetch();
		      $stmt -> closeCursor();
		      for($counter=1; isset($travel['target'.$counter]); ++$counter)
                  {
                        $stmt = $pdo -> query("SELECT name FROM zone WHERE id =".$travel['target'.$counter]);
			      $zone = $stmt -> fetch();
			      $stmt -> closeCursor();
       	            echo '<a href="travel_start.php?nr='.$counter.'">'.$zone['name'].'</a><br>';
                  }
            }
            catch(PDOException $e)
            {
                  echo 'Błąd PDO!';
                  header('Location: ../../../error.php');
            }
	?>
	<br><a href="../../../zone.php">Miasto</a>
</div>
