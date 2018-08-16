<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	require_once('funciones.php');

	if (estaLogueado()) {
		$usuario = traerPorId($_SESSION['id']);
	} else {
		$usuario = '';
	}

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<link rel="stylesheet" href="css/styles.css">
    <title>Multilanguage Meetings</title>
  </head>

  <body>

		<div class="container">

			<?php include 'header.php'; ?>

			<?php if (!empty($errores)): ?>
				<div class="div-errores alert alert-danger">
					<ul>
						<?php foreach ($errores as $value): ?>
						<li><?=$value?></li>
						<?php endforeach; ?>
					</ul>
				</div>
			<?php endif; ?>


      <!-- Fin de Cabecera con Barra de navegacion -->

			<div class="row">
				<div class="col-sm-8">
					<h2 class="centrar">TEXTO BIENVENIDA DE PAGINA</h2>
					<br>
					Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
					<br>
					<br>
					<br>

				</div>
			</div>

      <!-- Proximos Eventos -->
      <!-- Fin de Proximos Eventos -->

			<?php include 'footer.php' ?>


    </div>
  </body>
</html>
