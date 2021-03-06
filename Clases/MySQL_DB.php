<?php

class MySQL_DB extends DB
{
  protected $conn;

  public function __construct($conn){

    if($conn){
      $this->conn = $conn;
    }else{
      try {
        $this->conn = new PDO('mysql:host=localhost; dbname=tpi_db; charset=utf8; port=3306', 'root', '', array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      } catch (Exception $e) {
        echo $e->getMessage();
        exit;
      }
    }
  }

  public function insert($datos, $modelo)
  {
    $columnas = '';
    $values = '';

    foreach ($datos as $key => $value) {
      if (in_array($key, $modelo->columns)) {
        $columnas .= $key . ',';
        $values .= '"' . $value . '",';
      }
    }

    $columnas = trim($columnas, ',');
    $values = trim($values, ',');
    $sql = 'insert into '.$modelo->table.' ('.$columnas.') values ('.$values.')';

    try {
      $stmt = $this->conn->prepare($sql);
      $stmt->execute();
    } catch(Exception $e) {
      $e->getMessage();
    }
  }


  public function update($datos, $tabla, $id)
  {
    //global $db;
    $set = '';

    foreach ($datos as $key => $value) {
      $set .= $key . '="' . $value . '",';
    }

    $set = trim($set, ',');
    $sql = 'update '.$tabla.' set ' . $set . ' where id = ' . $id;

    try {
      $stmt = $this->conn->prepare($sql);
      $stmt->execute();
    } catch(Exception $e) {
      $e->getMessage();
    }
  }

  public function delete($tabla, $id){
    $sql = 'delete from '.$tabla.' where id = '.$id;
    //$sql = "delete from {$tabla} where id = {$id}";
    //echo "$sql";exit;

    try {
      $stmt = $this->conn->prepare($sql);
      $stmt->execute();
    } catch(Exception $e) {
      $e->getMessage();
    }
  }


  public function select($tabla, $columnas, $modelo){

    $campos = '';

    foreach ($columnas as $value) {
      if (in_array($value, $modelo->columns)) {
        $campos .= $value . ',';
      }
    }

    $campos = trim($campos, ',');

    //$sql = "SELECT {$campos} FROM {$tabla}";
    $sql = 'select '.$campos.' from '.$tabla;
    //print_r($sql); exit;

    try {
      $ConsultaALaBase = $this->conn->prepare($sql);
      $ConsultaALaBase->execute();
    } catch (Exception $e) {
      $e->getMessage();
    }
    return $ConsultaALaBase->fetchAll(PDO::FETCH_ASSOC);
  }



  public function find($tabla, $id)
  {
    $sql = 'select * from '.$tabla.' where id = :id'; //fecth

    try {
      $stmt = $this->conn->prepare($sql);
      $stmt->bindValue(':id', $id);
      $stmt->execute();
    } catch(Exception $e) {
      echo "Error MySQL_DB->find();\n";
      $e->getMessage();
      exit;
    }

    // return $ConsultaALaBase->fetch(PDO::FETCH_ASSOC);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }


  public function findByEmail($email)
  {
    $sql = "SELECT id, name, email, password, age, telephone, country, website, message, sex, language, role_id from tpi_db.users where email like '{$email}'"; //fecth

    // if($db = dbConnect()){
    //     $ConsultaALaBase = $db->prepare($sql);
    //     $ConsultaALaBase->bindValue(':email', $email);
    //     $ConsultaALaBase->execute();
    // }else{
    //     echo "Conexion fallida";
    //     exit;
    //   }
    try {
      $stmt = $this->conn->prepare($sql);
      //$stmt->bindValue(':email', $email);
      $stmt->execute();
    } catch (Exception $e) {
      $e->getMessage();
    }

    // return $ConsultaALaBase->fetch(PDO::FETCH_ASSOC);
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }


  public function EstaInscripto($user_id, $event_id){

    $query = "SELECT user_id, event_id from tpi_db.inscriptions where user_id = '{$user_id}' and event_id = '{$event_id}'";

    try{
      $ConsultaALaBase = $this->conn->prepare($query);
      $ConsultaALaBase->execute();
    }catch(Exception $e){
      echo $e->getMessage();
    }

    return $ConsultaALaBase->fetch(PDO::FETCH_ASSOC);
  }
}
