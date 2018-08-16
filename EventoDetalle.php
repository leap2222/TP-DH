<?php
  error_reporting(E_ALL);
  ini_set('display_errors', 1);

  require_once("funciones.php");
  require_once("Clases/evento.php");

  if (!estaLogueado()) {
	 	header('location: login.php');
	 	exit;
	}

  if(!($_GET['id'])) {
    header('location: VerEventos.php');
    exit;
  }

  $elEvento = buscarEvento($_GET['id']);

  // Variables para persistencia
  $name = $elEvento->getname();
  $site = $elEvento->getsite();
  $language = $elEvento->getlanguage();
  $estado = $elEvento->getStatus();

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <name>Datos del Evento</name>
  </head>

  <body>
    <?php include 'header.php'; ?>

    <div class="container">
    	<form  method="post" enctype="multipart/form-data">
    		<div class="row">
    			<div class="col-sm-6">
  					<label class="control-label">Nombre:</label>
  					<input type="text" class="form-control" name="name" value="<?=$name?>" disabled>
    			</div>
    			<div class="col-sm-6">
    				<label class="control-label">Lugar del Encuentro:</label>
  					<input class="form-control" type="text" name="site" value="<?=$site?>" disabled>
    			</div>
  				<div class="col-sm-6">
						<label class="control-label">Idioma Preferido:</label>
						<input class="form-control" type="text" name="language" value="<?=$language?>" disabled>
  				</div>
  				<div class="col-sm-6">
						<label class="control-label">Estado:</label>
						<input class="form-control" type="text" name="estado" value="<?=$estado?>" disabled>
    			</div>
      </form>
      <br>
      <a class="btn btn-success" href="VerEventos.php">Volver</a>
      <a class="btn btn-success" href="inscribir.php?event_id=<?= $elEvento->getId() ?>">Asistiré</a>
    </div>

    <?php include 'footer.php'; ?>

  </body>
</html>
