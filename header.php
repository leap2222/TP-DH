<?php require_once("funciones.php"); ?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
		<title><?= $TituloPagina ?></title>
  </head>
  <body>

    <div class="container">

      <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a href="index.php" class="navbar-brand">
          <img class="logo" src="images/Logo.png">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav mr-auto mt-2 mt-lg-0">
            <li class="nav-item active"><a href="quienesSomos.php" class="nav-link">QUIENES SOMOS</a></li>
            <li class="nav-item active"><a href="preguntasFrecuentes.php" class="nav-link">PREGUNTAS FRECUENTES</a></li>
            <li class="nav-item active"><a href="VerEventos.php" class="nav-link">PROXIMOS EVENTOS</a></li>
          </ul>

          <div>
            <?php if(estaLogueado()): ?>
              <?php $usuario = traerUsuarioPorId($_SESSION['id']); ?>
              <a href=perfil.php><?= $usuario->getName() ?> </a>
              (<a href=logout.php>Salir</a>)
            <?php else: ?>
              <a href=registracion.php><ion-icon name="person"></ion-icon>Registrar</a>
              <a href=login.php><ion-icon name="log-in"></ion-icon> Ingresar</a>
            <?php endif;?>
          </div>
        </div>
      </nav>

      <div class="row">
        <div class="col-sm cuerpo color-cuerpo">

          <?php if (!empty($errores)): ?>
    				<div class="div-errores alert alert-danger">
    					<ul>
    						<?php foreach ($errores as $value): ?>
    							<li><?=$value?></li>
    						<?php endforeach; ?>
    					</ul>
    				</div>
    			<?php endif;?>
