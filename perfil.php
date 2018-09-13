<?php
	require_once('funciones.php');

	if (!estaLogueado()) {
	 	header('location: login.php');
	 	exit;
	}
	header('location: UsuarioDetalle.php?id=' . $usuario->getId());
	exit;
?>
