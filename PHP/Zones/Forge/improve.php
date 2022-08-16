<?php
require_once('../../../Classes/hero.php');
require_once('../../Functions/equipment.php');
session_start();
try
{
      $pdo = new PDO('mysql:host=localhost;dbname=konta', 'root', 'lampa123', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
      $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      if(is_equipped($_GET['id']) == true) throw new Exception('Nosisz to.');
      $stmt = $pdo -> query("SELECT hero_id, item_type, item_id, level FROM ownership WHERE id =".$_GET['id']);
	$ownership = $stmt -> fetch();
	$stmt -> closeCursor();
	if($ownership['hero_id'] != $_SESSION['hero']['id']) throw new Exception('Nie jesteś właścicielem.');
      $stmt = $pdo -> query("SELECT value_improve FROM item_".$ownership['item_type']." WHERE id=".$ownership['item_id']);
      $item = $stmt -> fetch();
      $stmt -> closeCursor();
      if($_SESSION['hero']['cash'] < $item['value_improve'])
      {
	     $_SESSION['tech']['text'] = 'Za mało pieniędzy.<br> Potrzeba '.$item['value_improve'].', a masz '.$_SESSION['hero']['cash'].'.';
	     header('Location: ../../../communication.php');
      }
      else if($_SESSION['hero']['craftsmanship'] < ($ownership['level']+1)*10)
      {
	     $_SESSION['tech']['text'] = 'Za mało rzemiosła.<br> Potrzeba '.(($ownership['level']+1)*10).', a masz '.$_SESSION['hero']['craftsmanship'].'.';
	     header('Location: ../../../communication.php');
      }
      else
      {
            $_SESSION['hero']['cash'] -= $item['value_improve'];
            if(rand(1, 10) > $ownership['level'])
	      {
		    $_SESSION['tech']['text'] = 'Ulepszyłeś przedmiot na '.($ownership['level']+1).' poziom!<br>';
		    $pdo -> exec("UPDATE ownership SET level = ".($ownership['level']+1)." WHERE id = ".$_GET['id']);
	      }
	      else
	      {
		    $_SESSION['tech']['text'] = 'Niestety zepsułeś przedmiot. Ale z ciebie fajtłapa.';
		    $pdo -> exec("DELETE FROM ownership WHERE id = ".$_GET['id']);
	      }
	      header('Location: ../../../communication.php');
      }
}
catch(PDOException $e)
{
      $_SESSION['tech']['text'].= 'Błąd PDO';
      header('Location: ../../../error.php');
}
catch(Exception $e)
{
      $_SESSION['tech']['text'].= $e -> getMessage();
      header('Location: ../../../error.php');
}
?>
