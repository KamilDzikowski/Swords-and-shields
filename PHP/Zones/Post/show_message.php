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
      <?php
            require_once('../../../Classes/hero.php');
		session_start();
		$_SESSION['tech']['path'] = 'PHP/Zones/Post/';
	      $_SESSION['tech']['file'] = 'show_message.php';
	      if(!isset($_GET['id'])) header('Location: post.php');
	      else $_SESSION['tech']['file'] .= '?id='.$_GET['id'];
		$pdo = new PDO('mysql:host=localhost;dbname=konta', 'root', 'lampa123', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
		$stmt = $pdo -> query("SELECT * FROM player_post WHERE id = ".$_GET['id']);
		$post = $stmt -> fetch();
		$stmt -> closeCursor();
		if($post['addressee'] == $_SESSION['hero']['id'])
		{
		    $stmt = $pdo -> query("SELECT login FROM player_hero WHERE id = ".$post['sender']);
		    $sender = $stmt -> fetch();
		    $stmt -> closeCursor();
		    echo 'Nadawca: '.$sender['login'].'<br><br>';
		    echo 'Data: '.$post['time'].'<br><br>';
                echo 'Tytuł: '.$post['title'].'<br><br>';
		    echo 'Treść: '.$post['message'];
            }
	?>
	<br><br>
	<a href="post.php">Wróć</a>
</div>
