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
		$pass = trim($data['pass']);
		$rpass = trim($data['rpass']);


		if ($nombre == '') {
			$errores['nombre'] = "Completa tu nombre";
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

		$nombre = trim($data['name']);
		$email = trim($data['email']);
		$pass = trim($data['pass']);
		$passh = password_hash($pass, PASSWORD_DEFAULT);
		$foto = 'images/'.$data['email'].'.'.pathinfo($_FILES[$imagen]['name'], PATHINFO_EXTENSION);

		$unUsuario = new usuario(null, $nombre, $email, $passh, $foto);
		$unUsuario->Registrar();
		return $unUsuario;
	}


	function LoginDeUsuario($data){
		$email = trim($data['email']);
		$pass = trim($data['pass']);

		$usuario = buscarPorEmail($email);

		if($usuario){
			if (password_verify($pass, $usuario->getPass())) {
					$_SESSION['id'] = $usuario->getID();
					if ($data['recordar']) {
							setcookie('id', $usuario->getID(), time() + 3000);
					}
			}
			return $usuario;
		}
		return false;
	}


	function buscarPorEmail($email){

			if($db = dbConnect()) {
				//Ejecuto la lectura
				$CadenaDeBusqueda = "SELECT id, name, password FROM users WHERE email like '{$email}'";
				$ConsultaALaBase = $db->prepare($CadenaDeBusqueda);
				$ConsultaALaBase->execute();
				//$PeliculasADevolver = $ConsultaALaBase->fetchAll(PDO::FETCH_ASSOC); //Esto devuelve un array de array
			} else {
					echo "Conexion fallida";
				}

				$unRegistro = $ConsultaALaBase->fetch(PDO::FETCH_ASSOC);

				if($unRegistro){
					$unUsuario = new usuario($unRegistro['id'], $unRegistro['name'], $email, $unRegistro['password']);
					return $unUsuario;
				}

				return false;
	}


	function traerPorId($id){

		if($db = dbConnect()) {
			//Ejecuto la lectura
			$CadenaDeBusqueda = "SELECT name, email, password FROM users WHERE id = '{$id}'";
			$ConsultaALaBase = $db->prepare($CadenaDeBusqueda);
			$ConsultaALaBase->execute();
			//$PeliculasADevolver = $ConsultaALaBase->fetchAll(PDO::FETCH_ASSOC); //Esto devuelve un array de array
		} else {
				echo "Conexion fallida";
			}

			$unRegistro = $ConsultaALaBase->fetch(PDO::FETCH_ASSOC);

			if($unRegistro){
				$unUsuario = new usuario($id, $unRegistro['name'], $unRegistro['email'], $unRegistro['password']);
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
			$CadenaDeBusqueda = "SELECT site, language FROM events WHERE name like '{$name}'";
			$ConsultaALaBase = $db->prepare($CadenaDeBusqueda);
			$ConsultaALaBase->execute();
			//$PeliculasADevolver = $ConsultaALaBase->fetchAll(PDO::FETCH_ASSOC); //Esto devuelve un array de array
		} else {
				echo "Conexion fallida";
			}

			$unRegistro = $ConsultaALaBase->fetch(PDO::FETCH_ASSOC);

			if($unRegistro){
				$unEvento = new evento($name, $unRegistro['site'], $unRegistro['language']);
				return $unEvento;
			}

			return false;
	}


	function validarDatosEventoParaEditar($data){
		$errores = [];

		$title = isset($_POST['title']) ? trim($_POST['title']) : "";
		$rating = isset($_POST['rating']) ? trim($_POST['rating']) : "0";
		$awards = isset($_POST['awards']) ? trim($_POST['awards']) : "0";
		$release_date = isset($_POST['release_date']) ? trim($_POST['release_date']) : "";
		$genero = isset($_POST['genre_id']) ? trim($_POST['genre_id']) : "";

		if ($title == ''){
			$errores['title'] = "Completa el nombre de la Pelicula";
		}

		if($rating == ''){
			$errores['rating'] = "Debe ingresar el rating";
		}

		if($awards == ''){
			$errores['awards'] = "Debe ingresar la cantidad de premios";
		}

		if($release_date == ''){
			$errores['release_date'] = "Debe ingresar la fecha de release";
		}

		if($genero == ''){
			$errores['genero'] = "Debe ingresar el genero de la pelicula";
		}

		return $errores;
	}



	function guardarPelicula($data){

		$title = trim($data['title']);
		$rating = trim($data['rating']);
		$awards = trim($data['awards']);
		$release_date = trim($data['release_date']);
		$genre_id = trim($data['genre_id']);

		//Crear el objeto
		$unaPelicula = new pelicula($title, $rating, $awards, $release_date, $genre_id);
		//Guardar en la Base
		$unaPelicula->Guardar();
		return $unaPelicula;
	}
