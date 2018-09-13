<?php

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

            //Declaro el array de objetos Pelicula
            $usuariosInscriptos = array();

            if(!($conn = dbConnect())) {
              echo "Conexión fallida. Usuarios::ObtenerTodos.";
              exit;
            }

            $unaInscripcion = new inscripcion(null, $conn);
            $unaInscripcion->find($event_id);


            //Recorro cada registro que obtuve

            while($unRegistro = $unaInscripcion->find($unaInscripcion->table, $event_id)) {

                  $unUsuario = new usuario(null, $conn);

                  $unRegistroUser = $unUsuario->find($unRegistro['user_id']);

                  $unUsuario = new usuario($unRegistroUser, $conn);

                  $usuariosInscriptos[] = $unUsuario;
            }


            //Guardo las variables globales de la clase de entidad, para no tener que volverlas a llenar
            self::$Cantidad = count($usuariosInscriptos);
            self::$TodasLasInscripciones = $usuariosInscriptos;

        } else {
            //La lista ya había sido llenada con anterioridad, no la vuelvo a llenar
            $usuariosInscriptos = self::$TodasLasInscripciones;
        }

        //Devuelvo el array ya rellenado
        // print_r($usuariosInscriptos);exit;
        return $usuariosInscriptos;
      }

      // public static function getTodas(){
      //   return self::$TodasLasInscripciones;
      // }


      public static function ObtenerTodosLosEventos($user_id) {

          //Me fijo si la lista había sido obtenida previamente, para no hacerlo de nuevo.
          if (!isset(self::$TodosLosEventosDelUsuario)) {

              //Declaro el array de objetos Pelicula
              $eventosDelUsuario = array();

              if(!($conn = dbConnect())) {
                echo "Conexión fallida. Usuarios::ObtenerTodos.";
                exit;
              }

              $unaInscripcion = new inscripcion(null, $conn);

              //Recorro cada registro que obtuve
              while($unRegistro = $unaInscripcion->find($unaInscripcion->table, $user_id)) {

                  $unEvento = new evento(null, $conn);

                  $unRegistroEvent = $unEvento->find($unEvento->table, $unRegistro['event_id']);

                  $unEvento = new evento($unRegistroEvent, $conn);

                  $eventosDelUsuario[] = $unEvento;
              }

              //Guardo las variables globales de la clase de entidad, para no tener que volverlas a llenar
              self::$Cantidad = count($eventosDelUsuario);
              self::$TodosLosEventosDelUsuario = $eventosDelUsuario;

          } else {
              //La lista ya había sido llenada con anterioridad, no la vuelvo a llenar
              $eventosDelUsuario = self::$TodosLosEventosDelUsuario;
          }

          //Devuelvo el array ya rellenado
          return $eventosDelUsuario;
        }
  }

?>
