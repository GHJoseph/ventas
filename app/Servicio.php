<?php

namespace SisVentas;

use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    public $table='servicios_maestro';
    
    public $primaryKey = 'Cod_Serv';
    
    public $timestamps=false;
}

