<?php

namespace SisVentas\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use SisVentas\Proveedor;
use DB;

class ClientesController extends Controller
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

        $clientes = DB::table('clienprov_maestro')
            ->select('clienprov_maestro.*', DB::raw("CONCAT(IFNULL(Nom_PAC,''),' ',IFNULL(Pat_Pac,''),' ',IFNULL(Mat_Pac,'')) AS Nom_Pac"), 'pacientes_maestro.Cod_Pac')
            ->leftjoin('pacientes_maestro', 'clienprov_maestro.Cod_Pac', '=', 'pacientes_maestro.Cod_Pac')
            ->where('clienprov_maestro.Operacion', '<>', 'E')
            ->where('clienprov_maestro.Tip_CP', '<>', 'P')
            ->get();
        return view('almacen.cliente.index', ['clientes' => $clientes, 'datusu' => $datusu]);
    }

    public function edit($codEmp, $CodCP, $TipCP, $NomCP)
    {
        $codusu = session('key')['CodUsu'];
        $datusu = DB::table('usuarios_personal')
            ->join('personal_maestro', 'usuarios_personal.Cod_Per', '=', 'personal_maestro.Cod_Per')
            ->where('usuarios_personal.Cod_Usu', $codusu)
            ->first();
        $CodEmp = $datusu->Cod_Emp;
        $CodLoc = $datusu->Cod_Loc;

        $tipo_documentos = DB::table('personal_tipos_documentos')
            ->get();
        //Obteniendo registros
        $clientes = DB::select('call USP_SEEK_CLIENTES(?, ?, ?, ?)', [$codEmp, $CodCP, $TipCP, $NomCP]);
        // dump($clientes);
        $pais = DB::select('call USP_LIS_UBIGEO_PAISES()');
        $departamento = DB::select('call USP_LIS_UBIGEO_DEPARTAMENTOS(?)', ['51']);
        $provincia = DB::select('call USP_LIS_UBIGEO_PROVINCIAS(?,?)', ['51', '15']);
        $distrito = DB::select('call USP_LIS_UBIGEO_DISTRITOS(?,?,?)', ['51', '15', '01']);

        $paciente = DB::table('pacientes_maestro')
            ->where('Operacion', '<>', 'E')
            ->where('Cod_Pac', '=', $clientes[0]->Cod_Pac)
            ->get();

        return view('almacen.cliente.edit', ['paciente' => $paciente, 'clientes' => $clientes, 'distrito' => $distrito,
            'provincia' => $provincia, 'departamento' => $departamento, 'tipo_documentos' => $tipo_documentos,
            'paises' => $pais, 'datusu' => $datusu]);
    }

    public function postEdit(Request $request)
    {
        $codusu = session('key')['CodUsu'];
        $datusu = DB::table('usuarios_personal')
            ->join('personal_maestro', 'usuarios_personal.Cod_Per', '=', 'personal_maestro.Cod_Per')
            ->where('usuarios_personal.Cod_Usu', $codusu)
            ->first();
        $CodEmp = $datusu->Cod_Emp;

        $CodCP = $request->get('CodCP');
        $NomCP = $request->get('NomCP');
        $ApeCP = $request->get('ApeCP');
        $CodDoc = $request->get('TipDoc');
        $Documento = DB::table('personal_tipos_documentos')
            ->where('personal_tipos_documentos.Cod_Tip_Doc', '=', $CodDoc)
            ->first();
        $TipDoc = $Documento->Tip_Doc;
        $NumDoc = $request->get('NumDoc');
        $DirCP = $request->get('DirCP');
        $TelCP = $request->get('TelCP');
        $CelCP = $request->get('CelCP');
        $MailCP = $request->get('MailCP');
        $CodDis = $request->get('CodDis');
        $CodPro = $request->get('CodPro');
        $CodDep = $request->get('CodDep');
        $CodPais = $request->get('CodPais');
        $CodPac = $request->get('CodPac');
        $NomCnt = $request->get('NomCnt');
        $TelCnt = $request->get('TelCnt');
        $CrgCnt = $request->get('CrgCnt');
        $Usuario = '001';
        $Fecha = date("Y-m-d H:i:s");
        $TipCP = 'C';
        $Operacion = 'M';
        DB::select('CALL USP_UPD_CLIENTES_MAESTRO(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)', [$CodEmp, $CodCP, $NomCP, $ApeCP, $CodDoc, $TipDoc, $NumDoc, $DirCP, $CodDis, $CodPro, $CodDep, $CodPais, $TelCP, $CelCP, '-', $MailCP, '-', '-', 1, $TipCP, 'V', $CodPac, $NomCnt, $TelCnt, $CrgCnt, 'A', $Usuario, $Fecha, $Operacion]);
        return redirect('almacen/cliente')->with('success', 'Cliente actualizado satisfactoriamente');
    }

    public function create()
    {
        $codusu = session('key')['CodUsu'];
        $datusu = DB::table('usuarios_personal')
            ->join('personal_maestro', 'usuarios_personal.Cod_Per', '=', 'personal_maestro.Cod_Per')
            ->where('usuarios_personal.Cod_Usu', $codusu)
            ->first();

        $CodEmp = $datusu->Cod_Emp;
        $CodLoc = $datusu->Cod_Loc;

        $pais = DB::select('call USP_LIS_UBIGEO_PAISES()');
        $departamento = DB::select('call USP_LIS_UBIGEO_DEPARTAMENTOS(51)');
        $provincia = DB::select('call USP_LIS_UBIGEO_PROVINCIAS(15,51)');
        $distrito = DB::select('call USP_LIS_UBIGEO_DISTRITOS(15,51,2)');
        $paciente = DB::select('call USP_LIS_PACIENTES_MAESTRO(?)', [$datusu->Cod_Emp]);

        $tipo_documentos = DB::table('personal_tipos_documentos')
            ->get();

        return view('almacen.cliente.create', [
            'paciente' => $paciente,
            'distrito' => $distrito,
            'provincia' => $provincia,
            'departamento' => $departamento,
            'pais' => $pais,
            'datusu' => $datusu,
            'tipo_documentos' => $tipo_documentos]);
    }

    public function postCreate(Request $request)
    {
        $validar = DB::table('clienprov_maestro')
            ->where('Num_Doc', '=', $request->get('NumDoc'))
            ->where("Operacion", '<>', 'E')
            ->first();
        if (!$validar) {

            $codusu = session('key')['CodUsu'];
            $datusu = DB::table('usuarios_personal')
                ->join('personal_maestro', 'usuarios_personal.Cod_Per', '=', 'personal_maestro.Cod_Per')
                ->where('usuarios_personal.Cod_Usu', $codusu)
                ->first();
            $CodEmp = $datusu->Cod_Emp;

            $CodCP = $request->get('CodCP');
            $NomCP = $request->get('NomCP');
            $ApeCP = $request->get('ApeCP');
            $CodDoc = $request->get('TipDoc');
            $Documento = DB::table('personal_tipos_documentos')
                ->where('personal_tipos_documentos.Cod_Tip_Doc', '=', $CodDoc)
                ->first();
            $TipDoc = $Documento->Tip_Doc;
            $NumDoc = $request->get('NumDoc');
            $DirCP = $request->get('DirCP');
            $TelCP = $request->get('TelCP');
            $CelCP = $request->get('CelCP');
            $MailCP = $request->get('MailCP');
            $CodDis = $request->get('CodDis');
            $CodPro = $request->get('CodPro');
            $CodDep = $request->get('CodDep');
            $CodPais = $request->get('CodPais');

            $paciente = DB::select('CALL USP_LIS_PACIENTES_MAESTRO(?)', [$CodEmp]);
            $CodPac = $request->get('CodPac');

            $NomCnt = $request->get('NomCnt');
            $TelCnt = $request->get('TelCnt');
            $CrgCnt = $request->get('CrgCnt');
            $Usuario = $codusu;
            $TipCP = 'C';
            $Fecha = date("Y-m-d H:i:s"); //Por ahora estática
            $Operacion = 'I';
            DB::select('CALL USP_UPD_CLIENTES_MAESTRO(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)', [$CodEmp, $CodCP, $NomCP, $ApeCP, $CodDoc, $TipDoc, $NumDoc, $DirCP, $CodDis, $CodPro, $CodDep, $CodPais, $TelCP, $CelCP, null, $MailCP, null, null, 1, $TipCP, 'V', $CodPac, $NomCnt, $TelCnt, $CrgCnt, 'A', $Usuario, $Fecha, $Operacion]);
            return redirect('almacen/cliente')->with('success', 'Cliente registrado satisfactoriamente');
        } else {
            return back()->withInput($request->all())->with('error', 'Ya existe Cliente con N° Doc. : ' . $request->get('NumDoc'));
        }

    }

    public function eliminar($CodEmp, $CodCP, $Usuario, $Fecha, $Operacion)
    {

        DB::select('call USP_UPD_PROVEEDORES_MAESTRO_DEL(?, ?, ?, ?, ?)', [$CodEmp, $CodCP, $Usuario, $Fecha, $Operacion]);

        return redirect('almacen/cliente')->with('success', 'cliente eliminado satisfactoriamente');
    }

}
