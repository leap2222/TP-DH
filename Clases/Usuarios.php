<?php

  require_once("usuario.php");
  require_once("connect.php");
  ini_set('memory_limit', '5072M');

  class Usuarios {

    public static $Cantidad;
    public static $TodosLosUsuarios;

    public static function Guardar($nuevoUsuario){
      self::$TodosLosUsuarios[] = $nuevoUsuario;
    }

    public static function ObtenerTodos() {

      //Me fijo si la lista había sido obtenida previamente, para no hacerlo de nuevo.
      if (!isset(self::$TodosLosUsuarios)) {

        //Declaro el array de objetos Usuarios
        $UsuariosADevolver = array();

        if($conn = dbConnect()){
          $unUsuario = new usuario(null, $conn);
        }else {
          echo "Conexión fallida";
          exit;
        }

        //Recorro cada registro que obtuve
        while ($unRegistro = $unUsuario->select()) {

            //Instancio un objeto de tipo Usuario
        		$unUsuario = new usuario($unRegistro, $conn);

            //Agrego el objeto Usuario al array
            $UsuariosADevolver[] = $unUsuario;
        }

        //Guardo las variables globales de la clase de entidad, para no tener que volverlas a llenar
        self::$Cantidad = count($UsuariosADevolver);
        self::$TodosLosUsuarios = $UsuariosADevolver;

      } else {
        //La lista ya había sido llenada con anterioridad, no la vuelvo a llenar
        $UsuariosADevolver = self::$TodosLosUsuarios;
      }

      //Devuelvo el array ya rellenado
      return $UsuariosADevolver;
    }

    public static function getTodos(){
      return self::$TodosLosUsuarios;
    }
  }

?>
