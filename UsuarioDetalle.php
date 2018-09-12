<?php
  require_once("funciones.php");

	// Si vengo del perfil para editar.
  if (!estaLogueado()) {
	 	header('location: login.php');
	 	exit;
	}

  if($_GET['id']){
    $perfil = traerUsuarioPorId($_GET['id']);

	  $eventosInscriptos = Inscripciones::ObtenerTodosLosEventos($perfil->getAttr('id'));

	  // Variables para persistencia
		$nombre = $perfil->getAttr('name');
		$email = $perfil->getAttr('email');
		$edad = $perfil->getAttr('age');
		$tel = $perfil->getAttr('telephone');
		$pais = $perfil->getAttr('country');
		$website = $perfil->getAttr('website');
		$mensaje = $perfil->getAttr('message');
		$sexo = $perfil->getAttr('sex');
		$language = $perfil->getAttr('language');
		$photo = $perfil->getPhoto();
	}
?>

<?php $TituloPagina = "Perfil del Usuario"; include 'header.php'; ?>

<div class="row centrar">
  <div class="col-sm-12">
	  <img src='<?= $userPictures . $perfil->getPhoto() ?>' width=300px>
  </div>
</div>

<br><br>

<div class="row">
	<div class="col-sm-6">
		<label class="control-label">Nombre y Apellido:</label>
    <p class="form-control"><?=$nombre?></p>
	</div>
	<div class="col-sm-6">
    <label class="control-label">Correo:</label>
    <p class="form-control"><?=$email?></p>
	</div>
</div>
<div class="row">
	<div class="col-sm-6">
	  <label class="control-label">Edad:</label>
	  <p class="form-control"><?=$edad?></p>
	</div>
	<div class="col-sm-6">
		<label class="control-label">Teléfono de contacto:</label>
		<p class="form-control"><?=$tel?></p>
	</div>
</div>
<div class="row">
	<div class="col-sm-6">
		<label class="control-label">País de nacimiento:</label>
    <p class="form-control"><?=$pais?></p>
	</div>
	<div class="col-sm-6">
		<label class="control-label">Idioma de Interés:</label>
    <p class="form-control"><?=$language?></p>
	</div>
</div>
<div class="row">
	<div class="col-sm-6">
		<label>Género:</label>
    <p class="form-control"><?= $sexo == 'F' ? 'Femenino' : '' ?><?= $sexo == 'M' ? 'Masculino' : '' ?><?= $sexo == 'O' ? 'Otro' : '' ?></p>
	</div>
	<div class="col-sm-6">
		<label class="control-label">Sitio web:</label>
		<p class="form-control"><?=$website?></p>
	</div>
</div>
<div class="row">
	<div class="col-sm-12">
		<label class="control-label">Mensaje:</label>
		<p class="form-control"><?=$mensaje?></p>
	</div>
</div>

<?php if($eventosInscriptos): ?>
	<br><br>
	<label>Eventos a los que asistirá: </label> <?=$nombre?>
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

<a class="btn btn-success" href="VerUsuarios.php">Volver</a>

<?php include 'footer.php' ?>
