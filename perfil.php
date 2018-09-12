<?php
	require_once('funciones.php');

	if (!estaLogueado()) {
	 	header('location: login.php');
	 	exit;
	}
?>


<?php $TituloPagina = "Perfil de usuario"; include 'header.php'; ?>

<h1>Bienvenido, <?=$usuario->getAttr('name')?>!</h1>
<br><br>
<div class="row">
	<div class="col-sm cuerpo color-cuerpo">
  	<a href="VerEventos.php" class="btn btn-primary">Ver Eventos</a>
  	<br><br>
  	<a href="VerUsuarios.php" class="btn btn-primary">Ver Usuarios</a>
  	<br><br>
  	<?php if($usuario->isAdmin()): ?>
	  	<a class="btn btn-primary" href="CrearEvento.php">CARGAR EVENTO</a>
    	<br><br>
  	<?php endif; ?>
  	<a class="btn btn-primary" href="EditarUsuario.php">Editar Datos</a>
  	<br><br>
  	<a class="btn btn-warning" href="logout.php">CERRAR SESIÓN</a>
  	<br><br>
  </div>
</div>

<?php include 'footer.php'; ?>
