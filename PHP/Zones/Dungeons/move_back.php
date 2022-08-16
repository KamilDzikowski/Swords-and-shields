<?php
require_once('../../../Classes/hero.php');
require_once('../../../Classes/encounter.php');
session_start();
if($_SESSION['encounter']->battlefield['turn'] == 1 && $_SESSION['encounter']->hero['mobility'] >= 2)
{
      $_SESSION['encounter']->hero['position'] -= $_SESSION['encounter']->hero['direction'];
      $_SESSION['encounter']->hero['mobility'] = $_SESSION['encounter']->hero['mobility'] - 2;
      if($_SESSION['encounter']->hero['mobility'] == 0) $_SESSION['encounter']->battlefield['turn'] = 0;
}
header('Location: battle.php');
?>
