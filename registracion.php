<?php
	require_once('funciones.php');

	if (estaLogueado()) {
		header('location: perfil.php');
		exit;
	}

	// Array de países para el foreach en el select
	$paises = ['Argentina', 'Brasil', 'Colombia', 'Chile'];

	// Variables para persistencia
	$nombre = '';
	$apellido = '';
	$email = '';
	$edad = '';
	$tel = '';
	$pais = '';

	// Array de errores vacío
	$errores = [];

	// Si envían algo por $_POST
	if ($_POST) {
		// Persisto los datos con la información que envía el usuario por $_POST
		$nombre = trim($_POST['nombre']);
		$nombre = trim($_POST['apellido']);
		$email = trim($_POST['email']);
		$pais = trim($_POST['pais']);

		// Valido y guardo en errores
		$errores = validar($_POST, 'avatar');

		// Si el array de errorres está vacío, es porque no hubo errores, por lo tanto procedo con lo siguiente
		if (empty($errores)) {

			$errores = guardarImagen('avatar');

			if (empty($errores)) {
				// En la variable $usuario, guardo al usuario creado con la función crearUsuario() la cual recibe los datos
				//de $_POST y el avatar
				$usuario = guardarUsuario($_POST, 'avatar');

				// Logueo al usuario y por lo tanto no es necesario el re-direct
				loguear($usuario);
			}
		}
	}

?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Registrarse</title>
		<link rel="stylesheet" href="css/style.css">
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
      <strong>Registrarse</strong>
    </h1>
    <section class="registracion">
      <form action="submit.php" method="post">
        <fieldset>
          <legend>Datos personales</legend>
					<div class="form-group <?= isset($errores['nombre']) ? 'has-error' : null ?>">
						<label class="control-label">Nombre:</label>
	          <input class="form-control" type="text" nombre="nombre" placeholder="Paco" value="<?=$nombre?>">
						<span class="help-block" style="<?= !isset($errores['nombre']) ? 'display: none;' : ''; ?>">
							<b class="glyphicon glyphicon-exclamation-sign"></b>
							<?= isset($errores['nombre']) ? $errores['nombre'] : ''; ?>
						</span>
					</div>

					<div class="form-group <?= isset($errores['apellido']) ? 'has-error' : null ?>">
	          <label class="control-label">Apellido</label>
	          <input class="form-control" type="text" nombre="apellido" placeholder="Pérez" value="<?=$apellido?>">
						<span class="help-block" style="<?= !isset($errores['apellido']) ? 'display: none;' : ''; ?>">
							<b class="glyphicon glyphicon-exclamation-sign"></b>
							<?= isset($errores['apellido']) ? $errores['apellido'] : ''; ?>
						</span>
					</div>

					<div class="form-group <?= isset($errores['email']) ? 'has-error' : null ?>">
	          <label class="control-label">Correo:</label>
	          <input class="form-control" type="email" nombre="correo">
						<span class="help-block" style="<?= !isset($errores['email']) ? 'display: none;' : ''; ?>">
							<b class="glyphicon glyphicon-exclamation-sign"></b>
							<?= isset($errores['email']) ? $errores['email'] : ''; ?>
						</span>
					</div>

					<div class="form-group <?= isset($errores['pass']) ? 'has-error' : null ?>">
						<label class="control-label">Contraseña:</label>
						<input class="form-control" type="password" nombre="clave">
						<span class="help-block" style="<?= !isset($errores['pass']) ? 'display: none;' : ''; ?>">
							<b class="glyphicon glyphicon-exclamation-sign"></b>
							<?= isset($errores['pass']) ? $errores['pass'] : ''; ?>
						</span>
					</div>

					<div class="form-group <?= isset($errores['pass']) ? 'has-error' : null ?>">
						<label class="control-label">Repetir Contraseña:</label>
						<input class="form-control" type="password" name="rpass" value="">
						<span class="help-block" style="<?= !isset($errores['pass']) ? 'display: none;' : ''; ?>">
							<b class="glyphicon glyphicon-exclamation-sign"></b>
							<?= isset($errores['pass']) ? $errores['pass'] : ''; ?>
						</span>
					</div>

					<div class="form-group <?= isset($errores['tel']) ? 'has-error' : null ?>">
						<label class="control-label">Teléfono de contacto:</label>
						<i>+54 15</i>
						<input class="form-control" type="tel" nombre="tel">
						<span class="help-block" style="<?= !isset($errores['tel']) ? 'display: none;' : ''; ?>">
							<b class="glyphicon glyphicon-exclamation-sign"></b>
							<?= isset($errores['tel']) ? $errores['tel'] : ''; ?>
						</span>
					</div>
					<br><br>

					<div class="form-group <?= isset($errores['edad']) ? 'has-error' : null ?>">
						<label class="control-label">Edad:</label>
						<input class="form-control" type="number" nombre="edad">
						<span class="help-block" style="<?= !isset($errores['edad']) ? 'display: none;' : ''; ?>">
							<b class="glyphicon glyphicon-exclamation-sign"></b>
							<?= isset($errores['edad']) ? $errores['edad'] : ''; ?>
						</span>
					</div>

					<div class="form-group <?= isset($errores['pais']) ? 'has-error' : null ?>">
						<label class="control-label">País de nacimiento:</label>
						<select class="form-control" nombre="pais">
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

					<label>Género:</label>
          <label>
            <input type="radio" nombre="gender" value="F" checked>
            Femenino
          </label>
          <label>
            <input type="radio" nombre="gender" value="M">
            Masculino
          </label>
          <label>
            <input type="radio" nombre="gender" value="O">
            Otro
          </label>
          <br><br>

          <label>Pasatiempos:</label>
          <label>
            <input type="checkbox" nombre="hobbies[]" value="L" checked>
            Lectura
          </label>
          <label>
            <input type="checkbox" nombre="hobbies[]" value="M">
            Música
          </label>
          <label>
            <input type="checkbox" nombre="hobbies[]" value="P">
            Programación
          </label>
          <br><br>

          <label>Sitio web:</label>
          <input type="url" nombre="website">
          <br><br>

          <label>Subí tu imagen:</label>
          <input type="file" nombre="foto" accept="image/jpeg" multiple>
          <br><br>

          <label>Tu mensaje:</label>
          <textarea nombre="mensaje"></textarea>
          <br><br>

          <button type="submit">ENVIAR</button>
          <button type="reset">BORRAR</button>
        </fieldset>
      </form>
    </section>
  </body>
</html>
