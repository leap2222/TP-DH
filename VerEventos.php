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
  $userIsAdmin = Usuarios::isAdmin($usuario->getEmail());

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
          <a class="btn btn-info" href="EventoDetalle.php?name=<?=$unEvento->getName()?>">VER</a>
          <?php if($userIsAdmin): ?>
            <a class="btn btn-primary" href="EditarEvento.php?name=<?=$unEvento->getName()?>">EDITAR</a>
            <!-- <button class="btn btn-danger" name="delete">Eliminar</a> -->
            <input type="button" class="btn btn-danger" name="borrar" value="Eliminar">
          <?php endif; ?>
        <?php endforeach;?>
      </ol>
      <a class="btn btn-success" href="perfil.php">Volver</a>
    </body>
  </html>
