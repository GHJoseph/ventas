<?php

namespace SisVentas\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use SisVentas\Personal;
use Illuminate\Support\Facades\DB;

class PersonalController
{

    //Ver lista del Personal
    public function index()
    {
        $codusu = session('key')['CodUsu'];
        $datusu = DB::table('usuarios_personal')
            ->join('personal_maestro', 'usuarios_personal.Cod_Per', '=', 'personal_maestro.Cod_Per')
            ->where('usuarios_personal.Cod_Usu', $codusu)
            ->first();

        $personal = DB::table('personal_maestro')
            ->leftJoin('personal_tipos_cargos',
                'personal_tipos_cargos.Cod_Tip_Crg', '=',
                'personal_maestro.Cod_Tip_Crg')
            ->where('personal_maestro.Operacion', '<>', 'E')
            ->get();
        return view('almacen.personal.index', ['personal' => $personal, 'datusu' => $datusu]);
    }

    //Editar Personal
    public function edit($codEmp, $CodPer, $NomPer)
    {

        $codusu = session('key')['CodUsu'];
        $datusu = DB::table('usuarios_personal')
            ->join('personal_maestro', 'usuarios_personal.Cod_Per', '=', 'personal_maestro.Cod_Per')
            ->where('usuarios_personal.Cod_Usu', $codusu)
            ->first();
        //$personal = DB::select('call USP_SEEK_PERSONAL_MAESTRO(?, ?, ?)', [$codEmp, $CodPer, $NomPer]);
        $personal = DB::table('personal_maestro')
            ->where('Cod_Emp', '=', $codEmp)
            ->where('Operacion', '<>', 'E')
            ->where('Cod_Per', '=', $CodPer)->first();

        $cod_pais = $personal->Cod_Pais;
        if ($cod_pais === null || $cod_pais === '') {
            $cod_pais = '51';
        }
        $paises = DB::select('call USP_LIS_UBIGEO_PAISES()');
        $departamento = DB::select('call USP_LIS_UBIGEO_DEPARTAMENTOS(?)', [$cod_pais]);
        $provincia = DB::select('call USP_LIS_UBIGEO_PROVINCIAS(?,?)', [$personal->Cod_Pais, $personal->Cod_Dep]);
        $distrito = DB::select('call USP_LIS_UBIGEO_DISTRITOS(?,?,?)', [$personal->Cod_Pais, $personal->Cod_Dep, $personal->Cod_Pro]);
        $estCivil = DB::select('call USP_LIS_PERSONAL_ESTADO_CIVIL()');
        $documento = DB::select('call USP_LIS_PERSONAL_TIP_DOC()');
        $turno = DB::select('call USP_LIS_PLANILLAS_TURNOS()');
        $cargos = DB::table('personal_tipos_cargos')
            ->where('Operacion', '<>', 'E')
            ->get();

        return view('almacen.personal.edit', ['per' => $personal, 'distrito' => $distrito,
            'provincia' => $provincia, 'departamento' => $departamento,
            'paises' => $paises, 'estCivil' => $estCivil, 'documento' => $documento,
            'turno' => $turno, 'cargos' => $cargos, 'datusu' => $datusu]);
    }

    public function postEdit(Request $request)
    {
        //subir archivo/imagen a la carpeta correspondiente
        if ($request->file('FotoPer')) {
            $dir = public_path() . '/Fotos/personal/';
            $file = $request->file('FotoPer');

            $image = $request->CodPer . '.' . $file->getClientOriginalExtension();
            $file->move($dir, $image);
            $foto = 'Fotos/personal/' . $image;
        } else {
            $foto = $request->foto;
        }

        $documento = DB::table('personal_tipos_documentos')->where('Cod_Tip_Doc', '=', $request->CodDoc)->first();

        $CodEmp = session('key')['CodEmp'];
        $CodPer = $request->CodPer;
        $NomPer = $request->NomPer;
        $PatPer = $request->PatPer;
        $MatPer = $request->MatPer;
        $FecNacPer = $request->FecNacPer;
        $SexoPer = $request->radios;
        $CodDis = $request->CodDis;
        $CodPro = $request->CodPro;
        $CodDep = $request->CodDep;
        $CodPais = $request->CodPais;
        $CodEstCiv = $request->CodEstCiv;
        $CodDoc = $request->CodDoc;
        $TipDoc = $documento->Tip_Doc;
        $NumDoc = $request->NumDoc;
        $RucPer = $request->RucPer;
        $FecIng = $request->FecIng;
        $DirPer = $request->DirPer;
        $TelPer = $request->TelPer;
        $CelPer = $request->CelPer;
        $MailPer = $request->MailPer;
        $CodTur = $request->CodTur;
        $CodCargo = $request->get('CodCrg');
        $Ruta_Foto = $foto;
        $Usuario = session('key')['CodUsu'];
        $Fecha = date('Y-m-d');
        $Operacion = 'M';

        DB::select('CALL USP_UPD_PERSONAL_MAESTRO(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)', [$CodEmp, $CodPer, $NomPer, $PatPer, $MatPer, $FecNacPer, $SexoPer, $CodDis, $CodPro, $CodDep, $CodPais, $CodEstCiv, $CodDoc, $TipDoc, $NumDoc, $RucPer, $FecIng, $DirPer, $TelPer, $CelPer, $MailPer,$CodTur, $Ruta_Foto, $Usuario, $Fecha, $Operacion, $CodCargo]);
        return redirect('almacen/personal')->with('success', 'Personal actualizado satisfactoriamente');
    }

