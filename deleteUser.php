<?php
  error_reporting(E_ALL);
  ini_set('display_errors', 1);
  require_once("Clases/usuario.php");
  require_once("Clases/Modelo.php");
  require_once("funciones.php");

  if(isset($_POST['id']) && estaLogueado()){

    $elUsuario = new usuario();
    $elUsuario->find($_POST['id']);
    // print_r($elUsuario);exit;
    $elUsuario->delete();
  }

  header('location: VerUsuarios.php');
  exit;
?>
