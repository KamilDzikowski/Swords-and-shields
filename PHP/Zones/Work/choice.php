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
	     <td><b>Nazwa</b></td>
      </tr>
            <?php
                  require_once('../../../Classes/hero.php');
		      session_start();
		      $_SESSION['tech']['path'] = 'PHP/Zones/Work/';
		      $_SESSION['tech']['file'] = 'choice.php';
		      $_SESSION['tech']['file'] .= '?job_id='.$_GET['job_id'];
		      $pdo = new PDO('mysql:host=localhost;dbname=konta', 'root', 'lampa123', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
		      $pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		      $counter = 1;
		      $stmt = $pdo -> query("SELECT product_table1 FROM work_job WHERE id=".$_GET['job_id']);
		      $job = $stmt -> fetch();
		      $stmt -> closeCursor();
		      $stmt = $pdo -> query("SELECT * FROM item_".$job['product_table1']." WHERE job_id=".$_GET['job_id']);
                  foreach($stmt as $item)
		      {
                        echo '<tr>';
                        echo '<td>'.$item['name'].'</td>';
                        echo '<td><a href="job_start.php?item_id='.$item['id'].'&job_id='.$_GET['job_id'].'">Wybierz</a></td>';
                        echo '</tr>';
                        ++$counter;
		      }
		      $stmt -> closeCursor();
		      echo '<br>';
		      echo '</table>';
		      //echo '<a href="job_show.php?work_id='.$work['id'].'">Wstecz</a><br>';
	      ?>
	<a href="../../../zone.php">Miasto</a>
</div>
