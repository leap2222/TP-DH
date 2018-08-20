<?php
  error_reporting(E_ALL);
  ini_set('display_errors', 1);

  require_once("Clases/comentario.php");
  require_once("funciones.php");

  if(isset($_GET['id']) && estaLogueado()){
    $elComentario = new comentario($_GET['id'], null, null, null);
    $elComentario->Eliminar();
  }

  header('location: VerEventos.php');
  exit;
?>
