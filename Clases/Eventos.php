<?php
  // Tendrá una función que devuelve un array con un objeto película para todas las
  // películas que existen en la base.
  class Eventos {
    public static $Cantidad;
    public static $TodosLosEventos;

    public static function Guardar($nuevoEvento){
      self::$TodosLosEventos[] = $nuevoEvento;
      header('location: home.php');
      echo "Pelicula Creada exitosamente !";
      exit;
    }

    public static function ObtenerTodas() {

        //Me fijo si la lista había sido obtenida previamente, para no hacerlo de nuevo.
        if (!isset(self::$TodosLosEventos)) {

            //Me conecto a la base de datos
            require_once("connect.php");
            if($db = dbConnect()) {
              // Ejecuto la lectura
              // `event_id` int(10) unsigned NOT NULL AUTO_INCREMENT,
              // `name` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
              // `site` varchar(500) COLLATE utf8_unicode_ci NOT NULL,
              // `language` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
              $CadenaDeBusqueda = "SELECT event_id, name, site, language FROM events";
              $ConsultaALaBase = $db->prepare($CadenaDeBusqueda);
              $ConsultaALaBase->execute();
              //$EventosADevolver = $ConsultaALaBase->fetchAll(PDO::FETCH_ASSOC); //Esto devuelve un array de array

            } else {
                echo "Conexion fallida";
              }

            //Declaro el array de objetos Pelicula
            $EventosADevolver = array();

            //Recorro cada registro que obtuve
            while ($UnRegistro = $ConsultaALaBase->fetch(PDO::FETCH_ASSOC)) {

                //Instancio un objeto de tipo Pelicula
                require_once("Clases/evento.php");
                $UnEvento = new evento($UnRegistro['event_id'], $UnRegistro['name'], $UnRegistro['site'], $UnRegistro['language']);

                //Agrego el objeto Pelicula al array
                $EventosADevolver[] = $UnEvento;
            }

            //Guardo las variables globales de la clase de entidad, para no tener que volverlas a llenar
            self::$Cantidad = count($EventosADevolver);
            self::$TodosLosEventos = $EventosADevolver;

        } else {
            //La lista ya había sido llenada con anterioridad, no la vuelvo a llenar
            $EventosADevolver = self::$TodosLosEventos;
        }

        //Devuelvo el array ya rellenado
        return $EventosADevolver;
      }

      public static function getTodas(){
        return self::$TodosLosEventos;
      }
  }

?>
