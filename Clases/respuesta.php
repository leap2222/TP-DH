<?php
  require_once("connect.php");
  // Método guardar(), registrará una película en la base de datos a través de un form.
  class respuesta extends Modelo{

    private $id;
    private $idcomment;
    private $user_id;
    private $reply;
    public $table = 'replies';
    public $columns = ['idcomment', 'user_id', 'reply'];

    public function __construct($id, $idcomment, $user_id, $reply){
      $this->id = $id;
      $this->idcomment = $idcomment;
      $this->user_id = $user_id;
      $this->reply = $reply;
    }

    public function getId(){
      return $this->id;
    }

    public function getCommentId(){
      return $this->idcomment;
    }

    public function getUserId(){
      return $this->user_id;
    }

    public function getReply(){
      return $this->reply;
    }

    public function setReply($unaRespuesta){
      $this->reply[] = $unaRespuesta;
    }


    public function Guardar(){
      try{
        $db = dbConnect();
    		$query = "INSERT into tpi_db.replies (idcomment, user_id, reply)
                  VALUES ('{$this->idcomment}', '{$this->user_id}', '{$this->reply}')";
    		$ConsultaALaBase = $db->prepare($query);
    		$ConsultaALaBase->execute();
      }catch(PDOException $Exception){
        echo $Exception->getMessage();
      }
    }

    public function Editar(){
      try{
        $db = dbConnect();
    		$query = "UPDATE tpi_db.replies set reply = '{$this->reply}'
                  where idreply = '{$this->id}'";
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
    		$query = "DELETE from tpi_db.replies where idreply = '{$this->id}'";
    		$ConsultaALaBase = $db->prepare($query);
    		$ConsultaALaBase->execute();
      }catch(PDOException $Exception){
        echo $Exception->getMessage();
      }
    }
  }
?>
