<?php /*

  class Respuestas {
    public static $Cantidad;
    public static $TodasLasRespuestas;
    public static $TodasLasRespuestasDelUsuario;

    public static function Guardar($nuevaRespuesta){
      self::$TodasLasRespuestas[] = $nuevaRespuesta;
    }

    public static function ObtenerTodas($idComment) {

        //Me fijo si la lista había sido obtenida previamente, para no hacerlo de nuevo.
        if (!isset(self::$TodasLasRespuestas)) {

            //Me conecto a la base de datos
            require_once("connect.php");
            if($db = dbConnect()) {
              // Ejecuto la lectura
              $CadenaDeBusqueda = "SELECT id, idcomment, user_id, reply FROM tpi_db.replies where idcomment = '{$idComment}'";
              $ConsultaALaBase = $db->prepare($CadenaDeBusqueda);
              $ConsultaALaBase->execute();
              //$RespuestasADevolver = $ConsultaALaBase->fetchAll(PDO::FETCH_ASSOC); //Esto devuelve un array de array

            } else {
                echo "Conexion fallida";
              }

            //Declaro el array de objetos Pelicula
            $RespuestasADevolver = array();

            //Recorro cada registro que obtuve
            while ($unRegistro = $ConsultaALaBase->fetch(PDO::FETCH_ASSOC)) {

                //Instancio un objeto de tipo Pelicula
                require_once("Clases/respuesta.php");
                $unaRespuesta = new respuesta($unRegistro['id'], $unRegistro['idcomment'], $unRegistro['user_id'], $unRegistro['reply']);

                //Agrego el objeto Pelicula al array
                $RespuestasADevolver[] = $unaRespuesta;
            }

            //Guardo las variables globales de la clase de entidad, para no tener que volverlas a llenar
            self::$Cantidad = count($RespuestasADevolver);
            self::$TodasLasRespuestas = $RespuestasADevolver;

        } else {
            //La lista ya había sido llenada con anterioridad, no la vuelvo a llenar
            $RespuestasADevolver = self::$TodasLasRespuestas;
        }

        //Devuelvo el array ya rellenado
        return $RespuestasADevolver;
      }

      public static function getTodas(){
        return self::$TodasLasRespuestas;
      }

      // public static function RespuestasDelUsuario($user_id) {
      //
      //     //Me fijo si la lista había sido obtenida previamente, para no hacerlo de nuevo.
      //     if (!isset(self::$TodasLasRespuestasDelUsuario)) {
      //
      //         //Me conecto a la base de datos
      //         require_once("connect.php");
      //         if($db = dbConnect()) {
      //           // Ejecuto la lectura
      //           $CadenaDeBusqueda = "SELECT idcomment, event_id, user_id, comment FROM tpi_db.replies where user_id = '{$user_id}'";
      //           $ConsultaALaBase = $db->prepare($CadenaDeBusqueda);
      //           $ConsultaALaBase->execute();
      //           //$RespuestasADevolver = $ConsultaALaBase->fetchAll(PDO::FETCH_ASSOC); //Esto devuelve un array de array
      //
      //         } else {
      //             echo "Conexion fallida";
      //           }
      //
      //         //Declaro el array de objetos Pelicula
      //         $RespuestasADevolver = array();
      //
      //         //Recorro cada registro que obtuve
      //         while ($unRegistro = $ConsultaALaBase->fetch(PDO::FETCH_ASSOC)) {
      //
      //             require_once("Clases/comentario.php");
      //             $unaRespuesta = new respuesta($unRegistro['idcomment'], $unRegistro['event_id'], $unRegistro['user_id'], $unRegistro['comment']);
      //
      //             //Agrego el objeto Pelicula al array
      //             $RespuestasADevolver[] = $unaRespuesta;
      //         }
      //
      //         //Guardo las variables globales de la clase de entidad, para no tener que volverlas a llenar
      //         self::$Cantidad = count($RespuestasADevolver);
      //         self::$TodasLasRespuestasDelUsuario = $RespuestasADevolver;
      //
      //     } else {
      //         //La lista ya había sido llenada con anterioridad, no la vuelvo a llenar
      //         $RespuestasADevolver = self::$TodasLasRespuestasDelUsuario;
      //     }
      //
      //     //Devuelvo el array ya rellenado
      //     return $RespuestasADevolver;
      //   }
  }

*/ ?>
