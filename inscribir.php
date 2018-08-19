<?php
require_once("Clases/inscripcion.php");
require_once("Clases/Inscripciones.php");
require_once("funciones.php");

if(estaLogueado() && isset($_GET['event_id'])){
  $nuevaInscripcion = new inscripcion(null, $_GET['event_id'], $_SESSION['id']);
  $nuevaInscripcion->Guardar();
  Inscripciones::Guardar($nuevaInscripcion);
  $elUsuario = traerUsuarioPorId($_SESSION['id']);
  $elUsuario->setInscripcion($nuevaInscripcion);
  $elEvento = traerEventoPorId($_GET['event_id']);
  $elEvento->setInscripcion($nuevaInscripcion);
}

header('location: VerEventos.php');
exit;
