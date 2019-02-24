<?php

namespace SisVentas;

use Illuminate\Database\Eloquent\Model;

class Personal extends Model{
    
    public $table='personal_maestro';
    
    public $primaryKey = 'Cod_Per';
    
    public $timestamps=false;
    
}
