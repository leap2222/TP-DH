<?php
  require_once("funciones.php");

	// Si vengo del perfil para editar.
  if (!estaLogueado()) {
	 	header('location: login.php');
	 	exit;
	}

  if($_GET['id']){
    $usuario = traerUsuarioPorId($_GET['id']);

	  $eventosInscriptos = Inscripciones::ObtenerTodosLosEventos($usuario->getAttr('id'));

		// $paises = ["Argentina", "Brasil", "Colombia", "Chile", "Italia", "Luxembourg", "Bélgica", "Dinamarca", "Finlandia", "Francia", "Slovakia", "Eslovenia",
		// "Alemania", "Grecia", "Irlanda", "Holanda", "Portugal", "España", "Suecia", "Reino Unido", "Chipre", "Lithuania",
		// "Republica Checa", "Estonia", "Hungría", "Latvia", "Malta", "Austria", "Polonia"];
		// $idiomas = ["Español", "Inglés", "Aleman", "Frances", "Italiano", "Ruso", "Chino", "Japonés", "Coreano"];

	  // Variables para persistencia
		$nombre = $usuario->getAttr('name');
		$email = $usuario->getAttr('email');
		$edad = $usuario->getAttr('age');
		$tel = $usuario->getAttr('telephone');
		$pais = $usuario->getAttr('country');
		$website = $usuario->getAttr('website');
		$mensaje = $usuario->getAttr('message');
		$sexo = $usuario->getAttr('sex');
		$language = $usuario->getAttr('language');
		//$photo = $usuario->getPhoto();
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

      <legend>Datos personales</legend>

			<div class="row">
				<div class="col-sm-6">
					<div class="form-group">
						<label class="control-label">Nombre y Apellido:*</label>
	          <input class="form-control" type="text" name="nombre" placeholder="Pedro Perez" value="<?=$nombre?>">
					</div>
				</div>
				<div class="col-sm-6">
					<div class="form-group">
	          <label class="control-label">Correo:*</label>
	          <input class="form-control" type="email" name="email" value="<?=$email?>">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6">
				  <label class="control-label">Edad:</label>
				  <input class="form-control" type="number" name="edad" value="<?=$edad?>">
				</div>
				<div class="col-sm-6">
					<label class="control-label">Teléfono de contacto:</label>
					<i>+54 15</i>
					<input class="form-control" type="tel" name="tel" value="<?=$tel?>">
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6">
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
				</div>
				<div class="col-sm-6">
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
				</div>
			</div>
			<div class="row">
				<div class="col-sm-6"> <!-- No seria mejor ponerlo en un combo? -->
					<label>Género:</label>
					<br>
					<label><input type="radio" name="sexo" value="F" <?= $sexo == 'F' ? 'checked' : '' ?>>Femenino</label>
					<br>
          <label><input type="radio" name="sexo" value="M" <?= $sexo == 'M' ? 'checked' : '' ?>>Masculino</label>
					<br>
          <label><input type="radio" name="sexo" value="O" <?= $sexo == 'O' ? 'checked' : '' ?>>Otro</label>
          <br><br>
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
				<label> No está inscripto en ningún evento </label>
			<?php endif; ?>
    </fieldset>
  </form>
	<a class="btn btn-success" href="VerUsuarios.php">Volver</a>
</section>

<?php include 'footer.php' ?>
