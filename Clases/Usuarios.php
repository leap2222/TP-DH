<?php
// Tendrá un método que devuelve un array todos los nombres y mail de los usuarios
// registrados (NO MOSTRAR DATOS SENSIBLES)
  class Usuarios {

    public static $Cantidad;
    public static $TodosLosUsuarios;

    public static function Guardar($nuevoUsuario){
      self::$TodosLosUsuarios[] = $nuevoUsuario;
      header('location: home.php');
      exit;
    }

    public static function ObtenerTodos() {

      //Me fijo si la lista había sido obtenida previamente, para no hacerlo de nuevo.
      if (!isset(self::$TodasLosUsuarios)) {

        //Me conecto a la base de datos
        require_once("connect.php");

        if($db = dbConnect()) {
          //Ejecuto la lectura
          $CadenaDeBusqueda = "SELECT id, name, email, password FROM users";
          $ConsultaALaBase = $db->prepare($CadenaDeBusqueda);
          $ConsultaALaBase->execute();
          //$UsuariosADevolver = $ConsultaALaBase->fetchAll(PDO::FETCH_ASSOC);
        }
        else{
          echo "Conexion fallida";
        }

        //Declaro el array de objetos Usuarios
        $UsuariosADevolver = array();

        //Recorro cada registro que obtuve
        while ($unRegistro = $ConsultaALaBase->fetch(PDO::FETCH_ASSOC)) {

            //Instancio un objeto de tipo Usuario
            require_once("Clases/usuario.php");
            $UnUsuario = new usuario($unRegistro['id'], $unRegistro['name'], $unRegistro['email'], $unRegistro['password']);

            //Agrego el objeto Usuario al array
            $UsuariosADevolver[] = $UnUsuario;
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
