<?php
  require_once("funciones.php");

  if(!$usuario) {
	 	header('location: login.php');
	 	exit;
	}

  // Variables para persistencia
  $datos['id'] = $usuario->getId();
  $datos['name'] = isset($POST['name']) ? trim($_POST['name']) : $usuario->getName();
  $datos['email'] = $usuario->getEmail();
  $datos['age'] = isset($_POST['age']) ? trim($_POST['age']) : $usuario->getAge();
  $datos['telephone'] = isset($_POST['telephone']) ? trim($_POST['telephone']) : $usuario->getTelephone();
  $datos['country'] = isset($_POST['country']) ? trim($_POST['country']) : $usuario->getCountry();
  $datos['language'] = isset($_POST['language']) ? trim($_POST['language']) : $usuario->getLanguage();
  $datos['website'] = isset($_POST['website']) ? trim($_POST['website']) : $usuario->getWebsite();
  $datos['message'] = isset($_POST['message']) ? trim($_POST['message']) : $usuario->getMessage();
  $datos['sex'] = isset($_POST['sex']) ? trim($_POST['sex']) : $usuario->getSex();
  $datos['photo'] = isset($_FILES['photo']['name']) ? trim($_FILES['photo']['name']) : $usuario->getPhoto();

  $errores = [];

  if ($_POST) { // Si viene POST valido y trato de grabar.

    $errores = validarUsuarioEditar($datos, $usuario);
    $datos['photo'] = file_exists($userPictures . $datos['photo']) ? $datos['photo'] : 'profile.jpg';

    if (empty($errores)){ // si no hay errores cargo el usuario y redirijo al perfil.
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

    <section class="registracion">
      <form method="post" enctype="multipart/form-data">
        <fieldset>
          <div class="row">
            <div class="row centrar">
              <div class="col-sm-12">
    	           <img src='<?= $userPictures . $datos['photo'] ?>' width=300px>
              </div>
              <div class="col-sm-12">
                <br>
                <input type="file" name="photo" value="">
              </div>
            </div>

            <br><br>

						<div class="col-sm-6">
						  <label class="control-label">Nombre y Apellido:</label>
			        <input class="form-control" type="text" name="name" value="<?=$datos['name']?>">
            </div>

            <div class="col-sm-6">
			        <label class="control-label">Correo:</label>
			        <p class="form-control" type="email" name="email" disabled><?=$datos['email']?></p>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6">
						  <label class="control-label">Edad:</label>
						  <input class="form-control" type="number" name="age" value="<?=$datos['age']?>">
            </div>
            <div class="col-sm-6">
							<label class="control-label">Teléfono de contacto:</label>
							<input class="form-control" type="tel" name="telephone" value="<?=$datos['telephone']?>">
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6">
							<label class="control-label">País de nacimiento:</label>
							<select class="form-control" name="country">
								<?php foreach ($paises as $value): ?>
									<option <?= $value == $datos['country'] ? 'selected' : ''?> value="<?=$value?>"><?=$value?></option>
								<?php endforeach; ?>
							</select>
						</div>
						<div class="col-sm-6">
							<label class="control-label">Idioma de Interés:</label>
							<select class="form-control" name="language">
								<?php foreach ($idiomas as $value): ?>
									<option <?= $value == $datos['language'] ? 'selected' : ''?> value="<?=$value?>"><?=$value?></option>
								<?php endforeach; ?>
							</select>
						</div>
					</div>
					<div class="row">
						<div class="col-sm-6">
							<label>Género:</label><br>
              <select class="form-control" name="sex">
							  <option name="sex" value="F" <?= $datos['sex'] == 'F' ? 'selected' : '' ?>>Femenino</option>
		            <option name="sex" value="M" <?= $datos['sex'] == 'M' ? 'selected' : '' ?>>Masculino</option>
							  <option name="sex" value="O" <?= $datos['sex'] == 'O' ? 'selected' : '' ?>>Otro</option>
              </select>
						</div>
						<div class="col-sm-6">
			        <label class="control-label">Sitio web:</label>
			        <input class="form-control" type="url" name="website" value="<?= $datos['website']?>">
						</div>
					</div>

          <div class="row">
						<div class="col-sm-12">
			        <label class="control-label">Tu mensaje:</label>
							<textarea class="form-control" name="message"><?= $datos['message']?></textarea>
						</div>
					</div>

          <br>
				  <button class="btn btn-primary" type="submit">Guardar Cambios</button> <a class="btn btn-danger" href="perfil.php">Cancelar</a>

        </fieldset>
      </form>
    </section>

<?php include 'footer.php' ?>

<?php function validarUsuarioEditar($data, $usuario) {
  $errores = [];

  $photo = trim($data['photo']);

  if (trim($data['name']) == '') {
    $errores['name'] = "Completa tu nombre";
  }

  if (trim($data['country']) == '0') {
    $errores['country'] = "Debes elegir tu pais de procedencia";
  }

  if(trim($data['sex']) == ''){
    $errores['sex'] = "Complete el sexo";
  }

  if($photo != '' && $photo != $usuario->getPhoto()) {
    if ($_FILES['photo']['error'] == UPLOAD_ERR_OK) {
      $ext = strtolower(pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION));
      if ($ext != 'jpg' && $ext != 'png' && $ext != 'jpeg') {
        $errores['photo'] = "Formatos admitidos: JPG, JPEG, PNG o GIF";
      }
    }
  }

  return $errores;
}
