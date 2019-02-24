<?php

namespace SisVentas\Http\Controllers;

use DB;


class HomeController extends Controller
{
    public function index()
    {
        $CodUsu = session('key')['CodUsu'];
        $CodEmp = session('key')['CodEmp'];
        $CodLoc = session('key')['CodLoc'];
        $datusu = DB::table('usuarios_personal')
            ->join('personal_maestro', 'usuarios_personal.Cod_Per', '=', 'personal_maestro.Cod_Per')
            ->where('usuarios_personal.Cod_Usu', $CodUsu)
            ->first();
        $agendaExiste = DB::select('CALL USP_SEEK_AGENDA_RESUMEN(?, ?, ?)', [$CodEmp, $CodLoc, '1999-04-15']);
        $tiposAgen = DB::select('CALL USP_LIS_AGENDAS_TIPOS()');
        //Insertamos el tipo de cambio
        $CambioActual = DB::table('monedas_tipos_cambios')
            ->where('Anno', '=', date('Y'))
            ->where('NumMes', '=', date('m'))
            ->where('NumDia', '=', date('d'))
            ->get();
        if (count($CambioActual) === 0) {
            $TipoCambioDB = DB::table('monedas_tipos_cambios')
                ->orderBy('Fecha', '=', 'DESC')
                ->first();
            $TipoCambio = new TipoCambioController();
            $TipoCambioPag = $TipoCambio->obtenerTC();
            $diaPag = '00' . $TipoCambioPag[0];
            $diaPag = substr($diaPag, -2, 2);
            $fechaPag = strtotime($diaPag . '-' . date('m') . '-' . date('Y'));
            if ($TipoCambioDB === null) {
                DB::table('monedas_tipos_cambios')->insert(
                    ['Anno' => date('Y'), 'NumMes' => date('m'), 'NumDia' => $diaPag, 'Cod_Mon' => 'D', 'Val_Cmp' => $TipoCambioPag[1], 'Val_Vta' => $TipoCambioPag[2], 'Usuario' => $CodUsu, 'Fecha' => date('Y-m-d h:i:s'), 'Operacion' => 'I']
                );
            } else {
                $fechaDB = strtotime($TipoCambioDB->NumDia . '-' . $TipoCambioDB->NumMes . '-' . $TipoCambioDB->Anno); //Fecha del ultimo tipo de cambio almacenado en la BD
                if ($fechaPag > $fechaDB) {
                    DB::table('monedas_tipos_cambios')->insert(
                        ['Anno' => date('Y'), 'NumMes' => date('m'), 'NumDia' => $diaPag, 'Cod_Mon' => 'D', 'Val_Cmp' => $TipoCambioPag[1], 'Val_Vta' => $TipoCambioPag[2], 'Usuario' => $CodUsu, 'Fecha' => date('Y-m-d h:i:s'), 'Operacion' => 'I']
                    );
                }
            }
        }
        return view('almacen.home.index', ['agendaExiste' => $agendaExiste, 'tiposAgen' => $tiposAgen, 'datusu' => $datusu, ' codusu' => $CodUsu]);
    }

    public function agendaIntervalo($CodTipAgen)
    {
        dd($CodTipAgen);
        $lapsos = [];
        $horaCompleta = "09:00";
        $retazos = explode(":", $horaCompleta);

        $hora = (int)$retazos[0];
        $minutos = (int)$retazos[1];

        for ($i = $hora; $i < 22; $i++) {
            for ($j = $minutos; $j < 60; $j = $j + $intervalo) {
                $lapsos[] = $i . ":" . $j;
            }
        }
        return view('almacen.home.agendaIntervalo', ['lapsos' => $lapsos]);
    }

}
