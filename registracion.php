<?php
	require_once('funciones.php');

	if(estaLogueado()) {
		header('location: perfil.php');
		exit;
	}


	// Variables para persistencia
	$nombre = '';
	$email = '';
	$edad = '';
	$tel = '';
	$pais = '';
	$idioma = '';
	$sexo = '';
	$website = '';
	$mensaje = '';

	$errores = [];

	// Si envían algo por $_POST
	if ($_POST) {

		$nombre = trim($_POST['nombre']);
		$email = trim($_POST['email']);
		$edad = trim($_POST['edad']);
		$tel = trim($_POST['tel']);
		$pais = trim($_POST['pais']);
		$idioma = trim($_POST['idioma']);
		$website = trim($_POST['website']);
		$mensaje = trim($_POST['mensaje']);
		$sexo = isset($_POST['sexo']) ? trim($_POST['sexo']) : ""; //$sexo = $_POST['sexo'] ?? "";

		// valido todo
		$errores = validar($_POST, 'avatar');

		if (empty($errores)) {
			// $errores = guardarImagen('avatar');
			// En la variable $usuario, guardo al usuario creado con la función crearUsuario() la cual recibe los datos
			// de $_POST y el avatar
			$usuario = guardarUsuario($_POST, 'avatar');
			// Logueo al usuario
			$usuario->Loguear($email, $_POST['pass']);

		}
	}
?>

<?php $TituloPagina = "Registracion"; include 'header.php'; ?>

<h1 align="center">Registrarse</h1>
<form method="post" class="form-horizontal" enctype="multipart/form-data">
	<fieldset>
		<div class="form-group">
			<label class="control-label">Nombre y Apellido:*</label><input class="form-control" type="text" name="nombre" placeholder="Pedro Pérez" value="<?=$nombre?>">
		</div>
	<div class="form-group">
      <label class="control-label">Correo:*</label><input class="form-control" type="email" name="email" value="<?=$email?>">
		</div>
		<div class="form-group">
			<label class="control-label">Contraseña:*</label><input class="form-control" type="password" name="pass" value="">
		</div>
		<div class="form-group">
			<label class="control-label">Repetir Contraseña:*</label><input class="form-control" type="password" name="rpass" value="">
		</div>

	  <label class="control-label">Edad:</label><input class="form-control" type="number" name="edad" value="<?=$edad?>">

		<label class="control-label">Teléfono de contacto:</label><i>+54 15</i><input class="form-control" type="tel" name="tel" value="<?=$tel?>">

		<div class="form-group">
			<label class="control-label">País de nacimiento:*</label>
			<select class="form-control" name="pais">
				<option value="0">Elegí</option>
				<?php foreach ($paises as $value): ?>
					<?php if ($value == $pais): ?>
				<option selected value="<?=$value?>"><?=$value?></option>
					<?php else: ?>
				<option value="<?=$value?>"><?=$value?></option>
					<?php endif; ?>
				<?php endforeach; ?>
			</select>
		</div>

		<div class="form-group">
			<label class="control-label">Idioma de Interés:</label>
			<select class="form-control" name="idioma">
					<option value="0">Elegí</option>
					<?php foreach ($idiomas as $value): ?>
						<?php if ($value == $idioma): ?>
						<option selected value="<?=$value?>"><?=$value?></option>
						<?php else: ?>
						<option value="<?=$value?>"><?=$value?></option>
						<?php endif; ?>
					<?php endforeach; ?>
			</select>
		</div>

		<label>Género:</label>
		<label><input type="radio" name="sexo" value="F" <?= $sexo == 'F' ? 'checked' : '' ?>>Femenino</label>
  	<label><input type="radio" name="sexo" value="M" <?= $sexo == 'M' ? 'checked' : '' ?>>Masculino</label>
  	<label><input type="radio" name="sexo" value="O" <?= $sexo == 'O' ? 'checked' : '' ?>>Otro</label>

    <label class="control-label">Sitio web:</label><input class="form-control" type="url" name="website" value="<?=$website?>">

    <label class="control-label">Tu mensaje:</label><textarea class="form-control" name="mensaje"><?=$mensaje?></textarea>

		<div class="form-group">
			<label for="name" class="control-label">Subir Foto*:</label><input class="form-control" type="file" name="avatar" value="<?= isset($_FILES['avatar']) ? $_FILES['avatar']['name'] : null ?>">
		</div>

		<input class="btn btn-primary" type="submit" name="accion" value="CREAR USUARIO">
	</fieldset>
</form>

<?php include 'footer.php'; ?>
