<?php
  require_once("Clases/evento.php");
  require_once("funciones.php");

  if(isset($_POST['id']) && estaLogueado()){
    $elUsuario = new usuario($_POST['id'],"","","","","","","","","","","");
    $elUsuario->delete();
  }

  header('location: VerUsuarios.php');
  exit;
?>
