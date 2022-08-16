<?php
require_once('../../Classes/hero.php');
session_start();
$pdo = new PDO('mysql:host=localhost;dbname=konta', 'root', 'lampa123', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
$pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
try
{
      $stmt = $pdo -> query("SELECT item_type FROM ownership WHERE id = ".$_GET['id']);
      $ownership = $stmt -> fetch();
      $stmt -> closeCursor();
      header('Location: '.$_SESSION['tech']['file']);
      /*if($ownership['hero_id'] != $_SESSION['hero']['id']);
      else */
      if($ownership['item_type'] == 'armor')
      {
            $_SESSION['hero']['armor'] = 0;
      }
      else if($ownership['item_type'] == 'shield')
      {
            $_SESSION['hero']['hand_left'] = 0;
      }
      else if($ownership['item_type'] == 'weapon_melee')
      {
	      $_SESSION['hero']['hand_right'] = 0;
	      $_SESSION['hero']['left_busy'] = 0;
      }
      else if($ownership['item_type'] == 'weapon_ranged')
      {
           $_SESSION['hero']['hand_right'] = 0;
           $_SESSION['hero']['left_busy'] = 0;
      }
      else if($ownership['item_type'] == 'tool') $_SESSION['hero']['tool'] = 0;
      else if($ownership['item_type'] == 'ammo') $_SESSION['hero']['ammo'] = 0;
}
catch(PDOException $e)
{
      $_SESSION['tech']['text'] = $e->getMessage();
      header('Location: ../../error.php');
}
?>
