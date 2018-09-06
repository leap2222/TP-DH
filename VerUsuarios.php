<?php
  error_reporting(E_ALL);
  ini_set('display_errors', 1);

  require_once("funciones.php");
  require_once("Clases/Usuarios.php");
  require_once("Clases/usuario.php");
  $TodosLosUsuarios = Usuarios::ObtenerTodos();
  //var_dump($TodosLosUsuarios);
  if (!estaLogueado()) {
	 	header('location: login.php');
	 	exit;
	}
  $usuario = traerUsuarioPorId($_SESSION['id']);
  
  $userIsAdmin = Usuarios::isAdmin($usuario->getAttr('email'));
?>


  <?php $TituloPagina = "Usuarios Multilanguage"; include 'header.php'; ?>

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
                <td><?=$unUsuario->getAttr('name');?></td>
                <td><?=$unUsuario->getAttr('email');?></td>
                <td><?=$unUsuario->getAttr('language')?></td>
                <td>
                  <div class="d-flex justify-content-around">
                    <form class="" action="UsuarioDetalle.php" method="get">
                      <input hidden type="text" name="email" value="<?=$unUsuario->getAttr('email');?>">
                      <button type="submit" class="btn btn-info" name="">
                        <span class="ion-edit" aria-hidden="true"></span>
                        <span><strong>Ver</strong></span>
                      </button>
                    </form>

                    <?php if ($userIsAdmin): ?>
                      <form class="" action="deleteUser.php" method="post">
                        <input hidden type="text" name="id" value="<?=$unUsuario->getAttr('id');?>">
                          <button type="submit" class="btn btn-danger" name="">
                            <span class="ion-android-delete" aria-hidden="true"></span>
                            <span><strong>Eliminar</strong></span>
                          </button>
                      </form>
                    <?php endif; ?>
                  </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <a class="btn btn-success" href="perfil.php">Volver</a>
  </body>
</html>
