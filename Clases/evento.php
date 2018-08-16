<?php
  require_once("connect.php");

  class evento {

    private $id;
    private $name;
    private $site;
    private $language;
    private $status;
    private $inscripciones;
    private $comentarios;

    public function __construct($id, $name, $site, $language) {
      $this->id = $id;
      $this->name = $name;
      $this->site = $site;
      $this->language = $language;
    }

    public function getId() {
      return $this->id;
    }

    public function getName() {
      return $this->name;
    }

    public function getSite() {
      return $this->site;
    }

    public function getLanguage() {
      return $this->language;
    }

    public function getStatus() {
      return $this->status;
    }

    public function setStatus($newStatus) {
      $this->status = $newStatus;
    }

    public function setInscripcion($nuevaInscripcion) {
      $this->inscripciones[] = $nuevaInscripcion;
    }

    public function getInscripciones() {
      return $this->inscripciones;
    }

    public function setComentario($unComentario) {
      $this->comentarios[] = $unComentario;
    }

    public function getComentarios() {
      return $this->$comentarios;
    }

    public function Guardar() {
      try {
        $db = dbConnect();
    		$query = "insert into tpi_db.events (name, site, language, status) values (:name, :site, :language, 1)";
    		$ConsultaALaBase = $db->prepare($query);
        $ConsultaALaBase->bindParam(':name', $this->name);
        $ConsultaALaBase->bindParam(':site', $this->site);
        $ConsultaALaBase->bindParam(':language', $this->language);
    		$ConsultaALaBase->execute();
      }catch(PDOException $Exception) {
        echo $Exception->getMessage();
      }
    }

    public function Actualizar($name, $site, $language) {
      try {
        $db = dbConnect();
    		$query = "update events set name = :name, site = :site, language = :language where id like :id";
        $ConsultaALaBase = $db->prepare($query);
        $ConsultaALaBase->bindParam(':name', $name);
        $ConsultaALaBase->bindParam(':site', $site);
        $ConsultaALaBase->bindParam(':language', $language);
        $ConsultaALaBase->bindParam(':id', $this->id);
    		$ConsultaALaBase->execute();
      } catch(PDOException $Exception) {
        echo $Exception->getMessage();
        exit;
      }

      $this->name = $name;
      $this->site = $site;
      $this->language = $language;

      header('location: VerEventos.php');
      exit;
    }

    public function Eliminar() {
      try {
        $db = dbConnect();
    		$ConsultaALaBase = $db->prepare("delete from events where event_id like :id");
        $ConsultaALaBase->bindParam(':id', $this->id);
    		$ConsultaALaBase->execute();
      } catch(PDOException $Exception) {
        echo $Exception->getMessage();
        exit;
      }

      header('location: VerEventos.php');
      exit;
    }
  }
?>
