<?php

namespace SisVentas\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use SisVentas\Proveedor;
use DB;

class ProveedorController extends Controller
{

    public function index()
    {

//        $proveedores = DB::select("call USP_LIS_PROVEEDORES()");
        //dd($proveedores);
        $codusu = session('key')['CodUsu'];
        $datusu = DB::table('usuarios_personal')
            ->join('personal_maestro', 'usuarios_personal.Cod_Per', '=', 'personal_maestro.Cod_Per')
            ->where('usuarios_personal.Cod_Usu', $codusu)
            ->first();

        $proveedores = DB::table('clienprov_maestro')
            ->where('Operacion', '<>', 'E')
            ->where('Tip_CP', '<>', 'C')
            ->get();

        return view('almacen.proveedor.index', ['proveedores' => $proveedores, 'datusu' => $datusu]);
    }

    public function edit($codEmp, $CodCP, $TipCP, $NomCP)
    {

        $codusu = session('key')['CodUsu'];
        $datusu = DB::table('usuarios_personal')
            ->join('personal_maestro', 'usuarios_personal.Cod_Per', '=', 'personal_maestro.Cod_Per')
            ->where('usuarios_personal.Cod_Usu', $codusu)
            ->first();
        //Obteniendo registros
        $proveedor = DB::select('call USP_SEEK_PROVEEDORES(?, ?, ?, ?)', [$codEmp, $CodCP, $TipCP, $NomCP]);
        $pais = DB::select('call USP_LIS_UBIGEO_PAISES()');
        $departamento = DB::select('call USP_LIS_UBIGEO_DEPARTAMENTOS(?)', [$proveedor[0]->Cod_Pais]);

        $provincia = DB::select('call USP_LIS_UBIGEO_PROVINCIAS(?,?)', [$proveedor[0]->Cod_Pais, $proveedor[0]->Cod_Dep]);

        $distrito = DB::select('call USP_LIS_UBIGEO_DISTRITOS(?,?,?)', [$proveedor[0]->Cod_Pais, $proveedor[0]->Cod_Dep, $proveedor[0]->Cod_Pro]);


        //dd($proveedor);        

        return view('almacen.proveedor.edit', ['proveedor' => $proveedor, 'distrito' => $distrito,
            'provincia' => $provincia, 'departamento' => $departamento,
            'pais' => $pais, 'datusu' => $datusu]);
    }

    public function postEdit(Request $request)
    {
        $CodEmp = '01';
        $CodCP = $request->CodCP;
        $NomCP = $request->NomCP;
        $ApeCP = $request->ApeCP;
        $TipCP = $request->TipCP;
        $DirCP = $request->DirCP;
        $TelCP = $request->TelCP;
        $CelCP = $request->CelCP;
        $MailCP = $request->MailCP;
        $CodDis = $request->CodDis;
        $CodPro = $request->CodPro;
        $CodDep = $request->CodDep;
        $CodPais = $request->CodPais;
        $Usuario = '02';
        $Fecha = '2018-02-22 20:33:22';
        $Operacion = 'M';

        DB::select('CALL USP_UPD_PROVEEDORES_MAESTRO(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)', [$CodEmp, $CodCP, $NomCP, $ApeCP,
            $TipCP, $DirCP, $TelCP, $CelCP, $MailCP, $CodDis, $CodPro, $CodDep, $CodPais, $Usuario, $Fecha, $Operacion]);

        //dd($request);

        return redirect('almacen/proveedor')->with('success', 'Proveedor actualizado satisfactoriamente');
    }

    public function create()
    {

        $codusu = session('key')['CodUsu'];
        $datusu = DB::table('usuarios_personal')
            ->join('personal_maestro', 'usuarios_personal.Cod_Per', '=', 'personal_maestro.Cod_Per')
            ->where('usuarios_personal.Cod_Usu', $codusu)
            ->first();

        $pais = DB::select('call USP_LIS_UBIGEO_PAISES()');
        $departamento = DB::select('call USP_LIS_UBIGEO_DEPARTAMENTOS(?)', ['51']);

        return view('almacen.proveedor.create', ['departamento' => $departamento, 'pais' => $pais, 'datusu' => $datusu]);
    }

    public function postCreate(Request $request)
    {

        $CodEmp = '01';
        $CodCP = $request->get('CodCP');
        $NomCP = $request->get('NomCP');
        $ApeCP = $request->get('ApeCP');
        $TipCP = $request->get('TipCP');
        $DirCP = $request->get('DirCP');
        $TelCP = $request->get('TelCP');
        $CelCP = $request->get('CelCP');
        $MailCP = $request->get('MailC');
        $CodDis = $request->get('CodDis');
        $CodPro = $request->get('CodPro');
        $CodDep = $request->get('CodDep');
        $CodPais = $request->get('CodPais');
        $Usuario = '001';
        $Fecha = '2018-02-22 20:33:22'; //Por ahora estática
        $Operacion = 'I';

        DB::select('CALL USP_UPD_PROVEEDORES_MAESTRO_BK(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)', [$CodEmp, $CodCP, $NomCP, $ApeCP,
            $TipCP, $DirCP, $TelCP, $CelCP, $MailCP, $CodDis, $CodPro, $CodDep, $CodPais, $Usuario, $Fecha, $Operacion]);

        //dd($request);

        return redirect('almacen/proveedor')->with('success', 'Proveedor creado satisfactoriamente');

    }

    public function eliminar($CodEmp, $CodCP, $Usuario, $Fecha, $Operacion)
    {

        DB::select('call USP_UPD_PROVEEDORES_MAESTRO_DEL(?, ?, ?, ?, ?)', [$CodEmp, $CodCP, $Usuario, $Fecha, $Operacion]);

        return redirect('almacen/proveedor')->with('success', 'Proveedor eliminado satisfactoriamente');
    }

}
