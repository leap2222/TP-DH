<?php
  require_once("Clases/evento.php");
  require_once("funciones.php");

  if(isset($_POST['id']) && estaLogueado()){
    $elEvento = new evento();
    $elEvento->find($_POST['id']);
    $elEvento->delete();

  }

  header('location: VerEventos.php');
  exit;
?>
