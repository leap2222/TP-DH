<?php
  error_reporting(E_ALL);
  ini_set('display_errors', 1);

  require_once("Clases/respuesta.php");
  require_once("funciones.php");

  if(isset($_GET['idreply']) && isset($_GET['nuevaRespuesta']) && estaLogueado()){
    $unrespuesta = new respuesta($_GET['idreply'],null,null,$_GET['nuevaRespuesta']);
    $unrespuesta->Editar();
  }

  header('location: VerEventos.php');
  exit;
?>
