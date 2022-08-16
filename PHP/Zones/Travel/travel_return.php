<?php
require_once('../../../Classes/hero.php');
session_start();
try
{
      header('Location: travelling.php');
      if($_SESSION['hero']['time'] > time())
      {
            $pdo = new PDO('mysql:host=localhost;dbname=konta', 'root', 'lampa123', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $pdo -> query("SELECT * FROM zone_travel WHERE id =".$_SESSION['hero']['zone']);
            $travel = $stmt -> fetch();
            $stmt -> closeCursor();
            $counter = 1;
            while($travel['target'.$counter] != $_SESSION['hero']['action_var']) ++$counter;
            $zone = $_SESSION['hero']['zone'];
	      $_SESSION['hero']['zone'] = $_SESSION['hero']['action_var'];
	      $_SESSION['hero']['time'] = $travel['time'.$counter] - $_SESSION['hero']['time'] + 2*time();
	      $_SESSION['hero']['action_var'] = $zone;
      }
}
catch(PDOException $e)
{
      echo 'Błąd PDO!';
      header('Location: ../../../error.php');
}
?>
