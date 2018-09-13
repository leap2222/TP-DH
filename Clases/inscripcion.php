<?php
  class inscripcion extends Modelo{

    public $table = 'inscriptions';
    public $columns = ['id', 'user_id', 'event_id'];

    public function __construct($datos=[]) {
      $this->datos = $datos;
    }

    public function getInscriptionId(){
      return $this->getAttr('id');
    }

    public function getEventId(){
      return $this->getAttr('event_id');
    }

    public function getUserId(){
      return $this->getAttr('user_id');
    }

    public function Guardar(){
      try {
        $db = dbConnect();
     		$query = "INSERT into tpi_db.inscriptions (user_id, event_id)
                   values ('{$this->getUserId()}', '{$this->getEventId()}')";
     		$ConsultaALaBase = $db->prepare($query);
     		$ConsultaALaBase->execute();
      } catch(PDOException $Exception){
         echo $Exception->getMessage();
         exit;
      }
    }

    public function Eliminar() {
      try {
        $db = dbConnect();
     		$query = "DELETE from tpi_db.inscriptions where event_id = '{$this->getEventId()}' and user_id = '{$this->getUserId()}'";
     		$ConsultaALaBase = $db->prepare($query);
     		$ConsultaALaBase->execute();
       } catch(PDOException $Exception){
         echo $Exception->getMessage();
         exit;
       }
    }
  }
?>
