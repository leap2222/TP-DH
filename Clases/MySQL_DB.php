<?php

class MySQL_DB extends DB
{
  protected $conn;

  public function __construct()
  {
    try {
      $this->conn = new PDO('mysql:host=localhost;dbname=tpi_db', 'root', 'root');
      $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (Exception $e) {
      echo $e->getMessage();
      exit;
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
    $sql = 'delete from'.$tabla.'where id = '. $id;

    try {
      $stmt = $this->conn->prepare($sql);
      $stmt->execute();
    } catch(Exception $e) {
      $e->getMessage();
    }
  }


  public function find($tabla, $id)
  {
    $sql = 'select * from '.$tabla.' where id = :id'; //fecth

    try {
      $stmt = $this->conn->prepare($sql);
      $stmt->bindValue(':id', $id);
      $stmt->execute();
    } catch(Exception $e) {
      $e->getMessage();
    }

    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function findByEmail($email)
  {
    $sql = 'select * from tpi_db.users where email like :email'; //fecth

    try {
      $stmt = $this->conn->prepare($sql);
      $stmt->bindValue(':email', $email);
      $stmt->execute();
    } catch (Exception $e) {
      $e->getMessage();
    }

    return $stmt->fetch(PDO::FETCH_ASSOC);
  }
  // $datos = [
  //   'nombre' => 'Bronco',
  //   'especie' => 'Dog',
  //   'humano_id' => 1
  // ];
  // insert('humanos', $datos);
  // update('mascotas', $datos, 1);

  // $mascota = find('mascotas', 2);
  // var_dump($mascota);
}
