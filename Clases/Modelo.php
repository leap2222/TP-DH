<?php


class Modelo
{
  public $table;
  public $columns;
  public $datos;
  protected $db;

  public function __construct($datos=[])
  {
    $this->datos = $datos;
    $this->db = new MySQL_DB();
    //$this->db = new JSON_DB();
  }

  public function save()
  {
    if (!$this->getAttr('id')) {
      $this->insert();
    } else {
      $this->update();
    }
  }

  private function insert()
  {
    $this->db->insert($this->datos, $this);
  }

  private function update(){
    $this->db->update($this->datos, $this, $this->datos['id']);
  }

  private function delete(){
    $this->db->delete($this, $this->datos['id']);
  }

  public function getAttr($attr)
  {
    return isset($this->datos[$attr]) ? $this->datos[$attr] : null;
  }

  public function setAttr($attr, $value)
  {
    $this->datos[$attr] = $value;
  }

  public function findByEmail($email){
    return $this->db->findByEmail($email);
  }

  public function find($id){
    $reg = $this->db->find($this->table, $id);

    if($reg){
      foreach ($reg as $attr => $value) {
        $this->setAttr($attr, $value);
      }
    }
  }
}
