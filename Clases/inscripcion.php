<?php
  require_once("connect.php");

  class inscripcion {

    private $id;
    private $event_id;
    private $user_id;

    public function __construct($id, $event_id, $user_id) {
      $this->id = $id;
      $this->event_id = $event_id;
      $this->user_id = $user_id;
    }

    public function InscriptionId() {
      return $this->id;
    }

    public function getEventId() {
      return $this->event_id;
    }

    public function getUserId() {
      return $this->user_id;
    }


    public function Guardar() {
      try {
        $db = dbConnect();
    		$query = "insert into tpi_db.inscriptions (user_id, event_id) values (:event_id, :user_id)";
    		$ConsultaALaBase = $db->prepare($query);
        $ConsultaALaBase->bindParam(':event_id', $this->event_id);
        $ConsultaALaBase->bindParam(':user_id', $this->user_id);
    		$ConsultaALaBase->execute();
      } catch(PDOException $Exception) {
        echo $Exception->getMessage();
      }
    }

    public function Actualizar($event_id, $user_id) {
      try {
        $db = dbConnect();
    		$query = "update inscriptions set event_id = :event_id, user_id = :user_id where event_id like :event_id_anterior";
    		$ConsultaALaBase = $db->prepare($query);
        $ConsultaALaBase->bindParam(':event_id', $event_id);
        $ConsultaALaBase->bindParam(':user_id', $user_id);
        $ConsultaALaBase->bindParam(':event_id_anterior', $this->event_id);
    		$ConsultaALaBase->execute();
      } catch(PDOException $Exception) {
        echo $Exception->getMessage();
        exit;
      }
      $this->event_id = $event_id;
      $this->user_id = $user_id;

      header('location: VerInscripciones.php');
      exit;
    }


    public function Eliminar() {
      try {
        $db = dbConnect();
    		$query = "delete from inscriptions where event_id like :event_id";
    		$ConsultaALaBase = $db->prepare($query);
        $ConsultaALaBase->bindParam(':event_id', $this->event_id);
    		$ConsultaALaBase->execute();
      } catch(PDOException $Exception) {
        echo $Exception->getMessage();
        exit;
      }

      header('location: VerInscripciones.php');
      exit;
    }
  }
?>
