<!DOCTYPE html
	PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.batman.com">
<LINK rel="stylesheet" href="../../../Style/style_battle.css" type="text/css"></LINK>
<html xmlns="www.google.pl" xml:lang="pl" lang="pl">
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<meta name="Description" content="Tu wpisz opis zawartości strony" />
	<meta name="Keywords" content="Tu wpisz wyrazy kluczowe rozdzielone przecinkami" />
	<!--<meta http-equiv="Refresh" content="5" /> -->
	<title>Start</title>
</head>
<?php
	require_once('../../../Classes/hero.php');
	require_once('../../../Classes/encounter.php');
	session_start();
	$_SESSION['tech']['path'] = 'PHP/Zones/Dungeons/';
	$_SESSION['tech']['file'] = 'battle.php';
?>
<div id="page">
	<div id="Left">
		<br><br><br><br>
	</div>
	<div id="Right">
		<div id="RightLeft">
			<div id="RightLeftUp">
				<?php
					if($_SESSION['encounter']->battlefield['turn'] == 0)
					{
  						//enemy turn
                                    if($_SESSION['encounter']->enemy['atack_ranged'] &&  ($_SESSION['encounter']->enemy['position'] - $_SESSION['encounter']->hero['position'] > 1))
  						{
                                          $_SESSION['hero']['life'] -= $_SESSION['encounter']->enemy_atack_ranged();
                                          echo 'Potwór strzela!<br>';
                                    }
                                    else if(!$_SESSION['encounter']->enemy_move()) echo 'Potwór sie ruszył!<br>';
  						else 
                                    {
                                          $_SESSION['hero']['life'] -= $_SESSION['encounter']->enemy_atack_melee();
                                          echo 'Potwór uderza!<br>';
                                    }
                                    if($_SESSION['hero']['life'] <= 0)
                                    {
                                          $_SESSION['hero']['life'] = 1;
                                          $_SESSION['hero']['time'] = time()+100;
                                          $_SESSION['tech']['link'] = 'death.php';
                                          $postac['action'] = 5;
                                          header('Location: ../../../death.php');
                                    }
                                    $_SESSION['encounter']->battlefield['turn'] = 1;
                                    $_SESSION['encounter']->enemy['mobility'] = $_SESSION['encounter']->enemy['mobility_max'];
					      $_SESSION['encounter']->hero['mobility'] = $_SESSION['encounter']->hero['mobility_max'];
					}
					else
					{
  						echo 'Twój ruch!<br>';
					}
                              echo $_SESSION['hero']['life'].'/'.$_SESSION['hero']['life_max'].'<br>';
					echo $_SESSION['encounter']->enemy['life'].'/'.$_SESSION['encounter']->enemy['life_max'].'<br>';
					echo 'Gracz: '.$_SESSION['encounter']->hero['position'].'/'.$_SESSION['encounter']->hero['direction'].'/'.$_SESSION['encounter']->hero['mobility'].'<br>';
					echo 'Wróg: '.$_SESSION['encounter']->enemy['position'].'/'.$_SESSION['encounter']->enemy['direction'].'/-'.'<br>';
                              echo 'Atak: '.$_SESSION['encounter']->hero['atack_melee'].'/'.$_SESSION['encounter']->enemy['defense_melee'].'/-'.'<br>';
                              //echo 'Wróg: '.$_SESSION['encounter']->enemy['position'].'/'.$_SESSION['encounter']->enemy['direction'].'/-'.'<br>';
                        ?>
			</div>
			<div id="RightLeftBottom">
                        <?php
                              $position = $_SESSION['encounter']->hero['position'];
                              $direction = $_SESSION['encounter']->hero['direction'];
                              $target = $_SESSION['encounter']->enemy['position'];
                              $limit = $_SESSION['encounter']->battlefield['size'];
                              if($target - $position != $direction && $position * $direction < $limit && ($position != 0 || $direction != -1)) echo "<a href='move_forward.php'>Naprzód</a><br>";
					if($position - $target != $direction && $position * $direction*(-1) < $limit && ($position != 0 || $direction != 1) && $_SESSION['encounter']->hero['mobility'] > 1) echo "<a href='move_back.php'>Cofnij się</a><br>";
					echo "<a href='equipment_change.php'>Zmien ekwipunek</a><br>";
                              echo "<a href='turn_back.php'>Odwróć się</a><br>";
                              if($target - $position == $direction && $_SESSION['encounter']->hero['atack_ranged'] == 0)
                              {
                                    echo "<a href='blow.php?type=strong'>Silny cios</a><br>";
                                    echo "<a href='blow.php?type=accurate'>Precyzyjny cios</a><br>";
                              }
                              if($target - $position * $direction > 1 && $_SESSION['encounter']->hero['atack_ranged'])
                              {
                                    echo "<a href='shot.php?type=accurate'>Precyzyjny_strzal</a><br>";
                                    echo "<a href='shot.php?type=quick'>Szybki_strzal</a><br>";
                              }
                              echo "<a href='surrender.php'>Poddaj się</a>";
                        ?>
                  </div>
            </div>
		<div id="RightRight">
			<br><br><br><br>
		</div>
	</div>
</div>
