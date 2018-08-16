<?php
	error_reporting(E_ALL);
  ini_set('display_errors', 1);

  require_once("funciones.php");
	require_once("Clases/Usuarios.php");
	require_once("Clases/evento.php");

  if (!estaLogueado()) {
	 	header('location: login.php');
	 	exit;
	}


	$paises = ["Argentina", "Brasil", "Colombia", "Chile", "Italia", "Luxembourg", "Bélgica", "Dinamarca", "Finlandia", "Francia", "Slovakia", "Eslovenia",
	"Alemania", "Grecia", "Irlanda", "Holanda", "Portugal", "España", "Suecia", "Reino Unido", "Chipre", "Lithuania",
	"Republica Checa", "Estonia", "Hungría", "Latvia", "Malta", "Austria", "Polonia"];
	$idiomas = ["Español", "Inglés", "Aleman", "Frances", "Italiano", "Ruso", "Chino", "Japonés", "Coreano"];


	if($_GET['email']){
		$usuario = buscarPorEmail($_GET['email']);
//		$usuario = traerPorId($usuario->getId());
	}

  // Variables para persistencia
  $nombre = $usuario->getname();
	$email = $usuario->getEmail();
	$edad = $usuario->getAge();
	$tel = $usuario->getTelephone();
	$pais = $usuario->getCountry();
	$website = $usuario->getWebsite();
	$mensaje = $usuario->getMessage();
	$sexo = $usuario->getSex();
	$language = $usuario->getLanguage();
	//$photo = $usuario->getPhoto();
?>

<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="css/styles.css">
		<title>Perfil del Usuario</title>
	</head>
	<body>

		<?php require_once('header.php'); ?>

		<h1 align="center"><strong>Informacion del Usuario</strong></h1>

	  <section class="registracion">
			<form method="post" enctype="multipart/form-data">
        <fieldset>
          <legend>Datos personales</legend>

					<div class="row justify-content-md-center">
						<div class="col-sm-12">
							<div class="form-group>
								<label class="control-label">Nombre y Apellido:*</label>
			          <input class="form-control" type="text" name="nombre" value="<?=$nombre?>" disabled>
							</div>
							<br>
							<div class="form-group>
			          <label class="control-label">Correo:</label>
			          <input class="form-control" type="email" name="email" value="<?=$email?> disabled">
							</div>
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-sm-12">
						  <label class="control-label">Edad:</label>
						  <input class="form-control" type="number" name="edad" value="<?=$edad?>" disabled>
							<br>
							<label class="control-label">Teléfono de contacto:</label>
							<i>+54 15</i>
							<input class="form-control" type="tel" name="tel" value="<?=$tel?>" disabled>
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group>
								<label class="control-label">País de nacimiento:"</label>
								<select class="form-control" name="pais" disabled>
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
						</div>
					</div>
					<br>
					<div class="row">
						<div class="col-sm-12">
							<div class="form-group">
								<label class="control-label">Idioma de Interés:</label>
								<select class="form-control" name="idioma" disabled>
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
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12">
							<label>Género:</label>
							<br>
							<label><input type="radio" <?= $sexo == 'F' ? 'checked' : '' ?> disabled>Femenino</label>
							<br>
			        <label><input type="radio" <?= $sexo == 'M' ? 'checked' : '' ?> disabled>Masculino</label>
							<br>
		          <label><input type="radio" <?= $sexo == 'O' ? 'checked' : '' ?> disabled>Otro</label>
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
						</div>
					</div> -->
        </fieldset>
      </form>
			<a class="btn btn-success" href="VerUsuarios.php">Volver</a>
    </section>

		<?php require_once('footer.php'); ?>
  </body>
</html>
