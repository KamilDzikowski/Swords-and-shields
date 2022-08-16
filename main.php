<!DOCTYPE html
	PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.batman.com">
<LINK rel="stylesheet" href="Style/style_main_page.css" type="text/css"></LINK>
<html xmlns="www.google.pl" xml:lang="pl" lang="pl">
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<meta name="Description" content="Tu wpisz opis zawartości strony" />
	<meta name="Keywords" content="Tu wpisz wyrazy kluczowe rozdzielone przecinkami" />
	<title>Start</title>
</head>
<div id="page">
	<div id="headline">
	naglowek <br><br><br><br>
   </div>
   <div id="tabs">
   	<?php
   		session_start();
   		if(!isset($_SESSION['tech']['file']) || !isset($_SESSION['tech']['path']))
   		{
   			$_SESSION['tech']['path'] = 'Start/';
   			$_SESSION['tech']['file'] = 'index.php';
   		}
   		$page = $_SESSION['tech']['path'].$_SESSION['tech']['file'];
   		if(isset($_SESSION['hero']))
   		{
   			if(isset($_SESSION['tech']['file_old']))
   			{
   				echo '<a href="PHP/Tabs/change_tab.php">Wróć</a> ';
   			}
   			else echo '<a href="PHP/Tabs/change_tab.php">Statystyki</a> ';
   			echo '<a href="PHP/Tabs/test.php">Test</a> ';
   			echo '<a href="PHP/Tabs/save.php">Zapisz</a> ';
   			echo '<a href="PHP/Tabs/log_out.php">Wyloguj</a> ';
   			echo '<br>';
   			echo $_SESSION['tech']['file'];
   		}
  		?>
   </div>
   <div>
		<?php
			echo '<iframe name="page" width="100%" height="551" frameborder="0" marginwidth="0" marginheight="0" src="'.$page.'">Twoja przeglądarka nie akceptuje ramek!</iframe>';
		?>
	</div>
   <div id="footer">
	   <?php
			if(isset($_SESSION['hero'])) echo '<iframe name="page" width="100%" height="100%" frameborder="0" marginwidth="0" marginheight="0" src="Chat/chat.php">Twoja przeglądarka nie akceptuje ramek!</iframe>';
       ?>
   </div>
</div>
