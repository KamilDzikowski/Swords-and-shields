<?php
require_once('../../../Classes/hero.php');
session_start();
$rand = rand(1,3);
if($_SESSION['hero']['cash'] >= 3) if($rand == 3)
{
	$_SESSION['tech']['text'] = 'Wygrałeś!';
	$_SESSION['hero']['cash'] += 5;
}
else
{
	$_SESSION['tech']['text'] = 'Przegrałeś!';
	$_SESSION['hero']['cash'] -= 3;
}
header('Location: ../../../communication.php');
?>
