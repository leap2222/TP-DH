<?php
  require 'DB.php';
  //require 'JSON_DB.php';
  require 'MySQL_DB.php';
  require 'Modelo.php';

  class usuario extends Modelo{

    public $table = 'users';
    public $columns = ['id', 'name', 'email', 'password', 'age', 'telephone', 'country', 'website', 'message', 'sex', 'language', 'role_id'];


    public function getId() {
       return $this->getAttr('id');
    }

    public function getName(){
       return $this->getAttr('name');
    }

    public function getEmail(){
       return $this->getAttr('email');
    }

    public function getPass(){
       return $this->getAttr('password');
    }

    public function getAge(){
       return $this->getAttr('age');
    }

    public function getTelephone(){
       return $this->getAttr('telephone');
    }

    public function getCountry(){
       return $this->getAttr('country');
    }

    public function getWebsite(){
      return $this->getAttr('website');
    }

    public function getMessage(){
      return $this->getAttr('message');
    }

    public function getSex(){
      return $this->getAttr('sex');
    }

    public function getLanguage(){
      return $this->getAttr('language');
    }

    public function getRole(){
      return $this->getAttr('role_id');
    }

    public function getPhoto(){
      return $this->getAttr('photo');
    }

    public function isAdmin() {
      return $this->getAttr('role_id') == 1;
    }

    public function findByEmail($email){
      $reg = $this->db->findByEmail($email);
      // print_r($reg);exit;
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

  }
?>
