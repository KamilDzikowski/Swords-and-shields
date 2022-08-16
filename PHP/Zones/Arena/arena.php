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
	<table border="2">
	<tr><td><b>Login</b></td><td><b>Poziom</b></td><td><b>Stawka</b></td><td><b></b></td></tr>
		<?php
			require_once('../../../Classes/hero.php');
                  session_start();
			$_SESSION['tech']['path'] = 'PHP/Zones/Arena/';
			$_SESSION['tech']['file'] = 'arena.php';
			$pdo = new PDO('mysql:host=localhost;dbname=konta', 'root', 'lampa123', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
			$pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$stmt = $pdo -> query("SELECT * FROM arena_notification WHERE zone = ".$_SESSION['hero']['zone']);
			foreach($stmt as $notification) if($_SESSION['hero']['level'] >= $notification['restriction'])
			{
				$stmt2 = $pdo -> query("SELECT login, level FROM player_hero WHERE id = ".$notification['hero_id']);
				$hero2 = $stmt2 -> fetch();
				$stmt2 -> closeCursor();
				$stmt2 = $pdo -> query("SELECT logged_in FROM player_user WHERE login = '".$hero2['login']."'");
				$user = $stmt2 -> fetch();
				$stmt2 -> closeCursor();
				if($user['logged_in'] == 0)
				{
					$pdo -> exec("DELETE FROM arena_notification WHERE hero_id =".$notification['hero_id']);
					continue;
				}
				echo '<tr>';
				echo '<td>'.$hero2['login'].'</td>';
				echo '<td>'.$hero2['level'].'</td>';
				echo '<td>'.$notification['bid'].'</td>';
				if($_SESSION['hero']['cash'] >= $notification['bid']) echo '<td><a href="challenge.php?id='.$notification['id'].'">Walcz</a></td>';
				else echo '<td>Nie masz wystarczającej ilosći gotówki</td>';
                        echo '</tr>';
			}
			$stmt -> closeCursor();
		?>
	</table>
	<form method="post" action="notification.php">
		Podaj stawkę: <input type="text" name="bid"/><br/>
		Podaj ograniczenie: <input type="text" name="restriction"/><br/>
	      <input type="submit" value="OK"/>   
	</form>
	<a href="../../../zone.php">Miasto</a>
</div>
