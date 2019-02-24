<?php

namespace SisVentas\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use SisVentas\CitaUtil;

//use MaddHatter\LaravelFullcalendar\Facades\Calendar;

class AgendaController extends Controller {

    public function index() {
        //sesion de usuario
        $codusu= session('key')['CodUsu'];
        $datusu=DB::table('usuarios_personal')
        ->join('personal_maestro', 'usuarios_personal.Cod_Per', '=', 'personal_maestro.Cod_Per')
        ->where('usuarios_personal.Cod_Usu', $codusu)
        ->first();

        $agendaExiste = DB::select('CALL USP_SEEK_AGENDA_RESUMEN(?, ?, ?)', ['01', '01', '1999-04-15']);
        $doctores = DB::select('CALL USP_LIS_DOCTORES_MAESTRO()');
        $servicios = DB::select('CALL USP_LIS_SERVICIOS()');
        $citas = DB::select('CALL USP_COUNT_AGENDAS_CITAS()');
        $tiposCita = DB::select('CALL USP_LIS_AGENDAS_CITA_TIPOS()');
        $pacientes = DB::select('CALL USP_LIS_PACIENTES()');
        //$calendar = Calendar();
//        $agendas = DB::table('agendas_resumen')->get();
//        $agendasTipos = DB::table('agendas_tipos')->get();                        
        //dd($citas);
        $intervalo = $agendaExiste[0]->Tiempo_Consul;

        $lapsos = [];
        $horaCompleta = "09:00";
        $retazos = explode(":", $horaCompleta);

        $hora = (int) $retazos[0];
        $minutos = (int) $retazos[1];

        for ($i = $hora; $i < 22; $i++) {
            for ($j = $minutos; $j < 60; $j = $j + $intervalo) {
                $lapsos[] = str_pad($i, 2, "0", STR_PAD_LEFT) . ':' . str_pad($j, 2, "0", STR_PAD_LEFT);
            }
        }
        $lapsos[] = '22:00';

        //dd($citas);

        $citaUtil = new CitaUtil($citas);

        return view('almacen.agenda.index', ['agendaExiste' => $agendaExiste,
            'lapsos' => $lapsos, 'doctores' => $doctores, 'servicios' => $servicios, 'citas' => $citas,
            'citaUtil' => $citaUtil, 'tiposCita' => $tiposCita, 'pacientes' => $pacientes,'datusu' => $datusu]);
    }

    public function agendaResumen() {

        $lapsos = [];
        $horaCompleta = "09:00";
        $retazos = explode(":", $horaCompleta);

        $hora = (int) $retazos[0];
        $minutos = (int) $retazos[1];

        for ($i = $hora; $i < 22; $i++) {
            for ($j = $minutos; $j < 60; $j = $j + $intervalo) {
                if ($j == 0) {
                    $valores[] = $i . ":" . $j . '0';
                } else {
                    $valores[] = $i . ":" . $j;
                }
            }
        }

        return view('almacen.citas.index', ['lapsos' => $lapsos]);
    }

    public function agendaIntervalo($intervalo) {
        return view('almacen.citas.index', ['intervalo' => $intervalo]);
    }

    public function crearAgenda($codEmp, $codLoc, $usuario, $fecha) {
        $agendaExiste = DB::select('CALL USP_SEEK_AGENDA_RESUMEN(?, ?, ?)', [$codEmp, $codLoc, $fecha]);
        $tiposAgen = DB::select('CALL USP_LIS_AGENDAS_TIPOS()');
        return view('almacen.agenda.crearAgenda', ['codEmp' => $codEmp, 'codLoc' => $codLoc, 'usuario' => $usuario, 'fecha' => $fecha,
            'agendaExiste' => $agendaExiste, 'tiposAgen' => $tiposAgen]);
    }

    public function postCrearAgenda(Request $request) {

        $CodEmp = '01';
        $CodLoc = '01';
        $Anno = '2018';
        $NumMes = '09';
        $NumAgen = '';
        $FecAgen = '1999-04-15';
        $CodTipAgen = $request->get('CodTipAgen');
        $CodTur = '01';
        $Usuario = '01';
        $Fecha = '2018-02-22 20:33:22';
        $Operacion = 'I';

        DB::select('CALL USP_UPD_AGENDAS_RESUMEN(?,?,?,?,?,?,?,?,?,?,?)', [$CodEmp, $CodLoc, $Anno,
            $NumMes, $NumAgen, $FecAgen, $CodTipAgen, $CodTur, $Usuario, $Fecha, $Operacion]);

        //dd($request);
//        return view('almacen.agenda.index', ['CodTipAgen' => $CodTipAgen]);
        return redirect('almacen/agenda');
    }

