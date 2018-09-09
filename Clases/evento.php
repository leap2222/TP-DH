<?php
  require_once('DB.php');
  //require 'JSON_DB.php';
  require_once('MySQL_DB.php');
  require_once('Modelo.php');

  class evento extends Modelo{

    public $table = 'events';
    public $columns = ['id', 'name', 'site', 'language', 'status_id'];


    public function getId(){
      return $this->getAttr('id');
    }

    public function getName(){
      return $this->getAttr('name');
    }

    public function getSite(){
      return $this->getAttr('site');
    }

    public function getLanguage(){
      return $this->getAttr('language');
    }

    public function getStatus(){
      return $this->getAttr('status_id');
    }

    public function setStatus($newStatus){
      $this->setAttr('status_id', $newStatus);
    }

    public function setInscripcion($nuevaInscripcion){
      $this->inscripciones[] = $nuevaInscripcion;
    }

    public function getInscripciones(){
      return $this->inscripciones; // Si esta seteado, si no levantar de la base
    }

    public function setComentario($unComentario){
      $this->comentarios[] = $unComentario;
    }

    public function getComentarios(){
      return $this->$comentarios;
    }

    public function EstaInscripto($user_id){

        $unRegistro = $this->db->EstaInscripto($user_id, $this->getAttr('id'));

        if($unRegistro){
          return true;
        }
        else{
          return false;
        }
    }
  }
?>
