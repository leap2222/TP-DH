<?php
	session_start();
	$_SESSION['editar'] = true;
	session_destroy();
	header('location: registracion.php');
	exit;
?>
