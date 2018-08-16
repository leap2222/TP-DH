<?php
  require_once("connect.php");
  require_once("Clases/evento.php");

  class Eventos {
    public static $Cantidad;
    public static $TodosLosEventos;

    public static function ObtenerTodos() {
      //Me fijo si la lista había sido obtenida previamente, para no hacerlo de nuevo.
      if (!isset(self::$TodosLosEventos)) {
        //Me conecto a la base de datos
        if($db = dbConnect()) {
          $ConsultaALaBase = $db->prepare("SELECT id, name, site, language FROM tpi_db.events");
          $ConsultaALaBase->execute();
        } else {
          echo "Conexion fallida";
          exit;
        }

        $EventosADevolver = array();

        //Recorro cada registro que obtuve
        while ($UnRegistro = $ConsultaALaBase->fetch(PDO::FETCH_ASSOC)) {
          $EventosADevolver[] = new evento($UnRegistro['id'], $UnRegistro['name'], $UnRegistro['site'], $UnRegistro['language']);
        }

        //Guardo los eventos para despues.
        self::$Cantidad = count($EventosADevolver);
        self::$TodosLosEventos = $EventosADevolver;
        return self::$TodosLosEventos;
      } else {
        //La lista ya estaba cargada.
        return self::$TodosLosEventos;
      }
    }
  }
?>
