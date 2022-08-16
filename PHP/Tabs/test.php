<?php
require_once('../../Classes/hero.php');
session_start();
if(is_numeric($_GET['null'])) echo 'tak';
else echo 'nie';
echo '<br><br><a href="../../'.$_SESSION['tech']['path'].$_SESSION['tech']['file'].'">Wroc</a>';
//header('Location: ../../main.php');
?>
