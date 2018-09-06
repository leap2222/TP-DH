<?php
  require 'DB.php';
  //require 'JSON_DB.php';
  require 'MySQL_DB.php';
  require 'Modelo.php';

  class usuario extends Modelo{
    // private $user_id;
    // private $name;
    // private $email;
    // private $pass;
    // private $age;
    // private $telephone;
    // private $country;
    // private $website;
    // private $message;
    // private $sex;
    // private $language;
    // private $role_id;
    // //private $photo;
    // private $inscripciones;
    public $table = 'users';
    public $columns = ['id', 'name', 'email', 'password', 'age', 'telephone', 'country', 'website', 'message', 'sex', 'language', 'role_id'];

    // public function __construct($user_id, $name, $email, $pass, $age, $telephone, $country, $website, $message, $sex, $language, $role_id){
    //   $this->user_id = $user_id;
    //   $this->name = $name;
    //   $this->email = $email;
    //   $this->pass = $pass;
    //   $this->age = $age;
    //   $this->telephone = $telephone;
    //   $this->country = $country;
    //   $this->website = $website;
    //   $this->message = $message;
    //   $this->sex = $sex;
    //   $this->language = $language;
    //   $this->role_id = $role_id;
    //   //$this->photo = $foto;
    // }

    // public function getId(){
    //   return $this->user_id;
    // }
    //
    // public function getName(){
    //   return $this->name;
    // }
    //
    // public function getEmail(){
    //   return $this->email;
    // }
    //
    // public function getPass(){
    //   return $this->pass;
    // }
    //
    // public function getAge(){
    //   return $this->age;
    // }
    //
    // public function getTelephone(){
    //   return $this->telephone;
    // }
    //
    // public function getCountry(){
    //   return $this->country;
    // }
    //
    // public function getWebsite(){
    //   return $this->website;
    // }
    //
    // public function getMessage(){
    //   return $this->message;
    // }
    //
    // public function getSex(){
    //   return $this->sex;
    // }
    //
    // public function getLanguage(){
    //   return $this->language;
    // }
    //
    // public function getRole(){
    //   return $this->role_id;
    // }

    // public function getPhoto(){
    //   $this->photo = $foto;
    // }

    public function findByEmail($email){
      $reg = $this->db->findByEmail($email);

      if($reg){
        foreach ($reg as $attr => $value) {
          $this->setAttr($attr, $value);
        }
      }
    }

    public function setInscripcion($nuevaInscripcion){
      $this->inscripciones[] = $nuevaInscripcion;
    }

    public function getInscripciones(){
      return $this->inscripciones; //si esta seteado, si no levantar de la base
    }

    // public function Registrar(){
    //
    //   require_once("connect.php");
    //   try{
    //     $db = dbConnect();
    // 		$query = "insert into tpi_db.users (name, email, password, age, telephone, country, website, message, sex, language, role_id)
    //               values ('{$this->name}', '{$this->email}', '{$this->pass}', '{$this->age}', '{$this->telephone}', '{$this->country}', '{$this->website}', '{$this->message}', '{$this->sex}', '{$this->language}', '{$this->role_id}')";
    // 		$ConsultaALaBase = $db->prepare($query);
    // 		$ConsultaALaBase->execute();
    //   }catch(PDOException $Exception){
    //     echo $Exception->getMessage();
    //   }
    // }

    public function Loguear($mail, $pass) {
  		require_once("funciones.php");
  		$usuario = buscarPorEmail($mail);

  		if($usuario) {
  			if(password_verify($pass, $usuario->getAttr('password'))) {
  				$_SESSION['id'] = $usuario->getAttr('id');
  				setcookie('id', $usuario->getAttr('id'), time() + 3600);
  				header('location: perfil.php');
  				//exit;
  			}
  		}
      return false;
    }

    // public function Actualizar($nombre, $email, $pass, $edad, $tel, $pais, $idioma, $website, $mensaje, $sexo){
    //   try{
    //     $db = dbConnect();
    //     $query = "update users set name = '{$nombre}', email = '{$email}', password = '{$pass}', age = '{$edad}', telephone = '{$tel}',
    //               country = '{$pais}', language = '{$idioma}', website = '{$website}', message = '{$mensaje}', sex = '{$sexo}'
    //               where email like '{$this->email}'";
    //     $ConsultaALaBase = $db->prepare($query);
    //     $ConsultaALaBase->execute();
    //   }catch(PDOException $Exception){
    //     echo $Exception->getMessage();
    //   }
    //   $this->name = $nombre;
    //   $this->email = $email;
    //   $this->pass = $pass;
    //   $this->age = $edad;
    //   $this->telephone = $tel;
    //   $this->country = $pais;
    //   $this->language = $language;
    //   $this->website = $website;
    //   $this->message = $mensaje;
    //   $this->sex = $sexo;
    //   //$this->photo = $foto;
    //
    //   header('location: VerUsuarios.php');
    //   echo "Los datos se guardaron exitosamente !";
    //   exit;
    // }

    // public function Eliminar(){
    //   try{
    //     $db = dbConnect();
    // 		$query = "delete from users where user_id like '{$this->user_id}'";
    // 		$ConsultaALaBase = $db->prepare($query);
    // 		$ConsultaALaBase->execute();
    //   }catch(PDOException $Exception){
    //     echo $Exception->getMessage();
    //   }
    //
    //   header('location: VerUsuarios.php');
    //   exit;
    // }
  }
?>
