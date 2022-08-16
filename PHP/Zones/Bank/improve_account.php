<?php
require_once('../../../Classes/hero.php');
session_start();
$cost = $_SESSION['hero']['bank_level']*25 + 25;
if($_SESSION['hero']['cash'] + $_SESSION['hero']['bank_cash'] < $cost)
{
      $_SESSION['tech']['text'] = 'Niestety, nie stać cię.';
}
else if($_SESSION['hero']['cash'] >= $cost)
{
      $_SESSION['hero']['cash'] -= $cost;
      $_SESSION['hero']['bank_level'] += 1;
      $_SESSION['tech']['text'] = 'Konto zostalo ulepszone.';
}
else
{
	$_SESSION['hero']['bank_cash'] = $_SESSION['hero']['bank_cash'] - $cost + $_SESSION['hero']['cash'];
	$_SESSION['hero']['cash'] = 0;
	$_SESSION['hero']['bank_level'] += 1;
	$_SESSION['tech']['text'] = 'Konto zostalo ulepszone. Brakująca gotówka zostala zaczerpnięta z konta.';
}
header('Location: ../../../communication.php');
?>
