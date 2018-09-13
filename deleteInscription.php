<?php
  require_once("funciones.php");

  $evento = isset($_GET['event_id']);

  if($evento && estaLogueado()){
    $laInscripcion = new inscripcion(['event_id' => $evento, 'user_id' => $_SESSION['id']]);
    $laInscripcion->Eliminar();
  }

  header('location: EventoDetalle.php?id=' . $evento);
  exit;
?>
