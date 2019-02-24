<?php

namespace SisVentas;

use Illuminate\Database\Eloquent\Model;

class Articulo extends Model
{
   public $table='articulos_maestro';
    
    public $primaryKey = 'Cod_Art';
    
    public $timestamps=false;
    
    
    protected $fillable=[
    'Cod_Art',
    'Nom_Art',
    'Tip_Art',
  ];
}
