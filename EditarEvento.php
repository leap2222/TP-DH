<?php
  require_once("funciones.php");

  if(!$usuario) {
	 	header('location: login.php');
	 	exit;
	}

  if($_GET['id']){
    $elEvento = traerEventoPorId($_GET['id']);
  }

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

      $evento = new evento($datos, null);
      $evento->save();
      header('location: VerEventos.php');
    }
  }
?>

<?php $TituloPagina = "Multilanguage Meetings"; include 'header.php'; ?>

    <div class="data-form">
    	<form  method="post" enctype="multipart/form-data">
    		<div class="row">
    			<div class="col-sm">
    				<div class="form-group <?= isset($errores['name']) ? 'has-error' : null ?>">
    					<label class="control-label">Nombre*:</label>
    					<input type="text" class="form-control" name="name" value="<?=$name?>">
    				</div>
    			</div>
    			<div class="col-sm">
    				<div class="form-group <?= isset($errores['site']) ? 'has-error' : null ?>">
    					<label class="control-label">Lugar del Encuentro*:</label>
    						<input class="form-control" type="text" name="site" value="<?=$site?>">
             </div>
    				</div>
    			</div>
  				<div class="row">
  					<div class="col-sm">
  						<div class="form-group <?= isset($errores['language']) ? 'has-error' : null ?>">
  							<label class="control-label">Idioma Preferido*:</label>
  							<input class="form-control" type="text" name="language" value="<?=$language?>">
    		        </div>
    					</div>
    				</div>

              <button class="btn btn-primary" type="submit">Guardar Cambios</button>
              <a class="btn btn-danger" href="VerEventos.php">Cancelar</button>
            </form>
        </div>


<?php include 'footer.php' ?>
