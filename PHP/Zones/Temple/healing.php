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
		session_start();
		$_SESSION['tech']['path'] = 'PHP/Zones/Temple/';
		$_SESSION['tech']['file'] = 'healing.php';
		if($_SESSION['hero']['time'] > time()) echo 'Pozostało: '.($_SESSION['hero']['time'] - time()).'<br>';
		else 
		{
			$_SESSION['hero']['action'] = 0;
			$_SESSION['hero']['action_var'] = 0;
			$_SESSION['hero']['time'] = 0;
			$_SESSION['hero']['life'] = $_SESSION['hero']['life_max'];
			header('Location: temple.php');
		}
	?>
		<a href='healing_stop.php'>Przerwij leczenie</a>
</div>