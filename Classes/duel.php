<?php
class CDuel
{
      public $hero = array();
      public function __construct()
 	{
            $defense_melee = 0;
            if($_SESSION['hero']['armor']) $this->take_weapon($_SESSION['hero']['armor']);
            else $this->drop_weapon('armor');
            if($_SESSION['hero']['hand_left']) $this->take_weapon($_SESSION['hero']['hand_left']);
            else $this->drop_weapon('shield');
            if($_SESSION['hero']['hand_right']) $this->take_weapon($_SESSION['hero']['hand_right']);
            else $this->drop_weapon('weapon_melee');
            if($_SESSION['hero']['ammo']) $this->take_weapon($_SESSION['hero']['ammo']);
            else $this->drop_weapon('ammo');      
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
            $stmt = $pdo -> query("SELECT item_type, item_id, level FROM ownership WHERE id = ".$id);
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
            	$this->durability['armor'] = $item['durability'];     
                  $_SESSION['hero']['armor'] = $id;
                  $bonus = ($_SESSION['hero']['constitution'] - $item['constitution_requirements'])*$item['constitution_factor'];
                  $this->defense_melee['armor'] = $item['defense_melee']*$level_factor;
                  $this->hero['protection_ranged'] = ($item['protection_ranged'] + $bonus)*$level_factor;
                  $this->hero['protection_cut'] = ($item['protection_cut'] + $bonus)*$level_factor;
                  $this->hero['protection_smash'] = ($item['protection_smash'] + $bonus)*$level_factor;
                  $this->hero['defense_melee'] += $this -> defense_melee['armor']*$level_factor - $_SESSION['hero']['dexterity']*0.07;
            }
            else if($type == 'shield')
            {
          		$this->durability['shield'] = $item['durability'];
                  $_SESSION['hero']['hand_left'] = $id;
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
}
?>
