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
      $stmt = $pdo -> query("SELECT value, durability FROM item_".$ownership['item_type']." WHERE id = ".$ownership['item_id']);
      $item = $stmt -> fetch();
      $stmt -> closeCursor();
      $costs = floor($item['value'] * $ownership['level'] * (1 - $ownership['durability'] / $item['durability']));
      if($_SESSION['hero']['cash'] < $costs)
      {
	     $_SESSION['tech']['text'] = 'Za mało kasy.<br> Potrzeba '.$costs.', a masz '.$_SESSION['hero']['cash'].'.';
      }
      else
      {
            $_SESSION['hero']['cash'] -= $costs;
            $_SESSION['tech']['text'] = 'Przedmiot został skutecznie naprawiony przez czeladnika sztuki kowalskiej, Bożydara z Łysogrodu!';
            $pdo -> exec("UPDATE ownership SET durability = ".$item['durability']." WHERE id = ".$_GET['id']);
      }
      header('Location: ../../../communication.php');
}
catch(PDOException $e)
{
      $_SESSION['tech']['text'].= 'Błąd PDO';
      header('Location: ../../../error.php');
}
/*if($_SESSION['hero']['craftsmanship'] < $ownership['level']*10)
{
	$_SESSION['tech']['text'] = 'Za mało rzemiosła.<br> Potrzeba '.(($ownership['level']+1)*10).', a masz '.$_SESSION['hero']['craftsmanship'].'.';
	header('Location: ../../../communication.php');
}
else 
{
	$stmt = $pdo -> query("SELECT * FROM work_job WHERE id = ".$item['job_id']);
      $job = $stmt -> fetch();
      $stmt -> closeCursor();
      if($job['id_tool'] != 0)
      {
            if($_SESSION['hero']['tool'] == 0)
            {
                  $_SESSION['tech']['text'] = 'Nie masz narzędzi!';
                  header('Location: ../../../communication.php');
                  die();
            }
            $stmt = $pdo -> query("SELECT item_id FROM ownership WHERE id = ".$_SESSION['hero']['tool']);
            $tool = $stmt -> fetch();
            $stmt -> closeCursor();
            if($tool['item_id'] != $job['id_tool'])
            {
                  $_SESSION['tech']['text'] = 'Nie masz narzędzi!';
                  header('Location: ../../../communication.php');
                  die();
            }
      }
      $ownerships = NULL;
      for($i=1; isset($job['component_id'.$i]); $i++)
      {
            $stmt = $pdo -> query("SELECT id, amount FROM ownership WHERE hero_id = ".$_SESSION['hero']['id']." AND item_type = '".$job['component_table'.$i]."' AND item_id=".$job['component_id'.$i]." AND stored = 0 ORDER BY amount DESC");
            $ownership = $stmt -> fetch();
            $stmt -> closeCursor();
            if($ownership['amount'] >= $job['component_amount'.$i]) $ownerships[$i] = $ownership;
            else
            {
                  $_SESSION['tech']['text'] = 'Nie masz surowców!';
                  header('Location: ../../../communication.php');
                  die();
            }
      }
      for($i=1; isset($job['component_id'.$i]); $i++)
      {
            if($ownerships[$i]['amount'] == $job['component_amount'.$i]) $stmt = $pdo -> exec("DELETE FROM ownership WHERE id = ".$ownerships[$i]['id']);
            else $stmt = $pdo -> exec("UPDATE ownership SET amount = ".($ownerships[$i]['amount'] - $job['component_amount'.$i])." WHERE id = ".$ownerships[$i]['id']);
      }
      $stmt = $pdo -> query("SELECT durability FROM item_".$ownership['item_type']." WHERE id=".$ownership['item_id']);
	$item = $stmt -> fetch();
	$stmt -> closeCursor();
      if(rand(1, 100) <= 100 * $ownership['durability'] / $item['durability'] + $_SESSION['hero']['craftsmanship'] - $ownership['level']*10)
      {
            $_SESSION['tech']['text'] = 'Udało ci się naprawić przedmiot';
            $pdo -> exec("UPDATE ownership SET durability = ".$item['durability']." WHERE id = ".$_GET['id']);
	}
	else 
	{
		$ownership['durability'] -= floor(0.25 * $item['durability']);
		if($ownership['durability'] > 0)
		{
			$_SESSION['tech']['text'] = 'Niestety pogorszyłeś stan przedmiotu. Ale z ciebie niezdara. Następnym razem bądź bardziej ostrożnym';			
			$pdo -> exec("UPDATE ownership SET durability = ".$ownership['durability']." WHERE id = ".$_GET['id']);
		}
		else		
		{
			$_SESSION['tech']['text'] = 'Niestety zepsułeś przedmiot. Ale z ciebie niezdara. Następnym razem bądź bardziej ostrożnym';
			$pdo -> exec("DELETE FROM ownership WHERE id = ".$_GET['id']);
		}
	}
	header('Location: ../../../communication.php');
}*/
?>
