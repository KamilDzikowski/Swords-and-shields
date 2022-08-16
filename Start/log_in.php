<!DOCTYPE html
	PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.batman.com">
<LINK rel="stylesheet" href="../Style/style_start_pages.css" type="text/css"></LINK>
<html xmlns="www.google.pl" xml:lang="pl" lang="pl">
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<meta name="Description" content="Tu wpisz opis zawartości strony" />
	<meta name="Keywords" content="Tu wpisz wyrazy kluczowe rozdzielone przecinkami" />
	<title>Logowanie</title>
</head>
<div id="page">
	<form id="log_in" name="log_in"  method="post" action="log_in.php">
		Login:<input type="text" id="login" name="login"><br>
		Hasło:<input type="text" id="password" name="password"><br>
		<input type="submit" id="submit" value="Zatwierdź">
	</form>
	<a href="index.php">Powrót</a>
	<div class="incorrectData">
		<?php
			require_once('../Classes/hero.php');
			session_start();
			if(isset($_SESSION['hero'])) header('Location: ../zone.php'); //czy zaistnieć może(glowna)?
			$_SESSION['tech']['path'] = 'Start/';
			$_SESSION['tech']['file'] = 'log_in.php';
			function log_in()
			{
				$login = $_POST['login'];
				try
   			{
      			$pdo = new PDO('mysql:host=localhost;dbname=konta', 'root', 'lampa123', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
					$stmt = $pdo -> query("SELECT login, password FROM player_user WHERE login = '$login'");
					$user = $stmt -> fetch();
					$stmt -> closeCursor();
					if($user == NULL)
					{
      				echo 'Błędny login!<br>';
   				}
   				else if($user['password'] != $_POST['password'])
   				{
      				echo 'Błędne hasło!<br>';
   				}
   				else
					{
						$hero = CHero::factory($pdo, $login);
						//sprawdzenie czy istnieje(bugi itd)
						$pdo -> exec("UPDATE player_user SET logged_in = 1 WHERE login = '$login'");
						$_SESSION['id'] = $hero['id'];
						$action = $hero['action'];
						if($action == NULL || $action == 0)
						{
							$_SESSION['tech']['path'] = '';
							$_SESSION['tech']['file'] = 'zone.php';
						}
						else if($action == 1)
						{
							$_SESSION['tech']['path'] = 'PHP/Zones/Work/';
							$_SESSION['tech']['file'] = 'working.php';
						}
						else if($action == 2)
						{
							$_SESSION['tech']['path'] = 'PHP/Zones/Travel/';
							$_SESSION['tech']['file'] = 'travelling.php';
						}
						else if($action == 3)
						{
							$_SESSION['tech']['path'] = 'PHP/Zones/Temple/';
							$_SESSION['tech']['file'] = 'leczenie.php';
						}
						else if($action == 4)
						{
							$_SESSION['tech']['path'] = 'PHP/Zones/Dungeons/';
							$_SESSION['tech']['file'] = 'unconsciousness.php';
						}
						else if($action == 5)
						{
							$_SESSION['tech']['path'] = '';
							$_SESSION['tech']['file'] = 'death.php';
						}
						$_SESSION['hero'] = $hero;
						header('Location: ../'.$_SESSION['tech']['path'].$_SESSION['tech']['file']);
      			}
				}
				catch(PDOException $e)
				{
      			echo 'Połączenie nie mogło zostać utworzone: ' . $e->getMessage();
   			}
			}
			if($_SERVER['REQUEST_METHOD'] == 'POST') log_in();
		?>
	</div>
</div>
</html>
