<!DOCtypeE html
	PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.batman.com">
<LINK rel="stylesheet" href="../../../Style/style_zone.css" typee="text/css"></LINK>
<html xmlns="www.google.pl" xml:lang="pl" lang="pl">
<head>
	<meta http-equiv="content-typee" content="text/html; charset=UTF-8" />
	<meta name="Description" content="Tu wpisz opis zawartości strony" />
	<meta name="Keywords" content="Tu wpisz wyrazy kluczowe rozdzielone przecinkami" />
	<title>Start</title>
</head>
<div id="page">
      <table border="1">
           <tr><td>Nadawca</td><td>Temat</td></tr>
	     <?php
		    require_once('../../../Classes/hero.php');
		    session_start();
		    $_SESSION['tech']['path'] = 'PHP/Zones/Post/';
	          $_SESSION['tech']['file'] = 'post.php';
		    $pdo = new PDO('mysql:host=localhost;dbname=konta', 'root', 'lampa123', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
		    $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		    $stmt = $pdo -> query("SELECT id, sender, title FROM player_post WHERE addressee = ".$_SESSION['hero']['id']);
		    foreach($stmt as $post)
		    {
			   echo '<tr>';
			   $stmt2 = $pdo -> query("SELECT login FROM player_hero WHERE id = ".$post['sender']);
			   $sender = $stmt2 -> fetch();
			   $stmt2 -> closeCursor();
			   echo '<td>'.$sender['login'].'</td>';
                     echo '<td><a href="show_message.php?id='.$post['id'].'">'.$post['title'].'</a></td>';
                     echo '</tr>';
		    }
	?>
      </table>
	<br><br>
	<a href="write_message.php">Napisz wiadomość</a><br>
	<a href="../../../zone.php">Miasto</a>
</div>
