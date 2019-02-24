<?php

namespace SisVentas\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use SisVentas\Paciente;
use DB;

class PacienteController extends Controller
{

    //Listado de pacientes
    public function index()
    {
        $codusu = session('key')['CodUsu'];
        $datusu = DB::table('usuarios_personal')
            ->join('personal_maestro', 'usuarios_personal.Cod_Per', '=', 'personal_maestro.Cod_Per')
            ->where('usuarios_personal.Cod_Usu', $codusu)
            ->first();
        $tiposdoc = DB::table('personal_tipos_documentos')->get();
        $pacientes = DB::select("call USP_LIS_PACIENTES()");
        return view('almacen.paciente.index', ['pacientes' => $pacientes, 'codusu' => $codusu, 'datusu' => $datusu, 'tiposdoc' => $tiposdoc]);
    }

    //Edición del paciente
    public function edit($codEmp, $codLoc, $CodPac, $NomPac)
    {
        $codusu = session('key')['CodUsu'];
        $datusu = DB::table('usuarios_personal')
            ->join('personal_maestro', 'usuarios_personal.Cod_Per', '=', 'personal_maestro.Cod_Per')
            ->where('usuarios_personal.Cod_Usu', $codusu)
            ->first();
        //Obteniendo registros
        //$paciente = DB::select('call USP_SEEK_PACIENTES_MAESTRO(?, ?, ?, ?)', [$codEmp, $codLoc, $CodPac, $NomPac]);
        $paciente = DB::table('pacientes_maestro')
            ->where('Cod_Emp', '=', $codEmp)
            ->where('Cod_Loc', '=', $codLoc)
            ->where('Cod_Pac', '=', $CodPac)->first();
        $paises = DB::select('call USP_LIS_UBIGEO_PAISES()');
        $cod_pais = $paciente->Cod_Pais;
        if ($cod_pais === null || $cod_pais === '') {
            $cod_pais = '51';
        }
        $departamento = DB::select('call USP_LIS_UBIGEO_DEPARTAMENTOS(?)', [$cod_pais]);
        $provincia = DB::select('call USP_LIS_UBIGEO_PROVINCIAS(?,?)', [$paciente->Cod_Pais, $paciente->Cod_Dep]);
        $distrito = DB::select('call USP_LIS_UBIGEO_DISTRITOS(?,?,?)', [$paciente->Cod_Pais, $paciente->Cod_Dep, $paciente->Cod_Pro]);
        $tiposdoc = DB::table('personal_tipos_documentos')->get();
        return view('almacen.paciente.edit', ['pac' => $paciente
            , 'distrito' => $distrito, 'provincia' => $provincia, 'departamento' => $departamento, 'paises' => $paises, 'codusu' => $codusu, 'datusu' => $datusu, 'tiposdoc' => $tiposdoc]);
    }

    public function postEdit(Request $request)
    {
        $codusu = session('key')['CodUsu'];
        $datusu = DB::table('usuarios_personal')
            ->join('personal_maestro', 'usuarios_personal.Cod_Per', '=', 'personal_maestro.Cod_Per')
            ->where('usuarios_personal.Cod_Usu', $codusu)->first();
        $documento = DB::table('personal_tipos_documentos')
            ->where('personal_tipos_documentos.Cod_Tip_Doc', '=', $request->CodDoc)
            ->first();
        $Paciente = Paciente::find($request->CodPac);
        $Paciente->Num_Doc = $request->NumDoc;
        $Paciente->Cod_Emp = $datusu->Cod_Emp;
        $Paciente->Cod_Loc = $datusu->Cod_Loc;
        $Paciente->Pat_Pac = $request->PatPac;
        $Paciente->Mat_Pac = $request->MatPac;
        $Paciente->Nom_Pac = $request->NomPac;
        $Paciente->Cod_Doc = $request->CodDoc;
        $Paciente->Tip_Doc = $documento->Tip_Doc;
        $Paciente->Dir_Pac = $request->DirPac;
        $Paciente->Cod_Pais = $request->CodPais;
        $Paciente->Cod_Dep = $request->CodDep;
        $Paciente->Cod_Pro = $request->CodPro;
        $Paciente->Cod_Dis = $request->CodDis;
        $Paciente->Tel_Pac = $request->TelPac;
        $Paciente->Cel_Pac = $request->CelPac;
        $Paciente->Mail_Pac = $request->MailPac;
        $Paciente->Sexo_Pac = $request->radios;
        $Paciente->Fec_Nac_Pac = date("Y-m-d", strtotime($request->fecha_nacimiento));
        //subir archivo/imagen a la carpeta correspondiente
        if ($request->file('FotoPac')) {
            $dir = public_path() . '/Fotos/pacientes/';
            $file = $request->file('FotoPac');
            $image = $request->CodPac . '.' . $file->getClientOriginalExtension();
            $file->move($dir, $image);
            $Paciente->Ruta_Foto = 'Fotos/pacientes/' . $image;
        }
        $Paciente->save();

        return Redirect::to('almacen/paciente')->with('success', 'Paciente actualizado satisfactoriamente');
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
        $servicios = DB::select('CALL USP_LIS_SERVICIOS_MAESTRO(?)', [$datusu->Cod_Emp]);
        $tiposdoc = DB::table('personal_tipos_documentos')->get();

        return view('almacen.paciente.create', ['departamento' => $departamento,
            'pais' => $pais, 'servicios' => $servicios, 'codusu' => $codusu, 'datusu' => $datusu, 'tiposdoc' => $tiposdoc]);
    }

