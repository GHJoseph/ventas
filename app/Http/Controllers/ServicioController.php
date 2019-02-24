<?php

namespace SisVentas\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use SisVentas\Servicio;
use DB;

class ServicioController extends Controller
{

    public function index()
    {
        $codusu = session('key')['CodUsu'];
        $datusu = DB::table('usuarios_personal')
            ->join('personal_maestro', 'usuarios_personal.Cod_Per', '=', 'personal_maestro.Cod_Per')
            ->where('usuarios_personal.Cod_Usu', $codusu)
            ->first();
        $CodEmp=$datusu->Cod_Emp;
            
        $servicios = DB::table('servicios_maestro')
            ->where('Cod_Emp', '=', $CodEmp)
            ->where('Cod_Serv', '<>', '0000')
            ->where('Operacion', '<>', 'E')
            ->get();
        //El paginador se muestra solo si hay gran cantidad de registros a paginar
        return view('almacen.servicio.index', ['servicios' => $servicios, 'codusu' => $codusu, 'datusu' => $datusu]);
    }

    public function edit($codEmp, $CodServ, $NomServ)
    {
        $codusu = session('key')['CodUsu'];
        $datusu = DB::table('usuarios_personal')
            ->join('personal_maestro', 'usuarios_personal.Cod_Per', '=', 'personal_maestro.Cod_Per')
            ->where('usuarios_personal.Cod_Usu', $codusu)
            ->first();
        //Obteniendo registros 
        $servicio = DB::select('call USP_SEEK_SERVICIOS_MAESTRO(?, ?, ?)', [$codEmp, $CodServ, $NomServ]);
        return view('almacen.servicio.edit', ['servicio' => $servicio, 'datusu' => $datusu]);

    }

    public function postEdit(Request $request)
    {
        $CodEmp = '01';
        $CodServ = $request->CodServ;
        $NomServ = $request->NomServ;
        $DesServ = $request->DesServ;
        $PreServ = $request->get('PreServ');
        $TipServ = 'MASAJES';
        $Usuario = '001';
        $Fecha = date("Y-m-d H:i:s");
        $Operacion = 'M';

        DB::select('CALL USP_UPD_SERVICIOS_BK(?,?,?,?,?,?,?,?,?)', [$CodEmp, $CodServ, $NomServ, $DesServ, $PreServ, $TipServ, $Usuario,
            $Fecha, $Operacion]);
        return redirect('almacen/servicio')->with('success', 'Servicio actualizado satisfactoriamente');
    }

    public function create()
    {
        $codusu = session('key')['CodUsu'];
        $datusu = DB::table('usuarios_personal')
            ->join('personal_maestro', 'usuarios_personal.Cod_Per', '=', 'personal_maestro.Cod_Per')
            ->where('usuarios_personal.Cod_Usu', $codusu)
            ->first();
        return view('almacen.servicio.create', compact('codusu', 'datusu'));
    }

    public function postCreate(Request $request)
    {
        $CodEmp = '01';
        $CodServ = $request->get('CodServ');
        $NomServ = $request->get('NomServ');
        $DesServ = $request->get('DesServ');
        $PreServ = $request->get('PreServ');
        $TipServ = 'MASAJES';
        $Usuario = '001';
        $Fecha = date("Y-m-d H:i:s");
        $Operacion = 'I';

        DB::select('CALL USP_UPD_SERVICIOS_BK(?,?,?,?,?,?,?,?,?)', [$CodEmp, $CodServ, $NomServ, $DesServ, $PreServ, $TipServ, $Usuario,
            $Fecha, $Operacion]);
        return redirect('almacen/servicio')->with('success', 'Servicio creado satisfactoriamente');
    }

    public function eliminar($CodEmp, $CodServ, $Usuario, $Fecha, $Operacion)
    {

        DB::select('call USP_UPD_SERVICIOS_MAESTRO_DEL(?, ?, ?, ?, ?)', [$CodEmp, $CodServ, $Usuario, $Fecha, $Operacion]);
        return redirect('almacen/servicio')->with('success', 'Servicio eliminado satisfactoriamente');

    }


}
