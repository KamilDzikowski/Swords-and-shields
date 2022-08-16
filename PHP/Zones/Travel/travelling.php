<!DOCTYPE html
	PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.batman.com">
<LINK rel="stylesheet" href="../../../Style/style_zone.css" type="text/css"></LINK>
<html xmlns="www.google.pl" xml:lang="pl" lang="pl">
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<meta name="Description" content="Tu wpisz opis zawartości strony" />
	<meta name="Keywords" content="Tu wpisz wyrazy kluczowe rozdzielone przecinkami" />
	<meta http-equiv="Refresh" content="5" />
	<title>Start</title>
</head>
<div id="page">
	<?php
		require_once('../../../Classes/hero.php');
		require_once('../../../Classes/zone.php');
		session_start();
		$_SESSION['tech']['path'] = 'PHP/Zones/Travel/';
		$_SESSION['tech']['file'] = 'travelling.php';
		try
		{
		      $pdo = new PDO('mysql:host=localhost;dbname=konta', 'root', 'lampa123', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
                  $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		      $stmt = $pdo -> query("SELECT name FROM zone WHERE id =".$_SESSION['hero']['action_var']);
		      $zone = $stmt -> fetch();
                  $stmt -> closeCursor();
		      if($_SESSION['hero']['time'] <= time())
                  {
			      $_SESSION['hero']['zone'] = $_SESSION['hero']['action_var'];				
			      $_SESSION['hero']['action'] = 0;
			      $_SESSION['hero']['name'] = 0;
			      $_SESSION['hero']['action_var'] = 0;
			      header('Location: ../../../zone.php');
		      }
		      echo 'Teraz podróżujesz z '.$_SESSION['zone']['name'].' do '.$zone['name'].'.<br>Do końca pozostało: '.($_SESSION['hero']['time'] - time()).' sekund.<br>';		
		      echo '<br><a href="travel_return.php">Powrót</a>';
            }
            catch(PDOException $e)
            {
                  echo 'Błąd PDO!';
                  header('Location: ../../../error.php');
            }
	?>
</div>
