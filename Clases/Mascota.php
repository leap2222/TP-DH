<?php

class Mascota extends Modelo
{
  public $table = 'mascotas';
  public $columns = ['nombre', 'especie', 'humano_id'];
}
