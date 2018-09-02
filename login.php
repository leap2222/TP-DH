<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 1);

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
		var_dump($errores);
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

      <!-- Fin de Cabecera con Barra de navegacion -->


					<form method="post" enctype="multipart/form-data">
						<input class="form-control" type="text" name="email" placeholder="usuario" value="<?=$email?>">
						<br>
		       	<input class="form-control" type="password" name="pass" placeholder="contraseña">
	          <label class="centrar">
							<input type="checkbox" name="recordar" checked> Recordar
	          </label>
	          <button class="btn btn-primary" type="submit">ENTRAR</button>
						<a href="recuperar.php" class="registrar">¿Olvidaste la contraseña?</a>
						<a href="registracion.php" class="registrar">¿Sos nuevo? REGISTRATE!</a>
					</form>

			<?php include 'footer.php' ?>
