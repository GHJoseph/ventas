<?php

namespace SisVentas;

use Illuminate\Database\Eloquent\Model;

class ventasdetalletmp extends Model
{
    protected $table = 'ventas_detalle_tmp';
    public $primaryKey = 'Item_Vnt';
    public $timestamps=false;
}
