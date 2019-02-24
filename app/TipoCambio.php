<?php

namespace SisVentas;

use Illuminate\Database\Eloquent\Model;

class TipoCambio extends Model
{
    public $table = 'monedas_tipos_cambios';

    public $timestamps = false;
    protected $fillable = [
        'Anno',
        'NumMes',
        'NumDia',
        'Cod_Mon',
        'Val_Cmp',
        'Val_Vta',
        'Usuario',
        'Fecha',
        'Operacion'
    ];
}
