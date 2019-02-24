<?php

namespace SisVentas;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model{
       
    public $table='proveedores_maestro';
    
    public $primaryKey = 'Cod_Pro';
    
    public $timestamps=false;
    
}
