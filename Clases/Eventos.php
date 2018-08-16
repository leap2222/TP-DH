<?php
  require_once("connect.php");
  require_once("Clases/evento.php");

  class Eventos {
    public static $Cantidad;
    public static $TodosLosEventos;

    public static function ObtenerTodos() {
      //Me fijo si la lista había sido obtenida previamente, para no hacerlo de nuevo.
      if (!isset(self::$TodosLosEventos)) {
        //Me conecto a la base de datos
        if($db = dbConnect()) {
          $ConsultaALaBase = $db->prepare("SELECT id, name, site, language FROM tpi_db.events");
          $ConsultaALaBase->execute();
        } else {
          echo "Conexion fallida";
          exit;
        }

        $EventosADevolver = array();

        //Recorro cada registro que obtuve
        while ($UnRegistro = $ConsultaALaBase->fetch(PDO::FETCH_ASSOC)) {
          $EventosADevolver[] = new evento($UnRegistro['id'], $UnRegistro['name'], $UnRegistro['site'], $UnRegistro['language']);
        }

        //Guardo los eventos para despues.
        self::$Cantidad = count($EventosADevolver);
        self::$TodosLosEventos = $EventosADevolver;
        return self::$TodosLosEventos;
      } else {
        //La lista ya estaba cargada.
        return self::$TodosLosEventos;
      }
    }
  }


/// funciones que no estan en la clase pero que habria que integrarlas.

  function validarDatosEvento($data){
    $errores = [];

    $name = isset($data['name']) ? trim($data['name']) : "";
    $site = isset($data['site']) ? trim($data['site']) : "0";
    $language = isset($data['language']) ? trim($data['language']) : "0";

    if ($name == ''){
      $errores['name'] = "Completa el nombre del Evento";
    }elseif (buscarEvento($name)) {
      $errores['name'] = "Este Evento ya existe";
    }

    if($site == ''){
      $errores['site'] = "Debe ingresar la dirección del lugar";
    }

    if($language == ''){
      $errores['language'] = "Debe ingresar el idioma preferido del evento";
    }

    return $errores;
  }


  function buscarEvento($id){
    if($db = dbConnect()) {
      $ConsultaALaBase = $db->prepare("SELECT id, name, site, language FROM events WHERE id like :id");
      $ConsultaALaBase->bindParam(':id', $id);
      $ConsultaALaBase->execute();
    } else {
      echo "Conexion fallida";
      exit;
    }

    $Registro = $ConsultaALaBase->fetch(PDO::FETCH_ASSOC);

    if($Registro){
      return new evento($Registro['id'], $Registro['name'], $Registro['site'], $Registro['language']);
    }

    return false;
  }


  function validarDatosEventoParaEditar($data){
    $errores = [];

    $name = isset($_POST['name']) ? trim($_POST['name']) : "";
    $site = isset($_POST['site']) ? trim($_POST['site']) : "0";
    $language = isset($_POST['language']) ? trim($_POST['language']) : "0";

    if ($name == ''){
      $errores['name'] = "Completa el nombre del Evento";
    }

    if($site == ''){
      $errores['site'] = "Debe ingresar la dirección del Evento";
    }

    if($language == ''){
      $errores['language'] = "Debe ingresar el idioma del Evento";
    }

    return $errores;
  }

  function guardarEvento($data) {
    $name = trim($data['name']);
    $site = trim($data['site']);
    $language = trim($data['language']);

    //Crear el objeto
    $unEvento = new evento(null, $name, $site, $language);

    //Guardar en la Base
    $unEvento->Guardar();
    return $unEvento;
  }

?>
