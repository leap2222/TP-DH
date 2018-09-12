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

            //Declaro el array de objetos Pelicula
            $TodosLosEventos = array();

            if(!($conn = dbConnect())) {
              echo "Conexión fallida. Eventos->ObtenerTodos.";
              exit;
            }

            //Recorro cada registro que obtuve
            $unEvento = new evento(null, $conn);
            $Registros = $unEvento->select();

            //Recorro cada registro que obtuve
            foreach($Registros as $unRegistro) {

                //Instancio un objeto de tipo Usuario
            		$unEvento = new evento($unRegistro, $conn);

                //Agrego el objeto Usuario al array
                $TodosLosEventos[] = $unEvento;
            }

            return $TodosLosEventos;



            //Guardo las variables globales de la clase de entidad, para no tener que volverlas a llenar
            self::$Cantidad = count($EventosADevolver);
            self::$TodosLosEventos = $EventosADevolver;

        } else {
            //La lista ya había sido llenada con anterioridad, no la vuelvo a llenar
            return self::$TodosLosEventos;
        }
      }

      public static function getTodas(){
        return self::$TodosLosEventos;
      }
  }

?>
