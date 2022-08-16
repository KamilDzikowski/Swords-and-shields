<?php
require_once('../../../Classes/hero.php');
session_start();
$pdo = new PDO('mysql:host=localhost;dbname=konta', 'root', 'lampa123', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
$pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
if($_GET['type'] != 'strength' && $_GET['type'] != 'dexterity' && $_GET['type'] != 'speed' && $_GET['type'] == 'figure') header('Location: barracks.php');
else if($_SESSION['hero']['cash'] < $_SESSION['hero'][$_GET['type']] * 10)
{
      $_SESSION['tech']['text'] = 'Za mało kasy.<br> Potrzeba '.($_SESSION['hero'][$_GET['type']] * 10).', a masz '.$_SESSION['hero']['cash'].'.';
      header('Location: ../../../communication.php');
}
else
{
      $_SESSION['hero']['cash'] -= $_SESSION['hero'][$_GET['type']] * 10;
      $_SESSION['hero']['action'] = 6;
      $_SESSION['hero']['time'] = 10;
      $_SESSION['hero']['action_var'] = $_GET['type'];
}
?>
