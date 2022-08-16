<?php
require_once('../../Classes/hero.php');
session_start();
if(!isset($_GET['id']) || !is_numeric($_GET['id'])) header('Location: '.$_SESSION['tech']['path'].$_SESSION['tech']['file']);
else
{
      $pdo = new PDO('mysql:host=localhost;dbname=konta', 'root', 'lampa123', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
      $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $stmt = $pdo -> query("SELECT item_type, item_id FROM ownership WHERE id = ".$_GET['id']);
      $ownership = $stmt -> fetch();
      $stmt -> closeCursor();
      $stmt = $pdo -> query("SELECT stack FROM item_".$ownership['item_type']." WHERE id = ".$ownership['item_id']);
      $item = $stmt -> fetch();
      $stmt -> closeCursor();
      //sprawdzenie czy warto
      if($item['stack'] == 1)
      {
            header('Location: '.$_SESSION['tech']['path'].$_SESSION['tech']['file']);
            die();
      }
      //sprawdzenie czy nie nosi tego
      $worn = false;
      if($ownership['item_type'] == 'ammo') if($_SESSION['hero']['ammo'] != 0)
      {
            $stmt = $pdo -> query("SELECT item_id FROM ownership WHERE id = ".$_SESSION['hero']['ammo']);
            $ammo = $stmt -> fetch();
            $stmt -> closeCursor();
            if($ammo['item_id'] == $ownership['item_id'])
            {
                  $worn = true;
            }
      }
      $stmt = $pdo -> query("SELECT SUM(amount) as 'sum' FROM ownership WHERE hero_id = ".$_SESSION['hero']['id']." AND item_type = '".$ownership['item_type']."' AND item_id = ".$ownership['item_id']." AND stored = 0");
      $sum = $stmt -> fetch();
      $stmt -> closeCursor();
      $amount_full = floor($sum['sum']/$item['stack']);
      $rest = $sum['sum'] - $item['stack']*$amount_full;
      $pdo -> exec("DELETE FROM ownership WHERE hero_id = ".$_SESSION['hero']['id']." AND item_type = '".$ownership['item_type']."' AND item_id = ".$ownership['item_id']." AND stored = 0");
      for($i = 0; $i != $amount_full; ++$i) $pdo -> exec("INSERT INTO ownership (hero_id, item_type, item_id, amount) VALUES ('".$_SESSION['hero']['id']."', '".$ownership['item_type']."', '".$ownership['item_id']."', '".$item['stack']."')");
      if($rest != 0) $pdo -> exec("INSERT INTO ownership (hero_id, item_type, item_id, amount) VALUES ('".$_SESSION['hero']['id']."', '".$ownership['item_type']."', '".$ownership['item_id']."', '".$rest."')");
      //założenie tego co ma najwięcej
      if($worn == true)
      {
            if($amount_full != 0) $rest = $item['stack'];
            $stmt = $pdo -> query("SELECT id FROM ownership WHERE hero_id = ".$_SESSION['hero']['id']." AND item_type = '".$ownership['item_type']."' AND item_id = ".$ownership['item_id']." AND stored = 0 AND amount = ".$rest);
            $ownership = $stmt -> fetch();
            $_SESSION['hero']['ammo'] = $ownership['id'];
            $stmt -> closeCursor();
      }
      header('Location: ../../'.$_SESSION['tech']['path'].$_SESSION['tech']['file']);
}
?>				
