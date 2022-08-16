<!DOCTYPE html
	PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<LINK rel="stylesheet" href="../Style/style_start_pages.css" type="text/css">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pl" lang="pl">
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<meta name="Description" content="Tu wpisz opis zawartości strony" />
	<meta name="Keywords" content="Tu wpisz wyrazy kluczowe rozdzielone przecinkami" />
	<title>Strona główna</title>
</head>
<body>
<div id="page">
   <div id="columnLeft">
   	<div id="picture01">
   		<img src="../Graphics/batman.jpeg" alt="" >
      </div>
      <div id="menuVertical">
      	<ul>
      		<li><a href="log_in.php">logowanie</a>
      		<li><a href="registration.php">rejestracja</a>
      	</ul>
      </div>
   </div>
   <div id="columnRight">
      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus vehicula, nunc vel consequat blandit, nulla dui sollicitudin libero, tempor interdum dolor nunc eu lorem. Nunc tempus pellentesque tincidunt. Sed vulputate, ante a congue pharetra, velit augue porttitor elit, sit amet eleifend libero sem at sapien. Sed a velit at odio ultrices mollis. Praesent vitae ligula a erat cursus faucibus. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec hendrerit vehicula orci, vitae convallis tortor eleifend et. Duis eget erat vitae tortor laoreet ornare. Integer sit amet volutpat mi. Phasellus sagittis ornare dolor sit amet faucibus. Nam ac turpis quis enim gravida euismod. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</p>
   </div>
</div>
</body>
</html>
<?php
session_start();
$_SESSION['tech']['path'] = 'Start/';
$_SESSION['tech']['file'] = 'index.php';
?>