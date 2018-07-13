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
		<link rel="stylesheet" href="css/styles.css">
		<title>Perfil del usuario</title>
	</head>
	<body>
		<div class="container">
			<div class="row">
				<div class="col-sm-8">
					<div class="form-group">
						<!-- Cabecera con Barra de navegacion -->

						<?php include 'header.php'; ?>

					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-sm-8">
					<h1>Hola <?=$usuario['nombre']?>, Bienvenido!</h1>
					<img class="img-rounded" src="<?=$usuario['foto']?>" width="200">
					<br><br>
					<a class="btn btn-warning" href="logout.php">CERRAR SESIÓN</a>

					<a class="btn btn-primary" href="editar.php">Editar Datos</a>
					<br>
					<br>
				</div>
			</div>

			<?php include 'footer.php'; ?>

		</div>
	</body>
</html>
