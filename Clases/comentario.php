<?php
  require_once("connect.php");
  // Método guardar(), registrará una película en la base de datos a través de un form.
  class comentario {

    private $id;
    private $event_id;
    private $user_id;
    private $comment;

    public function __construct($id, $event_id, $user_id, $comment){
      $this->id = $id;
      $this->event_id = $event_id;
      $this->user_id = $user_id;
      $this->comment = $comment;
    }

    public function getId(){
      return $this->id;
    }

    public function getEventId(){
      return $this->event_id;
    }

    public function getUserId(){
      return $this->user_id;
    }

    public function getComment(){
      return $this->comment;
    }

    public function Guardar(){
      try{
        $db = dbConnect();
    		$query = "INSERT into tpi_db.comments (event_id, user_id, comment)
                  values ('{$this->event_id}', '{$this->user_id}', '{$this->comment}')";
    		$ConsultaALaBase = $db->prepare($query);
    		$ConsultaALaBase->execute();
      }catch(PDOException $Exception){
        echo $Exception->getMessage();
      }
    }

    public function Editar(){
      try{
        $db = dbConnect();
    		$query = "UPDATE tpi_db.comments set comment = '{$this->comment}'
                  where idcomment = '{$this->id}'";
    		$ConsultaALaBase = $db->prepare($query);
    		$ConsultaALaBase->execute();
      }catch(PDOException $Exception){
        echo $Exception->getMessage();
      }

      header('location: VerEventos.php'); //crear
      exit;
    }

    public function Eliminar(){
      try{
        $db = dbConnect();
    		$query = "DELETE from tpi_db.comments where idcomment = '{$this->id}'";
    		$ConsultaALaBase = $db->prepare($query);
    		$ConsultaALaBase->execute();
      }catch(PDOException $Exception){
        echo $Exception->getMessage();
      }
    }
  }
?>
