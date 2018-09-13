<?php

  class Eventos {
    public static $Cantidad;
    public static $TodosLosEventos;

    public static function Guardar($nuevoEvento){
      self::$TodosLosEventos[] = $nuevoEvento;
    }

    public static function ObtenerTodos() {

        //Me fijo si la lista había sido obtenida previamente, para no hacerlo de nuevo.
        if (!isset(self::$TodosLosEventos)) {

            //Me conecto a la base de datos
            require_once("connect.php");
            if($db = dbConnect()) {
              // Ejecuto la lectura
              $CadenaDeBusqueda = "SELECT id, name, site, language FROM tpi_db.events";
              $ConsultaALaBase = $db->prepare($CadenaDeBusqueda);
              $ConsultaALaBase->execute();
              //$EventosADevolver = $ConsultaALaBase->fetchAll(PDO::FETCH_ASSOC); //Esto devuelve un array de array

            } else {
                echo "Conexion fallida";
                exit;
              }

            //Declaro el array de objetos Pelicula
            $EventosADevolver = array();

            //Recorro cada registro que obtuve
            while ($UnRegistro = $ConsultaALaBase->fetch(PDO::FETCH_ASSOC)) {

                //Instancio un objeto de tipo Pelicula
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
