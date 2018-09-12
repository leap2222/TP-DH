<?php
	require_once('funciones.php');

	setcookie('id', '', time()-300);
	session_destroy();
	header('location: login.php');
	exit;
?>
