<?php
require_once('../../../Classes/hero.php');
session_start();
$pdo = new PDO('mysql:host=localhost;dbname=konta', 'root', 'lampa123', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
$pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
try
{
      $stmt = $pdo -> query("SELECT hero_id, item_id, item_type FROM ownership WHERE id = ".$_GET['id']);
      $ownership = $stmt -> fetch();
      $stmt -> closeCursor();
      header('Location: '.$_SESSION['tech']['file']);
      if($ownership['hero_id'] != $_SESSION['hero']['id']);
      else if($ownership['item_type'] == 'armor')
      {
            $stmt = $pdo -> query("SELECT constitution_requirements FROM item_armor WHERE id = ".$ownership['item_id']);
            $item = $stmt -> fetch();
            $stmt -> closeCursor();
            if($_SESSION['hero']['constitution'] >= $item['constitution_requirements']) $_SESSION['encounter']->take_weapon($_GET['id']);
            else
            {
                  $_SESSION['tech']['text'] = 'Za mało budowy.<br> Potrzeba '.$item['constitution_requirements'].', a masz '.$_SESSION['hero']['constitution'].'.';
                  header('Location: ../../../communication.php');
            }
      }
      else if($ownership['item_type'] == 'shield')
      {
            $stmt = $pdo -> query("SELECT dexterity_requirements FROM item_shield WHERE id = ".$ownership['item_id']);
            $item = $stmt -> fetch();
            $stmt -> closeCursor();
            if($_SESSION['hero']['dexterity'] >= $item['dexterity_requirements']) if($_SESSION['hero']['left_busy'] == 0) $_SESSION['encounter']->take_weapon($_GET['id']);
            else
            {
                  $_SESSION['tech']['text'] = 'Twoja lewa ręka jest już zajęta.';
                  header('Location: ../../../communication.php');
            }
            else
            {
                  $_SESSION['tech']['text'] = 'Za mało zręczności.<br> Potrzeba '.$item['dexterity_requirements'].', a masz '.$_SESSION['hero']['dexterity'].'.';
                  header('Location: ../../../communication.php');
            }
      }
      else if($ownership['item_type'] == 'weapon_melee')
      {
	      $stmt = $pdo -> query("SELECT strength_requirements, dexterity_requirements, handedness FROM item_weapon_melee WHERE id = ".$ownership['item_id']);
            $item = $stmt -> fetch();
            $stmt -> closeCursor();
            if($_SESSION['hero']['dexterity'] >= $item['dexterity_requirements'] && $_SESSION['hero']['strength'] >= $item['strength_requirements'])
            {
                  $_SESSION['encounter']->take_weapon($_GET['id']);
                  /*if($item['handedness'] == 2)
                  {
                        $_SESSION['hero']['left_busy'] = 1;
                        $_SESSION['hero']['hand_left'] = 0;
                  }
                  else $_SESSION['hero']['left_busy'] = 0;*/
            }
            else
            {
                  $_SESSION['tech']['text'] = 'Za mało siły lub zręczności.<br> Potrzeba '.$item['strength_requirements'].' i '.$item['dexterity_requirements'].', a masz '.$_SESSION['hero']['strength'].' i '.$_SESSION['hero']['dexterity'].'.';
                  header('Location: ../../../communication.php');
            }
      }
      else if($ownership['item_type'] == 'weapon_ranged')
      {
            $stmt = $pdo -> query("SELECT strength_requirements, dexterity_requirements, handedness FROM item_weapon_ranged WHERE id = ".$ownership['item_id']);
            $item = $stmt -> fetch();
            $stmt -> closeCursor();
            if($_SESSION['hero']['dexterity'] >= $item['dexterity_requirements'] && $_SESSION['hero']['strength'] >= $item['strength_requirements'])
            {
                  $_SESSION['encounter']->take_weapon($_GET['id']);
                  /*if($item['handedness'] == 2)
                  {
                        $_SESSION['hero']['left_busy'] = 1;
                        $_SESSION['hero']['hand_left'] = 0;
                  }
                  else $_SESSION['hero']['left_busy'] = 0;*/
            }
            else
            {
                  $_SESSION['tech']['text'] = 'Za mało siły lub zręczności.<br> Potrzeba '.$item['strength_requirements'].' i '.$item['dexterity_requirements'].', a masz '.$_SESSION['hero']['strength'].' i '.$_SESSION['hero']['dexterity'].'.';
                  header('Location: ../../../communication.php');
            }
      }
      else if($ownership['item_type'] == 'ammo') $_SESSION['encounter']->take_weapon($_GET['id']);
}
catch(PDOException $e)
{
      $_SESSION['tech']['text'] = $e->getMessage();
      header('Location: ../../error.php');
}
?>

