<?php
	require_once("connect.php");
	require_once("Clases/usuario.php");
	require_once("Clases/Usuarios.php");
	require_once("Clases/Peliculas.php");
	require_once("Clases/pelicula.php");
	require_once("Clases/genero.php");

	session_start();

	// Chequeo si está la cookie seteada y se la paso a session para auto-logueo
	if (isset($_COOKIE['id'])) {
		$_SESSION['id'] = $_COOKIE['id'];
	}


	function validarUsuario($data) {
		$errores = [];

		$nombre = trim($data['name']);
		$email = trim($data['email']);
		$pass = trim($data['pass']);
		$rpass = trim($data['rpass']);

		if ($nombre == '') {
			$errores['nombre'] = "Completa tu nombre";
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


	function LoginDeUsuario($data){
		$email = trim($data['email']);
		$pass = trim($data['pass']);

	 	$usuario = buscarPorEmail($email);

			// Pregunto si coindice la password escrita con la guardada en el JSON
		if (password_verify($pass, $usuario->getPass())) {
				$_SESSION['id'] = $usuario->getID();
		}

		return $usuario;
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


	function guardarUsuario($data){

		$nombre = trim($data['name']);
		$email = trim($data['email']);
		$pass = trim($data['pass']);
		$passh = password_hash($pass, PASSWORD_DEFAULT);

		$unUsuario = new usuario(null, $nombre, $email, $passh);
		$unUsuario->Registrar();
		return $unUsuario;
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


	function traerGeneroPorId($id){

		if($db = dbConnect()) {
			//Ejecuto la lectura
			$CadenaDeBusqueda = "SELECT id, name FROM genres WHERE id = '{$id}'";
			$ConsultaALaBase = $db->prepare($CadenaDeBusqueda);
			$ConsultaALaBase->execute();
			//$PeliculasADevolver = $ConsultaALaBase->fetchAll(PDO::FETCH_ASSOC); //Esto devuelve un array de array
		} else {
				echo "Conexion fallida";
			}

			$unRegistro = $ConsultaALaBase->fetch(PDO::FETCH_ASSOC);

			if($unRegistro){
				$UnGenero = new genero($id, $unRegistro['name']);
				return $UnGenero;
			}

			return false;
	}


	function validarDatosPelicula($data){
		$errores = [];

		$title = isset($_POST['title']) ? trim($_POST['title']) : "";
    $rating = isset($_POST['rating']) ? trim($_POST['rating']) : "0";
    $awards = isset($_POST['awards']) ? trim($_POST['awards']) : "0";
    $release_date = isset($_POST['release_date']) ? trim($_POST['release_date']) : "";
    $genero = isset($_POST['genre_id']) ? trim($_POST['genre_id']) : "";

		if ($title == ''){
			$errores['title'] = "Completa el nombre de la Pelicula";
		}elseif (buscarPelicula($title)) {
			$errores['title'] = "Esta pelicula ya existe";
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


	function validarDatosPeliculaParaEditar($data){
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


	function buscarPelicula($title){

		if($db = dbConnect()) {
			//Ejecuto la lectura
			$CadenaDeBusqueda = "SELECT rating, awards, release_date, genre_id FROM movies WHERE title like '{$title}'";
			$ConsultaALaBase = $db->prepare($CadenaDeBusqueda);
			$ConsultaALaBase->execute();
			//$PeliculasADevolver = $ConsultaALaBase->fetchAll(PDO::FETCH_ASSOC); //Esto devuelve un array de array
		} else {
				echo "Conexion fallida";
			}

			$unRegistro = $ConsultaALaBase->fetch(PDO::FETCH_ASSOC);

			if($unRegistro){
				$unaPelicula = new pelicula($title, $unRegistro['rating'], $unRegistro['awards'], $unRegistro['release_date'], $unRegistro['genre_id']);
				return $unaPelicula;
			}

			return false;

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
