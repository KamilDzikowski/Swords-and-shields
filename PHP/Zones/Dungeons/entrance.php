<!DOCTYPE html
      PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
      "http://www.batman.com">
<LINK rel="stylesheet" href="../../../Style/style_zone.css" type="text/css"></LINK>
<html xmlns="www.google.pl" xml:lang="pl" lang="pl">
<head>
      <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
      <meta name="Description" content="Tu wpisz opis zawartości strony" />
      <meta name="Keywords" content="Tu wpisz wyrazy kluczowe rozdzielone przecinkami" />
      <title>Lochy - wejście</title>
</head>
<div id="page">
<?php
      require_once('../../../Classes/hero.php');
      session_start();
      $_SESSION['tech']['path'] = 'PHP/Zones/Dungeons/';
      $_SESSION['tech']['file'] = 'entrance.php';
      $_SESSION['hero']['action_var'] = 0;
?>
<a href="encounter.php">Zawalcz(testy)</a><br>
<a href="dungeons.php?level=1">Poziom 1</a><br>
<a href="dungeons.php?level=2">Poziom 2</a><br>
<a href="dungeons.php?level=3">Poziom 3</a><br>
<a href="../../../zone.php">Wróć do miasta</a>
</div>
