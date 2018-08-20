<?php
  require_once("connect.php");
  // Método guardar(), registrará una película en la base de datos a través de un form.
  class inscripcion {

    private $id;
    private $event_id;
    private $user_id;

    public function __construct($id, $event_id, $user_id){
      $this->id = $id;
      $this->event_id = $event_id;
      $this->user_id = $user_id;
    }

    public function getInscriptionId(){
      return $this->id;
    }

    public function getEventId(){
      return $this->event_id;
    }

    public function getUserId(){
      return $this->user_id;
    }


    public function Guardar(){
      try{
        $db = dbConnect();
    		$query = "INSERT into tpi_db.inscriptions (user_id, event_id)
                  values ('{$this->user_id}', '{$this->event_id}')";
    		$ConsultaALaBase = $db->prepare($query);
    		$ConsultaALaBase->execute();
      }catch(PDOException $Exception){
        echo $Exception->getMessage();
      }
    }


    // public function Actualizar($event_id, $user_id){
    //   try{
    //     $db = dbConnect();
    // 		$query = "UPDATE inscriptions set event_id = '{$event_id}', user_id = '{$user_id}'
    //               where event_id = '{$this->event_id}'";
    // 		$ConsultaALaBase = $db->prepare($query);
    // 		$ConsultaALaBase->execute();
    //   }catch(PDOException $Exception){
    //     echo $Exception->getMessage();
    //   }
    //   $this->event_id = $event_id;
    //   $this->user_id = $user_id;
    //
    //   header('location: VerInscripciones.php'); //crear
    //   exit;
    // }

    public function Eliminar(){
      try{
        $db = dbConnect();
    		$query = "DELETE from tpi_db.inscriptions where event_id = '{$this->event_id}' and user_id = '{$this->user_id}'";
    		$ConsultaALaBase = $db->prepare($query);
    		$ConsultaALaBase->execute();
      }catch(PDOException $Exception){
        echo $Exception->getMessage();
      }
    }
  }
?>
