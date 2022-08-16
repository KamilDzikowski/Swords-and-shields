<?php
require_once('../../../Classes/hero.php');
session_start();
$pdo = new PDO('mysql:host=localhost;dbname=konta', 'root', 'lampa123', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
$pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
try
{
	$stmt = $pdo -> query("SELECT value, stack FROM item_".$_GET['type']." WHERE id=".$_GET['id']);
      $item = $stmt -> fetch();
      $stmt -> closeCursor();
      if($_SESSION['hero']['cash'] < $item['value'])
      {
		$_SESSION['tech']['text'] = 'Za mało pieniędzy.<br> Potrzeba '.$item['value'].', a masz '.$_SESSION['hero']['cash'].'.';
	}
	else
	{		
		try
		{     
		      $stmt = $pdo -> query("SELECT durability FROM item_".$_GET['type']." WHERE id=".$_GET['id']);
                  $item2 = $stmt -> fetch();
                  $stmt -> closeCursor();
                  $durability = $item2['durability'];
            }
            catch(PDOException $e)
            {
                  $durability = 'NULL';
            }
	      echo $durability;
            $pdo -> exec("INSERT INTO ownership (hero_id, item_type, item_id, amount, durability) VALUES ('".$_SESSION['hero']['id']."', '".$_GET['type']."', ".$_GET['id'].", ".$item['stack'].", ".$durability." )");
		$_SESSION['hero']['cash'] -= $item['value'];
		$_SESSION['tech']['text'] = 'Zakupiono.';
	}
	header('Location: ../../../communication.php');
}
catch(PDOException $e)
{
      $_SESSION['tech']['text'].= $e -> getMessage();
      header('Location: ../../../error.php');
}
?>
