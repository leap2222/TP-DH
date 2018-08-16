<?php
  require_once("connect.php");
  require_once("funciones.php");

  class usuario {
    private $user_id;
    private $name;
    private $email;
    private $pass;
    private $age;
    private $telephone;
    private $country;
    private $website;
    private $message;
    private $sex;
    private $language;
    private $role_id;
    private $photo;
    private $inscripciones;

    public function __construct($user_id, $name, $email, $pass, $age, $telephone, $country, $website, $message, $sex, $language, $role_id, $photo = null) {
      $this->user_id = $user_id;
      $this->name = $name;
      $this->email = $email;
      $this->pass = $pass;
      $this->age = $age;
      $this->telephone = $telephone;
      $this->country = $country;
      $this->website = $website;
      $this->message = $message;
      $this->sex = $sex;
      $this->language = $language;
      $this->role_id = $role_id;
      $this->photo = $photo;
    }

    public function setInscripcion($nuevaInscripcion) {
      $this->inscripciones[] = $nuevaInscripcion;
    }

    public function getInscripciones() {
      return $this->inscripciones;
    }

    public function getId() {
      return $this->user_id;
    }

    public function getName() {
      return $this->name;
    }

    public function getEmail() {
      return $this->email;
    }

    public function getPass() {
      return $this->pass;
    }

    public function getAge() {
      return $this->age;
    }

    public function getTelephone() {
      return $this->telephone;
    }

    public function getCountry() {
      return $this->country;
    }

    public function getWebsite() {
      return $this->website;
    }

    public function getMessage() {
      return $this->message;
    }

    public function getSex() {
      return $this->sex;
    }

    public function getLanguage() {
      return $this->language;
    }

    public function getRole() {
      return $this->role_id;
    }

    public function isAdmin() {
      return $this->role_id == 1;
    }

    public function getPhoto() {
      return $this->photo;
    }

    public function Registrar() {
      try {
        $db = dbConnect();
    		$query = "insert into tpi_db.users (name, email, password, age, telephone, country, website, message, sex, language, role_id)
                  values ('{$this->name}', '{$this->email}', '{$this->pass}', '{$this->age}', '{$this->telephone}', '{$this->country}', '{$this->website}', '{$this->message}', '{$this->sex}', '{$this->language}', '{$this->role_id}')";
    		$ConsultaALaBase = $db->prepare($query);
    		$ConsultaALaBase->execute();
      } catch(PDOException $Exception) {
        echo $Exception->getMessage();
      }
    }

    public function Loguear($mail, $pass) {
  		$usuario = buscarPorEmail($mail);

  		if($usuario) {
  			if(password_verify($pass, $usuario->getPass())) {
  				$_SESSION['id'] = $usuario->getID();
  				setcookie('id', $usuario->getID(), time() + 3600);
  				header('location: perfil.php');
  				exit;
  			}
  		}
      return false;
    }

    public function Actualizar($nombre, $email, $pass, $edad, $tel, $pais, $idioma, $website, $mensaje, $sexo) {
      try {
        $db = dbConnect();
        $query = "update users set name = '{$nombre}', email = '{$email}', password = '{$pass}', age = '{$edad}', telephone = '{$tel}',
                  country = '{$pais}', language = '{$idioma}', website = '{$website}', message = '{$mensaje}', sex = '{$sexo}'
                  where email like '{$this->email}'";
        $ConsultaALaBase = $db->prepare($query);
        $ConsultaALaBase->execute();
      } catch(PDOException $Exception) {
        echo $Exception->getMessage();
        exit;
      }

      $this->name = $nombre;
      $this->email = $email;
      $this->pass = $pass;
      $this->age = $edad;
      $this->telephone = $tel;
      $this->country = $pais;
      $this->language = $language;
      $this->website = $website;
      $this->message = $mensaje;
      $this->sex = $sexo;
      //$this->photo = $foto;

      // echo "Los datos se guardaron exitosamente !";
      header('location: VerUsuarios.php');
      exit;
    }

    public function Eliminar() {
      try {
        $db = dbConnect();
    		$query = "delete from users where user_id like :user_id";
    		$ConsultaALaBase = $db->prepare($query);
        $ConsultaALaBase->bindParam(':user_id', $this->user_id);
    		$ConsultaALaBase->execute();
      } catch(PDOException $Exception) {
        echo $Exception->getMessage();
        exit;
      }

      header('location: VerUsuarios.php');
      exit;
    }
  }

  // TODO integrar funciones sueltas a la Clase

  // == FUNCTION - validar ==
  function validar($data, $archivo) {
    $errores = [];

    $nombre = trim($data['nombre']);
    $email = trim($data['email']);
    $pais = trim($data['pais']);
    $sexo = trim($data['sexo']);
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
      $CadenaDeBusqueda = "SELECT user_id, name, password, age, telephone, country, website, message, sex, language, role_id FROM tpi_db.users WHERE email like :email";
      $ConsultaALaBase = $db->prepare($CadenaDeBusqueda);
      $ConsultaALaBase->bindParam(':email', $email);
      $ConsultaALaBase->execute();
    } else {
      echo "Conexion fallida. buscarPorEmail().";
      exit;
    }

    $unRegistro = $ConsultaALaBase->fetch(PDO::FETCH_ASSOC);

    if($unRegistro){
      $unUsuario = new usuario($unRegistro['user_id'], $unRegistro['name'], $email,
                  $unRegistro['password'], $unRegistro['age'], $unRegistro['telephone'], $unRegistro['country'],
                  $unRegistro['website'], $unRegistro['message'], $unRegistro['sex'], $unRegistro['language'],
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

?>
