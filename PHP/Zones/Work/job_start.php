<?php
include_once('../../../Classes/hero.php');
session_start();
$pdo = new PDO('mysql:host=localhost;dbname=konta', 'root', 'lampa123', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
$pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
try
{
      $stmt = $pdo -> query("SELECT * FROM work_job WHERE id=".$_GET['job_id']);
      $job = $stmt -> fetch();
      $stmt -> closeCursor();
      $_SESSION['hero']['action'] = 1;
      $_SESSION['hero']['time'] = time() + $job['time'];
      $_SESSION['hero']['action_var'] = $_GET['job_id'];
      if(isset($_GET['item_id'])) $_SESSION['hero']['action_var2'] = $_GET['item_id'];
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
      if($_SESSION['hero']['strength'] < $job['strength_requirements'])
      {
            $_SESSION['tech']['text'] = 'Za mała siła!';
            header('Location: ../../../communication.php');
            die();
      }
      if($_SESSION['hero']['dexterity'] < $job['dexterity_requirements'])
      {
            $_SESSION['tech']['text'] = 'Za mała zręczność!';
            header('Location: ../../../communication.php');
            die();
      }
      if($_SESSION['hero']['constitution'] < $job['constitution_requirements'])
      {
            $_SESSION['tech']['text'] = 'Za mała wytrzymałość!';
            header('Location: ../../../communication.php');
            die();
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
      header('Location: working.php');
}
catch(PDOException $e)
{
      $_SESSION['tech']['text'] = 'Błąd PDO';
      header('Location: ../../../error.php');
}
?>
