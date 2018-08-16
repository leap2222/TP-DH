<?php
	require_once("connect.php");
	require_once("Clases/Usuarios.php");
	require_once("Clases/usuario.php");
	require_once("Clases/Eventos.php");
	require_once("Clases/evento.php");

	session_start();

	// Chequeo si está la cookie seteada y se la paso a session para auto-logueo
	if (isset($_COOKIE['id'])) {
		$_SESSION['id'] = $_COOKIE['id'];
	}

	// == FUNCTION - validar ==

	function validar($data, $archivo) {
		$errores = [];

		$nombre = trim($data['nombre']);
		//$apellido = trim($data['apellido']);
		$email = trim($data['email']);
		$pais = trim($data['pais']);
		$sexo = isset($_POST['sexo']) ? trim($data['sexo']) : "";
		$pass = trim($data['pass']);
		$rpass = trim($data['rpass']);


		if ($nombre == '') {
			$errores['nombre'] = "Completa tu nombre";
		}

		if ($pais == '0') {
			$errores['pais'] = "Debes elegir tu pais de procedencia";
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

		if($sexo == ''){
			$errores['sexo'] = "Complete el sexo";
		}

		if(!estaLogueado()) {
			if ($pass == '' || $rpass == '') {
				$errores['pass'] = "Por favor completa tus passwords";
			}
		}

		if ($pass != $rpass) {
			$errores['pass'] = "Tus contraseñas no coinciden";
		}

		// if ($_FILES[$archivo]['error'] != UPLOAD_ERR_OK) { // Si no subieron ninguna imagen
		// 	if(!estaLogueado()) {
		// 		$errores['avatar'] = "No subiste ninguna foto!";
		// 	}
		// } else {
		// 		$ext = strtolower(pathinfo($_FILES[$archivo]['name'], PATHINFO_EXTENSION));
		// 		if ($ext != 'jpg' && $ext != 'png' && $ext != 'jpeg') {
		// 			$errores['avatar'] = "Formatos admitidos: JPG, JPEG, PNG o GIF";
		// 		}
		// 	}
		return $errores;
	}


	// FUNCTION - estaLogueado
	/*
		- No recibe parámetros
		- Pregunta si está guardado en SESIÓN el ID del $usuarios
	*/
	function estaLogueado() {
		return isset($_SESSION['id']);
	}

	function validarLogin($data) {
		$arrayADevolver = [];
		$email = trim($data['email']);
		$pass = trim($data['pass']);

		if ($email == '') {
			$arrayADevolver['email'] = 'Completá tu email';
		} elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$arrayADevolver['email'] = 'Poné un formato de email válido';
		} elseif (!$usuario = buscarPorEmail($email)) {
			$arrayADevolver['email'] = 'Este email no está registrado';
		} else {
			// Si el mail existe, me guardo al usuario dueño del mismo
				$usuario = buscarPorEmail($email);

			// Pregunto si coindice la password escrita con la guardada en el JSON
				if (!password_verify($pass, $usuario->getPass())) {
					$arrayADevolver['pass'] = "Credenciales incorrectas";
				}
		}

		return $arrayADevolver;
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


	function guardarUsuario($data, $imagen){

		$nombre = trim($data['nombre']);
		$email = trim($data['email']);
		$pass = trim($data['pass']);
		$passh = password_hash($pass, PASSWORD_DEFAULT);
		$edad = trim($_POST['edad']);
		$tel = trim($_POST['tel']);
		$pais = trim($_POST['pais']);
		$idioma = trim($_POST['idioma']);
		$website = trim($_POST['website']);
		$mensaje = trim($_POST['mensaje']);
		$sexo = trim($_POST['sexo']);
		$foto = 'images/'.$data['email'].'.'.pathinfo($_FILES[$imagen]['name'], PATHINFO_EXTENSION);
		$role_id = 2;

		$unUsuario = new usuario(null, $nombre, $email, $passh, $edad, $tel, $pais, $website, $mensaje, $sexo, $idioma, $role_id);
		$unUsuario->Registrar();
		return $unUsuario;
	}


	function LoginDeUsuario($data){
		$email = trim($data['email']);
		$pass = trim($data['pass']);

		$usuario = buscarPorEmail($email);

		if($usuario){
			if (password_verify($pass, $usuario->getPass())) {
					$_SESSION['id'] = $usuario->getId();
					if ($data['recordar']) {
							setcookie('id', $usuario->getId(), time() + 3000);
					}
			}
			return $usuario;
		}
		return false;
	}


	function buscarPorEmail($email){

			if($db = dbConnect()) {
				//Ejecuto la lectura
				$CadenaDeBusqueda = "SELECT user_id, name, password, age, telephone, country, website, message, sex, language, role_id FROM tpi_db.users WHERE email like '{$email}'";
				$ConsultaALaBase = $db->prepare($CadenaDeBusqueda);
				$ConsultaALaBase->execute();
				//$PeliculasADevolver = $ConsultaALaBase->fetchAll(PDO::FETCH_ASSOC); //Esto devuelve un array de array
			} else {
					echo "Conexion fallida";
					exit;
				}

				$unRegistro = $ConsultaALaBase->fetch(PDO::FETCH_ASSOC);

				if($unRegistro){
					$unUsuario = new usuario($unRegistro['user_id'], $unRegistro['name'], $email, $unRegistro['password'], $unRegistro['age'], $unRegistro['telephone'], $unRegistro['country'], $unRegistro['website'], $unRegistro['message'], $unRegistro['sex'], $unRegistro['language'],
																		$unRegistro['role_id']);

					return $unUsuario;
				}

				return false;
	}


	function traerPorId($id){

		if($db = dbConnect()) {
			//Ejecuto la lectura
			$CadenaDeBusqueda = "SELECT name, email, password, age, telephone, country, website, message, sex, language, role_id FROM tpi_db.users WHERE user_id = '{$id}'";
			$ConsultaALaBase = $db->prepare($CadenaDeBusqueda);
			$ConsultaALaBase->execute();
			//$PeliculasADevolver = $ConsultaALaBase->fetchAll(PDO::FETCH_ASSOC); //Esto devuelve un array de array
		} else {
				echo "Conexion fallida";
			}

			$unRegistro = $ConsultaALaBase->fetch(PDO::FETCH_ASSOC);

			if($unRegistro){
				$unUsuario = new usuario($id, $unRegistro['name'], $unRegistro['email'], $unRegistro['password'], $unRegistro['age'], $unRegistro['telephone'], $unRegistro['country'], $unRegistro['website'], $unRegistro['message'], $unRegistro['sex'], $unRegistro['language'],
																	$unRegistro['role_id']);
				return $unUsuario;
			}

			return false;
	}


	function validarDatosEvento($data){
		$errores = [];

		$name = isset($data['name']) ? trim($data['name']) : "";
		$site = isset($data['site']) ? trim($data['site']) : "0";
		$language = isset($data['language']) ? trim($data['language']) : "0";

		if ($name == ''){
			$errores['name'] = "Completa el nombre del Evento";
		}elseif (buscarEvento($name)) {
			$errores['name'] = "Este Evento ya existe";
		}

		if($site == ''){
			$errores['site'] = "Debe ingresar la dirección del lugar";
		}

		if($language == ''){
			$errores['language'] = "Debe ingresar el idioma preferido del evento";
		}

		return $errores;
	}


	function buscarEvento($name){

		if($db = dbConnect()) {
			//Ejecuto la lectura
			$CadenaDeBusqueda = "SELECT event_id, site, language FROM events WHERE name like '{$name}'";
			$ConsultaALaBase = $db->prepare($CadenaDeBusqueda);
			$ConsultaALaBase->execute();
			//$PeliculasADevolver = $ConsultaALaBase->fetchAll(PDO::FETCH_ASSOC); //Esto devuelve un array de array
		} else {
				echo "Conexion fallida";
			}

			$unRegistro = $ConsultaALaBase->fetch(PDO::FETCH_ASSOC);

			if($unRegistro){
				$unEvento = new evento($unRegistro['event_id'], $name, $unRegistro['site'], $unRegistro['language']);
				return $unEvento;
			}

			return false;
	}


	function validarDatosEventoParaEditar($data){
		$errores = [];

		$name = isset($_POST['name']) ? trim($_POST['name']) : "";
		$site = isset($_POST['site']) ? trim($_POST['site']) : "0";
		$language = isset($_POST['language']) ? trim($_POST['language']) : "0";

		if ($name == ''){
			$errores['name'] = "Completa el nombre del Evento";
		}

		if($site == ''){
			$errores['site'] = "Debe ingresar la dirección del Evento";
		}

		if($language == ''){
			$errores['language'] = "Debe ingresar el idioma del Evento";
		}

		return $errores;
	}


	function guardarEvento($data){

		$name = trim($data['name']);
		$site = trim($data['site']);
		$language = trim($data['language']);

		//Crear el objeto
		$unEvento = new evento(null, $name, $site, $language);
		//Guardar en la Base
		$unEvento->Guardar();
		return $unEvento;
	}


	function estadosDeEvento(){

		if($db = dbConnect()) {
			//Ejecuto la lectura
			$CadenaDeBusqueda = "SELECT status_id, value FROM event_status";
			$ConsultaALaBase = $db->prepare($CadenaDeBusqueda);
			$ConsultaALaBase->execute();
			$resultados = $ConsultaALaBase->fetchAll(PDO::FETCH_ASSOC); //Esto devuelve un array de array
			return $resultados;
		} else {
				echo "Conexion fallida";
			}

			return false;
	}
