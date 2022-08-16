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
		$_SESSION['tech']['path'] = 'PHP/Zones/Temple/';
		$_SESSION['tech']['file'] = 'temple.php';
		$delta = $_SESSION['hero']['life_max'] - $_SESSION['hero']['life'];
		$_SESSION['tech']['link1'] = 'healing_start.php?f=10&prize=0&delta='.$delta;
		$_SESSION['tech']['link2'] = 'healing_start.php?f=3&prize=5&delta='.$delta;
		if($delta > 0)
		{
			echo 'Masz '.$_SESSION['hero']['life'].' na '.$_SESSION['hero']['life_max'].' życia.<br>';
			echo '<a href="../../../links.php?nr=1">Pełne leczenie</a>';
			echo ' zajmie '.($delta * 10).' minut.<br>';
			echo '<a href="../../../links.php?nr=2">Leczenie wspomagane</a>';
			echo ' zajmie '.($delta * 3).' minut, ale ofiara będzie kosztowala '.($delta * 5).' sztuk złota.<br>';
		}
		else
		{
			echo 'Jesteś w pełni sił!<br>';
		}
	?>
	<a href='../../../zone.php'>Miasto</a>
</div>