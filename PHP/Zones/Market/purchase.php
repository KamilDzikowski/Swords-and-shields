<?php
require_once('../../../Classes/hero.php');
session_start();
$pdo = new PDO('mysql:host=localhost;dbname=konta', 'root', 'lampa123', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
$pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
if(!isset($_GET['type']) || !isset($_GET['id']) || !is_numeric($_GET['id'])) header('Location: market.php');
else if($_GET['type'] != 'armor' && $_GET['type'] != 'shield' && $_GET['type'] != 'weapon_melee' && $_GET['type'] != 'weapon_ranged') header('Location: market.php');
else
{
      $stmt = $pdo -> query("SELECT * FROM auction WHERE id=".$_GET['id']);
      $auction = $stmt -> fetch();
      $stmt -> closeCursor();
      if($auction['id_owner'] == $_SESSION['hero']['id'])
      {
            $_SESSION['tech']['text'] = 'Nie możesz kupić od siebie.';
      }
      else if($_SESSION['hero']['cash'] < $auction['value'])
      {
     	      $_SESSION['tech']['link'] = 'PHP/Zones/Market/market.php?typ='.$_GET['type'];
     	      $_SESSION['tech']['text'] = 'Za mało pieniędzy.<br> Potrzeba '.$auction['value'].', a masz '.$_SESSION['hero']['cash'].'.';
      }
      else
      {
            $pdo -> exec("UPDATE ownership SET id_hero =".$_SESSION['hero']['id']." WHERE id=".$auction['id_ownership']);
            $_SESSION['hero']['cash'] -= $auction['value'];
            $stmt = $pdo -> query("SELECT cash, bank_cash, bank_level FROM hero WHERE id =".$auction['id_ownership']);
            $owner = $stmt -> fetch();
            $stmt -> closeCursor();
            $limit = ($owner['bank_level']*$owner['bank_level']+2)*33;
            $cash = 0;
            if($owner['cash'] + $auction['value'] < $limit) $cash = $owner['cash'] + $auction['value'];
            else $cash = $limit;
     	      $pdo -> exec("UPDATE hero SET cash = $cash WHERE id =".$auction['id_owner']);
            $pdo -> exec("DELETE FROM auction WHERE id =".$_GET['id']);
            $_SESSION['tech']['text'] = 'Kupiono.';
      }
      $_SESSION['tech']['link'] = 'PHP/Zones/Market/market.php?type='.$_GET['type'];
      header('Location: ../../../communication.php');
}
?>
