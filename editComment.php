<?php
  error_reporting(E_ALL);
  ini_set('display_errors', 1);

  require_once("Clases/comentario.php");
  require_once("funciones.php");

  if(isset($_GET['idcomment']) && isset($_GET['nuevoComentario']) && estaLogueado()){

    $unComentario = new comentario($_GET['idcomment'], $_GET['event_id'], null, $_GET['nuevoComentario']);
    $unComentario->Editar();
  }

  header('location: EventoDetalle.php?id='.$unComentario->getEventId().'#commentId'.$unComentario->getId());
  exit;
?>
