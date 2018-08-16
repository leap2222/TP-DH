<?php
  require_once("Clases/evento.php");
  require_once("funciones.php");

  if(estaLogueado()) {
    $usuario = traerPorId($_SESSION['id']);

    if($usuario->isAdmin() && isset($_GET['id'])) {
      $elUsuario = new usuario($_GET['id'],"","","","","","","","","","","");
      $elUsuario->Eliminar();
    }
  }

  header('location: VerUsuarios.php');
  exit;
?>
