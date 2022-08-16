<!DOCTYPE html
	PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.batman.com">
<LINK rel="stylesheet" href="Style/style_zone.css" type="text/css"></LINK>
<html xmlns="www.google.pl" xml:lang="pl" lang="pl">
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<meta name="Description" content="Tu wpisz opis zawartości strony" />
	<meta name="Keywords" content="Tu wpisz wyrazy kluczowe rozdzielone przecinkami" />
	<title>Start</title>
</head>
<div id="page">
	<h4>Wybierz akcję:</h4>
		<?php
			require_once('Classes/zone.php');
			require_once('Classes/hero.php');
			session_start();
			$_SESSION['tech']['path'] = '';
			$_SESSION['tech']['file'] = 'zone.php';
			if(!isset($_SESSION['zone']))
			{
				$zone = CZone::factory($_SESSION['hero']['zone']);
				$_SESSION['zone'] = $zone;
			}
			else if($_SESSION['zone']['id'] != $_SESSION['hero']['zone']) $_SESSION['zone']->actualize($_SESSION['hero']['zone']);
			for($counter = 1; $_SESSION['zone']['link'.$counter] != NULL; ++$counter)
			{
				echo '<a href="'.$_SESSION['zone']['link'.$counter].'">'.$_SESSION['zone']['zone'.$counter].'</a><br>';
			}
			echo '<a href="PHP/Zones/Work/work_show.php">Urząd pracy</a><br>';
			echo '<a href="PHP/Zones/Travel/travel_show.php">Biuro podróży</a><br>';
			echo '<a href="PHP/Zones/Post/post.php">Poczta</a><br>';
		?>
</div>
