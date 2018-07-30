<?php
  error_reporting(E_ALL);
  ini_set('display_errors', 1);
  require_once("funciones.php");
  if (!estaLogueado()) {
	 	header('location: inicio.php');
	 	exit;
	}

  if($_GET['title']){
    $laPelicula = buscarPelicula($_GET['title']);
  }

  require_once("Clases/Generos.php");
  $datosGeneros = Generos::ObtenerTodos();

  // Variables para persistencia
  $title = $laPelicula->getTitle();
  $rating = $laPelicula->getRating();
  $awards = $laPelicula->getAwards();
  $release_date = $laPelicula->getReleaseDate();
  $genre_id = $laPelicula->getGenreID();
  $genero = traerGeneroPorId($genre_id);

  $errores = [];

  if ($_POST) {
    $title = isset($_POST['title']) ? trim($_POST['title']) : "";
    $rating = isset($_POST['rating']) ? trim($_POST['rating']) : "0";
    $awards = isset($_POST['awards']) ? trim($_POST['awards']) : "0";
    $release_date = isset($_POST['release_date']) ? trim($_POST['release_date']) : "";
    $genero = isset($_POST['genre_id']) ? trim($_POST['genre_id']) : "";

    // valido todo
    $errores = validarDatosPeliculaParaEditar($_POST);

    if (empty($errores)){
      require_once("Clases/pelicula.php");
      $laPelicula->Actualizar($title, $rating, $awards, $release_date, $genero);
    }
  }
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <title>Editar Pelicula</title>
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
    				<div class="form-group <?= isset($errores['title']) ? 'has-error' : null ?>">
    					<label class="control-label">Titulo*:</label>
    					<input type="text" class="form-control" name="title" value="<?=$title?>">
    					<span class="help-block" style="<?= !isset($errores['title']) ? 'display: none;' : ''; ?>">
    						<b class="glyphicon glyphicon-exclamation-sign"></b>
    							<?= isset($errores['title']) ? $errores['title'] : ''; ?>
    					</span>
    				</div>
    			</div>
    			<div class="col-sm-6">
    				<div class="form-group <?= isset($errores['rating']) ? 'has-error' : null ?>">
    					<label class="control-label">Rating*:</label>
    						<input class="form-control" type="text" name="rating" value="<?=$rating?>">
    						<span class="help-block" style="<?= !isset($errores['rating']) ? 'display: none;' : ''; ?>">
    							<b class="glyphicon glyphicon-exclamation-sign"></b>
    							<?= isset($errores['rating']) ? $errores['rating'] : ''; ?>
    						</span>
             </div>
    				</div>
    			</div>
  				<div class="row">
  					<div class="col-sm-6">
  						<div class="form-group <?= isset($errores['awards']) ? 'has-error' : null ?>">
  							<label class="control-label">Cantidad de Premios:</label>
  							<input class="form-control" type="text" name="awards" value="<?=$awards?>">
    							<span class="help-block" style="<?= !isset($errores['awards']) ? 'display: none;' : ''; ?>">
    								<b class="glyphicon glyphicon-exclamation-sign"></b>
    								<?= isset($errores['awards']) ? $errores['awards'] : ''; ?>
    							</span>
    		        </div>
    					</div>
    					<div class="col-sm-6">
    						<div class="form-group <?= isset($errores['release_date']) ? 'has-error' : null ?>">
    							<label class="control-label">Fecha de Release:</label>
    							<input class="form-control" type="text" name="release_date" placeholder="AAAA-MM-DD" value="<?=$release_date?>">
    							<span class="help-block" style="<?= !isset($errores['release_date']) ? 'display: none;' : ''; ?>">
    								<b class="glyphicon glyphicon-exclamation-sign"></b>
    								<?= isset($errores['release_date']) ? $errores['release_date'] : ''; ?>
    							</span>
    		        </div>
    					</div>
    				</div>

    				<div class="row">
    					<div class="col-sm-6">
    						<div class="form-group <?= isset($errores['genre_id']) ? 'has-error' : null ?>">
    							<label class="control-label">Genero*:</label>
    		             <select class="form-control" class="" name="genre_id">
  										 <option selected value="<?=$genero->getId()?>"><?=$genero->getName()?></option>
  												<?php foreach ($datosGeneros as $value): ?>
  													<?php if ($value->getName() == $genero): ?>
  														<option selected value="<?=$value->getId()?>"><?=$value->getName()?></option>
  													<?php else: ?>
  														<option value="<?=$value->getId()?>"><?=$value->getName()?></option>
  													<?php endif; ?>
  												<?php endforeach; ?>
    									</select>
      								<span class="help-block" style="<?= !isset($errores['genre_id']) ? 'display: none;' : ''; ?>">
      								<b class="glyphicon glyphicon-exclamation-sign"></b>
      								<?= isset($errores['genre_id']) ? $errores['genre_id'] : ''; ?>
      							</span>
    		        </div>
    					 </div>
              </div>
              <button class="btn btn-primary" type="submit">Guardar Cambios</button>
              <a class="btn btn-danger" href="VerPeliculas.php">Cancelar</button>
            </form>
        </div>
  </body>
</html>
