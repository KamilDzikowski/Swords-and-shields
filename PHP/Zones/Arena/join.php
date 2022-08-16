<?php
require_once('../../../Classes/hero.php');
session_start();
$pdo = new PDO('mysql:host=localhost;dbname=konta', 'root', 'lampa123', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
$pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $stmt = $pdo -> query("SELECT * FROM arena_notification WHERE id = ".$_GET['id']);
      $notification = $stmt -> fetch();
      $stmt -> closeCursor();
      $_SESSION['duel'] = new CDuel();
      $pdo -> exec("UPDATE arena_duel SET protection_cut_chellenged = $protection_cut, protection_smash_chellenged = $protection_smash, protection_ranged_chellenged = $protection_ranged, defense_melee_chellenged = $defense_melee, defense_ranged_chellenged = $defense_ranged, life_challenged = ".$_SESSION['hero']['life'].", mobility_challenged = $_SESSION['hero']['mobility'] WHERE id_challenged = ".$_SESSION['hero']['id']);
            $stmt = $pdo -> query("SELECT id, mobility_challenger FROM arena_duel WHERE id = ".$_SESSION['hero']['id']);
            $fight = $stmt -> fetch();
            $stmt -> closeCursor();
            $_SESSION['hero']['mobility'] = $_SESSION['hero']['speed'] + 5;
            if($_SESSION['hero']['mobility'] > $fight['mobility']['challenger']) $turn = 1;
            else if($_SESSION['hero']['mobility'] > $fight['mobility']['challenger']) $turn = 2;
            else $turn = rand(1,2);
            $pdo -> exec("UPDATE arena_duel SET turn = $turn WHERE id_challenged = ".$_SESSION['hero']['id']);
            $_SESSION['hero']['action_var'] = $fight['id'];
            $_SESSION['hero']['number'] = 1;
      }
$stmt = $pdo -> query("SELECT id FROM arena_duel WHERE id_challenged = ".$_SESSION['hero']['id']);
$walka = $stmt -> fetch();
$stmt -> closeCursor();
$_SESSION['hero']['action_var'] = $walka['id'];
$_SESSION['hero']['number'] = 2;
header('Location: duel.php');
?>