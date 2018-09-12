<?php
  require_once("funciones.php");

  $TodosLosUsuarios = Usuarios::ObtenerTodos();

  if (!estaLogueado()) {
	 	header('location: login.php');
	 	exit;
	}
?>


<?php $TituloPagina = "Listado de usuario"; include 'header.php'; ?>

<h1>Usuarios:</h1>
<table class="table table-striped table-hover">
  <thead>
    <tr>
      <th>Nombre</th>
      <th>email</th>
      <th>Idioma Interesado</th>
      <th>Acciones</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($TodosLosUsuarios as $unUsuario): ?>
    <tr>
      <td><?=$unUsuario->getName();?></td>
      <td><?=$unUsuario->getEmail();?></td>
      <td><?=$unUsuario->getLanguage();?></td>
      <td>
        <div class="d-flex justify-content-around">
          <form class="" action="UsuarioDetalle.php" method="get">
            <input hidden type="text" name="id" value="<?=$unUsuario->getId();?>">
            <button type="submit" class="btn btn-info" name="">
              <span class="ion-edit" aria-hidden="true"></span>
              <span><strong>Ver</strong></span>
            </button>
          </form>

          <?php if ($usuario->isAdmin()): ?>
            <form class="" action="deleteUser.php" method="post">
              <input hidden type="text" name="id" value="<?=$unUsuario->getId();?>">
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
<a class="btn btn-success" href="perfil.php">Volver</a>

<?php include 'footer.php'; ?>
