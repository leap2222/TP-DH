<?php

	session_start();

	// Chequeo si está la cookie seteada y se la paso a session para auto-logueo
	if (isset($_COOKIE['id'])) {
		$_SESSION['id'] = $_COOKIE['id'];
	}

	// == FUNCTION - validar ==
	/*
		- Recibe dos parámetros -> $_POST y el nombre del campo de subir imagen
		- Valida en el 1er submit que todos los campos son obligatorios
		- Usa la función existeEmail() para verificar que no haya registros con el mismo email
		- Retorna un array de errores que puede estar vacio
	*/
	function validar($data, $archivo) {
		$errores = [];

		$nombre = trim($_POST['nombre']);
		$apellido = trim($_POST['apellido']);
		$email = trim($_POST['email']);
		$pais = trim($_POST['pais']);
		$pass = trim($_POST['pass']);
		$rpass = trim($_POST['rpass']);


		// Valido cada campo del formulario y por cada error genero una posición en el array de errores ($errores) que inicialmente estaba vacío

		if ($nombre == '') { // Si el nombre está vacio
			$errores['nombre'] = "Completa tu nombre";
		}

		if($apellido == ''){
			$errores['apellido'] = "Completa tu apellido";
		}

		if ($pais == '') { // Si el país no fué elegido
			$errores['pais'] = "Decime de donde sos";
		}

		if ($email == '') { // Si el email está vacio
			$errores['email'] = "Completa tu email";
		} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			// Si el email no es un formato valido
			$errores['email'] = "Por favor poner un email valido";
		} elseif (existeEmail($email)) { // Si el email ya está registrado vacio
			$errores['email'] = "Este email ya existe.";
		}

		if ($pass == '' || $rpass == '') { // Si la contraseña o repetir contraseña está(n) vacio(s)
			$errores['pass'] = "Por favor completa tus passwords";
		} elseif ($pass != $rpass) {
			$errores['pass'] = "Tus contraseñas no coinciden";
		}

		if ($_FILES[$archivo]['error'] != UPLOAD_ERR_OK) { // Si no subieron ninguna imagen
			$errores['avatar'] = "Che subí una foto";
		} else {
			$ext = strtolower(pathinfo($_FILES[$archivo]['name'], PATHINFO_EXTENSION));

			if ($ext != 'jpg' && $ext != 'png' && $ext != 'jpeg') {
				$errores['avatar'] = "Formatos admitidos: JPG, JPEG, PNG o GIF";
			}

		}

		return $errores;
	}



	// == FUNCTION - traerTodos ==
	/*
		- NO recibe parámetros
		- Lee el JSON y arma un array de arrays de usuarios, cada línea en el JSON será un array de 1 usuario
		- Retorna el array con todos los usuarios
	*/
	function traerTodos() {
		// Traigo la data de todos los usuarios de 'usuarios.json'
		$todosJson = file_get_contents('usuarios.json');

		// Esto me arma un array con todos los usuarios
		$usuariosArray = explode(PHP_EOL, $todosJson);

		// Saco el último elemento que es una línea vacia
		array_pop($usuariosArray);

		// Creo un array vacio, para guardar los usuarios
		$todosPHP = [];

		// Recorremos el array y generamos por cada usuario un array del usuario
		foreach ($usuariosArray as $usuario) {
			$todosPHP[] = json_decode($usuario, true);
		}

		return $todosPHP;
	}



	// == FUNCTION - traerUltimoID ==
	/*
		- NO recibe parámetros
		- Usa la función traerTodos()
		- Retorna un número. En el 1er usuario registrado devuelve 1 y en los siguientes al ID actual le suma 1
	*/
	function traerUltimoID(){
		// me traigo todos los usuarios
		$usuarios = traerTodos();

		if (count($usuarios) == 0) {
			return 1;
		}

		// En caso de que haya usuarios agarro el ultimo usuario
		$elUltimo = array_pop($usuarios);

		// Pregunto por le ID de ese ultimo usuario
		$id = $elUltimo['id'];

		// A ese ID le sumo 1, para asignarle el nuevo ID al usuario que se esta registrando
		return $id + 1;
	}

	// == FUNCTION - existeEmail ==
	/*
		- Recibe un parámetro -> $_POST['email']
		- Usa la función traerTodos()
		- Retorna un array del usuario si encuentra el email. De no encontrarlo, retorna false
	*/
	function existeEmail($email){
		// Traigo todos los usuarios
		$todos = traerTodos();

		// Recorro ese array
		foreach ($todos as $unUsuario) {
			// Si el mail del usuario en el array es igual al que me llegó por POST, devuelvo al usuario
			if ($unUsuario['email'] == $email) {
				return $unUsuario;
			}
		}

		return false;
	}



	// == FUNCTION - guardarImagen ==
	/*
		- Recibe un parámetro -> el nombre del campo de la imagen
		- Se encarga de guardar el archivo de imagen en la ruta definida
		- Retorna un array de errores si los hay
	*/
	function guardarImagen($laImagen){
		$errores = [];

		if ($_FILES[$laImagen]['error'] == UPLOAD_ERR_OK) {
			// Capturo el nombre de la imagen, para obtener la extensión
			$nombreArchivo = $_FILES[$laImagen]['name'];
			// Obtengo la extensión de la imagen
			$ext = pathinfo($nombreArchivo, PATHINFO_EXTENSION);
			// Capturo el archivo temporal
			$archivoFisico = $_FILES[$laImagen]['tmp_name'];

			// Pregunto si la extensión es la deseada
			if ($ext == 'jpg' || $ext == 'jpeg' || $ext == 'png') {
				// Armo la ruta donde queda gurdada la imagen
				$dondeEstoyParado = dirname(__FILE__);

				$rutaFinalConNombre = $dondeEstoyParado.'\/images/'.$_POST['email'].'.'.$ext;

				// Subo la imagen definitivamente
				move_uploaded_file($archivoFisico, $rutaFinalConNombre);
			} else {
				$errores['imagen'] = 'El formato tiene que ser JPG, JPEG, PNG o GIF';
			}
		} else {
			// Genero error si no se puede subir
			$errores['imagen'] = 'No subiste nada';
		}

		return $errores;
	}

	// == FUNCTION - guardarUsuario ==
	/*
		- Recibe dos parámetros -> $_POST y el nombre del campo de la imagen
		- Usa la función crearUsuario()
		- Su función principal es guardar al usuario
		- Retorna el usuario para poder auto-loguear después del registro
	*/
	function guardarUsuario($data, $imagen){

		$usuario = crearUsuario($data, $imagen);

		$usuarioJSON = json_encode($usuario);

		// Inserta el objeto JSON en nuestro archivo de usuarios
		file_put_contents('usuarios.json', $usuarioJSON.PHP_EOL, FILE_APPEND);

		// Devuelvo al usuario para poder auto loguearlo después del registro
		return $usuario;
	}

	// == FUNCTION - crearUsuario ==
	/*
		- Recibe dos parámetros -> $_POST y el nombre del campo de subir imagen
		- Con estos datos, genera un array nuevo
		- Usa la función traerUltimoID() para generar un ID para cada usuario
		- Retorna el array con el usuario final
	*/
	function crearUsuario($data, $imagen) {
		$usuario = [
			'id' => traerUltimoID(),
			'name' => $data['name'],
			'email' => $data['email'],
			'pais' => $data['pais'],
			'pass' => password_hash($data['pass'], PASSWORD_DEFAULT),
			'foto' => 'images/'.$data['email'].'.'.pathinfo($_FILES[$imagen]['name'], PATHINFO_EXTENSION)
		];

	   return $usuario;
	}


	// == FUNCTION - validarLogin ==
	/*
		- Recibe un parámetro -> $_POST
		- Usa la función existeEmail()
		- Retorna un array de errores que puede estar vacio
	*/
	function validarLogin($data) {
		$arrayADevolver = [];
		$email = trim($data['email']);
		$pass = trim($data['pass']);

		if ($email == '') {
			$arrayADevolver['email'] = 'Completá tu email';
		} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$arrayADevolver['email'] = 'Poné un formato de email válido';
		} elseif (!$usuario = existeEmail($email)) {
			$arrayADevolver['email'] = 'Este email no está registrado';
		} else {
			// Si el mail existe, me guardo al usuario dueño del mismo
			// $usuario = existeEmail($email);

 			// Pregunto si coindice la password escrita con la guardada en el JSON
      	if (!password_verify($pass, $usuario["pass"])) {
         	$arrayADevolver['pass'] = "Credenciales incorrectas";
      	}
		}

		return $arrayADevolver;
	}



	// FUNCTION - loguear
	/*
		- Recibe un parámetro -> el usuario
		- Guarda en sesión el ID del usuario que recibe
		- Redirecciona a perfil.php
	*/
	function loguear($usuario) {
		// Guardo en $_SESSION el ID del USUARIO
	  $_SESSION['id'] = $usuario['id'];
		header('location: perfil.php');
		exit;
	}

	// FUNCTION - estaLogueado
	/*
		- No recibe parámetros
		- Pregunta si está guardado en SESIÓN el ID del $usuarios
	*/
	function estaLogueado() {
		return isset($_SESSION['id']);
	}




	// == FUNCTION - traerId ==
	/*
		- Recibe un parámetro -> $id:
		- Devuelve el usuario si encuentra a alguno con ese ID
		- Devuelve false si no hay usuarios con ese ID
	*/
	function traerPorId($id){
		// me traigo todos los usuarios
		$todos = traerTodos();

		// Recorro el array de todos los usuarios
		foreach ($todos as $usuario) {
			if ($id == $usuario['id']) {
				return $usuario;
			}
		}

		return false;
	}
