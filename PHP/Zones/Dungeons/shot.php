<?php
require_once('../../../Classes/hero.php');
require_once('../../../Classes/encounter.php');
session_start();
if(isset($_GET['type']))
{
      if($_GET['type'] == 'accurate')$atack_factor = 1;
      if($_GET['type'] == 'quick')$atack_factor = 1/2;
      $atack = ($_SESSION['encounter']->hero['atack_ranged'] - $_SESSION['encounter']->enemy['defense_ranged'])*$atack_factor;
      if($atack >= 0)$szansa = 100 - 200/($atack + 4);
  	else $szansa = 400/(8 - $atack);
      if(rand(1,100) > $szansa)if(rand(0,2) == 0) $_SESSION['encounter']->impair($_SESSION['hero']['hand_right'], 'weapon_ranged');
      else
      {
                  if(rand(0,2) != 0) $_SESSION['encounter']->impair($_SESSION['hero']['hand_right'], 'weapon');
                  $_SESSION['encounter']->enemy['life'] -= round($_SESSION['encounter']->enemy['damage_ranged']/(1 + $_SESSION['encounter']->hero['protection_ranged']/$_SESSION['encounter']->enemy['damage_ranged']));
  	}
      $ruch = ceil($_SESSION['encounter']->enemy['mobility_max']/2 + 1);
      if($_GET['type'] == 'quick') $ruch = ceil($ruch/2);
      $_SESSION['encounter']->hero['mobility'] -= $ruch;  
      if($_SESSION['encounter']->hero['mobility'] <= 0) $_SESSION['encounter']->battlefield['turn'] = 0;
      if($_SESSION['encounter']->enemy['life'] <= 0) header('Location: dungeons.php'); //zginal
      else header('Location: battle.php');
}
?>
