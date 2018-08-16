<?php
  error_reporting(E_ALL);
  ini_set('display_errors', 1);

  require_once("funciones.php");
  require_once("Clases/Eventos.php");

  if(!estaLogueado()) {
	 	header('location: login.php');
	 	exit;
	}

  $usuario = traerPorId($_SESSION['id']);
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <title>Ver Eventos</title>
  </head>

  <body>
    <?php require_once("header.php"); ?>

    <h1>Eventos</h1>

    <table class="table table-striped table-hover">
      <thead>
        <tr>
          <th>Nombre</th>
          <th>Lugar de Encuentro</th>
          <th>Idioma Preferido</th>
          <th>Acciones</th>
        </tr>
      </thead>

      <tbody>
        <?php foreach(Eventos::ObtenerTodos() as $unEvento): ?>
          <tr>
            <td><?=$unEvento->getName();?></td>
            <td><?=$unEvento->getSite();?></td>
            <td><?=$unEvento->getLanguage();?></td>
            <td>
              <div class="d-flex justify-content-around">
                <a class="btn btn-primary" href="EventoDetalle.php?id=<?=$unEvento->getId();?>">Ver</a>

                <!-- Editar y Borrar si sos administrador -->
                <?php if ($usuario->isAdmin()): ?>
                  <a class="btn btn-success" href="EditarDetalle.php?id=<?=$unEvento->getId();?>">Modificar</a>

                  <a class="btn btn-danger" href="deleteEvent.php?id=<?=$unEvento->getId();?>">Eliminar</a>
                <?php endif; ?>
                <!-- -->

              </div>
            </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>

    <div>
      <?php if($usuario->isAdmin()):?>
        <a class="btn btn-primary" href="CrearEvento.php">Nuevo Evento</a>
      <?php endif; ?>

      <a class="btn btn-success" href="perfil.php">Volver</a>
    </div>

    <?php require_once("footer.php"); ?>

  </body>
</html>
