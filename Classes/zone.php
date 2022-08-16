<?php
class CZone implements ArrayAccess
{
	static private $reference;
	static public function factory($zone_temp)
	{
		if(!isset(CZone::$reference))
		{
			CZone::$reference = new CZone($zone_temp);
			return CZone::$reference;
		}
		else return CZone::$reference;
	}
	/////////////////
	private $date = array();
 	public function __construct($zone_temp)
 	{
		$this->actualize($zone_temp);
	}
	public function actualize($zone_temp)
	{
		if(!is_numeric($zone_temp)) return false;
		$pdo = new PDO('mysql:host=localhost;dbname=konta', 'root', 'lampa123', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
		$pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt = $pdo -> query("SELECT * FROM zone WHERE id=".$zone_temp);
		$this->date = $stmt -> fetch();
		$stmt -> closeCursor();
	}
      public function offsetGet($key)
      {
   		if(isset($this->date[$key])) return $this->date[$key];
   	   else return false;
      }
      public function offsetSet($key, $value)
      {
   		if(isset($this->date[$key])) return $this->date[$key] = $value;
   	   else return false;
      }
      public function offsetExists($key)
      {
   		if(isset($this->date[$key])) return true;
   	   else return false;
      }
      public function offsetUnset($key)
      {
   		if(isset($this->date[$key]))
         {
         	unset($this->date[$key]);
            return true;
         }
   	   else return false;
      }
}


?>
