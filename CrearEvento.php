<?php
  require_once("funciones.php");

  if(!estaLogueado()) {
	 	header('location: login.php');
	 	exit;
	}

  $datosEventos = Eventos::ObtenerTodos();

  $status = estadosDeEvento();

  $languages = ["Español", "Inglés", "Aleman", "Frances", "Italiano", "Ruso", "Chino", "Japonés", "Coreano"];

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

    <div class="data-form">
    	<form  method="post" enctype="multipart/form-data">
    		<div class="row">
    			<div class="col-sm-6">
    				<div class="form-group <?= isset($errores['name']) ? 'has-error' : null ?>">
    					<label class="control-label">Nombre*:</label>
    					<input type="text" class="form-control" name="name" value="<?=$name?>">
    				</div>
    			</div>
        </div>
        <br>
        <div class="row">
    			<div class="col-sm-6">
    				<div class="form-group <?= isset($errores['site']) ? 'has-error' : null ?>">
    					<label class="control-label">Lugar de Encuentro*:</label>
    						<input class="form-control" type="text" name="site" value="<?=$site?>">
             </div>
    				</div>
    			</div>
          <br>
          <div class="row">
            <div class="col-sm-6">
              <div class="form-group <?= isset($errores['language']) ? 'has-error' : null ?>">
                <label class="control-label">Idioma de Interés:</label>
                <select class="form-control" name="language">
                    <option value="0">Elegí</option>
                    <?php foreach ($languages as $value): ?>
                      <?php if ($value == $language): ?>
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
            <div class="col-sm-6">
              <div class="form-group <?= isset($errores['estado']) ? 'has-error' : null ?>">
                <label class="control-label">Estado:</label>
                <select class="form-control" name="estado">
                    <option value="0">Estado:</option>
                    <?php foreach ($status as $value): ?>
                      <?php if ($value['value'] == $estado): ?>
                      <option selected value="<?=$value['status_id']?>"><?=$value['value']?></option>
                      <?php else: ?>
                      <option value="<?=$value['status_id']?>"><?=$value['value']?></option>
                      <?php endif; ?>
                    <?php endforeach; ?>
                </select>
              </div>
            </div>
          </div>
          <br>
          <button class="btn btn-primary" type="submit">Crear</button>
        </form>
      </div>

<?php include 'footer.php'; ?>
