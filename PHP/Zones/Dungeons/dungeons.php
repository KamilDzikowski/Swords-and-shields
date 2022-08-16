<!DOCTYPE html
	PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.batman.com">
<LINK rel="stylesheet" href="../../../Style/style_zone.css" type="text/css"></LINK>
<html xmlns="www.google.pl" xml:lang="pl" lang="pl">
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<meta name="Description" content="Tu wpisz opis zawartości strony" />
	<meta name="Keywords" content="Tu wpisz wyrazy kluczowe rozdzielone przecinkami" />
	<title>Podziemia - wejście</title>
</head>
<div id="page">
      <?php
            require_once('../../../Classes/hero.php');
            session_start();
            if(isset($_GET['level'])) if($_SESSION['hero']['courage'] < $_GET['level'])
            {
                  $_SESSION['hero']['action_var'] = 0;
                  $_SESSION['tech']['text'] = 'Za mało odwagi.<br> Potrzeba '.$_GET['level'].', a masz '.$_SESSION['hero']['courage'].'.';
                  $_SESSION['tech']['link'] ='PHP/Zones/Dungeons/entrance.php';
                  header('Location: ../../../communication.php');
            }
            else $_SESSION['hero']['action_var'] = $_GET['level'];
            // sprawdza czy weszlismy do podziemi i czy mamy tyle mestwa
            if($_SESSION['hero']['action_var'] != 0) // sprawdza czy weszlismy poprawnie
            {
                  $_SESSION['tech']['path'] = 'PHP/Zones/Dungeons/';
                  $_SESSION['tech']['file'] = 'dungeons.php';
                  $flag = false;
                  if($_SESSION['hero']['action_var'] < 10)
                  {
                        echo $_SESSION['hero']['action_var'].'<br>';
                        $random = rand(1,2429);
                        $_SESSION['hero']['action_var'] += 10*$random;
                  }
                  else $random = floor($_SESSION['hero']['action_var'] / 10);
                  echo $_SESSION['hero']['action_var'].'<br>';
                  if($random % 3 == 0)
                  {
                        echo '<a href="event.php">idz naprzod</a><br>';
                        $flag = true;
                  }
                  $random = floor($random / 3);
                  if($random % 3 == 0)
                  {
                        echo '<a href="event.php">idz w prawo</a><br>';
                        $flag = true;
                  }
                  $random = floor($random / 3);
                  if($random % 3 == 0)
                  {
                        echo '<a href="event.php">idz w lewo</a><br>';
                        $flag = true;
                  }
                  $random = floor($random / 3);
                  if($random % 3 == 0)
                  {
                        echo '<a href="event.php">zejdz po schodach</a><br>';
                        $flag = true;
                  }
                  $random = floor($random / 3);
                  if($random % 3 == 0)
                  {
                        echo '<a href="event.php">wejdz po drabinie</a><br>';
                        $flag = true;
                  }
                  $random = floor($random / 3);
                  if($random % 10 == 0 || $flag == false) echo '<a href="exit.php">Wyjdz</a>';
            }
            else if(!isset($_SESSION['tech']['text']))header('Location: entrance.php'); // gdyby po wejsciu nie bylo get(hacker)
      ?>
</div>
