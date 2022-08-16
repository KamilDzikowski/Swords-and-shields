<?php
session_start();
if(!is_numeric($_GET['nr']) || !isset($_SESSION['tech']['link'.$_GET['nr']])) header('Location: zone.php');
header('Location: '.$_SESSION['tech']['path'].$_SESSION['tech']['link'.$_GET['nr']]);
for($i=1; isset($_SESSION['tech']['link'.$i]); $i++)
{
	unset($_SESSION['tech']['link'.$i]);
}
?>