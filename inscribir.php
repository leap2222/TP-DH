<?php
require_once("funciones.php");

$evento = isset($_GET['event_id']);

if(estaLogueado() && $evento){
  $nuevaInscripcion = new inscripcion(null, $evento, $_SESSION['id']);
  $nuevaInscripcion->Guardar();
  Inscripciones::Guardar($nuevaInscripcion);
  $elUsuario = traerUsuarioPorId($_SESSION['id']);
  $elUsuario->setInscripcion($nuevaInscripcion);
  $elEvento = traerEventoPorId($evento);
  $elEvento->setInscripcion($nuevaInscripcion);
}

header('location: EventoDetalle.php?id=' . $evento);
exit;
