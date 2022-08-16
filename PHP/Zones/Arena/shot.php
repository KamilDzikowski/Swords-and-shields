<?php
require_once('../../../Classes/hero.php');
require_once('../../../Classes/duel.php');
session_start();
if(isset($_GET['type']))
{
      $pdo = new PDO('mysql:host=localhost;dbname=konta', 'root', 'lampa123', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
      $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      if($_SESSION['hero']['number'] == 1)
      {
            $stmt = $pdo -> query("SELECT * FROM arana_duel WHERE id_challenger = ".$_SESSION['hero']['id']);
            $enemy = 'challenged';
      }
      else if($_SESSION['hero']['number'] == 2)
      {
            $stmt = $pdo -> query("SELECT * FROM arena_duel WHERE id = 1");
            $enemy = 'challenger';
      }
      $opponent = $stmt -> fetch();
      $stmt -> closeCursor();
      if($_GET['type'] == 'accurate')$atack_factor = 1;
      if($_GET['type'] == 'quick')$atack_factor = 1/2;
      $atack = ($_SESSION['duel']->hero['atack_ranged'] - $opponent[$enemy.'_defense_ranged'])*$atack_factor;
      if($atack >= 0)$szansa = 100 - 200/($atack + 4);
  	else $szansa = 400/(8 - $atack);
      if(rand(1,100) > $szansa)if(rand(0,2) == 0) $_SESSION['duel']->impair($_SESSION['hero']['hand_right'], 'weapon_ranged');
      else
      {
                  if(rand(0,2) != 0) $_SESSION['duel']->impair($_SESSION['hero']['hand_right'], 'weapon');
                  $opponent[$enemy.'_life'] -= round($opponent[$enemy.'_damage_ranged']/(1 + $_SESSION['duel']->hero['protection_ranged']/$opponent[$enemy.'_damage_ranged']));
  	}
      if($opponent[$enemy.'_life'] <= 0) 
      {
            $pdo -> exec("UPDATE INTO arena_duel (turn) VALUES (-1)");
            header('Location: victory.php'); //zginal
      }
      else
      {
            $ruch = ceil($opponent[$enemy.'_mobility']/2 + 1);
            if($_GET['type'] == 'quick') $ruch = ceil($ruch/2);
            $_SESSION['duel']->hero['mobility'] -= $ruch;  
            if($_SESSION['duel']->hero['mobility'] <= 0) $opponent['turn'] = 3 - $_SESSION['hero']['number'];
            $pdo -> exec("UPDATE INTO arena_duel (".$enemy."_life, turn) VALUES (".$opponent[$enemy.'_life']." , ".$opponent['turn'].")");
            header('Location: duel.php');
      }
}
?>