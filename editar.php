<?php
	session_start();
	setcookie('editar', 'true', time() + 3000);

	header('location: registracion.php');
	exit;
?>
