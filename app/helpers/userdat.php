<?php
use Illuminate\Support\Facades\DB;
class userdat
{
    function Datusu($usuario, $pais, $departamento, $local)
    {
        $usersquiro = DB::table('usuarios_personal')
            ->where('Nom_Usu', $usuario)
            ->where('cod_Pais', $pais)
            ->where('Cod_Dep', $departamento)
            ->where('Cod_Loc', $local)
            ->first();
        return (isset($usersquiro->Cod_Usu) ? $usersquiro->Cod_Usu : '');
    }
}
