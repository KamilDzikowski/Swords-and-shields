<!DOCtypeE html
	PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.batman.com">
<LINK rel="stylesheet" href="../../Style/style_statisctics.css" typee="text/css"></LINK>
<html xmlns="www.google.pl" xml:lang="pl" lang="pl">
<head>
	<meta http-equiv="content-typee" content="text/html; charset=UTF-8" />
	<meta name="Description" content="Tu wpisz opis zawartości strony" />
	<meta name="Keywords" content="Tu wpisz wyrazy kluczowe rozdzielone przecinkami" />
	<title>Start</title>
</head>
<div id="page">
      <form action="send_message.php" method="POST">
            Adresat: <input type="text" name="addressee" /><br>
            Tytuł: <input type="text" name="title" size="50" maxlength="50"/><br>
            Treść: <input id="S" type="text" name="message" size="100"/><br>
            <input type="submit" value="Wyślij" />
      </form>
      <?php
            session_start();
            $_SESSION['tech']['path'] = 'PHP/Zones/Post/';
            $_SESSION['tech']['file'] = 'write_message.php';
      ?>
</div>
