<?php
	error_reporting(E_ALL);
  ini_set('display_errors', 1);

  require_once("funciones.php");
	// Si vengo del perfil para editar.
  if (!estaLogueado()) {
	 	header('location: login.php');
	 	exit;
	}

  if($_GET['email']){
    $usuario = buscarPorEmail($_GET['email']);
  }

  require_once("Clases/Usuarios.php");
  $datosUsuarios = Usuarios::ObtenerTodos();

	$paises = ["Argentina", "Brasil", "Colombia", "Chile", "Italia", "Luxembourg", "Bélgica", "Dinamarca", "Finlandia", "Francia", "Slovakia", "Eslovenia",
	"Alemania", "Grecia","Irlanda", "Holanda", "Portugal", "España", "Suecia", "Reino Unido", "Chipre", "Lithuania",
	"Republica Checa", "Estonia", "Hungría", "Latvia", "Malta", "Austria", "Polonia"];
	$idiomas = ["Español", "Inglés", "Aleman", "Frances", "Italiano", "Ruso", "Chino", "Japonés", "Coreano"];

  // Variables para persistencia
  $name = $usuario->getname();
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

  if ($_POST) {

		$nombre = isset($POST['nombre']) ? trim($_POST['nombre']) : "";
		$email = isset($_POST['email']) ? trim($_POST['email']) : "";
		$edad = isset($_POST['edad']) ? trim($_POST['edad']) : "";
		$tel = isset($_POST['tel']) ? trim($_POST['tel']) : "";
		$pais = isset($_POST['pais']) ? trim($_POST['pais']) : "";
		$idioma = isset($_POST['idioma']) ? trim($_POST['idioma']) : "";
		$website = isset($_POST['website']) ? trim($_POST['website']) : "";
		$mensaje = isset($_POST['mensaje']) ? trim($_POST['mensaje']) : "";
		$sexo = isset($_POST['sexo']) ? trim($_POST['sexo']) : "";

    // valido todo
    $errores = validar($_POST, 'avatar');

    if (empty($errores)){
			// Borrar usuario anterior y volver a grabar.
			//
			//			borrarUsuario($email);
			//
			//		Falta resolver como borrar el usuario anterior y grabar la foto anterior
			//		tambien si no la modifico.
      require_once("Clases/evento.php");
      $usuario->Actualizar($nombre, $email, $edad, $tel, $pais, $idioma, $website, $mensaje, $sexo);
    }
  } else {
		// Cargar datos del usuario.
		$usuario = traerPorId($_SESSION['id']);

		$nombre = $usuario->getname();
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
		<title>Perfil del Usuario</title>
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
      <strong>Informacion del Usuario</strong>
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
        </fieldset>
      </form>
    </section>
  </body>
</html>