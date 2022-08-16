<!DOCtypeE html
	PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.batman.com">
<LINK rel="stylesheet" href="../../Style/style_statisctics.css" typee="text/css"></LINK>
<html xmlns="www.google.pl" xml:lang="pl" lang="pl">
<head>
	<meta http-equiv="content-typee" content="text/html; charset=UTF-8" />
	<meta name="Description" content="Tu wpisz opis zawartości strony" />
	<meta name="Keywords" content="Tu wpisz wyrazy kluczowe rozdzielone przecinkami" />
	<title>Start</title>
</head>
<div id="page">
      <div id="column-Left">
            <div id="column-Left-Top">
                  <?php
                        require_once('../../Classes/hero.php');
                        session_start();
                        $pdo = new PDO('mysql:host=localhost;dbname=konta', 'root', 'lampa123', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
				$pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
				echo "<font size=\"6\"><strong>".$_SESSION['hero']['login']."</strong></font><br>";
				echo "<strong> Poziom: ".$_SESSION['hero']['level']."<br>Doświadczenie: ".$_SESSION['hero']['experience']."/".(30*$_SESSION['hero']['level'])."<br>Kasa: ".$_SESSION['hero']['cash']."</strong><br>";
				echo 'Jestes w '.$_SESSION['hero']['zone'].'<br>';
				echo "Teraz robisz: ".$_SESSION['hero']['action']." do: ".$_SESSION['hero']['time'];
				echo "<br>".time();
                  ?>
            </div>
            <div id="column-Left-Left">
                  <?php
				echo "<strong>Atrybuty:</strong><br>";
                        echo "Życie: ".$_SESSION['hero']['life']."/".$_SESSION['hero']['life_max']."<br>";
                        echo "Siła: ".$_SESSION['hero']['strength']."<br>";
				echo "Zręczność: ".$_SESSION['hero']['dexterity']."<br>";
				echo "Szybkość: ".$_SESSION['hero']['speed']."<br>";
				echo "Budowa: ".$_SESSION['hero']['constitution']."<br>";
                  ?>
            </div>
            <div id="column-Left-Right">
                  <?php
                        echo "<strong>Zdolności pracy:</strong><br>";
                        echo "Rolnictwo: ".$_SESSION['hero']['farming']."<br>";
				echo "Zbieractwo: ".$_SESSION['hero']['gathering']."<br>";
				echo "Rzemiosło: ".$_SESSION['hero']['craftsmanship']."<br>";
				//echo "Jazda konna: ".$_SESSION['hero']['riding']."<br>";
				echo '<br><br>';
			?>
            </div>
            <div id="column-Left-Bottom">
                  <?php
				echo "<strong>Kwalifikacje:</strong><br>";
				echo "Drwal: ".$_SESSION['hero']['woodcutter']."<br>";
				echo "Stolarz: ".$_SESSION['hero']['carpenter']."<br>";
				echo "Górnik: ".$_SESSION['hero']['miner']."<br>";
				echo "Kowal: ".$_SESSION['hero']['smith']."<br>";
				echo "Hodowca: ".$_SESSION['hero']['animal_keeper']."<br>";
				echo "Krawiec: ".$_SESSION['hero']['tailor']."<br>";
				echo "Kaletnik: ".$_SESSION['hero']['vesicle']."<br>";
			?>
            </div>
      </div>
      <div id="column-Right">
            <div style='border-bottom : 1px solid black'>
                  <a href='statistics.php?type=armor' >Zbroje</a>
                  <a href='statistics.php?type=shield' >Tarcze</a>
                  <a href='statistics.php?type=weapon_melee_1' >Broń Jednoręczna</a>
                  <a href='statistics.php?type=weapon_melee_2' >Broń Dwuręczna</a>
                  <a href='statistics.php?type=weapon_ranged' >Broń Dystansowa</a><br>
                  <a href='statistics.php?type=ammo' >Amunicja</a>
                  <a href='statistics.php?type=tool' >Narzędzia</a>
                  <a href='statistics.php?type=resource' >Surowce</a>
                  <a href='statistics.php?type=equipment' >Ekwipunek</a>
            </div>
            <?php
   		      include_once('show_equipment.php');
   		      include_once('../Functions/show_ownership.php');
   		      $type = '';
      	      if(isset($_GET['type'])) $type = $_GET['type'];
   		      if($type == 'armor')
   		      {
   			      show_armor($pdo, $_SESSION['hero'], '../../', array('level'), array('Poziom'), array('constitution_requirements'), array('Budowa'), 0, 'replace.php', 'Załóż', $_SESSION['hero']['armor'], 'remove.php', 'Zdejmij');
                  }
   		      else if($type == 'shield')
   		      {
   		            show_shield($pdo, $_SESSION['hero'], '../../', array('level'), array('Poziom'), array('dexterity_requirements'), array('Zręczność'), 0, 'replace.php', 'Załóż', $_SESSION['hero']['hand_left'], 'remove.php', 'Zdejmij');
                  }
   		      else if($type == 'weapon_melee_1')
   		      {
   		            show_weapon_melee($pdo, $_SESSION['hero'], '../../', array('level'), array('Poziom'), array('strength_requirements', 'dexterity_requirements'), array('Siła', 'Zręczność'), 0, 'replace.php', 'Załóż', $_SESSION['hero']['hand_right'], 'remove.php', 'Zdejmij', 1);
                  }
		      else if($type == 'weapon_melee_2')
   		      {
   		      	show_weapon_melee($pdo, $_SESSION['hero'], '../../', array('level'), array('Poziom'), array('strength_requirements', 'dexterity_requirements'), array('Siła', 'Zręczność'), 0, 'replace.php', 'Załóż', $_SESSION['hero']['hand_right'], 'remove.php', 'Zdejmij', 2);
                  }
   		      else if($type == 'weapon_ranged')
   		      {
   		      	show_weapon_ranged($pdo, $_SESSION['hero'], '../../', array('level'), array('Poziom'), array('strength_requirements', 'dexterity_requirements'), array('Siła', 'Zręczność'), 0, 'replace.php', 'Załóż', $_SESSION['hero']['hand_right'], 'remove.php', 'Zdejmij');
                  }
                  else if($type == 'ammo')
   		      {
   		      	show_ammo($pdo, $_SESSION['hero'], '../../', array('level', 'amount'), array('Poziom', 'Ilość'), NULL, NULL, 0, 'replace.php', 'Załóż', $_SESSION['hero']['ammo'], 'remove.php', 'Zdejmij', true);
                  }
                  else if($type == 'tool')
   		      {
   		      	show_tool($pdo, $_SESSION['hero'], '../../', array('level'), array('Poziom'), NULL, NULL, 0, 'replace.php', 'Załóż', $_SESSION['hero']['tool'], 'remove.php', 'Zdejmij');
                  }
                  else if($type == 'resource')
   		      {
   		      	show_resource($pdo, $_SESSION['hero'], '../../', array('amount'), array('Ilość'), NULL, NULL, 0, true);
                  }
   		      else if($type == 'equipment')
   		      {
   		      	show_equipment($pdo, $_SESSION['hero']);
   		      }
   		      $_SESSION['tech']['file'] = 'statistics.php?type='.$type;
            ?>
      </div>
</div>
