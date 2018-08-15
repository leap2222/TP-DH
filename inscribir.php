<?php
require_once("Clases/inscripcion");
require_once("funciones");

if(estaLogueado()){
  $nuevaInscripcion = new inscripcion(null, $event_id,$_SESSION['id']);
}
