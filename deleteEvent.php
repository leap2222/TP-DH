<?php
  require_once("Clases/evento.php");
  require_once("funciones.php");

  if(isset($_POST['id']) && estaLogueado()){
    $elEvento = new evento($_POST['id'],"","","");
    $elEvento->Eliminar();
  }

  header('location: movies.php');
  exit;
?>
