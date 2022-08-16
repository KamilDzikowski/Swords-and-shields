<?php
class CHero implements ArrayAccess
{
	static private $reference;
	static public function factory($pdo, $login)
	{
		if(!isset(CHero::$reference))
		{
			CHero::$reference = new CHero($pdo, $login);
			return CHero::$reference;
		}
		else return CHero::$reference;
	}
	//////////////////
	private $date = array();
  	private $date_temp = array();
 	private function __construct($pdo, $login)
 	{
 	  	$pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $stmt = $pdo -> query("SELECT * FROM player_hero WHERE login='".$login."'");
		$this->date = $stmt -> fetch();
		$stmt -> closeCursor();
		$pdo -> exec("UPDATE player_user SET logged_in = -10 WHERE login = '".$this->date['login']."'");
  	}
	public function __destruct()
	{
		$this->save();
	}
  	public function offsetGet($key)
  	{
            if(isset($this->date[$key]) || $this->date[$key] == NULL) return $this->date[$key];
    	      else if(isset($this->date_temp[$key])) return $this->date_temp[$key];
   	      else return false;
  	}
  	public function offsetSet($key, $value)
  	{
    	      if(isset($this->date[$key]) || $this->date[$key] == NULL) return $this->date[$key] = $value;
    	      else return $this->date_temp[$key] = $value;
  	}
  	public function offsetExists($key)
  	{
   	      if(isset($this->date[$key])) return true;
    	      else if(isset($this->date_temp[$key])) return true;
   	      else return false;
  	}
  	public function offsetUnset($key)
  	{
    	      if(isset($this->date[$key]))
    	      {
      	      unset($this->date[$key]);
      	      return true;
    	      }
    	      else if(isset($this->date_temp[$key]))
    	      {
      	      unset($this->date_temp[$key]);
      	      return true;
    	      }
    	      else return false;
  	}
	public function save()
	{
	 	$pdo = new PDO('mysql:host=localhost;dbname=konta', 'root', 'lampa123', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
		//$pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	 	$pdo -> exec("UPDATE player_user SET logged_in = 0 WHERE login = '".$this->date['login']."'");
	 	foreach($this->date as $index => $value) $pdo -> exec("UPDATE player_hero SET $index = $value WHERE id = ".$this->date['id']);
	}
}
?>
