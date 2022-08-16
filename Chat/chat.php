<!DOCtypeE html
	PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.batman.com">
<LINK rel="stylesheet" href="../Style/style_chat.css" type="text/css"></LINK>
<html xmlns="www.google.pl" xml:lang="pl" lang="pl">
<head>
	<meta http-equiv="content-typee" content="text/html; charset=UTF-8" />
	<meta name="Description" content="Tu wpisz opis zawartości strony" />
	<meta name="Keywords" content="Tu wpisz wyrazy kluczowe rozdzielone przecinkami" />
	<meta http-equiv="Refresh" content="5" />
	<title>Czat</title>
</head>
<div>
	<form action="send_chat.php" method="POST">
            <input type="text" size="50" maxlength="50" name="message" /> 
            <input type="submit" value="Napisz" />
      </form>
	<?php
		require_once('../Classes/hero.php');
		session_start();
		$pdo = new PDO('mysql:host=localhost;dbname=konta', 'root', 'lampa123', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
		$pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt = $pdo -> query("SELECT * FROM player_chat ORDER BY id DESC");
		foreach($stmt as $shoutbox)
		{
			try
			{	
				$stmt2 = $pdo -> query("SELECT login FROM player_hero WHERE id=".$shoutbox['sender']);
				$sender = $stmt2 -> fetch();
				$stmt2 -> closeCursor();
			}
			catch(PDOException $e)
			{
				$pdo -> exec("DELETE FROM player_chat WHERE id=".$shoutbox['id']);
				break;
			}
			echo '<div class="light">'.$shoutbox['date'].' <b>'.$sender['login'].'</b>: '.$shoutbox['message'].'</div>';
		}
	?>
</div>
<script>
var divs = document.getElementsByTagName('div');
for(i=1; i<divs.length; i+=2) divs[i].className = 'dark';
</script>
