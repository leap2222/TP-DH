<?php

abstract class DB
{
  abstract public function insert($datos, $modelo);

  abstract public function update($datos, $modelo, $id);

  abstract public function delete($modelo, $id);

  abstract public function select($table, $columns, $modelo);

  abstract public function find($table, $id);

}
