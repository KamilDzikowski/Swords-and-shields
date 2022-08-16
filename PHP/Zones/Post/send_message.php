<?php
require_once('../../../Classes/hero.php');
session_start();
if(false);
else
{
      $pdo = new PDO('mysql:host=localhost;dbname=konta', 'root', 'lampa123', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
      $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	try
      {
            //echo "SELECT id FROM player_hero WHERE login=".$_POST['addressee'];
            //die();
            $stmt = $pdo -> query("SELECT id FROM player_hero WHERE login='".$_POST['addressee']."'");
            $addressee = $stmt ->fetch();
            $stmt -> closeCursor();
      }
      catch(PDOException $e)
      {
            $_SESSION['tech']['text'].= 'Nie ma takiej postaci!';
            header('Location: ../../../error.php');
            die();
      }
      $pdo -> exec("INSERT INTO player_post (sender, addressee, title, message) VALUES(".$_SESSION['hero']['id'].", ".$addressee['id'].", '".$_POST['title']."', '".$_POST['message']."')");
      
}
header('Location: post.php');	
?>
