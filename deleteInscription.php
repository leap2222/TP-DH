<?php
  require_once("Clases/inscripcion.php");
  require_once("funciones.php");

  if(isset($_GET['event_id']) && estaLogueado()){
    $laInscripcion = new inscripcion(null,$_GET['event_id'],$_SESSION['id']);
    $laInscripcion->Eliminar();
  }

  header('location: VerEventos.php');
  exit;
?>
