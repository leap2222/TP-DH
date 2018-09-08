<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	require_once('funciones.php');

	// Si vengo del el perfil para editar.
	if(estaLogueado()) {
		header('location: perfil.php');
		exit;
	}


	// Variables para persistencia
	$paises = ["Argentina", "Brasil", "Colombia", "Chile", "Italia", "Luxembourg", "Bélgica", "Dinamarca", "Finlandia", "Francia", "Slovakia", "Eslovenia",
	"Alemania", "Grecia","Irlanda", "Holanda", "Portugal", "España", "Suecia", "Reino Unido", "Chipre", "Lithuania",
	"Republica Checa", "Estonia", "Hungría", "Latvia", "Malta", "Austria", "Polonia"];
	$idiomas = ["Español", "Inglés", "Aleman", "Frances", "Italiano", "Ruso", "Chino", "Japonés", "Coreano"];

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

							<div class="form-group has-error has-feedback">
								<label class="control-label <?= isset($errores['nombre']) ? 'has-error' : null ?>">Nombre y Apellido:*</label>
			          <input class="form-control <?= isset($errores['nombre']) ? 'has-error' : null ?>" type="text" name="nombre" placeholder="Pedro Pérez" value="<?=$nombre?>">
								<span class="help-block <?= !isset($errores['nombre']) ? 'display: none;' : ''; ?>">
									<b class="glyphicon glyphicon-exclamation-sign"></b>
									<?= isset($errores['nombre']) ? $errores['nombre'] : ''; ?>
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
							<br>

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

						  <label class="control-label">Edad:</label>
						  <input class="form-control" type="number" name="edad" value="<?=$edad?>">
							<br>

							<label class="control-label">Teléfono de contacto:</label>
							<i>+54 15</i>
							<input class="form-control" type="tel" name="tel" value="<?=$tel?>">

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
						<br>

								<div class="form-group <?= isset($errores['idioma']) ? 'has-error' : null ?>">
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
									<span class="help-block" style="<?= !isset($errores['idioma']) ? 'display: none;' : ''; ?>">
										<b class="glyphicon glyphicon-exclamation-sign"></b>
										<?= isset($errores['idioma']) ? $errores['idioma'] : ''; ?>
									</span>
								</div>
								<br>

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


			        <label class="control-label">Sitio web:</label>
			        <input class="form-control" type="url" name="website" value="<?=$website?>">
							<br>

			        <label class="control-label">Tu mensaje:</label>
							<textarea class="form-control" name="mensaje"><?=$mensaje?></textarea>
							<br>

							<div class="form-group <?= isset($errores['avatar']) ? 'has-error' : null ?>">
								<label for="name" class="control-label">Subir Foto*:</label>
								<input class="form-control" type="file" name="avatar" value="<?= isset($_FILES['avatar']) ? $_FILES['avatar']['name'] : null ?>">
								<span class="help-block" style="<?= !isset($errores['avatar']) ? 'display: none;' : '' ; ?>">
									<b class="glyphicon glyphicon-exclamation-sign"></b>
									<?= isset($errores['avatar']) ? $errores['avatar'] : '' ;?>
								</span>
							</div>
						</div>

					</div>
					<input class="btn btn-primary" type="submit" name="accion" value="CREAR USUARIO">
        </fieldset>
      </form>
    </section>

		<?php include 'footer.php'; ?>
