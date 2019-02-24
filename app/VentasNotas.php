<?php

namespace SisVentas;

use Illuminate\Database\Eloquent\Model;

class VentasNotas extends Model
{
    protected $table = 'ventas_notas';
    public $primaryKey = 'Num_Nota';
    public $timestamps=false;
}
