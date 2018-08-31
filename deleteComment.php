<?php
  error_reporting(E_ALL);
  ini_set('display_errors', 1);

  require_once("funciones.php");

  $comentario = isset($_GET['id_comment']) ? $_GET['id_comment'] : 0;

  if($comentario && estaLogueado()){
    $elComentario = new comentario($comentario, null, null, null);
    $elComentario->Eliminar();
  }

  header('location: EventoDetalle.php?id=' . $_GET['id_event']);
  exit;
?>
