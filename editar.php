<?php
	session_start();
	setcookie('editar', 'true', time() + 300); // 5 minutos

	header('location: registracion.php');
	exit;
?>
