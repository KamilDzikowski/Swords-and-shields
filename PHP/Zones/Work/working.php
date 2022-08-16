<!DOCTYPE html
	PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.batman.com">
<LINK rel="stylesheet" href="../../../Style/style_zone.css" type="text/css"></LINK>
<html xmlns="www.google.pl" xml:lang="pl" lang="pl">
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<meta name="Description" content="Tu wpisz opis zawartości strony" />
	<meta name="Keywords" content="Tu wpisz wyrazy kluczowe rozdzielone przecinkami" />
	<meta http-equiv="Refresh" content="5" />
	<title>Start</title>
</head>
<div id="page">
      <?php
            require_once('../../../Classes/hero.php');
		session_start();
		$_SESSION['tech']['path'] = 'PHP/Zones/Work/';
		$_SESSION['tech']['file'] = 'working.php';
		$pdo = new PDO('mysql:host=localhost;dbname=konta', 'root', 'lampa123', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
		//$pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$stmt = $pdo -> query("SELECT * FROM work_job WHERE id =".$_SESSION['hero']['action_var']);
		$job = $stmt -> fetch();
		$stmt -> closeCursor();
		$stmt = $pdo -> query("SELECT * FROM zone_work WHERE id =".$job['id_work']);
		$work = $stmt -> fetch();
		$stmt -> closeCursor();
		if($_SESSION['hero']['time'] <= time())
		{
                  header("Location: work_show.php");
                  $_SESSION['hero']['cash'] += $job['salary'];
                  //if(rand(0, 99) < 100 / (1 + $_SESSION['hero'][$work['name']] / $work['factor'] / 7))
                  {
				$_SESSION['hero'][$work['name']] += 1;
				$_SESSION['hero'][$work['type']] += 1;
			}
			$_SESSION['hero']['experience'] += $job['time'];
			while($_SESSION['hero']['experience'] >= $_SESSION['hero']['level']*30)
			{
				$_SESSION['hero']['experience'] -= $_SESSION['hero']['level']*30;
				$_SESSION['hero']['level'] += 1;
				$_SESSION['tech']['file'] = 'work_show.php';
                        $_SESSION['tech']['text'] = 'Nabiłeś poziom!';
                        header("Location: ../../../communication.php");
			}
                  if($_SESSION['hero']['action_var2'] != 0)
                  {
                        $stmt = $pdo -> exec("INSERT INTO ownership (hero_id, item_id, item_type) VALUES (".$_SESSION['hero']['id'].", ".$_SESSION['hero']['action_var2'].", '".$job['product_table1']."')");
                        $_SESSION['hero']['action_var2'] = 0;
                  }
			$_SESSION['hero']['action'] = 0;
			$_SESSION['hero']['time'] = 0;
			$_SESSION['hero']['action_var'] = 0;
                  if($_SESSION['hero']['tool'] != 0)
                  {
                        $stmt = $pdo -> query("SELECT durability FROM ownership WHERE id = ".$_SESSION['hero']['tool']);
                        $tool = $stmt -> fetch();
                        $tool['durability'] -= 1;
                        if($tool['durability'] == 0)
                        {
                              $pdo -> exec("DELETE FROM ownership WHERE id = ".$_SESSION['hero']['tool']);
                              $_SESSION['hero']['tool'] = 0;
                              $_SESSION['tech']['text'] = 'Narzędzie uległo zniszczeniu!';
                              header("Location: ../../../communication.php");
                        }
                        else $pdo -> exec("UPDATE ownership SET durability = ".($tool['durability']-1)." WHERE id = ".$_SESSION['hero']['tool']);
                  }/* OBNIŻENIE WYTRZYMAŁOŚCI NARZĘDZIA*/
			for($i=1; isset($job['product_id'.$i]); $i++)
                  {
                        if($job['product_id'.$i] == 0) continue;
                        $stmt = $pdo -> query("SELECT stack FROM item_".$job['product_table'.$i]." WHERE id = ".$job['product_id'.$i]);
                        $item = $stmt -> fetch();
                        $stmt -> closeCursor();
                        $stmt = $pdo -> query("SELECT id, item_id, amount FROM ownership WHERE hero_id = ".$_SESSION['hero']['id']." AND item_type = '".$job['product_table'.$i]."' AND item_id = ".$job['product_id'.$i]." AND stored = 0 ORDER BY amount");
                        $ownership = $stmt -> fetch();
                        $stmt -> closeCursor();
                        $stmt = $pdo -> query("SELECT durability FROM item_".$job['product_table'.$i]." WHERE id = ".$job['product_id'.$i]);
                        if($stmt != false)
                        {
                              $item2 = $stmt -> fetch();
                              $stmt -> closeCursor();
                              $durability = $item2['durability'];
                        }
                        else $durability = 'NULL';
                        for($j = floor($job['product_amount'.$i]/$item['stack']), $job['product_amount'.$i] -= $j*$item['stack']; $j != 0; --$j) $pdo -> query("INSERT INTO ownership (hero_id, item_type, item_id, amount, durability) VALUES (".$_SESSION['hero']['id'].", '".$job['product_table'.$i]."', ".$job['product_id'.$i].", ".$item['stack'].", ".$durability.")");
                        if($ownership == NULL) $pdo -> query("INSERT INTO ownership (hero_id, item_type, item_id, amount, durability) VALUES (".$_SESSION['hero']['id'].", '".$job['product_table'.$i]."', ".$job['product_id'.$i].", ".$job['product_amount'.$i].", $durability)");
                        else
                        {
                              if($item['stack'] >= $ownership['amount'] + $job['product_amount'.$i]) $pdo -> exec("UPDATE ownership SET amount = ".($ownership['amount'] + $job['product_amount'.$i])." WHERE id = ".$ownership['id']);
                              else
                              {
                                    $pdo -> exec("UPDATE ownership SET amount = ".$item['stack']." WHERE id = ".$ownership['id']);
                                    $pdo -> exec("INSERT INTO ownership (hero_id, item_type, item_id, amount, durability) VALUES (".$_SESSION['hero']['id'].", '".$job['product_table'.$i]."', ".$job['product_id'.$i].", ".($job['product_amount'.$i] - $item['stack'] + $ownership['amount']).", $durability )");
                              }
                        }
                  }
		}
		echo 'Teraz pracujesz jako: '.$work['name_show'].', '.$job['name'].'.<br> Do końca pozostało: '.($_SESSION['hero']['time'] - time()).' sekund.<br>';
	?>
	<a href="work_stop.php">Przerwij</a>
</div>
