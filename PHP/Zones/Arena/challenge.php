<?php
require_once('../../../Classes/hero.php');
require_once('../../../Classes/duel.php');
session_start();
if(!isset($_GET['id']) || !is_numeric($_GET['id'])) header('Location: arena.php');
else
{
      $pdo = new PDO('mysql:host=localhost;dbname=konta', 'root', 'lampa123', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
      $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $stmt = $pdo -> query("SELECT * FROM arena_notification WHERE id = ".$_GET['id']);
      $notification = $stmt -> fetch();
      $stmt -> closeCursor();
      if($notification['restriction'] > $_SESSION['hero']['level'] || $notification['bid'] > $_SESSION['hero']['cash'] || $notification['zone'] != $_SESSION['hero']['zone']) header('Location: arena.php');
      else
      {
            $pdo -> exec("INSERT INTO arena_duel (size, id_challenger, id_challenged, position_challenger, position_challenged, direction_challenger, direction_challenged, bid) VALUES (20, ".$_SESSION['hero']['id'].", ".$_GET['id'].", 5, 15, 1, -1, ".$notification['bid'].")");
            $_SESSION['duel'] = new CDuel();
            $_SESSION['hero']['mobility'] = $_SESSION['hero']['speed'] + 5;
            $pdo -> exec("UPDATE INTO arena_duel (protection_cut_chellenger, protection_smash_chellenger, protection_ranged_chellenger, defense_melee_chellenger, defense_ranged_chellenger, life_challenger, mobility_challenger) VALUES (".$_SESSION['duel']->hero['protection_cut'].", ".$_SESSION['duel']->hero['protection_smash'].", ".$_SESSION['duel']->hero['protection_ranged'].", ".$_SESSION['duel']->hero['defense_melee'].", ".$_SESSION['duel']->hero['defense_ranged'].", ".$_SESSION['hero']['life'].", ".$_SESSION['hero']['speed'].")");
            $pdo -> exec("DELETE FROM arena_notification WHERE hero_id = ".$_GET['id']);
            $stmt = $pdo -> query("SELECT id FROM arena_duel WHERE id = ".$_SESSION['hero']['id']);
            $walka = $stmt -> fetch();
            $stmt -> closeCursor();
            $_SESSION['hero']['action_var'] = $walka['id'];
            $_SESSION['hero']['number'] = 1;
      }
}
header('Location: duel.php');
?>
