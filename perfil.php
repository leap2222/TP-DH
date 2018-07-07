<?php
	require_once('funciones.php');

	if (!estaLogueado()) {
		header('location: login.php');
		exit;
	}

	$usuario = traerPorId($_SESSION['id']);
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<title>Perfil del usuario</title>
	</head>
	<body>
		<div class="container">
			<h1>Hola <?=$usuario['name']?></h1>
			<img class="img-rounded" src="<?=$usuario['foto']?>" width="200">
			<br><br>
			<a class="btn btn-warning" href="logout.php">CERRAR SESIÓN</a>
		</div>
	</body>
</html>
