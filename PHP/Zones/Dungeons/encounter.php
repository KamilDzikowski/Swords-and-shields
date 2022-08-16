<?php
      require_once('../../../Classes/hero.php');
      require_once('../../../Classes/encounter.php');
      session_start();
      $_SESSION['hero']['life'] = $_SESSION['hero']['life_max'];
      $_SESSION['encounter'] = new CEncounter(/*$_SESSION['hero']*/);
      $_SESSION['encounter'] -> initialize_player();
      if($_SESSION['hero']['armor']) $_SESSION['encounter']->take_weapon($_SESSION['hero']['armor']);
      else $_SESSION['encounter']->drop_weapon('armor');
      if($_SESSION['hero']['hand_left']) $_SESSION['encounter']->take_weapon($_SESSION['hero']['hand_left']);
      else $_SESSION['encounter']->drop_weapon('shield');
      if($_SESSION['hero']['hand_right']) $_SESSION['encounter']->take_weapon($_SESSION['hero']['hand_right']);
      else $_SESSION['encounter']->drop_weapon('weapon_melee');
      if($_SESSION['hero']['ammo']) $_SESSION['encounter']->take_weapon($_SESSION['hero']['ammo']);
      else $_SESSION['encounter']->drop_weapon('ammo');
      header('Location: battle.php');
?>
