<?php
class CEncounter
{
      public $enemy = array();
      public $hero = array();
      public $battlefield = array();
      public $defense_melee = array();
      public $durability = array();      
 	public function __construct()
 	{
            $pdo = new PDO('mysql:host=localhost;dbname=konta', 'root', 'lampa123', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $pdo -> query("SELECT * FROM enemy_dungeons WHERE id = 1");
            $this->enemy = $stmt -> fetch();
            $stmt -> closeCursor();
            //inicjalizacja potwora
            $this->enemy['direction'] = -1;
            $this->enemy['position'] = 15;
            $this->enemy['mobility'] = $this->enemy['mobility_max'] = 5 + $this->enemy['speed'];
            $this->enemy['life'] = $this->enemy['life_max'];
            
            $this->initialize_player();
            //inicjalizacja mapy
            if($this->hero['mobility'] > $this->enemy['mobility']) $this->battlefield['turn'] = 1;
            else if($this->hero['mobility'] < $this->enemy['mobility']) $this->battlefield['turn'] = 0;
            else $this->battlefield['turn'] = rand(0,1); // ustala kto pierwszy - decyduje szybkosc, a jak rowne to rand.
  	      $this->battlefield['size'] = 20;
      }
      public function __destruct()
      {
            $pdo = new PDO('mysql:host=localhost;dbname=konta', 'root', 'lampa123', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            if($_SESSION['hero']['armor']) $pdo -> exec("UPDATE ownership SET durability =".$this->durability['armor']." WHERE id = ".$_SESSION['hero']['armor']);     
            if($_SESSION['hero']['hand_left']) $pdo -> exec("UPDATE ownership SET durability =".$this->durability['shield']." WHERE id = ".$_SESSION['hero']['hand_left']);     
            if($_SESSION['hero']['hand_right']) $pdo -> exec("UPDATE ownership SET durability =".$this->durability['weapon']." WHERE id = ".$_SESSION['hero']['hand_right']);     
      }
      public function initialize_player()
      {
            $this->hero['direction'] = 1;
            $this->hero['position'] = 5;
            $this->hero['mobility'] = $this->hero['mobility_max'] = 5 + $_SESSION['hero']['speed'];
            $this->hero['defense_melee'] = 0;
      }
  	public function drop_weapon($type)
      {
            $pdo = new PDO('mysql:host=localhost;dbname=konta', 'root', 'lampa123', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            if($type == 'armor')
            {
                  if($_SESSION['hero']['armor']) $pdo -> exec("UPDATE ownership SET durability =".$this->durability['armor']." WHERE id = ".$_SESSION['hero']['armor']);     
                  $this->hero['protection_ranged'] = $this->hero['protection_cut']  = $this->hero['protection_smash'] = 0;                 
			$_SESSION['hero']['armor'] == 0;
			$this->hero['protection_ranged'] = $_SESSION['hero']['constitution']*0.2;
                  $this->hero['protection_cut'] = $_SESSION['hero']['constitution']*0.2;
                  $this->hero['protection_smash'] = $_SESSION['hero']['constitution']*0.2;
                  $this->hero['defense_melee'] += $_SESSION['hero']['dexterity']*0.07 - $this->defense_melee['armor'];
                  $this -> defense_melee['armor'] = 0;            
      	}
            else if($type == 'shield')
            {
                  if($_SESSION['hero']['hand_left']) $pdo -> exec("UPDATE ownership SET durability =".$this->durability['shield']." WHERE id = ".$_SESSION['hero']['hand_left']);     
                  $this->hero['defense_ranged'] = 0;
                  $_SESSION['hero']['hand_left'] = 0;
			$this->hero['defense_ranged'] = $_SESSION['hero']['dexterity']*0.2;
                  $this->hero['defense_melee'] += $_SESSION['hero']['dexterity']*0.07 - $this->defense_melee['shield'];
                  $this -> defense_melee['shield'] = 0;
            }
            else if($type == 'weapon_ranged' || $type == 'ammo') $this->hero['atack_ranged'] = $this->hero['damage_ranged'] = 0;        
            if($type == 'weapon_ranged')
            {
                  if($_SESSION['hero']['hand_right'])$pdo -> exec("UPDATE ownership SET durability =".$this->durability['weapon']." WHERE id = ".$_SESSION['hero']['hand_right']);     
                  $_SESSION['hero']['right_hand'] == 0;
            }
            else if($type == 'ammo')$_SESSION['hero']['ammo'] == 0;
            else if($type == 'weapon_melee')
            {
                  if($_SESSION['hero']['hand_right']) $pdo -> exec("UPDATE ownership SET durability =".$this->durability['weapon']." WHERE id = ".$_SESSION['hero']['hand_right']);     
                  $this->hero['atack_melee'] = $this->hero['damage_cut'] =  $this->hero['damage_smash'] = 0;
                  $_SESSION['hero']['right_hand'] == 0;
                  $this->hero['damage_cut'] = $_SESSION['hero']['strength']*0.2;
                  $this->hero['damage_smash'] = $_SESSION['hero']['strength']*0.2;
                  $this->hero['atack_melee'] = $_SESSION['hero']['dexterity']*0.2;
                  $this->hero['defense_melee'] += $_SESSION['hero']['dexterity']*0.07 - $this->defense_melee['weapon'];
			$this -> defense_melee['weapon'] = 0;
            }
      }
      public function take_weapon($id)
      {
            $pdo = new PDO('mysql:host=localhost;dbname=konta', 'root', 'lampa123', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $pdo -> query("SELECT item_type, item_id, level, durability FROM ownership WHERE id = ".$id);
            $ownership = $stmt -> fetch();
            $stmt -> closeCursor();
            $level = $ownership['level'];
            $type = $ownership['item_type'];
            $stmt = $pdo -> query("SELECT * FROM item_".$type." WHERE id = ".$ownership['item_id']);
            $item = $stmt -> fetch();
            $stmt -> closeCursor();            
            $level_factor = 1;
            for($i = 0; $i<$level; $i++) $level_factor *= 1.2;
            if($type == 'armor')
            {
            	$this->durability['armor'] = $ownership['durability'];     
                  $_SESSION['hero']['armor'] = $id;
                  $bonus = ($_SESSION['hero']['constitution'] - $item['constitution_requirements'])*$item['constitution_factor'];
                  $this->defense_melee['armor'] = $item['defense_melee']*$level_factor;
                  $this->hero['protection_ranged'] = ($item['protection_ranged'] + $bonus)*$level_factor;
                  $this->hero['protection_cut'] = ($item['protection_cut'] + $bonus)*$level_factor;
                  $this->hero['protection_smash'] = ($item['protection_smash'] + $bonus)*$level_factor;
                  $this->hero['defense_melee'] += $this -> defense_melee['armor'] - $_SESSION['hero']['dexterity']*0.07;
            }
            else if($type == 'shield')
            {
          		$this->durability['shield'] = $item['durability'];
                  $_SESSION['hero']['hand_left'] = $id;
                  $this->defense_melee['shield'] = $item['defense_melee'];
                  $bonus = ($_SESSION['hero']['dexterity'] - $item['dexterity_requirements'])*$item['dexterity_factor'];
                  $this->hero['defense_ranged'] =  ($item['defense_ranged'] + $bonus)*$level_factor;
                  $this->hero['defense_melee'] += $this->defense_melee['shield']*$level_factor - $_SESSION['hero']['dexterity']*0.07;
            }
            else if($type == 'weapon_ranged')
            {
            		$_SESSION['hero']['right_hand'] = $id;
            		 if($item['ammo_type'] == 0)
            		 {
            		 		$this->hero['atack_ranged'] = ($item['atack_ranged'] + ($_SESSION['hero']['dexterity'] - $item['dexterity_requirements'])*$item['dexterity_factor']) *$level_factor;
            		 		$this->hero['damage_ranged'] = ($item['damage_ranged'] + ($_SESSION['hero']['strength'] - $item['strength_requirements'])*$item['strength_factor']) *$level_factor;
            		 
            		 }
            		 else
            		 {
            		 		$this->durability['weapon'] = $item['durability'];                       
            		 		$this->hero['atack_ranged'] = ($item['atack_ranged'] + ($_SESSION['hero']['dexterity'] - $item['dexterity_requirements'])*$item['dexterity_factor']) *$level_factor;
            		 		$this->hero['damage_ranged'] = ($item['damage_ranged'] + ($item['damage_max'] - $item['damage_ranged'])*(1 - 1/($_SESSION['hero']['strength'] - $item['strength_requirements']))*$item['strength_factor']) *$level_factor;          		 
            		 }
           }
           else if($type == 'ammo')
           {
                      $_SESSION['hero']['ammo'] = $id;          		
           		    if($this->hero['atack_ranged'] > 0)
           		    {
           		    		$stmt = $pdo -> query("SELECT item_id FROM ownership WHERE id = ".$_SESSION['hero']['hand_right']);
            	    		$ownership = $stmt -> fetch();
            	    		$stmt -> closeCursor();
            	    		$stmt = $pdo -> query("SELECT ammo_type FROM item_weapon_ranged WHERE id = ".$ownership['item_id']);
            	    		$weapon_ranged = $stmt -> fetch();
            	    		$stmt -> closeCursor();
            	    		if($weapon_ranged['ammo_type'] == $item['type'])$this->hero['damage_ranged'] += $item['damage']*$level_factor;
            	     }
            }		
            else if($type == 'weapon_melee')
            {
            	$this->durability['weapon'] = $item['durability'];                       
            	$_SESSION['hero']['right_hand'] = $id;
            	$this->defense_melee['weapon'] = ($item['defense_melee'] + ($_SESSION['hero']['dexterity'] - $item['dexterity_requirements'])*$item['dexterity_factor']) *$level_factor;
            	$this->hero['atack_melee'] = ($item['atack_melee'] + ($_SESSION['hero']['dexterity'] - $item['dexterity_requirements'])*$item['dexterity_factor']) *$level_factor;   
                  $this->hero['damage_cut'] = ($item['damage_cut'] + ($_SESSION['hero']['strength'] - $item['strength_requirements'])*$item['strength_factor'])*$level_factor;
                  $this->hero['damage_smash'] = ($item['damage_smash'] + ($_SESSION['hero']['strength'] - $item['strength_requirements'])*$item['strength_factor']) *$level_factor;
                  $this->hero['defense_melee'] += $this->defense_melee['weapon'] - $_SESSION['hero']['dexterity']*0.07;                        
            }
      }
      public function enemy_move()
  	{
  		$position = $this->enemy['position'];
  		$direction = $this->enemy['direction'];
  		if($direction == 1) if($this->battlefield['player_position'] > $position) $target = $this->hero['position'] - 1;
            else $target = $this->battlefield['size'];
		else if($this->hero['position'] < $position) $target = $this->hero['position'] + 1;
		else $target = 0;
            $distance = abs($position - $target);
		if($distance <= $this->enemy['mobility'])
            {
                  $this->enemy['position'] = $target;
                  $this->enemy['mobility'] -= $distance;
            }
		else
            {
                  $this->enemy['position'] += $direction * $this->enemy['mobility'];
                  $this->enemy['mobility'] = 0;
            }
            return $this->enemy['mobility'];
  	}
      public function impair($id, $type)
  	{
  		$pdo = new PDO('mysql:host=localhost;dbname=konta', 'root', 'lampa123', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->durability[$type] -= 1;
            if($this->durability[$type] == 0)
            {
                  $pdo -> exec("DELETE FROM ownership WHERE id = ".$id);
                  $this->drop_weapon($type);
            }
  	}
      public function enemy_atack_ranged()
  	{
            $atack = $this->enemy['atack_ranged'] - $this->hero['defense_ranged'];
            if($atack >= 0)$szansa = 100 - 200/($atack + 4);
  		else $szansa = 400/(8 - $atack);
            if(rand(1,100) > $szansa) 
            {
            		if($_SESSION['hero']['hand_left'])if(rand(0,1) >= 0) $this->impair($_SESSION['hero']['hand_left'], "shield");
            		return 0;            		
            }
            else 
            {
            		if($_SESSION['hero']['armor'])if(rand(0,1) >= 0) $this->impair($_SESSION['hero']['armor'], "armor");
            		return round($this->enemy['damage_ranged']/(1 + $this->hero['protection_ranged']/$this->enemy['damage_ranged']));
  		}
  	}
      public function enemy_atack_melee()
  	{
  		$atack = $this->enemy['atack_melee'] - $this->hero['defense_melee'];
            if($atack >= 0)$szansa = 100 - 200/($atack + 4);
  		else $szansa = 400/(8 - $atack);
            if(rand(1,100) > $szansa)
            {     
                  if($_SESSION['hero']['hand_left'])if(rand(0,1) == 0) $this->impair($_SESSION['hero']['hand_left'], 'shield');
                  return 0;
            }
            else
            {
                  if($_SESSION['hero']['armor'])if(rand(0,1) == 0) $this->impair($_SESSION['hero']['armor'], 'armor');
                  $damage_cut = $this->enemy['damage_cut']/(1 + $this->hero['protection_cut']/$this->enemy['damage_cut']);
                  $damage_smash = $this->enemy['damage_smash']/(1 + $this->hero['protection_smash']/$this->enemy['damage_smash']);
                  return round($damage_cut + $damage_smash);
            } 
  	}
}
?>
