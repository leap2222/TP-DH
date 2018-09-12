<?php
  require_once("funciones.php");

  if(isset($_GET['idreply']) && estaLogueado()){
    $laRespuesta = new respuesta($_GET['id'], null, null, null);
    $laRespuesta->Eliminar();
  }

  header('location: VerEventos.php');
  exit;
?>
