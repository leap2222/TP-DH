<?php

  class Comentarios {
    public static $Cantidad;
    public static $TodosLosComentarios;
    public static $TodosLosComentariosDelUsuario;

    public static function Guardar($nuevoComentario){
      self::$TodosLosComentarios[] = $nuevoComentario;
    }

    public static function ObtenerTodos($event_id) {

        //Me fijo si la lista había sido obtenida previamente, para no hacerlo de nuevo.
        if (!isset(self::$TodosLosComentarios)) {

            //Me conecto a la base de datos
            require_once("connect.php");
            if($db = dbConnect()) {
              // Ejecuto la lectura
              $CadenaDeBusqueda = "SELECT idcomment, event_id, user_id, comment FROM tpi_db.comments where event_id = '{$event_id}'";
              $ConsultaALaBase = $db->prepare($CadenaDeBusqueda);
              $ConsultaALaBase->execute();
              //$ComentariosADevolver = $ConsultaALaBase->fetchAll(PDO::FETCH_ASSOC); //Esto devuelve un array de array

            } else {
                echo "Conexion fallida";
              }

            //Declaro el array de objetos Pelicula
            $ComentariosADevolver = array();

            //Recorro cada registro que obtuve
            while ($unRegistro = $ConsultaALaBase->fetch(PDO::FETCH_ASSOC)) {

                //Instancio un objeto de tipo Pelicula
                require_once("Clases/comentario.php");
                $unComentario = new comentario($unRegistro['idcomment'], $unRegistro['event_id'], $unRegistro['user_id'], $unRegistro['comment']);

                //Agrego el objeto Pelicula al array
                $ComentariosADevolver[] = $unComentario;
            }

            //Guardo las variables globales de la clase de entidad, para no tener que volverlas a llenar
            self::$Cantidad = count($ComentariosADevolver);
            self::$TodosLosComentarios = $ComentariosADevolver;

        } else {
            //La lista ya había sido llenada con anterioridad, no la vuelvo a llenar
            $ComentariosADevolver = self::$TodosLosComentarios;
        }

        //Devuelvo el array ya rellenado
        return $ComentariosADevolver;
      }

      public static function getTodos(){
        return self::$TodosLosComentarios;
      }


      public static function ComentariosDelUsuario($user_id) {

          //Me fijo si la lista había sido obtenida previamente, para no hacerlo de nuevo.
          if (!isset(self::$TodosLosComentariosDelUsuario)) {

              //Me conecto a la base de datos
              require_once("connect.php");
              if($db = dbConnect()) {
                // Ejecuto la lectura
                $CadenaDeBusqueda = "SELECT idcomment, event_id, user_id, comment FROM tpi_db.comments where user_id = '{$user_id}'";
                $ConsultaALaBase = $db->prepare($CadenaDeBusqueda);
                $ConsultaALaBase->execute();
                //$ComentariosADevolver = $ConsultaALaBase->fetchAll(PDO::FETCH_ASSOC); //Esto devuelve un array de array

              } else {
                  echo "Conexion fallida";
                }

              //Declaro el array de objetos Pelicula
              $ComentariosADevolver = array();

              //Recorro cada registro que obtuve
              while ($unRegistro = $ConsultaALaBase->fetch(PDO::FETCH_ASSOC)) {

                  require_once("Clases/comentario.php");
                  $unComentario = new comentario($unRegistro['idcomment'], $unRegistro['event_id'], $unRegistro['user_id'], $unRegistro['comment']);

                  //Agrego el objeto Pelicula al array
                  $ComentariosADevolver[] = $unComentario;
              }

              //Guardo las variables globales de la clase de entidad, para no tener que volverlas a llenar
              self::$Cantidad = count($ComentariosADevolver);
              self::$TodosLosComentariosDelUsuario = $ComentariosADevolver;

          } else {
              //La lista ya había sido llenada con anterioridad, no la vuelvo a llenar
              $ComentariosADevolver = self::$TodosLosComentariosDelUsuario;
          }

          //Devuelvo el array ya rellenado
          return $ComentariosADevolver;
        }
  }

?>
