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
		- Usa la función buscarPorEmail() para verificar que no haya registros con el mismo email
		- Retorna un array de errores que puede estar vacio
	*/
	function validar($data, $archivo) {
		$errores = [];

		$nombre = trim($data['nombre']);
		$apellido = trim($data['apellido']);
		$email = trim($data['email']);
		$pais = trim($data['pais']);
		$pass = trim($data['pass']);
		$rpass = trim($data['rpass']);


		if ($nombre == '') {
			$errores['nombre'] = "Completa tu nombre";
		}

		if($apellido == ''){
			$errores['apellido'] = "Completa tu apellido";
		}

		if ($pais == '') {
			$errores['pais'] = "Decime de donde sos";
		}

		if ($email == '') {
			$errores['email'] = "Completa tu email";
		} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) { // Mail invalido
			$errores['email'] = "Por favor poner un email valido";
		} else
			if(!estaLogueado()) {
				if (buscarPorEmail($email)) {
				$errores['email'] = "Este email ya existe.";
			}
		}

		if(!estaLogueado()) {
			if ($pass == '' || $rpass == '') {
				$errores['pass'] = "Por favor completa tus passwords";
			}
		}

		if ($pass != $rpass) {
			$errores['pass'] = "Tus contraseñas no coinciden";
		}

		if ($_FILES[$archivo]['error'] != UPLOAD_ERR_OK) { // Si no subieron ninguna imagen
			if(!estaLogueado()) {
				$errores['avatar'] = "No subiste ninguna foto!";
			}
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


	function nuevoID(){
		$usuarios = traerTodos();

		if (count($usuarios) == 0) {
			return 1;
		}

		$Ultimo = array_pop($usuarios);

		return $Ultimo['id'] + 1;
	}


	function buscarPorEmail($email){
		$todos = traerTodos();

		foreach ($todos as $unUsuario) {
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
		- Retorna nombre del archivo. Nada si hay algun error.
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

				$rutaFinalConNombre = $dondeEstoyParado.'/images/'.$_POST['email'].'.'.$ext;

				// Subo la imagen definitivamente
				move_uploaded_file($archivoFisico, $rutaFinalConNombre);
			} else {
				return $errores['imagen'] = 'El formato tiene que ser JPG, JPEG, PNG o GIF';
			}
		} else {
			// Genero error si no se puede subir
			return $errores['imagen'] = 'No subiste nada';
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

	function borrarUsuario($email) {

	}


	function crearUsuario($data, $imagen) {
		$usuario = [
			'id' => estaLogueado() ? $_SESSION['id'] : nuevoID(),
			'nombre' => $data['nombre'],
			'apellido' => $data['apellido'],
			'email' => $data['email'],
			'edad' => $data['edad'],
			'sexo' => $data['sexo'],
			'tel' => $data['tel'],
			'pais' => $data['pais'],
			'website' => $data['website'],
			'mensaje' => $data['mensaje'],
			'pass' => password_hash($data['pass'], PASSWORD_DEFAULT),
			'foto' => 'images/'.$data['email'].'.'.pathinfo($_FILES[$imagen]['name'], PATHINFO_EXTENSION)
		];

	  return $usuario;
	}


	// == FUNCTION - validarLogin ==
	/*
		- Recibe un parámetro -> $_POST
		- Retorna un array de errores que puede estar vacio
	*/
	function Loguear($mail, $pass) {
		$usuario = buscarPorEmail($mail);

		if($usuario) {
   		if(password_verify($pass, $usuario["pass"])) {
				setcookie('id', $usuario['id'], time()+3600);
				header('location: perfil.php');
				exit;
    	}
		}

		return false;
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
