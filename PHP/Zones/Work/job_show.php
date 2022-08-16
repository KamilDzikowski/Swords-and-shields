<!DOCTYPE html
	PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.batman.com">
<LINK rel="stylesheet" href="../../../Style/style_zone.css" type="text/css"></LINK>
<html xmlns="www.google.pl" xml:lang="pl" lang="pl">
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<meta name="Description" content="Tu wpisz opis zawartości strony" />
	<meta name="Keywords" content="Tu wpisz wyrazy kluczowe rozdzielone przecinkami" />
	<title>Start</title>
</head>

<div id="page">
      <table border='2'>
      <tr>
	     <td><b>Praca</b></td> <td><b>Poziom</b></td> <td><b>Zarobek</b></td> <td><b>Czas pracy</b></td> <td><b>Narzedzie</b></td> <td><b>Składnik 1</b></td> <td><b>Składnik 2</b></td> <td><b>Składnik 3</b></td>  <td><b>Produkt 1</b></td>  <td><b>Produkt 2</b></td>
      </tr>
            <?php
                  require_once('../../../Classes/hero.php');
		      session_start();
		      $_SESSION['tech']['path'] = 'PHP/Zones/Work/';
		      $_SESSION['tech']['file'] = 'job_show.php';
		      $_SESSION['tech']['file'] .= '?work_id='.$_GET['work_id'];
		      $pdo = new PDO('mysql:host=localhost;dbname=konta', 'root', 'lampa123', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
		      $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		      $counter = 1;
		      $stmt = $pdo -> query("SELECT * FROM work_job WHERE id_work=".$_GET['work_id']." ORDER BY threshold");
		      foreach($stmt as $job)
		      {
			      $stmt = $pdo -> query("SELECT name FROM zone_work WHERE id=".$job['id_work']);
                        $work = $stmt -> fetch();
                        $stmt -> closeCursor();
                        if($_SESSION['hero'][$work['name']] >= $job['threshold']) echo '<td><a href="'.($job['product_id1'] != 0? 'job_start' : 'choice').'.php?job_id='.$job['id'].'">'.$job['name'].'</a></td>';
                        else echo '<td>'.$job['name'].'</td>';
                        echo '<td>'.$job['threshold'].'</td>';
                        echo '<td>'.$job['salary'].'</td>';
                        echo '<td>'.$job['time'].'</td>';
                        if($job['id_tool'] != 0)
                        {
                              $stmt = $pdo -> query("SELECT name FROM item_tool WHERE id=".$job['id_tool']);
                              $tool = $stmt -> fetch();
			            $stmt -> closeCursor();
			            echo '<td>'.$tool['name'].'</td>';
                        }
                        else echo '<td>Brak</td>';
                        $i = 1;
                        for(; isset($job['component_id'.$i]); $i++)
                        {
                              $stmt = $pdo -> query("SELECT name FROM item_".$job['component_table'.$i]." WHERE id=".$job['component_id'.$i]);
                              $item = $stmt -> fetch();
			            $stmt -> closeCursor();
                              echo '<td>'.$item['name'].' x'.$job['component_amount'.$i].'</td>';
                        }
                        for(; $i != 4; $i++)
                        {
                              echo '<td>Brak</td>';
                        }
                        for($i=1; isset($job['product_id'.$i]); $i++)
                        {
                              $stmt = $pdo -> query("SELECT name FROM item_".$job['product_table'.$i]." WHERE id=".$job['product_id'.$i]);
                              $item = $stmt -> fetch();
			            $stmt -> closeCursor();
                              echo '<td>'.$item['name'].' x'.$job['product_amount'.$i].'</td>';
                        }
                        for(; $i != 3; $i++)
                        {
                              echo '<td>Brak</td>';
                        }
                        echo '</tr>';
                        ++$counter;
		      }
		      $stmt -> closeCursor();
		      echo '<br>';
	      ?>
      </table>
      <a href="work_show.php">Wstecz</a><br>
	<a href="../../../zone.php">Miasto</a>
</div>
