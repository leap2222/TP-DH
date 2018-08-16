<?php
  require_once("Clases/evento.php");
  require_once("funciones.php");

  if(estaLogueado()) {
		$usuario = traerPorId($_SESSION['id']);

    if($usuario->isAdmin() && isset($_GET['id'])) {
      $elEvento = new evento($_GET['id'],"","","");
      $elEvento->Eliminar();
    }
	}

  header('location: verEventos.php');
  exit;

?>
