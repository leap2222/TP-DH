<?php
	require_once('funciones.php');

	if(estaLogueado()) {
		header('location: perfil.php');
		exit;
	}


	// Variables para persistencia

  $datos['name'] = isset($POST['name']) ? trim($_POST['name']) : '';
  $datos['email'] = isset($POST['email']) ? trim($_POST['email']) : '';
  $datos['age'] = isset($_POST['age']) ? trim($_POST['age']) : '';
  $datos['telephone'] = isset($_POST['telephone']) ? trim($_POST['telephone']) : '';
  $datos['country'] = isset($_POST['country']) ? trim($_POST['country']) : '';
  $datos['language'] = isset($_POST['language']) ? trim($_POST['language']) : '';
  $datos['website'] = isset($_POST['website']) ? trim($_POST['website']) : '';
  $datos['message'] = isset($_POST['message']) ? trim($_POST['message']) : '';
  $datos['sex'] = isset($_POST['sex']) ? trim($_POST['sex']) : '';
  $datos['photo'] = 'profile.jpg';

	$errores = [];

	// Si envían algo por $_POST
	if ($_POST) {

		// valido todo
		$errores = validar($_POST, 'avatar');

		if (empty($errores)) {
			// $errores = guardarImagen('avatar');
			// En la variable $usuario, guardo al usuario creado con la función crearUsuario() la cual recibe los datos
			// de $_POST y el avatar
			$usuario = guardarUsuario($_POST, 'avatar');
			// Logueo al usuario
			$usuario->Loguear($usuario->getEmail(), $_POST['pass']);

		}
	}
?>

<?php $TituloPagina = "Registracion"; include 'header.php'; ?>

<h1 align="center">Registrarse</h1>
<form method="post" class="form-horizontal" enctype="multipart/form-data">
	<fieldset>
		<div class="row">
			<div class="col-sm-6">
				<label class="control-label">Nombre y Apellido:*</label><input class="form-control" type="text" name="name" value="<?=$datos['name']?>">
			</div>
			<div class="col-sm-6">
      	<label class="control-label">Correo:*</label><input class="form-control" type="email" name="email" value="<?=$datos['email']?>">
			</div>
		</div>
		<div class="row">
			<div class="col-sm-6">
				<label class="control-label">Contraseña:*</label><input class="form-control" type="password" name="pass">
			</div>
			<div class="col-sm-6">
				<label class="control-label">Repetir Contraseña:*</label><input class="form-control" type="password" name="rpass">
			</div>
		</div>

		<div class="row">
			<div class="col-sm-6">
	  		<label class="control-label">Edad:</label><input class="form-control" type="number" name="age" value="<?=$datos['age']?>">
			</div>
			<div class="col-sm-6">
				<label class="control-label">Teléfono de contacto:</label><i>+54 15</i><input class="form-control" type="telephone" name="telephone" value="<?=$datos['telephone']?>">
			</div>
		</div>

		<div class="row">
			<div class="col-sm-6">
				<label class="control-label">País de nacimiento:*</label>
				<select class="form-control" name="country">
					<?php foreach ($paises as $value): ?>
						<option <?= $value == $datos['country'] ? 'selected' : ''?> value="<?=$value?>"><?=$value?></option>
					<?php endforeach; ?>
				</select>
			</div>
			<div class="col-sm-6">
				<label class="control-label">Idioma de Interés:</label>
				<select class="form-control" name="language">
					<?php foreach ($idiomas as $value): ?>
					<option <?= $value == $datos['language'] ? 'selected' : ''?> value="<?=$value?>"><?=$value?></option>
					<?php endforeach; ?>
				</select>
			</div>
		</div>

		<div class="row">
			<div class="col-sm-6">
				<label>Género:</label><br>
				<select class="form-control" name="sex">
					<option name="sex" value="F" <?= $datos['sex'] == 'F' ? 'selected' : '' ?>>Femenino</option>
					<option name="sex" value="M" <?= $datos['sex'] == 'M' ? 'selected' : '' ?>>Masculino</option>
					<option name="sex" value="O" <?= $datos['sex'] == 'O' ? 'selected' : '' ?>>Otro</option>
				</select>
			</div>
			<div class="col-sm-6">
    		<label class="control-label">Sitio web:</label><input class="form-control" type="url" name="website" value="<?=$datos['website']?>">
			</div>
		</div>

		<div class="row">
			<div class="col-sm-12">
    		<label class="control-label">Tu mensaje:</label><textarea class="form-control" name="message"><?=$datos['message']?></textarea>
			</div>
		</div>

		<br>

		<div class="row">
			<div class="col-sm-12">
				<label for="name" class="control-label">Subir Foto: </label><input type="file" name="photo">
			</div>
		</div>

		<br>

		<input class="btn btn-primary" type="submit" name="accion" value="Crear Usuario">
	</fieldset>
</form>

<?php include 'footer.php'; ?>

<?php

function validar($data) {
	$errores = [];

	$pass = trim($data['pass']);
	$rpass = trim($data['rpass']);

	if (trim($data['name']) == '') {
		$errores['name'] = "Completa tu nombre";
	}

	if (trim($data['country']) == '0') {
		$errores['country'] = "Debes elegir tu pais de procedencia";
	}

	if (trim($data['email']) == '') {
		$errores['email'] = "Completa tu email";
	} elseif (!filter_var(trim($data['email']), FILTER_VALIDATE_EMAIL)) { // Mail invalido
		$errores['email'] = "Por favor poner un email valido";
	} else
		if (buscarPorEmail(trim($data['email']))) {
		$errores['email'] = "Este email ya existe.";
	}

	if(trim($data['sex']) == ''){
		$errores['sexo'] = "Complete el sexo";
	}

	if ($pass == '' || $rpass == '') {
		$errores['pass'] = "Por favor completa tus passwords";
	}

	if ($pass != $rpass) {
		$errores['pass'] = "Tus contraseñas no coinciden";
	}

	if ($_FILES['photo']['error'] == UPLOAD_ERR_OK) {
		$ext = strtolower(pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION));
		if ($ext != 'jpg' && $ext != 'png' && $ext != 'jpeg') {
			$errores['photo'] = "Formatos admitidos: JPG, JPEG, PNG o GIF";
		}
	}
	return $errores;
}
