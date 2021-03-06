<?php
	require_once('Clases/DB.php');
	require_once('Clases/MySQL_DB.php');
	require_once('Clases/Modelo.php');
	require_once("Clases/Usuarios.php");
	require_once("Clases/usuario.php");
	require_once("Clases/Eventos.php");
	require_once("Clases/evento.php");
	require_once("Clases/Comentarios.php");
	require_once("Clases/comentario.php");
	require_once("Clases/inscripcion.php");
	require_once("Clases/Inscripciones.php");


	error_reporting(E_ALL);
  ini_set('display_errors', 1);

	date_default_timezone_set('America/Argentina/Buenos_Aires');
	session_start();

	$paises = ["Argentina", "Brasil", "Colombia", "Chile", "Italia", "Luxembourg", "Bélgica", "Dinamarca", "Finlandia", "Francia", "Slovakia", "Eslovenia",
	"Alemania", "Grecia","Irlanda", "Holanda", "Portugal", "España", "Suecia", "Reino Unido", "Chipre", "Lithuania",
	"Republica Checa", "Estonia", "Hungría", "Latvia", "Malta", "Austria", "Polonia"];

	$idiomas = ["Español", "Inglés", "Aleman", "Frances", "Italiano", "Ruso", "Chino", "Japonés", "Coreano"];

	$userPictures = 'userPictures/';
	$eventPictures = 'eventPictures/';

	// Chequeo si está la cookie seteada y se la paso a session para auto-logueo
	if (isset($_COOKIE['id'])) {
		$_SESSION['id'] = $_COOKIE['id'];
	}

  if(isset($_SESSION['id'])) {
		$usuario = traerUsuarioPorId($_SESSION['id']);
	} else {
		$usuario = null;
	}


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


	function guardarUsuario($data){

		$data['password'] = password_hash($data['pass'], PASSWORD_DEFAULT);
		$data['role_id'] = 2;
		$data['photo'] = $data['photo'] ? $data['photo'] : 'profile.jpg';

		$unUsuario = new usuario($data, null);

		$unUsuario->save();

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

			$unUsuario = new usuario(null, null);
			$unUsuario->findByEmail($email);

				if($unUsuario->getEmail()){

					return $unUsuario;
				}

				return false;
	}


	function traerUsuarioPorId($id){

		$unUsuario = new usuario(null, null);
		$unUsuario->find($id);

		if($unUsuario){
			return $unUsuario;
		}

		return false;

	}


	function traerEventoPorId($id){

		$unEvento = new evento(null, null);
		$unEvento->find($id);

		if($unEvento){
			return $unEvento;
		}

		return false;
	}


	function traerComentarioPorId($id){

		if($db = dbConnect()) {
			//Ejecuto la lectura
			$CadenaDeBusqueda = "SELECT event_id, user_id, comment FROM tpi_db.comments WHERE idcomment = '{$id}'";
			$ConsultaALaBase = $db->prepare($CadenaDeBusqueda);
			$ConsultaALaBase->execute();
			//$PeliculasADevolver = $ConsultaALaBase->fetchAll(PDO::FETCH_ASSOC); //Esto devuelve un array de array
		} else {
				echo "Conexion fallida";
			}

			$unRegistro = $ConsultaALaBase->fetch(PDO::FETCH_ASSOC);

			if(isset($unRegistro)){
				$unComentario = new comentario($id, $unRegistro['event_id'], $unRegistro['user_id'], $unRegistro['comment']);
				return $unComentario;
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
			$CadenaDeBusqueda = "SELECT id, site, language FROM events WHERE name like '{$name}'";
			$ConsultaALaBase = $db->prepare($CadenaDeBusqueda);
			$ConsultaALaBase->execute();
			//$PeliculasADevolver = $ConsultaALaBase->fetchAll(PDO::FETCH_ASSOC); //Esto devuelve un array de array
		} else {
			echo "Conexion fallida";
			exit;
		}

		$unRegistro = $ConsultaALaBase->fetch(PDO::FETCH_ASSOC);

		if($unRegistro){
			$unEvento = new evento($unRegistro['id'], $name, $unRegistro['site'], $unRegistro['language']);
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

		$datos['name'] = trim($data['name']);
		$datos['site'] = trim($data['site']);
		$datos['language'] = trim($data['language']);

		$unEvento = new evento($datos, null);

		$unEvento->save();

		return $unEvento;
	}


	function guardarComentario($event_id, $user_id, $comment){

		$unComentario = new comentario(null, $event_id, $user_id, $comment);
		$unComentario->Guardar();
		Comentarios::Guardar($unComentario);
		$elEvento = traerEventoPorId($event_id);
		$elEvento->setComentario($unComentario);
		return $unComentario;
	}


	function dbConnect(){
		$ruta = 'mysql:host=localhost; dbname=tpi_db; charset=utf8; port=3306';
		$usuario = 'root';
		$password = '';
		$opciones = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");

		try {
			$conn = new PDO($ruta, $usuario, $password, $opciones);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return $conn;
		}
		catch( PDOException $ErrorEnConexion ) {
			echo "Error DB, dbConnect(): ".$ErrorEnConexion->getMessage();
			return false;
		}
	}
