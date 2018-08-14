<?php
  error_reporting(E_ALL);
  ini_set('display_errors', 1);

  require_once("funciones.php");
  if (!estaLogueado()) {
	 	header('location: login.php');
	 	exit;
	}

  require_once("Clases/Eventos.php");
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
      require_once("Clases/Eventos.php");
      Eventos::Guardar($unEvento);
    }
  }
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <name>Crear Evento</name>
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
    <div class="data-form">
    	<form  method="post" enctype="multipart/form-data">
    		<div class="row">
    			<div class="col-sm-6">
    				<div class="form-group <?= isset($errores['name']) ? 'has-error' : null ?>">
    					<label class="control-label">Nombre*:</label>
    					<input type="text" class="form-control" name="name" value="<?=$name?>">
    					<span class="help-block" style="<?= !isset($errores['name']) ? 'display: none;' : ''; ?>">
    						<b class="glyphicon glyphicon-exclamation-sign"></b>
    							<?= isset($errores['name']) ? $errores['name'] : ''; ?>
    					</span>
    				</div>
    			</div>
        </div>
        <br>
        <div class="row">
    			<div class="col-sm-6">
    				<div class="form-group <?= isset($errores['site']) ? 'has-error' : null ?>">
    					<label class="control-label">Lugar de Encuentro*:</label>
    						<input class="form-control" type="text" name="site" value="<?=$site?>">
    						<span class="help-block" style="<?= !isset($errores['site']) ? 'display: none;' : ''; ?>">
    							<b class="glyphicon glyphicon-exclamation-sign"></b>
    							<?= isset($errores['site']) ? $errores['site'] : ''; ?>
    						</span>
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
                <span class="help-block" style="<?= !isset($errores['language']) ? 'display: none;' : ''; ?>">
                  <b class="glyphicon glyphicon-exclamation-sign"></b>
                  <?= isset($errores['language']) ? $errores['language'] : ''; ?>
                </span>
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
                <span class="help-block" style="<?= !isset($errores['estado']) ? 'display: none;' : ''; ?>">
                  <b class="glyphicon glyphicon-exclamation-sign"></b>
                  <?= isset($errores['estado']) ? $errores['estado'] : ''; ?>
                </span>
              </div>
            </div>
          </div>
          <br>
          <?php var_dump($value['status_id']); var_dump($value['value']); ?>
          <button class="btn btn-primary" type="submit">Crear</button>
        </form>
      </div>
  </body>
</html>
