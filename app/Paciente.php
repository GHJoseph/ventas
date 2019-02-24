<?php

namespace SisVentas;

use Illuminate\Database\Eloquent\Model;

class Paciente extends Model{
    
    public $table='pacientes_maestro';
    
    public $primaryKey = 'Cod_Pac';
    
    public $timestamps=false;

  //   protected $fillable=[
  //   'Cod_CP',
  //   'Nom_CP',
  //   'Ape_CP',
  // ];
    
}
