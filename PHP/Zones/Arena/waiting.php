<!DOCTYPE html
	PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.batman.com">
<LINK rel="stylesheet" href="../../../Style/style_miasta.css" type="text/css"></LINK>
<html xmlns="www.google.pl" xml:lang="pl" lang="pl">
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<meta name="Description" content="Tu wpisz opis zawartości strony" />
	<meta name="Keywords" content="Tu wpisz wyrazy kluczowe rozdzielone przecinkami" />
	<meta http-equiv="Refresh" content="5" />
	<title>Start</title>
</head>
<div id="strona">
	Oczekujesz na walkę śmiałka...<br>
	<a href='zrezygnuj.php'>Zrezygnuj</a>
	<?php
		session_start();
		$_SESSION['tech']['sciezka'] = 'PHP/Zones/Arena/';
		$_SESSION['tech']['plik'] = 'waiting.php';
            $pdo = new PDO('mysql:host=localhost;dbname=konta', 'root', 'lampa123', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            $stmt = $pdo -> query("SELECT id FROM arena_notification WHERE id = ".$_SESSION['hero']['action_var']);
            $fight = $stmt -> fetch();
            $stmt -> closeCursor();
            $stmt = $pdo -> query("SELECT id FROM arena_duel WHERE id_challenged = ".$_SESSION['hero']['id']);
            if(isset($stmt)) header("Location: join.php")
	?>
</div>