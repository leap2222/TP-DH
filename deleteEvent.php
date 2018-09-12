<?php
  require_once("funciones.php");

  if(isset($_POST['id']) && estaLogueado()){
    $elEvento = new evento(null, null);
    $elEvento->find($_POST['id']);
    $elEvento->delete();
  }

  header('location: VerEventos.php');
  exit;
?>
