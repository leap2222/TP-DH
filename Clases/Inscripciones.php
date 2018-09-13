<?php

  class Inscripciones {

    public static $Cantidad;
    public static $TodasLasInscripciones;
    public static $TodosLosEventosDelUsuario;

    public static function Guardar($nuevaInscripcion){
      self::$TodasLasInscripciones[] = $nuevaInscripcion;
    }

    public static function ObtenerTodas($event_id) {
      if (!isset(self::$TodasLasInscripciones)) {
        if($db = dbConnect()) {
          $CadenaDeBusqueda = "SELECT id, event_id, user_id FROM tpi_db.inscriptions where event_id = '{$event_id}' order by id";
          $ConsultaALaBase = $db->prepare($CadenaDeBusqueda);
          $ConsultaALaBase->execute();
        } else {
          echo "Conexion fallida";
          exit;
        }

        self::$TodasLasInscripciones = array();

        while ($unRegistro = $ConsultaALaBase->fetch(PDO::FETCH_ASSOC)) {
          $inscripcion = new inscripcion($unRegistro);

          self::$TodasLasInscripciones[] = $inscripcion;
        }
      }
      return self::$TodasLasInscripciones;
    }

    public static function ObtenerTodosLosEventos($user_id) {
      if (!isset(self::$TodosLosEventosDelUsuario)) {
        if($db = dbConnect()) {
          $CadenaDeBusqueda = "SELECT id, event_id, user_id FROM tpi_db.inscriptions where user_id = '{$user_id}' order by id";
          $ConsultaALaBase = $db->prepare($CadenaDeBusqueda);
          $ConsultaALaBase->execute();
        } else {
          echo "Conexion fallida";
          exit;
        }

        self::$TodosLosEventosDelUsuario = array();

        while ($unRegistro = $ConsultaALaBase->fetch(PDO::FETCH_ASSOC)) {
          $inscripcion = new inscripcion($unRegistro);

          self::$TodosLosEventosDelUsuario[] = $inscripcion;
        }
      }

      return self::$TodosLosEventosDelUsuario;
    }
  }

?>
