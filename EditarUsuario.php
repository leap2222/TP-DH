<?php
  require_once("funciones.php");

	// Si vengo del perfil para editar.
  if(!$usuario) {
	 	header('location: login.php');
	 	exit;
	}

  // Variables para persistencia
  $datos['id'] = $usuario->getId();
  $datos['name'] = isset($POST['nombre']) ? trim($_POST['nombre']) : $usuario->getName();
  $datos['email'] = isset($_POST['email']) ? trim($_POST['email']) : $usuario->getEmail();
  $datos['age'] = isset($_POST['edad']) ? trim($_POST['edad']) : $usuario->getAge();
  $datos['telephone'] = isset($_POST['tel']) ? trim($_POST['tel']) : $usuario->getTelephone();
  $datos['country'] = isset($_POST['pais']) ? trim($_POST['pais']) : $usuario->getCountry();
  $datos['language'] = isset($_POST['idioma']) ? trim($_POST['idioma']) : $usuario->getLanguage();
  $datos['website'] = isset($_POST['website']) ? trim($_POST['website']) : $usuario->getWebsite();
  $datos['message'] = isset($_POST['mensaje']) ? trim($_POST['mensaje']) : $usuario->getMessage();
  $datos['sex'] = isset($_POST['sexo']) ? trim($_POST['sexo']) : $usuario->getSex();
  $datos['photo'] = isset($_POST['photo']) ? trim($_POST['photo']) : $usuario->getPhoto();


  $errores = [];

  if ($_POST) { // Si viene POST valido y trato de grabar.
    // valido todo
    $errores = validar($_POST);

    if (empty($errores)){ // si no hay errores cargo el usuario y redirijo al perfil.
      $datos['password'] = $usuario->getattr('password'); // hace falta pasarla de nuevo?
      $usuario = new usuario($datos, null);
			$usuario->save();

      // TODO:
      // Habria que grabar la imagen en la carpeta $userPictures tambien?

			header('location: UsuarioDetalle.php?id=' . $usuario->getId());
      exit;

		} // sino vuelvo a mostrar el formulario con los errores.


  } // cargo todo el formulario de nuevo para persistencia.

?>

<?php $TituloPagina = "Editar usuario"; include 'header.php'; ?>

		<h1 align="center"><strong>Modificar Perfil</strong></h1><br>

    <div class="row centrar">
      <div class="col-sm-12">
    	  <img src='<?= $userPictures . $datos['photo'] ?>' width=300px>
      </div>
    </div>

    <br><br>


    <section class="registracion">
			<form method="post" enctype="multipart/form-data">
        <fieldset>
					<div class="row">
						<div class="col-sm-6">
							<label class="control-label">Nombre y Apellido:*</label>
			        <input class="form-control" type="text" name="nombre" value="<?=$datos['name']?>">
            </div>
            <div class="col-sm-6">
			        <label class="control-label">Correo:*</label>
			        <input class="form-control" type="email" name="email" value="<?=$datos['email']?>">
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6">
						  <label class="control-label">Edad:</label>
						  <input class="form-control" type="number" name="edad" value="<?=$datos['age']?>">
            </div>
            <div class="col-sm-6">
							<label class="control-label">Teléfono de contacto:</label>
							<input class="form-control" type="tel" name="tel" value="<?=$datos['telephone']?>">
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6">
							<label class="control-label">País de nacimiento:*</label>
							<select class="form-control" name="pais">
								<?php foreach ($paises as $value): ?>
									<option <?= $value == $datos['country'] ? 'selected' : ''?> value="<?=$value?>"><?=$value?></option>
								<?php endforeach; ?>
							</select>
						</div>
						<div class="col-sm-6">
							<label class="control-label">Idioma de Interés:</label>
							<select class="form-control" name="idioma">
								<?php foreach ($idiomas as $value): ?>
									<option <?= $value == $datos['language'] ? 'selected' : ''?> value="<?=$value?>"><?=$value?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6">
							<label>Género:</label><br>
							<label><input type="radio" name="sexo" value="F" <?= $datos['sex'] == 'F' ? 'checked' : '' ?>>Femenino</label>
		          <label><input type="radio" name="sexo" value="M" <?= $datos['sex'] == 'M' ? 'checked' : '' ?>>Masculino</label>
							<label><input type="radio" name="sexo" value="O" <?= $datos['sex'] == 'O' ? 'checked' : '' ?>>Otro</label>
						</div>
						<div class="col-sm-6">
			        <label class="control-label">Sitio web:</label>
			        <input class="form-control" type="url" name="website" value="<?= $datos['website']?>">
						</div>
					</div>

          <div class="row">
						<div class="col-sm-12">
			        <label class="control-label">Tu mensaje:</label>
							<textarea class="form-control" name="mensaje"><?= $datos['message']?></textarea>
						</div>
					</div>

          <br>
				  <button class="btn btn-primary" type="submit">Guardar Cambios</button>
					<a class="btn btn-danger" href="perfil.php">Cancelar</a>

        </fieldset>
      </form>
    </section>

<?php include 'footer.php' ?>
