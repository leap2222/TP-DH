<?php
  require_once("inscripcion.php");
  require_once("connect.php");

  class Inscripciones {
    public static $Cantidad;
    public static $TodasLasInscripciones;
    public static $TodosLosEventosDelUsuario;

    public static function Guardar($nuevaInscripcion){
      self::$TodasLasInscripciones[] = $nuevaInscripcion;
    }

    public static function ObtenerTodas($event_id) {

        //Me fijo si la lista había sido obtenida previamente, para no hacerlo de nuevo.
        if (!isset(self::$TodasLasInscripciones)) {

            //Me conecto a la base de datos
            if($db = dbConnect()) {
              // Ejecuto la lectura
              $CadenaDeBusqueda = "SELECT id, user_id, event_id FROM tpi_db.inscriptions where event_id = '{$event_id}'";
              $ConsultaALaBase = $db->prepare($CadenaDeBusqueda);
              $ConsultaALaBase->execute();
              //$InscripcionesADevolver = $ConsultaALaBase->fetchAll(PDO::FETCH_ASSOC); //Esto devuelve un array de array

            } else {
                echo "Conexion fallida";
                exit;
              }

            //Declaro el array de objetos Pelicula
            $InscripcionesADevolver = array();

            //Recorro cada registro que obtuve
            while ($UnRegistro = $ConsultaALaBase->fetch(PDO::FETCH_ASSOC)) {

                //Instancio un objeto de tipo Pelicula
                $unaInscripcion = new inscripcion($UnRegistro['id'], $UnRegistro['event_id'], $UnRegistro['user_id']);

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


      public static function ObtenerTodosLosEventos($user_id) {

          //Me fijo si la lista había sido obtenida previamente, para no hacerlo de nuevo.
          if (!isset(self::$TodosLosEventosDelUsuario)) {

              //Me conecto a la base de datos
              require_once("connect.php");
              if($db = dbConnect()) {
                // Ejecuto la lectura
                $CadenaDeBusqueda = "SELECT id, user_id, event_id FROM tpi_db.inscriptions where user_id = '{$user_id}'";
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
                  require_once("Clases/inscripcion.php");
                  $unaInscripcion = new inscripcion($UnRegistro['id'], $UnRegistro['event_id'], $UnRegistro['user_id']);

                  //Agrego el objeto Pelicula al array
                  $InscripcionesADevolver[] = $unaInscripcion;
              }

              //Guardo las variables globales de la clase de entidad, para no tener que volverlas a llenar
              self::$Cantidad = count($InscripcionesADevolver);
              self::$TodosLosEventosDelUsuario = $InscripcionesADevolver;

          } else {
              //La lista ya había sido llenada con anterioridad, no la vuelvo a llenar
              $InscripcionesADevolver = self::$TodosLosEventosDelUsuario;
          }

          //Devuelvo el array ya rellenado
          return $InscripcionesADevolver;
        }
  }

?>
