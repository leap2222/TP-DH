<?php
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
    <title>Multilanguage Meetings</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/styles.css">
  </head>
  <body>

    <div class="container">
			<?php if (!empty($errores)): ?>
				<div class="div-errores alert alert-danger">
					<ul>
						<?php foreach ($errores as $value): ?>
							<li><?=$value?></li>
						<?php endforeach; ?>
					</ul>
				</div>
			<?php endif; ?>

			<?php include 'header.php'; ?>

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


		</header>
    </div>
  </body>
</html>
