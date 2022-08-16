<?php
require_once('../../../Classes/hero.php');
require_once('../../../Classes/duel.php');
session_start();
if(isset($_GET['type']))
{
      if($_GET['type'] == 'strong')
      {
            $atack_factor = 0.5;
            $damage_factor = 2;
      }
      else if($_GET['type'] == 'accurate') 
      {
            $atack_factor = 2;
            $damage_factor = 0.5;
      }
      $pdo = new PDO('mysql:host=localhost;dbname=konta', 'root', 'lampa123', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
      $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      if($_SESSION['hero']['number'] == 1)
      {
            $stmt = $pdo -> query("SELECT * FROM arana_duel WHERE id_challenger = ".$_SESSION['hero']['id']);
            $enemy = 'challenged';
      }
      else if($_SESSION['hero']['number'] == 2)
      {
            $stmt = $pdo -> query("SELECT * FROM arena_duel WHERE id_challenged = ".$_SESSION['hero']['id']);
            $enemy = 'challenger';
      }
      $opponent = $stmt -> fetch();
      $stmt -> closeCursor();
      $atack = ($_SESSION['duel']->hero['atack_melee'] - $opponent[$enemy.'_defense_melee'])*$atack_factor;
      if($atack >= 0)$chance = 100 - 200/($atack + 4);
  	else $chance = 400/(8 - $atack);
      if(rand(1,100) > $chance) {if($_SESSION['hero']['hand_right'])if(rand(0,2) == 0) $_SESSION['duel']->impair($_SESSION['hero']['hand_right'], "weapon");}
      else
      {
                  if($_SESSION['hero']['hand_right']) if(rand(0,2) > 0) $_SESSION['duel']->impair($_SESSION['hero']['hand_right'], "weapon");
                  $damage_cut = $_SESSION['duel']->hero['damage_cut']/(1 + $opponent[$enemy.'_protection_cut']/$_SESSION['duel']->hero['damage_cut']);
                  $damage_smash = $_SESSION['duel']->hero['damage_smash']/(1 + $opponent[$enemy.'_protection_smash']/$_SESSION['duel']->hero['damage_smash']);
                  $opponent[$enemy.'_life'] -= round(($damage_cut + $damage_smash) * $damage_factor);
      }
      $pdo -> exec("UPDATE INTO arena_duel (".$enemy."_life) VALUES (".$opponent[$enemy.'_life']")");
      if($opponent[$enemy.'_life'] <= 0) 
      {
            $pdo -> exec("UPDATE INTO arena_duel (turn) VALUES (-1)");
            header('Location: victory.php'); //zginal
      }
      else 
      {
            $_SESSION['duel']->hero['mobility'] -= $opponent[$enemy.'_mobility'];  
            if($_SESSION['duel']->hero['mobility'] <= 0) $opponent['turn'] = 3 - $_SESSION['hero']['number'];
            $pdo -> exec("UPDATE INTO arena_duel (".$enemy."_life, turn) VALUES (".$opponent[$enemy.'_life']." , ".$opponent['turn'].")");
            header('Location: duel.php');
      } 
}//jak nie bylo ruchu nadal tura playera
?>
