<?php
  require_once("funciones.php");

  if(isset($_POST['id']) && estaLogueado()){
    $elUsuario = new usuario(null, null);
    $elUsuario->find($_POST['id']);
    // print_r($elUsuario);exit;
    $elUsuario->delete();
  }

  header('location: VerUsuarios.php');
  exit;
?>
