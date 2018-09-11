<?php
  error_reporting(E_ALL);
  ini_set('display_errors', 1);

  require_once("funciones.php");
  if (!estaLogueado()) {
	 	header('location: login.php');
	 	exit;
	}

  if($_GET['id']){
    $elEvento = traerEventoPorId($_GET['id']);
  }

  require_once("Clases/Eventos.php");
  $datosEventos = Eventos::ObtenerTodos();

  // Variables para persistencia
  $name = $elEvento->getName();
  $site = $elEvento->getSite();
  $language = $elEvento->getLanguage();

  $errores = [];

  if ($_POST) {
    $datos['id'] = $elEvento->getId();
    $datos['name'] = isset($_POST['name']) ? trim($_POST['name']) : "";
    $datos['site'] = isset($_POST['site']) ? trim($_POST['site']) : "";
    $datos['language'] = isset($_POST['language']) ? trim($_POST['language']) : "";

    // valido todo
    $errores = validarDatosEventoParaEditar($_POST);

    if (empty($errores)){
      require_once("Clases/evento.php");

      $evento = new evento($datos, null);
      $evento->save();
      header('location: VerEventos.php');
    }
  }
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <name>Editar Evento</name>
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
    			<div class="col-sm-6">
    				<div class="form-group <?= isset($errores['site']) ? 'has-error' : null ?>">
    					<label class="control-label">Lugar del Encuentro*:</label>
    						<input class="form-control" type="text" name="site" value="<?=$site?>">
    						<span class="help-block" style="<?= !isset($errores['site']) ? 'display: none;' : ''; ?>">
    							<b class="glyphicon glyphicon-exclamation-sign"></b>
    							<?= isset($errores['site']) ? $errores['site'] : ''; ?>
    						</span>
             </div>
    				</div>
    			</div>
  				<div class="row">
  					<div class="col-sm-6">
  						<div class="form-group <?= isset($errores['language']) ? 'has-error' : null ?>">
  							<label class="control-label">Idioma Preferido*:</label>
  							<input class="form-control" type="text" name="language" value="<?=$language?>">
    							<span class="help-block" style="<?= !isset($errores['language']) ? 'display: none;' : ''; ?>">
    								<b class="glyphicon glyphicon-exclamation-sign"></b>
    								<?= isset($errores['language']) ? $errores['language'] : ''; ?>
    							</span>
    		        </div>
    					</div>
    				</div>

              <button class="btn btn-primary" type="submit">Guardar Cambios</button>
              <a class="btn btn-danger" href="VerEventos.php">Cancelar</button>
            </form>
        </div>
  </body>
</html>
