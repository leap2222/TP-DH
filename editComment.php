<?php
  error_reporting(E_ALL);
  ini_set('display_errors', 1);

  require_once("Clases/comentario.php");
  require_once("funciones.php");

  if(isset($_GET['idcomment']) && isset($_GET['nuevoComentario']) && estaLogueado()){

    $unComentario = new comentario($_GET['idcomment'],null,null,$_GET['nuevoComentario']);
    $unComentario->Editar();
  }

  header('location: VerEventos.php');
  exit;
?>