    public function postCrearCita(Request $request) {

        if (($request->get('modal')) == 'insertar') {

            $CodEmp = '01';
            $CodLoc = '01';
            $Anno = '2018';
            $NumMes = '09';
            $NumCita = $request->get('idCita');
            $IdCita = $request->get('idCita');
            $InicioCita = '2018-02-22 20:33:22';
            $FinalCita = '2018-02-22 20:33:22';
            $CodPac = $request->get('paciente');
            $CodDocPac = '01';
            $TipDocPac = 'DNI';
            $NumDocPac = '123456';
            $CodMed = $request->get('doctor');
            $CodDocMed = '01';
            $TipDocMed = 'DNI';
            $NumDocMed = '9334335';
            $CodTerap = $request->get('CodServ');
            $NumConsul = $request->get('columna');
            $CodEstCita = '01';
            $ObsCita = $request->get('mensaje');
            $CodTipCita = $request->get('CodTipCita');
            $NomColum = $request->get('columna');
            $NomFila = $request->get('fila');
            $Usuario = '01';
            $Fecha = '2018-02-22 20:33:22';
            $Operacion = 'I';                       

            DB::select('CALL USP_UPD_AGENDAS_CITAS(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)', [$CodEmp,
                $CodLoc, $Anno, $NumMes, $NumCita, $IdCita, $InicioCita, $FinalCita, $CodPac, $CodDocPac,
                $TipDocPac, $NumDocPac, $CodMed, $CodDocMed, $TipDocMed, $NumDocMed, $CodTerap, $NumConsul,
                $CodEstCita, $ObsCita, $CodTipCita, $NomColum, $NomFila, $Usuario, $Fecha, $Operacion]);

            //dd($request);
//        return redirect('almacen/agenda')->with('success', 'Cita creada satisfactoriamente');
        } elseif (($request->get('modal')) == 'modificar') {

            $CodEmp = '01';
            $CodLoc = '01';
            $Anno = '2018';
            $NumMes = '09';
            $NumCita = $request->get('idCita');
            $IdCita = $request->get('idCita');
            $InicioCita = '2018-02-22 20:33:22';
            $FinalCita = '2018-02-22 20:33:22';
            $CodPac = $request->get('paciente');
            $CodDocPac = '01';
            $TipDocPac = 'DNI';
            $NumDocPac = '123456';
            $CodMed = $request->get('doctor');
            $CodDocMed = '01';
            $TipDocMed = 'DNI';
            $NumDocMed = '9334335';
            $CodTerap = $request->get('CodServ');
            $NumConsul = $request->get('consultorio');
            $CodEstCita = '01';
            $ObsCita = $request->get('mensaje');
            $CodTipCita = $request->get('CodTipCita');
            $NomColum = $request->get('consultorio');
            $NomFila = $request->get('horaInicio');
            $Usuario = '01';
            $Fecha = '2018-02-22 20:33:22';
            $Operacion = 'M';

            DB::select('CALL USP_UPD_AGENDAS_CITAS_ACTUALIZAR(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)', [$CodEmp,
                $CodLoc, $Anno, $NumMes, $NumCita, $IdCita, $InicioCita, $FinalCita, $CodPac, $CodDocPac,
                $TipDocPac, $NumDocPac, $CodMed, $CodDocMed, $TipDocMed, $NumDocMed, $CodTerap, $NumConsul,
                $CodEstCita, $ObsCita, $CodTipCita, $NomColum, $NomFila, $Usuario, $Fecha, $Operacion]);

            //dd($request);
//        return redirect('almacen/agenda')->with('success', 'Cita creada satisfactoriamente');
        }
    }

    public function postEliminar() {

        $CodEmp = '01';
        $NumCita = $request->get('');
        $NomColum = $request->get('columna');
        $NomFila = $request->get('fila');
        $Usuario = '01';
        $Fecha = '2018-02-22 20:33:22';
        $Operacion = 'E';

        DB::select('call USP_UPD_AGENDAS_CITAS_DEL(?,?,?,?,?,?,?)', [$CodEmp, $NumCita, $NomColum, $NomFila, $Usuario,
            $Fecha, $Operacion]);
        //dd($articulo);
        return redirect('almacen/articulo')->with('success', 'Artículo eliminado satisfactoriamente');
    }

}
