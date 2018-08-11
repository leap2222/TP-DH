<?php
// `user_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
// -- `event_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
// `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
// `email` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
// `password` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
// `age` int(10) unsigned NOT NULL,
// `telephone` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
// `country` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
// `website` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
// `message` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
// `sex` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
// `language` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  class usuario{
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
    //private $photo;

    public function __construct($user_id, $name, $email, $pass, $age, $telephone, $country, $website, $message, $sex, $language){
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
      //$this->photo = $foto;
    }

    public function getId(){
      return $this->user_id;
    }

    public function getName(){
      return $this->name;
    }

    public function getEmail(){
      return $this->email;
    }

    public function getPass(){
      return $this->pass;
    }

    public function getAge(){
      return $this->age;
    }

    public function getTelephone(){
      return $this->telephone;
    }

    public function getCountry(){
      return $this->country;
    }

    public function getWebsite(){
      return $this->website;
    }

    public function getMessage(){
      return $this->message;
    }

    public function getSex(){
      return $this->sex;
    }

    public function getLanguage(){
      return $this->language;
    }

    // public function getPhoto(){
    //   $this->photo = $foto;
    // }

    public function Registrar(){

      require_once("connect.php");
      try{
        $db = dbConnect();
    		$query = "insert into tpi_db.users (name, email, password, age, telephone, country, website, message, sex, language)
                  values ('{$this->name}', '{$this->email}', '{$this->pass}', '{$this->age}', '{$this->telephone}', '{$this->country}', '{$this->website}', '{$this->message}', '{$this->sex}', '{$this->language}')";
    		$ConsultaALaBase = $db->prepare($query);
    		$ConsultaALaBase->execute();
      }catch(PDOException $Exception){
        echo $Exception->getMessage();
      }
    }

    public function Loguear($mail, $pass) {
  		require_once("funciones.php");
  		$usuario = buscarPorEmail($mail);

  		if($usuario) {
  			if(password_verify($pass, $usuario->getPass())) {
  				$_SESSION['id'] = $usuario->getID();
  				setcookie('id', $usuario->getID(), time() + 3600);
  				header('location: perfil.php');
  				//exit;
  			}
  		}
      return false;
    }

    public function Actualizar($nombre, $email, $edad, $tel, $pais, $idioma, $website, $mensaje, $sexo){
      try{
        $db = dbConnect();
        $query = "update users set name = '{$nombre}', email = '{$email}', age = '{$edad}', telephone = '{$tel}',
                  country = '{$pais}', language = '{$idioma}', website = '{$website}', message = '{$mensaje}', sex = '{$sexo}'
                  where email like '{$this->email}'";
        $ConsultaALaBase = $db->prepare($query);
        $ConsultaALaBase->execute();
      }catch(PDOException $Exception){
        echo $Exception->getMessage();
      }
      $this->name = $nombre;
      $this->email = $email;
      //$this->pass = $pass;
      $this->age = $edad;
      $this->telephone = $tel;
      $this->country = $pais;
      $this->language = $language;
      $this->website = $website;
      $this->message = $mensaje;
      $this->sex = $sexo;
      //$this->photo = $foto;

      header('location: VerUsuarios.php');
      echo "Los datos se guardaron exitosamente !";
      exit;
    }
  }
?>
