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
	<?php
		session_start();
		echo 'Błąd: <br>';
		if(isset($_SESSION['tech']['text'])) echo $_SESSION['tech']['text'];
		else echo 'Błąd w pliku - brak argumentów!';
		if(isset($_SESSION['tech']['link']))
            {
                  echo '<br><b>Stary sposób!</b><br>';
                  echo '<br><a href="'.$_SESSION['tech']['link'].'">OK</a>';
                  unset($_SESSION['tech']['link']);
            }
            else echo '<br><a href="'.$_SESSION['tech']['path'].$_SESSION['tech']['file'].'">OK</a>';
		unset($_SESSION['tech']['text']);
		unset($_SESSION['tech']['link']);
	?>
</div>
