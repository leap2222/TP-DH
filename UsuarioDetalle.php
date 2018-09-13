<?php
  require_once("funciones.php");
  require_once("Clases/Inscripciones.php");

	// Si vengo del perfil para editar.
  if (!estaLogueado()) {
	 	header('location: login.php');
	 	exit;
	}

  if($_GET['id']){
    $perfil = traerUsuarioPorId($_GET['id']);

	  $eventosInscriptos = Inscripciones::ObtenerTodosLosEventos($perfil->getId());

		// $paises = ["Argentina", "Brasil", "Colombia", "Chile", "Italia", "Luxembourg", "Bélgica", "Dinamarca", "Finlandia", "Francia", "Slovakia", "Eslovenia",
		// "Alemania", "Grecia", "Irlanda", "Holanda", "Portugal", "España", "Suecia", "Reino Unido", "Chipre", "Lithuania",
		// "Republica Checa", "Estonia", "Hungría", "Latvia", "Malta", "Austria", "Polonia"];
		// $idiomas = ["Español", "Inglés", "Aleman", "Frances", "Italiano", "Ruso", "Chino", "Japonés", "Coreano"];

	  // Variables para persistencia
		$nombre = $perfil->getName();
		$email = $perfil->getEmail();
		$edad = $perfil->getAge();
		$tel = $perfil->getTelephone();
		$pais = $perfil->getCountry();
		$website = $perfil->getWebsite();
		$mensaje = $perfil->getMessage();
		$sexo = $perfil->getSex();
		$language = $perfil->getLanguage();
		$photo = $perfil->getPhoto();
	}


?>

<?php $TituloPagina = "Perfil del Usuario"; include 'header.php'; ?>

<h1 align="center"><strong>Informacion del Usuario</strong></h1>
<section class="registracion">
	<form method="post" enctype="multipart/form-data">
    <fieldset>

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

			<div class="row">
				<div class="col-sm-6">
						<label class="control-label">Nombre y Apellido:</label>
	          <input class="form-control" type="text" name="nombre" placeholder="Pedro Perez" value="<?=$nombre?>">
				</div>
				<div class="col-sm-6">
	          <label class="control-label">Correo:</label>
	          <input class="form-control" type="email" name="email" value="<?=$email?>">
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6">
				  <label class="control-label">Edad:</label>
				  <input class="form-control" type="number" name="edad" value="<?=$edad?>">
				</div>
				<div class="col-sm-6">
					<label class="control-label">Teléfono de contacto:</label>
					<input class="form-control" type="tel" name="tel" value="<?=$tel?>">
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6">
						<label class="control-label">País de nacimiento:</label>
            <input class="form-control" type="text" name="pais" value="<?=$pais?>">
				</div>
				<div class="col-sm-6">
						<label class="control-label">Idioma de Interés:</label>
            <input class="form-control" type="text" name="idioma" value="<?=$language?>">
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6">
					<label>Género:</label>
          <input class="form-control" type="text" name="sexo" value="<?= $sexo == 'F' ? 'Femenino' : '' ?><?= $sexo == 'M' ? 'Masculino' : '' ?><?= $sexo == 'O' ? 'Otro' : '' ?>">
				</div>
				<div class="col-sm-6">
					<label class="control-label">Sitio web:</label>
					<input class="form-control" type="url" name="website" value="<?=$website?>">
				</div>
			</div>
			<div class="row">
				<div class="col-sm-12">
      		<label class="control-label">Tu mensaje:</label>
					<textarea class="form-control" name="mensaje"><?=$mensaje?></textarea>
				</div>
			</div>

			<?php if($eventosInscriptos): ?>
				<br><br>
				<label>Eventos a los que asistirá:</label> <?=$nombre?>
				<table class="table table-striped table-hover">
					<thead>
						<tr>
							<th>Evento</th>
							<th>Lugar</th>
							<th>Idioma Preferido</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($eventosInscriptos as $unaInscripcion): ?>
							<?php $unEvento = traerEventoPorId($unaInscripcion->getEventId())?>
							<tr>
								<td><a href=EventoDetalle.php?id='<?=$unEvento->getId()?>' class='nombreUsuario'> <?=$unEvento->getName();?></a></td>
								<td><?=$unEvento->getSite();?></td>
								<td><?=$unEvento->getLanguage();?></td>
							</tr>
						<?php endforeach; ?>
					</tbody>
				</table>
			<?php else: ?>
        <br>
        <br>
				<label>No está inscripto en ningún evento </label>
        <br>
        <br>
			<?php endif; ?>
    </fieldset>
  </form>
	<a class="btn btn-success" href="VerUsuarios.php">Volver</a>
</section>

<?php include 'footer.php' ?>
