<?php
session_start();
if(isset($_SESSION['encounter']));
else if(isset($_SESSION['tech']['file_old']))
{
	$_SESSION['tech']['path'] = $_SESSION['tech']['path_old'];
	$_SESSION['tech']['file'] = $_SESSION['tech']['file_old'];
	unset($_SESSION['tech']['path_old']);		
	unset($_SESSION['tech']['file_old']);
}
else
{
    $_SESSION['tech']['path_old'] = $_SESSION['tech']['path'];
	$_SESSION['tech']['file_old'] = $_SESSION['tech']['file'];
	$_SESSION['tech']['path'] = 'PHP/Tabs/';
	$_SESSION['tech']['file'] = 'statistics.php';
}
header('Location: ../../main.php');
?>
