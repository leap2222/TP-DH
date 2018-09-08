<?php
  class comentario extends Modelo{

    public $id;
    public $parent_id;
    public $event_id;
    public $user_id;
    public $comment;
    public $timestamp;
    public $user_name;
    public $user_photo;

    public $table = 'comments';
    public $columns = ['id', 'parent_id','event_id', 'user_id', 'comment', 'timestamp'];

    public function __construct() {

    }

    public function setReply($unaRespuesta){
      $this->respuestas[] = $unaRespuesta;
    }

    public function getId(){
      return $this->id;
    }

    public function getEventId(){
      return $this->event_id;
    }

    public function getParentId() {
      return $this->parent_id;
    }
    public function getUserId(){
      return $this->user_id;
    }

    public function getComment(){
      return $this->comment;
    }

    public function getTimestamp() {
      return $this->timestamp;
    }

    public function getUserName() {
      return $this->user_name;
    }

    public function getUserPhoto() {
      return $this->user_photo;
    }

    public function setId($id){
      return $this->id = $id;;
    }

    public function setEventId($event_id){
      return $this->event_id = $event_id;
    }

    public function setParentId($parent_id) {
      return $this->parent_id = $parent_id;
    }
    public function setUserId($user_id){
      return $this->user_id = $user_id;
    }

    public function setComment($comment){
      return $this->comment = $comment;
    }

    public function setTimestamp($timestamp) {
      return $this->timestamp = $timestamp;
    }

    public function Guardar(){
      try{
        $db = dbConnect();
    		$query = "INSERT into tpi_db.comments (event_id, user_id, parent_id, comment, timestamp)
                  values ('{$this->event_id}', '{$this->user_id}', '{$this->parent_id}', '{$this->comment}', '{$this->timestamp}')";
    		$ConsultaALaBase = $db->prepare($query);
    		$ConsultaALaBase->execute();
        $this->id = $db->lastInsertId();

      }catch(PDOException $Exception){
        echo "Comentario->guardar(); <br>";
        echo $Exception->getMessage();
        exit;
      }
    }

    public function Editar(){
      try{
        $db = dbConnect();
    		$query = "UPDATE tpi_db.comments set comment = '{$this->comment}'
                  where id = '{$this->id}'";
    		$ConsultaALaBase = $db->prepare($query);
    		$ConsultaALaBase->execute();
      }catch(PDOException $Exception){
        echo $Exception->getMessage();
        exit;
      }
      // header('location: VerEventos.php');
      // exit;
    }

    public function Eliminar(){
      try{
        $db = dbConnect();
    		$query = "DELETE from tpi_db.comments where id = '{$this->id}'";
    		$ConsultaALaBase = $db->prepare($query);
    		$ConsultaALaBase->execute();
      }catch(PDOException $Exception){
        echo $Exception->getMessage();
        exit;
      }
    }
  }
?>
