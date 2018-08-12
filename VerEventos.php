<?php
  error_reporting(E_ALL);
  ini_set('display_errors', 1);

  require_once("funciones.php");
  require_once("Clases/Eventos.php");
  $TodosLosEventos = Eventos::ObtenerTodos();

  if (!estaLogueado()) {
	 	header('location: login.php');
	 	exit;
	}
  $usuario = traerPorId($_SESSION['id']);
  $userIsAdmin = Usuarios::isAdmin($_SESSION['email']);
 ?>


  <!DOCTYPE html>
  <html>
    <head>
      <meta charset="utf-8">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
      <title></title>
    </head>
    <body>
      <label>Eventos: </label>
      <ol name="events">
        <?php foreach($TodosLosEventos as $unEvento):?>
          <li value="<?=$unEvento->getName()?>"> Nombre: <?=$unEvento->getName()?>; Lugar del Encuentro: <?=$unEvento->getSite()?>; Idioma Preferido: <?=$unEvento->getLanguage()?> </li>
          <?php if($userIsAdmin): ?>
          <a class="btn btn-primary" href="EditarEvento.php?name=<?=$unEvento->getName()?>">EDITAR</a>
        <?php endif; ?>
          <a class="btn btn-info" href="EventoDetalle.php?name=<?=$unEvento->getName()?>">VER</a>
        <?php endforeach;?>
      </ol>
    </body>
  </html>
