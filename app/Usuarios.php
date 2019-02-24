<?php

namespace SisVentas;

use Illuminate\Database\Eloquent\Model;

class Usuarios extends Model
{
    public $table = 'usuarios_personal';

    public $primaryKey = 'Cod_Usu';

    public $timestamps = false;
    protected $fillable = [
        'Cod_Emp',
        'Cod_Sis',
        'Cod_Usu',
        'Nom_Usu',
        'Key_Usu',
        'Key_Ant',
        'Cod_Per',
        'Cod_Doc',
        'Tip_Doc',
        'Num_Doc',
        'Cod_Tip_Usu',
        'Estado',
        'Usuario',
        'Fecha',
        'Operacion',
        'cod_Pais',
        'Cod_Dep',
        'Cod_Loc'
    ];

}
