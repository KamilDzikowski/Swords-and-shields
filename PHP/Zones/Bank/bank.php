<!doctype html
	public "-//w3c//dtd xhtml 1.0 transitional//en"
	"http://www.batman.com">
<link rel="stylesheet" href="../../../style/style_zone.css" type="text/css"></link>
<html xmlns="www.google.pl" xml:lang="pl" lang="pl">
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="description" content="tu wpisz opis zawartości strony" />
	<meta name="keywords" content="tu wpisz wyrazy kluczowe rozdzielone przecinkami" />
	<title>start</title>
</head>
<div id="page">
	witamy w banku. <br>
	oprocentowanie wynosi 2% w skali dnia.<br>
	kapitalizacja następuje po uplywie 24 godzin.<br>
      <?php
		require_once('../../../classes/hero.php');
		session_start();
		$_session['tech']['path'] = 'php/zones/bank/';
		$_session['tech']['file'] = 'bank.php';
    	      $limit = ($_session['hero']['bank_level']*$_session['hero']['bank_level']+2)*33;
		$time = time() - $_session['hero']['bank_time'];
		if($time >= 86400)
		{
			$_session['hero']['bank_cash'] *= 1.02;
			$_session['hero']['bank_time'] -= 86400;
			while($time >= 86400)
			{
				$_session['hero']['bank_cash'] *= 1.02;
				$time -= 86400;
			}
			if($_session['hero']['bank_cash'] > $limit)
			{
				$_session['hero']['bank_cash'] = $limit;
				echo '<b>powiększ konto, bo tracisz odsetki!</b><br>';
			}
			$_session['hero']['bank_time'] = $time + time();
		}
		echo 'przy sobie masz '.$_session['hero']['cash'].' gotówki, a w banku '.floor($_session['hero']['bank_cash']).'.<br>';
            echo 'na koncie możesz przechowywać maksymalnie: '.$limit.'.<br>';
            echo '<a href = "improve_account.php">ulepszenie</a> konta kosztuje '.($_session['hero']['bank_level']*25 + 25).'. ';
    	      echo 'zwiększy to twój limit o '.($_session['hero']['bank_level']*66 + 33).'.<br>';
	?>
	wpłać. <br>
	<form method="post" action="deposit.php">
		podaj kwotę: <input type="text" name="payment"/><br>
	      <input type="submit" value="ok"/>
	</form>
	wypłać. <br>
	<form method="post" action="deposit.php">
		podaj kwotę: <input type="text" name="withdraw"/><br>
	      <input type="submit" value="ok"/>
	</form>
	<a href="../../../zone.php">miasto</a>
</div>
