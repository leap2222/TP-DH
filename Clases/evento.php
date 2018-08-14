<?php
  require_once("connect.php");
  // Método guardar(), registrará una película en la base de datos a través de un form.
  class evento {

    private $event_id;
    private $name;
    private $site;
    private $language;
    private $status;
    private $inscripciones;
    private $comentarios;


    public function __construct($event_id, $name, $site, $language){
      $this->event_id = $event_id;
      $this->name = $name;
      $this->site = $site;
      $this->language = $language;
    }

    public function getId(){
      return $this->event_id;
    }

    public function getName(){
      return $this->name;
    }

    public function getSite(){
      return $this->site;
    }

    public function getLanguage(){
      return $this->language;
    }

    public function getStatus(){
      return $this->status;
    }

    public function setStatus($newStatus){
      $this->status = $newStatus;
    }

    public function setInscripcion($nuevaInscripcion){
      $this->inscripciones[] = $nuevaInscripcion;
    }

    public function getInscripciones(){
      return $this->inscripciones;
    }

    public function setComentario($unComentario){
      $this->comentarios[] = $unComentario;
    }

    public function getComentarios(){
      return $this->$comentarios;
    }

    public function Guardar(){

      try{
        $db = dbConnect();
    		$query = "insert into tpi_db.events (name, site, language)
                  values ('{$this->name}', '{$this->site}', '{$this->language}')";
    		$ConsultaALaBase = $db->prepare($query);
    		$ConsultaALaBase->execute();
      }catch(PDOException $Exception){
        echo $Exception->getMessage();
      }
    }

    public function Actualizar($name, $site, $language){
      try{
        $db = dbConnect();
    		$query = "update events set name = '{$name}', site = '{$site}', language = '{$language}'
                  where name like '{$this->name}'";
    		$ConsultaALaBase = $db->prepare($query);
    		$ConsultaALaBase->execute();
      }catch(PDOException $Exception){
        echo $Exception->getMessage();
      }
      $this->name = $name;
      $this->site = $site;
      $this->language = $language;

      header('location: VerEventos.php');
      echo "Los datos se guardaron exitosamente !";
      exit;
    }

    public function Eliminar(){
      try{
        $db = dbConnect();
    		$query = "delete from events where event_id like '{$this->event_id}'";
    		$ConsultaALaBase = $db->prepare($query);
    		$ConsultaALaBase->execute();
      }catch(PDOException $Exception){
        echo $Exception->getMessage();
      }

      header('location: VerEventos.php');
      exit;
    }
  }
?>
