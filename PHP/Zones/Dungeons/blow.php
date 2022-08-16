<?php
require_once('../../../Classes/hero.php');
require_once('../../../Classes/encounter.php');
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
      $atack = ($_SESSION['encounter']->hero['atack_melee'] - $_SESSION['encounter']->enemy['defense_melee'])*$atack_factor;
      if($atack >= 0)$chance = 100 - 200/($atack + 4);
  	else $chance = 400/(8 - $atack);
      if(rand(1,100) > $chance) {if($_SESSION['hero']['hand_right'])if(rand(0,2) == 0) $_SESSION['encounter']->impair($_SESSION['hero']['hand_right'], "weapon");}
      else
      {
                  if($_SESSION['hero']['hand_right']) if(rand(0,2) > 0) $_SESSION['encounter']->impair($_SESSION['hero']['hand_right'], "weapon");
                  $damage_cut = $_SESSION['encounter']->hero['damage_cut']/(1 + $_SESSION['encounter']->enemy['protection_cut']/$_SESSION['encounter']->hero['damage_cut']);
                  $damage_smash = $_SESSION['encounter']->hero['damage_smash']/(1 + $_SESSION['encounter']->enemy['protection_smash']/$_SESSION['encounter']->hero['damage_smash']);
                  $_SESSION['encounter']->enemy['life'] -= round(($damage_cut + $damage_smash) * $damage_factor);
      }
      if($_SESSION['encounter']->enemy['life'] <= 0) header('Location: dungeons.php'); //zginal
      else 
      {
            $_SESSION['encounter']->hero['mobility'] -= $_SESSION['encounter']->enemy['mobility_max'];  
            if($_SESSION['encounter']->hero['mobility'] <= 0) $_SESSION['encounter']->battlefield['turn'] = 0;
            header('Location: battle.php');
      } 
}//jak nie bylo ruchu nadal tura playera
?>
