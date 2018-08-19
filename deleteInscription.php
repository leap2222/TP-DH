<?php
  require_once("Clases/inscripcion.php");
  require_once("funciones.php");

  if(isset($_GET['id']) && estaLogueado()){
    $laInscripcion = new inscripcion("",$_GET['id'],$_SESSION['id']);
    $laInscripcion->Eliminar();
  }

  header('location: EventoDetalle.php');
  exit;
?>
