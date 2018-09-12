<?php
  require_once("funciones.php");

  if(!estaLogueado()) {
	 	header('location: login.php');
	 	exit;
	}

  // Variables para persistencia
  $name = '';
  $site = '';
  $language = '';
  $estado = '';

  $errores = [];

  if ($_POST) {
    $name = isset($_POST['name']) ? trim($_POST['name']) : "";
    $site = isset($_POST['site']) ? trim($_POST['site']) : "";
    $language = isset($_POST['language']) ? trim($_POST['language']) : "";
    $estado = isset($_POST['estado']) ? trim($_POST['estado']) : "";
    // valido todo
    $errores = validarDatosEvento($_POST);

    if (empty($errores)){
      $unEvento = guardarEvento($_POST);
      $unEvento->setStatus($estado);
      Eventos::Guardar($unEvento);
    }
  }
?>

<?php $TituloPagina = "Crear Evento"; include 'header.php'; ?>

<form  method="post" enctype="multipart/form-data">
	<div class="row">
		<div class="col-sm-6">
			<div class="form-group">
				<label class="control-label">Nombre*:</label>
				<input type="text" class="form-control" name="name" value="<?=$name?>">
			</div>
		</div>
		<div class="col-sm-6">
			<div class="form-group">
				<label class="control-label">Lugar de Encuentro*:</label>
				<input class="form-control" type="text" name="site" value="<?=$site?>">
      </div>
		</div>
	</div>
  <div class="row">
    <div class="col-sm-6">
      <div class="form-group">
        <label class="control-label">Idioma de Interés:</label>
        <select class="form-control" name="language">
          <option value="0">Elegí</option>
            <?php foreach ($idiomas as $value): ?>
            <?php if ($value == $language): ?>
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
        <label class="control-label">Estado:</label>
        <select class="form-control" name="estado">
          <option value="1">Activo</option>
          <option value="0">Inactivo</option>
        </select>
      </div>
    </div>
  </div>
  <button class="btn btn-primary" type="submit">Crear</button>
</form>

<?php include 'footer.php'; ?>
