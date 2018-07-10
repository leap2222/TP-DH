<?php
	require_once('funciones.php');

	if (estaLogueado()) {
		header('location: perfil.php');
		exit;
	}

	$email = '';
	$errores = [];

	if ($_POST) {
		$email = trim($_POST['email']);

		$errores = validarLogin($_POST);

		if (empty($errores)) {
			$usuario = existeEmail($email);

			loguear($usuario);

			if (isset($_POST["recordar"])) {
	        setcookie('id', $usuario['id'], time() + 300); // 5 minutos
	    }

			header('location: perfil.php');
			exit;
		}
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
		<?php if (!empty($errores)): ?>
			<div class="div-errores alert alert-danger">
				<ul>
					<?php foreach ($errores as $value): ?>
					<li><?=$value?></li>
					<?php endforeach; ?>
				</ul>
			</div>
		<?php endif; ?>

    <div class="container">
			<div class="row">
				<div class="col-sm-8">
					<div class="form-group">
      			<!-- Cabecera con Barra de navegacion -->
			      <header class="main-header">

			        <img class="logo" src="images/Logo.png">

			        <h1>Multilanguage Meetings</h1>

			        <a href="#" class="toggle-nav">
			          <div class="ion-navicon-round"></div>
			        </a>

			        <nav class="main-nav">
			          <ul>
			            <a href="http://localhost/estebanraffo/TP-DH/quienesSomos.html"><li>QUIENES SOMOS</li></a>
			            <a href="http://localhost/estebanraffo/TP-DH/preguntasFrecuentes.html"><li>PREGUNTAS FRECUENTES</li></a>
			            <a href="#"><li>PROXIMOS EVENTOS</li></a>
			          </ul>
			        </nav>
			      </header>
					</div>
				</div>
			</div>

      <!-- Fin de Cabecera con Barra de navegacion -->
      <div class="data-form">
        <form method="post" enctype="multipart/form-data">
					<div class="row">
						<div class="col-sm-8">
							<div class="form-group">
								<input class="form-control" type="text" name="email" placeholder="usuario" value="<?=$email?>">
								<?php if (isset($errores['email'])): ?>
									<span style="color: red;">
										<b class="glyphicon glyphicon-exclamation-sign"></b>
										<?=$errores['email'];?>
									</span>
								<?php endif; ?>
							</div>
						</div>
						<div class="col-sm-8">
							<div class="form-group">
		            <input class="form-control" type="password" name="pass" placeholder="contraseña">
								<?php if (isset($errores['pass'])): ?>
									<span style="color: red;">
										<b class="glyphicon glyphicon-exclamation-sign"></b>
										<?=$errores['pass'];?>
									</span>
								<?php endif; ?>
							</div>
						</div>
					</div>

					<div class="row">
						<div class="col-sm-8">
							<div class="form-group">
		            <label class="centrar">
		              <input type="checkbox" name="recordar" checked> Recordar
		            </label>
		            <button class="btn btn-primary" type="submit">ENTRAR</button>
							</div>
						</div>
					</div>

        </form>

				<div class="row">
					<div class="col-sm-8">
		        <a href="recuperar.php" class="registrar">¿Olvidaste la contraseña?</a>
		        <a href="registracion.php" class="registrar">¿Sos nuevo? REGISTRATE!</a>
					</div>
				</div>
      </div>

      <!-- Proximos Eventos -->
      <!-- Fin de Proximos Eventos -->

			<div class="row">
				<div class="col-sm-8">
		      <!-- Footer -->
		      <footer class="footer">
		        <a href="http://facebook.com"><ion-icon name="logo-facebook"></ion-icon></a>
		        <a href="http://twitter.com"><ion-icon name="logo-twitter"></ion-icon></a>
		        <a href="http://instagram.com"><ion-icon name="logo-instagram"></ion-icon></a>
		        <br>
		        <ion-icon name="call"></ion-icon> 5555-5555
		      </footer>
		      <!-- Fin de Footer -->
				</div>
			</div>

		  <script src="https://unpkg.com/ionicons@4.1.2/dist/ionicons.js"></script>
		  <script src="http://code.jquery.com/jquery-3.3.1.min.js"></script>
		  <script>
		  		$('.toggle-nav').click(function () {
		   			$('.main-nav').slideToggle();
		    		});
		  </script>
    </div>
  </body>
</html>
