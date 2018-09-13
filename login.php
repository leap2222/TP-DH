<?php
	require_once('funciones.php');

	if (estaLogueado()) {
		header('location: perfil.php');
		exit;
	}

	$errores = [];
	$email = "";

	if ($_POST) {
		$email = trim($_POST['email']);
		$clave = $_POST['pass'];
		$recordar = $_POST['recordar'];

		$errores = validarLogin($_POST);

		if(!count($errores)) {
				$usuario = LoginDeUsuario($_POST);
				header('location: perfil.php');
				exit;
		} else {
			var_dump($errores);
			$errores['email'] = "Error de credenciales al intentar loguear!";
		}
	}
?>

<?php $TituloPagina = "Login"; include 'header.php'; ?>

<form method="post" enctype="multipart/form-data">
	<input class="form-control" type="text" name="email" value="<?=$email?>"><br>
 	<input class="form-control" type="password" name="pass">
  <label class="centrar"><input type="checkbox" name="recordar" checked> Recordar</label>
  <button class="btn btn-primary" type="submit">ENTRAR</button>
	<a href="recuperar.php" class="registrar">¿Olvidaste la contraseña?</a>
	<a href="registracion.php" class="registrar">¿Sos nuevo? REGISTRATE!</a>
</form>

<?php include 'footer.php' ?>

<?php
 	function validarLogin($data) {
	$arrayADevolver = [];
	$email = trim($data['email']);
	$pass = trim($data['pass']);

	if ($email == '') {
		$arrayADevolver['email'] = 'Completá tu email';
	} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$arrayADevolver['email'] = 'Poné un formato de email válido';
	}

	$usuario = buscarPorEmail($email);

	if(!$usuario) {
		$arrayADevolver['email'] = 'Este email no está registrado';
	} else {
		// Pregunto si coindice la password escrita con la guardada en el JSON
		if (!password_verify($pass, $usuario->getPass())) {
			$arrayADevolver['pass'] = "Credenciales incorrectas";
		}
	}

	return $arrayADevolver;
}
