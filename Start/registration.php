<!DOCTYPE html
	PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
	"http://www.batman.com">
<LINK rel="stylesheet" href="../Style/style_start_pages.css" type="text/css"></LINK>
<html xmlns="www.google.pl" xml:lang="pl" lang="pl">
<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<meta name="Description" content="Tu wpisz opis zawartości strony" />
	<meta name="Keywords" content="Tu wpisz wyrazy kluczowe rozdzielone przecinkami" />
	<title>Rejestracja</title>
</head>
<div id="page">
	<form id="registration" name="registration"  method="post" action="registration.php">
		Login:<input type="text" id="login" name="login"><br>
		Hasło:<input type="text" id="password1" name="password1"><br>
		Hasło:<input type="text" id="password2" name="password2"><br>
		E-mail:<input type="text" id="mail" name="mail"><br>
		<input type="submit" id="submit" value="Zatwierdź">
	</form>
	<a href="index.php">Powrót</a>
	<div class="incorrectData" id="incorrectData">
		<?php
			require_once('../Classes/hero.php');
			session_start();
			$_SESSION['tech']['path'] = 'Start/';
			$_SESSION['tech']['file'] = 'registration.php';
			function registrate()
			{
				$login = $_POST['login'];
				try
   			      {
                              $pdo = new PDO('mysql:host=localhost;dbname=konta', 'root', 'lampa123', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));  			
      			      $stmt = $pdo -> query("SELECT login FROM player_user WHERE login = '$login'");
      			      $user = $stmt -> fetch();
					$stmt -> closeCursor();
					if($user != NULL)
					{
      				      echo 'Login zajęty!<br>';
   				      }
   				      else
   				      {
   					      $amount = $pdo -> exec("INSERT INTO player_user (login, password, mail) VALUES ('$login', '".$_POST['password1']."', '".$_POST['mail']."')");
        				      $amount += $pdo -> exec("INSERT INTO player_hero (login) VALUES ('$login')");
						if($amount <= 1)
 				            {
                                          echo 'Wystąpił błąd podczas dodawania rekordów!';
                  	                  break;
 			                  }
                                    $stmt = $pdo -> query("SELECT id FROM player_hero WHERE login = '$login'");
					      $hero = $stmt -> fetch();
					      $stmt-> closeCursor();
					      if(isset($_SESSION['hero']))
						{
							header('Location: index.php');
						}
						else
						{
						      $hero = CHero::factory($pdo, $login);
						      //sprawdzenie czy istnieje(bugi itd)
						      if(!isset($hero))
						      {
						   	      echo 'Wystąpił błąd podczas logowania, ale postać została utworzona.';
                  		                  break;
						      }
						      else
						      {
						   	      $pdo -> exec("UPDATE player_user SET logged_in = 1 WHERE login = '".$login."'");
					      	      $_SESSION['id'] = $hero['id'];
					      	      $_SESSION['hero'] = $hero;
								echo "UPDATE player_user SET logged_in = 1 WHERE login = '".$login."'";
								//header('Location: ../zone.php');
							}
						}
   				      }
				}
   			      catch(PDOException $e)
   			      {
      			      echo 'Połączenie nie mogło zostać utworzone: ' . $e->getMessage();
   			      }
			}
			if($_SERVER['REQUEST_METHOD'] == 'POST') registrate();
		?>
	</div>
</div>
<script type="text/javascript" >
	function check()
	{
		incorrectData = document.getElementById('incorrectData');
		for(var i=incorrectData.childNodes.length-1; i>-1; --i) incorrectData.removeChild(incorrectData.lastChild);
		var mistakes = new Array(6);
		var form = document.forms['registration'];
		if(form.login.value == '') mistakes[0] = "Uzupełnij pola!\n";
		else
		{
			formula = /^[a-zA-Z]\w+$/;
			if(!formula.test(form.login.value)) mistakes[1] = "Niedozwolone znaki!";
			if(form.login.value.length > 15) mistakes[2] = "Za długi login!";
			else if(form.login.value.length < 3) mistakes[2] = "Za krótki login!";
		}
		if(form.password1.value == '') mistakes[0] = "Uzupełnij pola!\n";
		else
		{
			if(form.password1.value.length > 15) mistakes[3] = "Za długie hasło!";
			else if(form.password1.value.length < 3) mistakes[3] = "Za krótkie hasło!";
		}
		if(form.password1.value != form.password2.value) mistakes[4] = "Różne hasła!\n";
		if(form.mail.value == '') mistakes[0] = "Uzupełnij pola!\n";
		else
		{
			formula = /^[\w\.]+@\w+\.[a-z]{2,4}$/;
			if(!formula.test(form.mail.value)) mistakes[5] = "Niemożliwy mail!";
		}
		var correct = true;
		for(var i=0; i<mistakes.length; i++)
		{
			if(mistakes[i] != undefined)
			{
				correct = false;
				break;
			}
		}
		if(correct)
		{
			//alert('good');
			return true;
		}
		//else alert('bad');
		for(var i=0; i<mistakes.length; i++)
		{
			if(mistakes[i] != undefined)
			{
				incorrectData.appendChild(document.createTextNode(mistakes[i]));
				incorrectData.appendChild(document.createElement('Br'));
			}
		}
		if(incorrectData.childNodes.length == 5) incorrectData.appendChild(document.createTextNode('Ale debil!'));
		return false;
	}
	document.getElementById("submit").onclick = check;
</script>
</html>
