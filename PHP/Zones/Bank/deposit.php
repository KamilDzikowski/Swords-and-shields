<?php
require_once('../../../Classes/hero.php');
session_start();	
header('Location: ../../../communication.php');
$limit = ($_SESSION['hero']['bank_level']*$_SESSION['hero']['bank_level']+2)*33;
if(isset($_POST['payment'])) $amount = $_POST['payment'];
else if(isset($_POST['withdraw'])) $amount = -$_POST['withdraw'];
if(!isset($amount) || !is_numeric($amount)) header('Location: bank.php');
else if($amount < -($_SESSION['hero']['bank_cash']))
{
	$_SESSION['tech']['text'] = 'Za mało pieniędzy na koncie.<br>';
}
else if($_SESSION['hero']['cash'] < $amount)
{
	$_SESSION['tech']['text'] = 'Za mało pieniędzy.<br> Potrzeba '.$amount.', a masz '.$_SESSION['hero']['cash'].'.';
}
else if($amount + $_SESSION['hero']['bank_cash'] > $limit)
{
	$_SESSION['tech']['text'] = 'Brak miejsca na koncie. Wplacono tylko '.abs(ceil($limit - $_SESSION['hero']['bank_cash'])).'.';
	$_SESSION['hero']['cash'] -= ceil($limit - $_SESSION['hero']['bank_cash']);
	$_SESSION['hero']['bank_cash'] = $limit;
  	$_SESSION['hero']['bank_time'] = time();
}
else
{
	$_SESSION['hero']['cash'] -= $amount;
	$_SESSION['hero']['bank_cash'] += $amount;
  	$_SESSION['hero']['bank_time'] = time();
  	$_SESSION['tech']['text'] = 'Pomyślnie w'.((isset($_POST['withdraw']) && $amount<0)? 'y' : '').((isset($_POST['payment']) && $amount<0)? 'y' : '').'płacono '.abs($amount).'.';
}
?>
