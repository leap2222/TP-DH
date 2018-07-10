<?php
	session_start();
	setcookie('editar', 'true', time() + 300); // 5 minutos
	session_destroy();
	header('location: registracion.php');
	exit;
?>
