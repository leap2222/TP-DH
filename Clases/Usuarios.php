<?php

  require_once("usuario.php");

  class Usuarios {

    public static $Cantidad;
    public static $TodosLosUsuarios;

    // public $table = 'users';
    // public $columns = ['id', 'name', 'email', 'password', 'age', 'telephone', 'country', 'website', 'message', 'sex', 'language', 'role_id'];

    public static function isAdmin($email){
      foreach (Usuarios::ObtenerTodos() as $user) {
        if($user->getEmail() == $email){
          return ($user->getRole() == 1);
        }
      }
      return false;
    }

    public static function Guardar($nuevoUsuario){
      self::$TodosLosUsuarios[] = $nuevoUsuario;
    }

    public static function ObtenerTodos() {

      //Me fijo si la lista había sido obtenida previamente, para no hacerlo de nuevo.
      if (!isset(self::$TodosLosUsuarios)) {

        //Declaro el array de objetos Usuarios
        $UsuariosADevolver = array();

        $unUsuario = new usuario();

        //Recorro cada registro que obtuve
        while ($unRegistro = $unUsuario->select()) {

            //Instancio un objeto de tipo Usuario
        		$unUsuario = new usuario($unRegistro);

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
