<?php
  // Tendrá una función que devuelve un array con un objeto película para todas las
  // películas que existen en la base.
  class Peliculas {
    public static $Cantidad;
    public static $TodasLasPeliculas;

    public static function Guardar($nuevaPelicula){
      self::$TodasLasPeliculas[] = $nuevaPelicula;
      header('location: home.php');
      echo "Pelicula Creada exitosamente !";
      exit;
    }

    public static function ObtenerTodas() {

        //Me fijo si la lista había sido obtenida previamente, para no hacerlo de nuevo.
        if (!isset(self::$TodasLasPeliculas)) {

            //Me conecto a la base de datos
            require_once("connect.php");
            if($db = dbConnect()) {
              //Ejecuto la lectura
              $CadenaDeBusqueda = "SELECT title, rating, awards, release_date, genre_id FROM movies";
              $ConsultaALaBase = $db->prepare($CadenaDeBusqueda);
              $ConsultaALaBase->execute();
              //$PeliculasADevolver = $ConsultaALaBase->fetchAll(PDO::FETCH_ASSOC); //Esto devuelve un array de array

            } else {
                echo "Conexion fallida";
              }

            //Declaro el array de objetos Pelicula
            $PeliculasADevolver = array();

            //Recorro cada registro que obtuve
            while ($UnRegistro = $ConsultaALaBase->fetch(PDO::FETCH_ASSOC)) {

                //Instancio un objeto de tipo Pelicula
                require_once("Clases/pelicula.php");
                $UnaPeli = new pelicula($UnRegistro['title'], $UnRegistro['rating'], $UnRegistro['awards'], $UnRegistro['release_date'], $UnRegistro['genre_id']);

                //Agrego el objeto Pelicula al array
                $PeliculasADevolver[] = $UnaPeli;
            }

            //Guardo las variables globales de la clase de entidad, para no tener que volverlas a llenar
            self::$Cantidad = count($PeliculasADevolver);
            self::$TodasLasPeliculas = $PeliculasADevolver;

        } else {
            //La lista ya había sido llenada con anterioridad, no la vuelvo a llenar
            $PeliculasADevolver = self::$TodasLasPeliculas;
        }

        //Devuelvo el array ya rellenado
      return $PeliculasADevolver;
      }

      public static function getTodas(){
        return self::$TodasLasPeliculas;
      }
  }

?>
