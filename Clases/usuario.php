<?php
  class usuario{
    private $id;
    private $name;
    private $email;
    private $pass;

    public function __construct($id, $name, $email, $pass){
      $this->id = $id;
      $this->name = $name;
      $this->email = $email;
      $this->pass = $pass;
    }

    public function getID(){
      return $this->id;
    }

    public function getName(){
      return $this->name;
    }

    public function getEmail(){
      return $this->email;
    }

    public function getPass(){
      return $this->pass;
    }

    public function Registrar(){

      require_once("connect.php");
      try{
        $db = dbConnect();
    		$query = "insert into movies_db.users (name, email, password)
                  values ('{$this->name}', '{$this->email}', '{$this->pass}')";
    		$ConsultaALaBase = $db->prepare($query);
    		$ConsultaALaBase->execute();
      }catch(PDOException $Exception){
        echo $Exception->getMessage();
      }
    }

    public function Loguear($mail, $pass) {
      require_once("funciones.php");
      $usuario = buscarPorEmail($mail);

      if($usuario) {
        if(password_verify($pass, $usuario["pass"])) {
          setcookie('id', $usuario->getID(), time() + 3600);
          header('location: home.php');
    			exit;
        }
      }

      return false;
    }
  }
?>
