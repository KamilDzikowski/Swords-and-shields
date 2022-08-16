<?php
session_start();
unset($_SESSION['duel']);
$pdo = new PDO('mysql:host=localhost;dbname=konta', 'root', 'lampa123', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
$pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
if($_SESSION['hero']['number'] == 1)
{
            $stmt = $pdo -> query("SELECT id_challenged, bid FROM arena_duel WHERE id_challenger = ".$_SESSION['hero']['id']);
            $arena = $stmt -> fetch();
            $stmt -> closeCursor();
            $enemy = $arena['id_challenged'];
}
else if($_SESSION['hero']['number'] == 2)
{
            $stmt = $pdo -> query("SELECT id_challenger, bid FROM arena_duel WHERE id_challenged = ".$_SESSION['hero']['id']);
            $arena = $stmt -> fetch();
            $stmt -> closeCursor();
            $enemy = $arena['id_challenger'];
}
$stmt = $pdo -> query("SELECT cash FROM player_hero WHERE id = ".$enemy);
$hero = $stmt -> fetch();
$stmt -> closeCursor();
$cash = $hero['cash'] - $arena['bid'];
$stmt = $pdo -> exec("UDPDATE INTO player_hero (cash) VALUES (".$cash.") WHERE id = ".$enemy);
$_SESSION['hero']['cash'] += $arena['bid'];
if($_SESSION['hero']['number'] == 1) $pdo -> exec("DELETE FROM arena_duel WHERE challenger_id = ".$_SESSION['hero']['id']);            
if($_SESSION['hero']['number'] == 2) $pdo -> exec("DELETE FROM arena_duel WHERE challenged_id = ".$_SESSION['hero']['id']);            
header('Location: arena.php');
?>