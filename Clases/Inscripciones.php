<?php

  class Inscripciones {
    public static $Cantidad;
    public static $TodasLasInscripciones;

    public static function Guardar($nuevaInscripcion){
      self::$TodasLasInscripciones[] = $nuevaInscripcion;
      header('location: perfil.php');
    }

    public static function ObtenerTodas($event_id) {

        //Me fijo si la lista había sido obtenida previamente, para no hacerlo de nuevo.
        if (!isset(self::$TodasLasInscripciones)) {

            //Me conecto a la base de datos
            require_once("connect.php");
            if($db = dbConnect()) {
              // Ejecuto la lectura
              $CadenaDeBusqueda = "SELECT id, user_id, event_id FROM tpi_db.inscriptions where event_id = '{$event_id}'";
              $ConsultaALaBase = $db->prepare($CadenaDeBusqueda);
              $ConsultaALaBase->execute();
              //$InscripcionesADevolver = $ConsultaALaBase->fetchAll(PDO::FETCH_ASSOC); //Esto devuelve un array de array

            } else {
                echo "Conexion fallida";
              }

            //Declaro el array de objetos Pelicula
            $InscripcionesADevolver = array();

            //Recorro cada registro que obtuve
            while ($UnRegistro = $ConsultaALaBase->fetch(PDO::FETCH_ASSOC)) {

                //Instancio un objeto de tipo Pelicula
                require_once("Clases/evento.php");
                $unaInscripcion = new inscripcion($UnRegistro['id'], $UnRegistro['user_id'], $UnRegistro['event_id']);

                //Agrego el objeto Pelicula al array
                $InscripcionesADevolver[] = $unaInscripcion;
            }

            //Guardo las variables globales de la clase de entidad, para no tener que volverlas a llenar
            self::$Cantidad = count($InscripcionesADevolver);
            self::$TodasLasInscripciones = $InscripcionesADevolver;

        } else {
            //La lista ya había sido llenada con anterioridad, no la vuelvo a llenar
            $InscripcionesADevolver = self::$TodasLasInscripciones;
        }

        //Devuelvo el array ya rellenado
        return $InscripcionesADevolver;
      }

      public static function getTodas(){
        return self::$TodasLasInscripciones;
      }
  }

?>