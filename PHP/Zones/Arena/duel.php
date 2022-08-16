<!DOCTYPE html
	PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.batman.com">
<LINK rel="stylesheet" href="../../../Style/style_walka.css" type="text/css"></LINK>
<html xmlns="www.google.pl" xml:lang="pl" lang="pl">
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<meta name="Description" content="Tu wpisz opis zawartości strony" />
	<meta name="Keywords" content="Tu wpisz wyrazy kluczowe rozdzielone przecinkami" />
	<!--<meta http-equiv="Refresh" content="5" />-->
	<title>Start</title>
</head>
<div id="strona"> 
	<div id="Lewo">
		<br><br><br><br>
	</div>
	<div id="Prawo">
		<div id="PrawoLewo">
			<div id="PrawoLewoGora">
			 <?php
                        require_once('../../../Classes/hero.php');
                        require_once('../../../Classes/duel.php');
                        session_start();
                        $_SESSION['tech_sciezka'] = 'PHP/Czynnosci/Arena/';
                        $_SESSION['tech_plik'] = 'walka.php';
                        $pdo = new PDO('mysql:host=localhost;dbname=konta', 'root', 'lampa123', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
                        $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                        $stmt = $pdo -> query("SELECT turn FROM arena_duel WHERE id = ".$_SESSION['hero']['action_var']);
                        $walka = $stmt -> fetch();
                        $stmt -> closeCursor();
                        $stmt = $pdo -> query("SELECT size, position_challenger, position_challenged, direction_challenged, direction_challenger, life_challenger, life_ challenged, mobility_challenged, mobility_challenger FROM arena_duel WHERE id = ".$_SESSION['hero']['action_var']);
                        $duel = $stmt -> fetch();
                        $stmt -> closeCursor();
                        if($_SESSION['hero']['number'] == 1)
                        {     
                              echo 'Ty:'.$duel['life_challenger'].'/'.$_SESSION['hero']['life_max'].'<br>';
                              echo 'Przciwnik:'.$duel['life_challenged'].'<br>';
                              echo 'Pozycje:'.$duel['position_challenger'].'/'.$duel['position_challenger'].'<br>';
                              echo 'Jestes zwrócony w '.(($walka['direction_challenger'] == 1)? 'prawo' : 'lewo').'<br>';
                        }
                        else
                        {     
                              echo 'Ty:'.$duel['life_challenged'].'/'.$_SESSION['hero']['life_max'].'<br>';
                              echo 'Przciwnik:'.$duel['life_challenger'].'<br>';
                              echo 'Pozycje:'.$duel['position_challenged'].'/'.$duel['position_challenged'].'<br>';
                              echo 'Jestes zwrócony w '.(($walka['direction_challenged'] == 1)? 'prawo' : 'lewo').'<br>';
                        }
                  ?>
			</div>
			<div id="PrawoLewoDol">
            <?php
            if($walka['turn'] == 0) header('Location: victory.php');
            else if($walka['turn'] == -1)
            {
                  header('Location: arena.php');
                  unset($_SESSION['duel']);
            }
            else if($walka['turn'] == $_SESSION['hero']['number'])
            {
                  if($_SESSION['hero']['number'] == 1)
                  {
                        $position = $duel['position_challenger'];
                        $direction = $duel['direction_challenger'];
                        $target = $duel['position_challenged'];
                  }
                  else
                  {
                        $position = $duel['position_challenged'];
                        $direction = $duel['direction_challenged'];
                        $target = $duel['position_challenger'];
                  }
                  $limit = $duel['size'];                              
                  if($target - $position != $direction && $position * $direction < $limit && ($position != 0 || $direction != -1)) echo "<a href='move_forward.php'>Naprzód</a><br>";
			if($position - $target != $direction && $position * $direction*(-1) < $limit && ($position != 0 || $direction != 1) && $_SESSION['duel']->hero['mobility'] > 1) echo "<a href='move_back.php'>Cofnij się</a><br>";
			echo "<a href='equipment_change.php'>Zmien ekwipunek</a><br>";
                  echo "<a href='turn_back.php'>Odwróć się</a><br>";
                  if($target - $position == $direction && $_SESSION['duel']->hero['atack_ranged'] == 0)
                  {
                                    echo "<a href='blow.php?type=strong'>Silny cios</a><br>";
                                    echo "<a href='blow.php?type=accurate'>Precyzyjny cios</a><br>";
                  }
                  if($target - $position * $direction > 1 && $_SESSION['duel']->hero['atack_ranged'])
                  {
                                    echo "<a href='shot.php?type=accurate'>Precyzyjny_strzal</a><br>";
                                    echo "<a href='shot.php?type=quick'>Szybki_strzal</a><br>";
                  }
                  echo "<a href='surrender.php'>Poddaj się</a>";
            }
            else echo "Ruch przeciwnika";
        ?>
			</div>
		</div>
		<div id="PrawoPrawo">
			<br><br><br><br>
		</div>
	</div>
</div>