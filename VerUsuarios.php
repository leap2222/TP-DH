<?php
  error_reporting(E_ALL);
  ini_set('display_errors', 1);

  require_once("funciones.php");
  require_once("Clases/Usuarios.php");
  $TodosLosUsuarios = Usuarios::ObtenerTodos();

  if (!estaLogueado()) {
	 	header('location: login.php');
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
    <label>Usuarios:</label>
    <ol name="users">
      <?php foreach($TodosLosUsuarios as $unUsuario):?>
        <li value="<?=$unUsuario->getId()?>">Nombre: <?=$unUsuario->getName()?>; email: <?=$unUsuario->getEmail()?> </li>
        <a class="btn btn-primary" href="perfil.php?email=<?=$unUsuario->getEmail()?>">VER</a>
      <?php endforeach;?>
    </ul>
  </body>
</html>
