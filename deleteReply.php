<?php
  error_reporting(E_ALL);
  ini_set('display_errors', 1);

  require_once("Clases/respuesta.php");
  require_once("funciones.php");

  if(isset($_GET['idreply']) && estaLogueado()){
    $laRespuesta = new respuesta($_GET['id'], null, null, null);
    $laRespuesta->Eliminar();
  }

  header('location: VerEventos.php');
  exit;
?>
