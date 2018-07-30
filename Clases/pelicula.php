<?php
  require_once("connect.php");
  // Método guardar(), registrará una película en la base de datos a través de un form.
  class pelicula {

    private $title;
    private $rating;
    private $awards;
    private $release_date;
    private $genre_id;

    public function getTitle(){
      return $this->title;
    }

    public function getRating(){
      return $this->rating;
    }

    public function getAwards(){
      return $this->awards;
    }

    public function getReleaseDate(){
      return $this->release_date;
    }

    public function getGenreID(){
      return $this->genre_id;
    }


    public function __construct($title, $rating, $awards, $release_date, $genre_id){
      $this->title = $title;
      $this->rating = $rating;
      $this->awards = $awards;
      $this->release_date = $release_date;
      $this->genre_id = $genre_id;
    }

    public function Guardar(){

      try{
        $db = dbConnect();
    		$query = "insert into movies_db.movies (title, rating, awards, release_date, genre_id)
                  values ('{$this->title}', '{$this->rating}', '{$this->awards}', '{$this->release_date}', '{$this->genre_id}')";
    		$ConsultaALaBase = $db->prepare($query);
    		$ConsultaALaBase->execute();
      }catch(PDOException $Exception){
        echo $Exception->getMessage();
      }
    }

    public function Actualizar($title, $rating, $awards, $release_date, $genero){
      try{
        $db = dbConnect();
    		$query = "update movies set title = '{$title}', rating = '{$rating}', awards = '{$awards}',
                  release_date = '{$release_date}', genre_id = '{$genero}' where title like '{$this->title}'";
    		$ConsultaALaBase = $db->prepare($query);
    		$ConsultaALaBase->execute();
      }catch(PDOException $Exception){
        echo $Exception->getMessage();
      }
      $this->title = $title;
      $this->rating = $rating;
      $this->awards = $awards;
      $this->release_date = $release_date;
      $this->genre_id = $genre_id;

      header('location: VerPeliculas.php');
      echo "Los datos se guardaron exitosamente !";
      exit;
    }
  }
?>
