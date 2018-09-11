<?php
	error_reporting(E_ALL);
  ini_set('display_errors', 1);

  require_once("funciones.php");
	// Si vengo del perfil para editar.
  if (!estaLogueado()) {
	 	header('location: login.php');
	 	exit;
	} else {
		require_once("Clases/Usuarios.php");
		$usuario = traerUsuarioPorId($_SESSION['id']);
		//$datosUsuarios = Usuarios::ObtenerTodos();
	}



	$paises = ["Argentina", "Brasil", "Colombia", "Chile", "Italia", "Luxembourg", "Bélgica", "Dinamarca", "Finlandia", "Francia", "Slovakia", "Eslovenia",
	"Alemania", "Grecia","Irlanda", "Holanda", "Portugal", "España", "Suecia", "Reino Unido", "Chipre", "Lithuania",
	"Republica Checa", "Estonia", "Hungría", "Latvia", "Malta", "Austria", "Polonia"];
	$idiomas = ["Español", "Inglés", "Aleman", "Frances", "Italiano", "Ruso", "Chino", "Japonés", "Coreano"];

  // Variables para persistencia
  $nombre = $usuario->getName();
	$email = $usuario->getEmail();
	$edad = $usuario->getAge();
	$tel = $usuario->getTelephone();
	$pais = $usuario->getCountry();
	$website = $usuario->getWebsite();
	$mensaje = $usuario->getMessage();
	$sexo = $usuario->getSex();
	$language = $usuario->getLanguage();
	//$photo = $usuario->getPhoto();

  $errores = [];
	$datos = [];

  if ($_POST) {

		$datos['id'] = $usuario->getId();
		$datos['name'] = isset($POST['nombre']) ? trim($_POST['nombre']) : "";
		$datos['email'] = isset($_POST['email']) ? trim($_POST['email']) : "";
		$pass = isset($_POST['pass']) ? trim($_POST['pass']) : "";
		$datos['password'] = password_hash($pass, PASSWORD_DEFAULT);
		$datos['age'] = isset($_POST['edad']) ? trim($_POST['edad']) : "";
		$datos['telephone'] = isset($_POST['tel']) ? trim($_POST['tel']) : "";
		$datos['country'] = isset($_POST['pais']) ? trim($_POST['pais']) : "";
		$datos['language'] = isset($_POST['idioma']) ? trim($_POST['idioma']) : "";
		$datos['website'] = isset($_POST['website']) ? trim($_POST['website']) : "";
		$datos['message'] = isset($_POST['mensaje']) ? trim($_POST['mensaje']) : "";
		$datos['sex'] = isset($_POST['sexo']) ? trim($_POST['sexo']) : "";

    // valido todo
    $errores = validar($_POST, 'avatar');

    if (empty($errores)){
      require_once("Clases/usuario.php");

      $usuario = new usuario($datos, null);
			$usuario->save();
			header('location: VerUsuarios.php');
		}
  } else {
		// Cargar datos del usuario.
		$usuario = traerUsuarioPorId($_SESSION['id']);

		$nombre = $usuario->getName();
		$email = $usuario->getEmail();
		$edad = $usuario->getAge();
		$tel = $usuario->getTelephone();
		$pais = $usuario->getCountry();
		$website = $usuario->getWebsite();
		$mensaje = $usuario->getMessage();
		$sexo = $usuario->getSex();
		$idioma = $usuario->getLanguage();
		//$photo = $usuario->getPhoto();
	}
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>Editar</title>
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
								<label class="control-label">Nombre y Apellido:*</label>
			          <input class="form-control" type="text" name="nombre" placeholder="Pedro Perez" value="<?=$nombre?>">
								<span class="help-block" style="<?= !isset($errores['nombre']) ? 'display: none;' : ''; ?>">
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
					</div>
					<br>
					<div class="row">
						<div class="col-sm-12">
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
						<br><br>
						<!-- <div class="col-xs-12">
							<div class="form-group <?php //isset($errores['avatar']) ? 'has-error' : null ?>">
								<img src='<?php//$usuario->getPhoto()?>' width=100px>
								<label for="name" class="control-label">Subir Foto*:</label>
								<input class="form-control" type="file" name="avatar" value="<?php //isset($_FILES['avatar']) ? $_FILES['avatar']['name'] : null ?>">
								<span class="help-block" style="<?php// !isset($errores['avatar']) ? 'display: none;' : '' ; ?>">
									<b class="glyphicon glyphicon-exclamation-sign"></b>
									<?php //isset($errores['avatar']) ? $errores['avatar'] : '' ;?>
								</span>
							</div>
						</div> -->
						<button class="btn btn-primary" type="submit">Guardar Cambios</button>
						<a class="btn btn-danger" href="perfil.php">Cancelar</a>
        </fieldset>
      </form>
    </section>
  </body>
</html>
