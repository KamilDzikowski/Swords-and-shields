<?php
require_once('../Classes/hero.php');
session_start();
if(!isset($_POST['message']));
else
{
      $pdo = new PDO('mysql:host=localhost;dbname=konta', 'root', 'lampa123', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
      $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      $stmt = $pdo -> query("SELECT MIN(id) FROM player_chat");
      $chat = $stmt -> fetch();
      $stmt -> closeCursor();
      $pdo -> exec("DELETE FROM player_chat WHERE id=".$chat['MIN(id)']);
      $pdo -> exec("INSERT INTO player_chat (sender, message) VALUES(".$_SESSION['hero']['id'].", '".$_POST['message']."')");
}
header('Location: chat.php');	
?>
