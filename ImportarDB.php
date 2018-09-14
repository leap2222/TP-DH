<?php

try {
  $db = dbConnect();
  $query = file_get_contents('script/tpi_db.sql');
  $ConsultaALaBase = $db->prepare($query);
  $ConsultaALaBase->execute();
  echo "Base cargada.";
} catch(PDOException $Exception){
  echo $Exception->getMessage();
  exit;
}

function dbConnect(){
  $ruta = 'mysql:host=localhost; dbname=tpi_db; charset=utf8; port=3306';
  $usuario = 'root';
  $password = 'root';
  $opciones = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");

  try {
    $conn = new PDO($ruta, $usuario, $password, $opciones);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $conn;
  }
  catch( PDOException $ErrorEnConexion ) {
    echo "Error DB, dbConnect(): ".$ErrorEnConexion->getMessage();
    return false;
  }
}
