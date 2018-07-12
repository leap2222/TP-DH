<?php
	require_once('funciones.php');

	// Si vengo del el perfil para editar.
	if(!estaLogueado()) {
		header('location: login.php');
		exit;
	}

	// Variables para persistencia
	$paises = ['Argentina', 'Brasil', 'Colombia', 'Chile'];
	$nombre = '';
	$apellido = '';
	$email = '';
	$edad = '';
	$tel = '';
	$pais = '';
	$sexo = '';
	$website = '';
	$mensaje = '';
	$errores = [];

	// Si envían algo por $_POST
	if ($_POST) {

		$nombre = trim($_POST['nombre']);
		$apellido = trim($_POST['apellido']);
		$email = trim($_POST['email']);
		$edad = trim($_POST['edad']);
		$tel = trim($_POST['tel']);
		$pais = trim($_POST['pais']);
		$website = trim($_POST['website']);
		$mensaje = trim($_POST['mensaje']);
		$sexo = trim($_POST['sexo']);
		// valido todo
		$errores = validar($_POST, 'avatar');

		if (empty($errores)) {
// Borrar usuario anterior y volver a grabar.
//
//			borrarUsuario($email);
//
//		Falta resolver como borrar el usuario anterior y grabar la foto anterior
//		tambien si no la modifico.
//
			$errores = guardarImagen('avatar');
			// En la variable $usuario, guardo al usuario creado con la función crearUsuario() la cual recibe los datos
			//de $_POST y el avatar
			$usuario = guardarUsuario($_POST, 'avatar');
			// Logueo al usuario y por lo tanto no es necesario el re-direct
			header('location: perfil.php');
			exit;

		}
	} else {
		// Cargar datos del usuario.
		$usuario = traerPorId($_SESSION['id']);

		$nombre = $usuario['nombre'];
		$apellido = $usuario['apellido'];
		$email = $usuario['email'];
		$edad = $usuario['edad'];
		$tel = $usuario['tel'];
		$pais = $usuario['pais'];
		$website = $usuario['website'];
		$mensaje = $usuario['mensaje'];
		$sexo = $usuario['sexo'];
		$foto = $usuario['foto'];
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Registrarse</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link rel="stylesheet" href="css/styles.css">
	</head>
	<body>
		<?php if (!empty($errores)): ?>
			<div class="div-errores alert alert-danger">
				<ul>
					<?php foreach ($errores as $value): ?>
					<li><?=$value?></li>
					<?php endforeach; ?>
				</ul>
			</div>
		<?php endif; ?>
		<h1 align="center">
      <strong>Modificar datos del usuario</strong>
    </h1>
    <section class="registracion">
			<form method="post" enctype="multipart/form-data">
        <fieldset>
          <legend>Datos personales</legend>

					<div class="row justify-content-md-center">
						<div class="col-sm-12">
							<div class="form-group <?= isset($errores['nombre']) ? 'has-error' : null ?>">
								<label class="control-label">Nombre:*</label>
			          <input class="form-control" type="text" name="nombre" placeholder="Paco" value="<?=$nombre?>">
								<span class="help-block" style="<?= !isset($errores['nombre']) ? 'display: none;' : ''; ?>">
									<b class="glyphicon glyphicon-exclamation-sign"></b>
									<?= isset($errores['nombre']) ? $errores['nombre'] : ''; ?>
								</span>
							</div>
							<br>

							<div class="form-group <?= isset($errores['apellido']) ? 'has-error' : null ?>">
			          <label class="control-label">Apellido:*</label>
			          <input class="form-control" type="text" name="apellido" placeholder="Pérez" value="<?=$apellido?>">
								<span class="help-block" style="<?= !isset($errores['apellido']) ? 'display: none;' : ''; ?>">
									<b class="glyphicon glyphicon-exclamation-sign"></b>
									<?= isset($errores['apellido']) ? $errores['apellido'] : ''; ?>
								</span>
							</div>
							<br>

							<div class="form-group <?= isset($errores['email']) ? 'has-error' : null ?>">
			          <label class="control-label">Correo:*</label>
			          <input class="form-control" type="email" name="email" value="<?=$email?>">
								<span class="help-block" style="<?= !isset($errores['email']) ? 'display: none;' : ''; ?>">
									<b class="glyphicon glyphicon-exclamation-sign"></b>
									<?= isset($errores['email']) ? $errores['email'] : ''; ?>
								</span>
							</div>
						</div>
					</div>
					<br>

					<div class="row">
						<div class="col-sm-12">
							<div class="form-group <?= isset($errores['pass']) ? 'has-error' : null ?>">
								<label class="control-label">Contraseña:*</label>
								<input class="form-control" type="password" name="pass" value="">
								<span class="help-block" style="<?= !isset($errores['pass']) ? 'display: none;' : ''; ?>">
									<b class="glyphicon glyphicon-exclamation-sign"></b>
									<?= isset($errores['pass']) ? $errores['pass'] : ''; ?>
								</span>
							</div>
							<br>

							<div class="form-group <?= isset($errores['pass']) ? 'has-error' : null ?>">
								<label class="control-label">Repetir Contraseña:*</label>
								<input class="form-control" type="password" name="rpass" value="">
								<span class="help-block" style="<?= !isset($errores['pass']) ? 'display: none;' : ''; ?>">
									<b class="glyphicon glyphicon-exclamation-sign"></b>
									<?= isset($errores['pass']) ? $errores['pass'] : ''; ?>
								</span>
							</div>
						</div>
					</div>
					<br>

					<div class="row">
						<div class="col-sm-12">
						  <label class="control-label">Edad:</label>
						  <input class="form-control" type="number" name="edad" value="<?=$edad?>">
							<br>

							<label class="control-label">Teléfono de contacto:</label>
							<i>+54 15</i>
							<input class="form-control" type="tel" name="tel" value="<?=$tel?>">
						</div>
					</div>
					<br>

					<div class="row">
						<div class="col-sm-12">
							<div class="form-group <?= isset($errores['pais']) ? 'has-error' : null ?>">
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
								<span class="help-block" style="<?= !isset($errores['pais']) ? 'display: none;' : ''; ?>">
									<b class="glyphicon glyphicon-exclamation-sign"></b>
									<?= isset($errores['pais']) ? $errores['pais'] : ''; ?>
								</span>
							</div>
						</div>
						<br>

						<div class="row">
							<div class="col-sm-12">
								<label>Género:</label>
								<br>
								<label>
			            <input type="radio" name="sexo" value="F" <?= $sexo == 'F' ? 'checked' : '' ?>>
			            Femenino
			          </label>
								<br>
			          <label>
			            <input type="radio" name="sexo" value="M" <?= $sexo == 'M' ? 'checked' : '' ?>>
			            Masculino
			          </label>
								<br>
			          <label>
			            <input type="radio" name="sexo" value="O" <?= $sexo == 'O' ? 'checked' : '' ?>>
			            Otro
			          </label>
			          <br><br>

							</div>
						</div>

						<div class="col-sm-12">
			        <label class="control-label">Sitio web:</label>
			        <input class="form-control" type="url" name="website" value="<?=$website?>">
						</div>
						<br>

						<div class="col-sm-12">
			        <label class="control-label">Tu mensaje:</label>
							<textarea class="form-control" name="mensaje"><?=$mensaje?></textarea>
						</div>
						<br>

						<div class="col-xs-12">
							<div class="form-group <?= isset($errores['avatar']) ? 'has-error' : null ?>">
								<img src='<?=$usuario['foto']?>' width=100px>
								<label for="name" class="control-label">Subir Foto*:</label>
								<input class="form-control" type="file" name="avatar" value="<?= isset($_FILES['avatar']) ? $_FILES['avatar']['name'] : null ?>">
								<span class="help-block" style="<?= !isset($errores['avatar']) ? 'display: none;' : '' ; ?>">
									<b class="glyphicon glyphicon-exclamation-sign"></b>
									<?= isset($errores['avatar']) ? $errores['avatar'] : '' ;?>
								</span>
							</div>
						</div>
					</div>
			  	<input class="btn btn-primary" type="submit" name="accion" value="MODIFICAR USUARIO">
        </fieldset>
      </form>
    </section>
  </body>
</html>
