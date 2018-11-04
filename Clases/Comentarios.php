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
            if($db = dbConnect()) {
              // Ejecuto la lectura
              $CadenaDeBusqueda = "SELECT comments.id, event_id, user_id, parent_id, text, users.name, users.photo FROM tpi_db.comments left join tpi_db.users on comments.user_id = users.id where event_id = '{$event_id}' order by comments.id";
              $ConsultaALaBase = $db->prepare($CadenaDeBusqueda);
              $ConsultaALaBase->execute();
              //$ComentariosADevolver = $ConsultaALaBase->fetchAll(PDO::FETCH_ASSOC); //Esto devuelve un array de array

            } else {
                echo "Conexion fallida";
                exit;
              }

            //Declaro el array de objetos Pelicula
            $ComentariosADevolver = array();

            //Recorro cada registro que obtuve
            while ($unRegistro = $ConsultaALaBase->fetch(PDO::FETCH_ASSOC)) {

                //Instancio un objeto de tipo Pelicula
                $unComentario = new comentario();
                $unComentario->id = $unRegistro['id'];
                $unComentario->event_id = $unRegistro['event_id'];
                $unComentario->user_id = $unRegistro['user_id'];
                $unComentario->parent_id = $unRegistro['parent_id'];
                $unComentario->comment = $unRegistro['text'];
                $unComentario->user_name = $unRegistro['name'];
                $unComentario->user_photo = $unRegistro['photo'];

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
              if($db = dbConnect()) {
                // Ejecuto la lectura
                $CadenaDeBusqueda = "SELECT comments.id, event_id, user_id, parent_id, comment, timestamp, users.name, users.photo FROM tpi_db.comments left join tpi_db.users on comments.user_id = users.id where user_id = '{$user_id}' order by comments.id";
                $ConsultaALaBase = $db->prepare($CadenaDeBusqueda);
                $ConsultaALaBase->execute();
                //$ComentariosADevolver = $ConsultaALaBase->fetchAll(PDO::FETCH_ASSOC); //Esto devuelve un array de array

              } else {
                  echo "Conexion fallida";
                  exit;
                }

              //Declaro el array de objetos Pelicula
              $ComentariosADevolver = array();

              //Recorro cada registro que obtuve
              while ($unRegistro = $ConsultaALaBase->fetch(PDO::FETCH_ASSOC)) {

                  $unComentario = new comentario();
                  $unComentario->id = $unRegistro['comments.id'];
                  $unComentario->event_id = $unRegistro['event_id'];
                  $unComentario->user_id = $unRegistro['user_id'];
                  $unComentario->parent_id = $unRegistro['parent_id'];
                  $unComentario->comment = $unRegistro['comment'];
                  $unComentario->timestamp = $unRegistro['timestamp'];
                  $unComentario->user_name = $unRegistro['users.name'];
                  $unComentario->user_photo = $unRegistro['users.photo'];

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
