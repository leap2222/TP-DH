<?php
require_once("Clases/inscripcion.php");
require_once("funciones.php");

if(estaLogueado() && isset($_GET['event_id'])){
  $nuevaInscripcion = new inscripcion(null, $_GET['event_id'], $_SESSION['id']);
  $nuevaInscripcion->Guardar();
}

header('location: VerEventos.php');
exit;
