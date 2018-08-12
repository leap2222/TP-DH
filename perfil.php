<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	require_once('funciones.php');
	if (!estaLogueado()) {
	 	header('location: login.php');
	 	exit;
	}

	$usuario = traerPorId($_SESSION['id']);
	$userIsAdmin = Usuarios::isAdmin($usuario->getEmail());
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
					<h1>Hola <?=$usuario->getName()?>, Bienvenido!</h1>
					<!-- <img class="img-rounded" src="<?php
									// echo $usuario->getPhoto()?>
					 " width="200"> -->
					<br><br>
					<div class="row">
						<div class="col-sm-8">
			        <a href="VerEventos.php" class="eventos">Ver Eventos</a>
						</div>
					</div>
					<br><br>
					<div class="row">
						<div class="col-sm-8">
							<a href="VerUsuarios.php" class="usuarios">Ver Usuarios</a>
						</div>
					</div>
					<br><br>
					<?php if($userIsAdmin): ?>
					<div class="row">
						<div class="col-sm-8">
							<a class="btn btn-primary" href="CrearEvento.php">CARGAR EVENTO</a>
						</div>
					</div>
					<br><br>
					<?php endif; ?>
					<a class="btn btn-warning" href="logout.php">CERRAR SESIÓN</a>
					<a class="btn btn-primary" href="EditarUsuario.php?email=<?=$usuario->getEmail()?>">Editar Datos</a>
					<br><br>
				</div>
			</div>

			<?php include 'footer.php'; ?>

		</div>
	</body>
</html>
