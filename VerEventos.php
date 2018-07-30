<?php
  error_reporting(E_ALL);
  ini_set('display_errors', 1);
  require_once("funciones.php");
  require_once("Clases/Peliculas.php");
  $TodasLasPeliculas = Peliculas::ObtenerTodas();

  if (!estaLogueado()) {
	 	header('location: inicio.php');
	 	exit;
	}

 ?>


  <!DOCTYPE html>
  <html>
    <head>
      <meta charset="utf-8">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
      <title></title>
    </head>
    <body>
      <label>Peliculas: </label>

      <ol name="movies">
        <?php foreach($TodasLasPeliculas as $unaPelicula):?>
          <li value="<?=$unaPelicula->getTitle()?>"> Titulo: <?=$unaPelicula->getTitle()?>; Rating: <?=$unaPelicula->getRating()?>; Premios: <?=$unaPelicula->getAwards()?>; Fecha de Estreno: <?=$unaPelicula->getReleaseDate()?>; Genero: <?=$unaPelicula->getGenreID()?> </li>
          <a class="btn btn-primary" href="EditarPelicula.php?title=<?=$unaPelicula->getTitle()?>">EDITAR</a>
        <?php endforeach;?>
      </ol>

    </body>
  </html>
