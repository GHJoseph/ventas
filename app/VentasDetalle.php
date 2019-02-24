<?php

namespace SisVentas;

use Illuminate\Database\Eloquent\Model;

class VentasDetalle extends Model
{
    protected $table = 'ventas_detalle';
    public $primaryKey = 'Item_Vnt';
    public $timestamps=false;


    
    
}
