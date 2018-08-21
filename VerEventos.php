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
  $usuario = traerUsuarioPorId($_SESSION['id']);
  $userIsAdmin = Usuarios::isAdmin($usuario->getEmail());

 ?>

  <?php $TituloPagina = "Proximos Eventos"; include 'header.php'; ?>


  <div class="row">
  <div class="col-sm cuerpo color-cuerpo">
    <h1>Eventos:</h1>
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

      <?php foreach($TodosLosEventos as $unEvento): ?>

      <tr>
        <td><?=$unEvento->getName();?></td>
        <td><?=$unEvento->getSite();?></td>
        <td><?=$unEvento->getLanguage();?></td>
        <td>
          <div class="d-flex justify-content-around">
            <form class="" action="EventoDetalle.php" method="get">
              <input hidden type="text" name="id" value="<?=$unEvento->getId();?>">
              <button type="submit" class="btn btn-info" name="">
                <span class="ion-edit" aria-hidden="true"></span>
                <span><strong>Ver</strong></span>
              </button>
            </form>

            <?php if ($userIsAdmin): ?>
              <form class="" action="EditarEvento.php" method="get">
                <input hidden type="text" name="id" value="<?=$unEvento->getId();?>">
                <button type="submit" class="btn btn-primary" name="">
                  <span class="ion-edit" aria-hidden="true"></span>
                  <span><strong>Modificar</strong></span>
                </button>
              </form>

              <form class="" action="deleteEvent.php" method="post">
                <input hidden type="text" name="id" value="<?=$unEvento->getId();?>">
                <button type="submit" class="btn btn-danger" name="">
                  <span class="ion-android-delete" aria-hidden="true"></span>
                  <span><strong>Eliminar</strong></span>
                </button>
              </form>
            <?php endif; ?>
          </div>
        </td>
      </tr>
              <?php endforeach; ?>
      </tbody>
      </table>
      <?php if($userIsAdmin):?>
        <a class="btn btn-primary" href="CrearEvento.php">Nuevo Evento</a>
      <?php endif; ?>
      <a class="btn btn-success" href="perfil.php">Volver</a>
      <br><br>

      <?php include 'footer.php'; ?>

    </body>
  </html>
