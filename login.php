<?php
	require_once('funciones.php');

	if (estaLogueado()) {
		header('location: perfil.php');
		exit;
	}

	$email = '';
	$errores = [];
	$usuario = null;

	if ($_POST) {
		$email = trim($_POST['email']);
		$clave = $_POST['pass'];
		$recordar = isset($_POST['recordar']) ? trim($_POST['recordar']) : "";

		$errores = validarLogin($_POST);

		if (empty($errores)) {
				$usuario = LoginDeUsuario($_POST);
				header('location: perfil.php');
				exit;
		} else {
			$errores['email'] = "Error de credenciales al intentar loguear!";
		}
	}

?>

<?php $TituloPagina = "Login"; include 'header.php'; ?>

<div class="row justify-content-md-center">
	<div class="col-sm-6">
		<form method="post" enctype="multipart/form-data">
			<input class="form-control" type="text" name="email" placeholder="usuario" value="<?=$email?>">
			<br>
 			<input class="form-control" type="password" name="pass" placeholder="contraseña">
			<br>
			<div class="row justify-content-md-center">
				<div class="col-sm-6">
  				<button class="btn btn-primary" type="submit">ENTRAR</button>
				</div>
				<div class="col-sm-6">
					<label class="centrar"><input type="checkbox" name="recordar" checked> Recordar</label>
				</div>
			</div>
			<a href="recuperar.php" class="registrar">¿Olvidaste la contraseña?</a>
			<a href="registracion.php" class="registrar">¿Sos nuevo? REGISTRATE!</a>
		</form>
	</div>
</div>

<?php include 'footer.php' ?>
