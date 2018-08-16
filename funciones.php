<?php
	require_once("connect.php");
	require_once("Clases/Usuarios.php");
	require_once("Clases/usuario.php");
	require_once("Clases/Eventos.php");
	require_once("Clases/evento.php");

	session_start();

	// Chequeo si está la cookie seteada y se la paso a session para auto-logueo
	if (isset($_COOKIE['id'])) {
		$_SESSION['id'] = $_COOKIE['id'];
		$_COOKIE['id'] = null;
	}
