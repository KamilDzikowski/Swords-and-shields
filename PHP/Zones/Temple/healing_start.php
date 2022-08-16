<?php
require_once('../../../Classes/hero.php');
session_start();
if(!is_numeric($_GET['f']) || $_GET['f'] <= 0 || !is_numeric($_GET['delta']) || $_GET['delta'] <= 0 || !is_numeric($_GET['prize']) || $_GET['prize'] < 0) header('Location: swiatynia.php');
else
{
	if($_SESSION['hero']['cash'] >= $_GET['prize'] * $_GET['delta'])
	{
		$_SESSION['hero']['cash'] = $_SESSION['hero']['cash'] - $_GET['prize'] * $_GET['delta'];
		$_SESSION['hero']['action'] = 3;
		$_SESSION['hero']['action_var'] = $_GET['f'];
		$_SESSION['hero']['time'] = $_GET['delta'] * $_GET['f'] + time();
		header('Location: healing.php');
	}
	else 
	{
		$_SESSION['tech']['link'] = 'PHP/Zones/Temple/temple.php';
		$_SESSION['tech']['text'] = 'Za mało pieniędzy.<br> Potrzeba '.$_GET['prize'] * $_GET['delta'].', a masz '.$_SESSION['hero']['cash'].'.';
		header('Location: ../../../communication.php');
	}
}
?>