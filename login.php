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
		$clave = $_POST['pass'];
		$recordar = $_POST['recordar'];


		// me fijo que el mail sea, mas o menos, legal.
		if ($email == '') {
			$errores['email'] = 'Completá tu email';
		} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$errores['email'] = 'Poné un formato de email válido';
		}

		// si se pudo Loguear() me devuelve el usuario sino false.
		$usuario = Loguear($email, $clave);

		if ($usuario) {
			$usuario['id'] = $_SESSION['id'];

			if ($recordar) {
	        setcookie('id', $usuario['id'], time() + 3000);
	    }

			header('location: perfil.php');
			exit;
		} else {
			$errores['email'] = "Error de credenciales al intentar loguear!";
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

			<?php include 'footer.php' ?>


		</header>
    </div>
  </body>
</html>