    public function postCreate(Request $request)
    {
        $validar = DB::table('pacientes_maestro')
            ->where("Operacion", '<>', 'E')
            ->where('Num_Doc', '=', $request->NumDoc)->first();
        if (!$validar) {
            $countpac = DB::table('pacientes_maestro')->count();
            if ($countpac == 0) {
                $CodPac = '000001';
            } else {
                $countpac = $countpac + 1;
                $maxpacformat = '000000' . $countpac;
                $CodPac = substr($maxpacformat, -6, 6);
            }
            //subir archivo/imagen a la carpeta correspondiente
            if ($request->file('FotoPac') !== null) {
                $dir = public_path() . '/Fotos/pacientes/';
                $file = $request->file('FotoPac');
                $image = $CodPac . '.' . $file->getClientOriginalExtension();
                $file->move($dir, $image);

                $foto = 'Fotos/pacientes/' . $image;
            }else{
                $foto = '';
            }

            $codusu = session('key')['CodUsu'];
            $datusu = DB::table('usuarios_personal')
                ->join('personal_maestro', 'usuarios_personal.Cod_Per', '=', 'personal_maestro.Cod_Per')
                ->where('usuarios_personal.Cod_Usu', $codusu)
                ->first();

            $fechaActual = date('Y-m-d');
            
            //die($request->fecha_nacimiento);

            $Paciente = new Paciente;
            $Paciente->Cod_Emp = $datusu->Cod_Emp;
            $Paciente->Cod_Loc = $datusu->Cod_Loc;
            $Paciente->Cod_Pac = $CodPac;
            $Paciente->Pat_Pac = $request->PatPac;
            $Paciente->Mat_Pac = $request->MatPac;
            $Paciente->Nom_Pac = $request->NomPac;
            $Paciente->Sexo_Pac = $request->radios;
            $Paciente->Fec_Nac_Pac = date("Y-m-d", strtotime($request->fecha_nacimiento));
            $Paciente->Dir_Nac_Pac = $request->DirPac;
            $Paciente->Cod_Pais_Nac = '';
            $Paciente->Cod_Dep_Nac = '';
            $Paciente->Cod_Pro_Nac = '';
            $Paciente->Cod_Dis_Nac = '';
            $tipdoc = DB::table('personal_tipos_documentos')->where('Cod_Tip_Doc', $request->tipdoc)->first();
            $Paciente->Cod_Doc = $tipdoc->Cod_Tip_Doc;
            $Paciente->Tip_Doc = $tipdoc->Tip_Doc;
            $Paciente->Num_Doc = $request->NumDoc;
            $Paciente->Ruc_Pac = '';
            $Paciente->SIS_Pac = '';
            $Paciente->Dir_Pac = $request->DirPac;
            $Paciente->Cod_Pais = $request->CodPais;
            $Paciente->Cod_Dep = $request->CodDep;
            $Paciente->Cod_Pro = $request->CodPro;
            $Paciente->Cod_Dis = $request->CodDis;
            $Paciente->Cod_Zon = '';
            $Paciente->Cod_Tip_Nac = '';
            $Paciente->Tel_Pac = $request->TelPac;
            $Paciente->Cel_Pac = $request->CelPac;
            $Paciente->Mail_Pac = $request->MailPac;
            $Paciente->Brv_Pac = '';
            $Paciente->Cod_Est_Civ = '';
            $Paciente->Cod_Tip_Pla = '';
            $Paciente->Cod_Tip_Crg = '';
            $Paciente->Cod_Tip_Pag = '';
            $Paciente->Cod_Per_Pag = '';
            $Paciente->Cod_Area = '';
            $Paciente->Cod_Tur = '';
            $Paciente->Cod_Tip = '';
            $Paciente->Disc_Pac = '';
            $Paciente->Cese_Pac = '';
            $Paciente->Cod_Tarjeta = '';
            $Paciente->Cod_Niv_Edu = '';
            $Paciente->Cod_Tip_Esp = '';
            $Paciente->Trabajo = '';
            $Paciente->Trabajo_Lug = '';
            $Paciente->Estudios = '';
            $Paciente->Profesion = '';
            $Paciente->Ocupacion = '';
            $Paciente->Otro_Dato = '';
            $Paciente->Foto_Pac = '';
            $Paciente->Ruta_Foto = $foto;
            $Paciente->Usuario_Ing = '';
            $Paciente->Usuario_Mod = '';
            $Paciente->Fecha_Ing = $fechaActual;
            $Paciente->Fecha_Mod = $fechaActual;
            $Paciente->Operacion = 'I';
            $Paciente->save();
            return redirect('almacen/paciente')->with('success', 'Paciente creado satisfactoriamente');
        } else {
            return back()->withInput($request->all())->with('danger', 'Ya existe paciente con N° Doc. : ' . $request->NumDoc);
        }
    }

    public function eliminar($CodEmp, $CodPac, $Usuario_Mod, $Fecha_Mod, $Operacion)
    {

        DB::select('call USP_UPD_PACIENTES_DEL(?, ?, ?, ?, ?)', [$CodEmp, $CodPac, $Usuario_Mod, $Fecha_Mod, $Operacion]);

        return redirect('almacen/paciente')->with('success', 'Paciente eliminado satisfactoriamente');

    }

}
