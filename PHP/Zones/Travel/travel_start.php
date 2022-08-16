<?php
require_once('../../../Classes/hero.php');
session_start();
try
{
      $pdo = new PDO('mysql:host=localhost;dbname=konta', 'root', 'lampa123', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
      $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $stmt = $pdo -> query("SELECT target".$_GET['nr'].", time".$_GET['nr']." FROM zone_travel WHERE id =".$_SESSION['hero']['zone']);
      $travel = $stmt -> fetch();
      $stmt -> closeCursor();
      $_SESSION['hero']['action'] = 2;
      $_SESSION['hero']['time'] = $travel['time'.$_GET['nr']]+time();
      $_SESSION['hero']['action_var'] = $travel['target'.$_GET['nr']];
      header("Location: travelling.php");
}
catch(PDOException $e)
{
      echo 'Błąd PDO!';
      header('Location: ../../../error.php');
}
?>
