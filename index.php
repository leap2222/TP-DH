<?php
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
	require_once('funciones.php');

	if (estaLogueado()) {
		$usuario = traerUsuarioPorId($_SESSION['id']);
	} else {
		$usuario = '';
	}

?>

			<?php $TituloPagina = "Multilanguage Meetings"; include 'header.php'; ?>

			<div class="row">
				<div class="col-sm cuerpo color-cuerpo">
					<h2 class="centrar">TEXTO BIENVENIDA DE PAGINA</h2><br>
					Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
				</div>
			</div>

			<?php include 'footer.php' ?>
