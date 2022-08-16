<?php
require_once('../../../Classes/hero.php');
session_start();
$_SESSION['tech']['path'] = 'PHP/Zones/Dungeons/';
$_SESSION['tech']['file'] = 'event.php';
$pdo = new PDO('mysql:host=localhost;dbname=konta', 'root', 'lampa123', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
$pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$random = rand(0,6);
$level = $_SESSION['hero']['action_var']%10;
if($random == 0)
{
   $_SESSION['tech']['text'] = 'Zaatakowal cię potwór';
   $_SESSION['tech']['link'] = 'PHP/Zones/Dungeons/encounter.php';
}
else if($random == 1)
{
   $cash = rand($level, $level * $level * 5 + 1);
   $_SESSION['tech']['text'] = 'Znalazles '.$cash.' monet!';
   $_SESSION['tech']['link'] = 'PHP/Zones/Dungeons/dungeons.php';
   $_SESSION['hero']['cash'] += $cash;
}
else if($random == 2)
{
   $type = rand(1,5);
   if($type == 1) $type = 'ammo';
   if($type == 2) $type = 'armor';
   if($type == 3) $type = 'shield';
   if($type == 4) $type = 'weapon_melee';
   if($type == 5) $type = 'weapon_ranged';
   $stmt = $pdo -> query("SELECT COUNT(id) as amount FROM item_".$type);
   $amount = $stmt -> fetch();
   $stmt -> closeCursor();
   $choice = rand(1, $amount['amount']);
   $stmt = $pdo -> query("SELECT id FROM item_".$type);
   for($i=0; $i<$choice; $i++)
   {
      $possibilities = $stmt-> fetch();
   }
   $stmt -> closeCursor();
   $stmt = $pdo -> query("SELECT name FROM item_".$type." WHERE id = ".$possibilities['id']);
   $name = $stmt -> fetch();
   $pdo -> exec("INSERT INTO ownership (hero_id, item_type, item_id) VALUES ('".$_SESSION['hero']['id']."', '".$type."', '".$possibilities['id']."')");
   $_SESSION['tech']['text'] = 'Znalazles '.$name['name'];
   $_SESSION['tech']['link'] = 'PHP/Zones/Dungeons/dungeons.php';
}
else if($random == 3)
{
   $cash = rand($level, $level * $level*5+1);
   $cash *= ($level+1);
   $_SESSION['tech']['text'] = 'Zgubiles mieszek z '.$cash.' monetami.';
   $_SESSION['tech']['link'] = 'PHP/Zones/Dungeons/dungeons.php';
   if($cash > $_SESSION['hero']['kasa']) $_SESSION['hero']['kasa'] = 0;
   else $_SESSION['hero']['kasa'] -= $cash;
}
else if($random == 4)
{
   $_SESSION['tech']['text'] = 'Upadles i straciles przytomnosć';
   $_SESSION['tech']['link'] = 'PHP/Zones/Dungeons/unconsciousness.php';
   $_SESSION['hero']['time'] = time()+10;
   $postac['action'] = 4;
}
else if($random == 5)
{
   $damage = rand($level, $level * $level * 2);
   $_SESSION['tech']['text'] = 'Upadles i zraniles się. Otrzymujesz '.$damage.' rany!';
   $_SESSION['tech']['link'] = 'PHP/Zones/Dungeons/dungeons.php';
   if($_SESSION['hero']['life'] > $damage) $_SESSION['hero']['life'] -= $damage;
   else 
   {
      $_SESSION['hero']['time'] = time()+100;
      $_SESSION['tech']['link'] = 'death.php';
      $postac['action'] = 5;
      }
}
else if($random == 6)
{
   $_SESSION['tech']['text'] = 'Przechodzisz dlugi ciemny korytarz';
   $_SESSION['tech']['link'] = 'PHP/Zones/Dungeons/dungeons.php';
}
$_SESSION['hero']['action_var'] = $_SESSION['hero']['action_var']%10;
header('location: ../../../communication.php');
?>