    //Crear nuevo personal
    public function create()
    {
        $codusu = session('key')['CodUsu'];
        $datusu = DB::table('usuarios_personal')
            ->join('personal_maestro', 'usuarios_personal.Cod_Per', '=', 'personal_maestro.Cod_Per')
            ->where('usuarios_personal.Cod_Usu', $codusu)
            ->first();

        $pais = DB::select('call USP_LIS_UBIGEO_PAISES()');
        $departamento = DB::select('call USP_LIS_UBIGEO_DEPARTAMENTOS(?)', ['51']);

        $estCivil = DB::select('call USP_LIS_PERSONAL_ESTADO_CIVIL()');
        $documento = DB::select('call USP_LIS_PERSONAL_TIP_DOC()');
        $turno = DB::select('call USP_LIS_PLANILLAS_TURNOS()');
        $cargos = DB::table('personal_tipos_cargos')
            ->where('Operacion', '<>', 'E')
            ->get();

        return view('almacen.personal.create', ['departamento' => $departamento,
            'pais' => $pais, 'estCivil' => $estCivil, 'documento' => $documento,
            'turno' => $turno, 'cargos' => $cargos, 'datusu' => $datusu]);
    }

    public function postCreate(Request $request)
    {
        $validar = DB::table('personal_maestro')
            ->where("Operacion", '<>', 'E')
            ->where('Num_Doc', '=', $request->get('NumDoc'))->first();

        if (!$validar) {
            $countpac = DB::table('personal_maestro')->count();
            if ($countpac == 0) {
                $CodPer = '000001';
            } else {
                $countpac = $countpac + 1;
                $maxpacformat = '000000' . $countpac;

                $CodPer = substr($maxpacformat, -6, 6);
            }
            //subir archivo/imagen a la carpeta correspondiente
            if ($request->file('FotoPer')) {
                $dir = public_path() . '/Fotos/personal/';
                $file = $request->file('FotoPer');

                $image = $CodPer . '.' . $file->getClientOriginalExtension();
                $file->move($dir, $image);
                $foto = 'Fotos/personal/' . $image;
            } else {
                $foto = '';
            }

            $documento = DB::table('personal_tipos_documentos')->where('Cod_Tip_Doc', '=', $request->CodDoc)->first();

            $codusu = session('key')['CodUsu'];
            $CodEmp = session('key')['CodEmp'];
            $CodPer = $request->get('CodPer');
            $NomPer = $request->get('NomPer');
            $PatPer = $request->get('PatPer');
            $MatPer = $request->get('MatPer');
            $SexoPer = $request->get('radios');
            $FecNacPer = $request->get('FecNacPer');
            $CodPais = $request->get('CodPais');
            $CodDep = $request->get('CodDep');
            $CodPro = $request->get('CodPro');
            $CodDis = $request->get('CodDis');
            $CodEstCiv = $request->get('CodEstCiv');
            $CodDoc = $request->get('CodDoc');
            $TipDoc = $documento->Tip_Doc;
            $NumDoc = $request->get('NumDoc');
            $RucPer = $request->get('RucPer');
            $FecIng = $request->get('FecIng');
            $DirPer = $request->get('DirPer');
            $TelPer = $request->get('TelPer');
            $CelPer = $request->get('CelPer');
            $MailPer = $request->get('MailPer');
            $CodTur = $request->get('CodTur');
            $CodCargo = $request->get('CodCrg');
            $Ruta_Foto = $foto;
            $Usuario = $codusu;
            $Fecha = date("Y-m-d H:i:s");
            $Operacion = 'I';
            /*dump([$CodEmp, $CodPer, $NomPer, $PatPer, $MatPer, $FecNacPer, $SexoPer, $CodDis, $CodPro,
                $CodDep, $CodPais, $CodEstCiv, $CodDoc, $NumDoc, $RucPer, $FecIng, $DirPer,
                $TelPer, $CelPer, $CodTur, $Ruta_Foto, $Usuario, $Fecha, $Operacion]);*/
            DB::select('CALL USP_UPD_PERSONAL_MAESTRO(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)', [$CodEmp, $CodPer, $NomPer, $PatPer, $MatPer, $FecNacPer, $SexoPer, $CodDis, $CodPro, $CodDep, $CodPais, $CodEstCiv, $CodDoc, $TipDoc, $NumDoc, $RucPer, $FecIng, $DirPer, $TelPer, $CelPer,$MailPer, $CodTur, $Ruta_Foto, $Usuario, $Fecha, $Operacion, $CodCargo]);
            return redirect('almacen/personal')->with('success', 'Personal creado satisfactoriamente');
        } else {
            return back()->withInput($request->all())->with('danger', 'Ya existe Personal con N° Doc. : ' . $request->get('NumDoc'));
        }

    }

    //Eliminar Personal
    public function eliminar($CodEmp, $CodPer, $Usuario, $Fecha, $Operacion)
    {

        DB::select('call USP_UPD_PERSONAL_MAESTRO_DEL(?, ?, ?, ?, ?)', [$CodEmp, $CodPer, $Usuario, $Fecha, $Operacion]);
        return redirect('almacen/personal')->with('success', 'Personal eliminado satisfactoriamente');
    }

    public function FiltraPersonal(Request $request)
    {
        $consulta = $request->input('personal');
        $data = Personal::select(DB::raw("CONCAT(Pat_Per , ' ' ,Mat_Per,' ',Nom_Per) AS name"), "Cod_Per as id")
            ->where("Operacion", '<>', 'E')
            ->where(function ($query) use ($consulta) {
                $query->where('Nom_Per', 'LIKE', '%' . $consulta . '%')
                    ->orWhere('Pat_Per', 'LIKE', '%' . $consulta . '%')
                    ->orWhere('Mat_Per', 'LIKE', '%' . $consulta . '%');
            })->get();

        $data_out = [];
        $data_out['incomplete_results'] = 'true';
        $data_out['items'] = $data;
        $data_out['total_count'] = count($data);
        return response()->json($data_out);
    }


}
