<?php

class JSON_DB extends DB
{

  private $file;

  public function __construct()
  {
    $this->file = __DIR__ . '/../vet.json';
  }

  public function insert($datos, $modelo)
  {
    $insert = [
      $modelo->table => $datos
    ];
    $insert = json_encode($insert);
    file_put_contents($this->file, $insert);
  }

  // public function update($datos, $modelo, $id){
  //
  // }
}
