<?php

namespace SisVentas\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use  DB;
use SisVentas\Usuarios;

class UsuarioController extends Controller
{
    public function index()
    {
        $codusu = session('key')['CodUsu'];
        $datusu = DB::table('usuarios_personal')
            ->join('personal_maestro', 'usuarios_personal.Cod_Per', '=', 'personal_maestro.Cod_Per')
            ->where('usuarios_personal.Cod_Usu', $codusu)
            ->first();
        $tiposdoc = DB::table('personal_tipos_documentos')->get();
        $usuarios = DB::select("call USP_SEL_USUARIOS_PERSONAL(?)", [$datusu->Cod_Emp]);
        return view('almacen.usuario.index', ['usuarios' => $usuarios, 'codusu' => $codusu, 'datusu' => $datusu, 'tiposdoc' => $tiposdoc]);
    }

    public function create()
    {
        $codusu = session('key')['CodUsu'];
        $datusu = DB::table('usuarios_personal')
            ->join('personal_maestro', 'usuarios_personal.Cod_Per', '=', 'personal_maestro.Cod_Per')
            ->where('usuarios_personal.Cod_Usu', $codusu)
            ->first();
        $personal = DB::select('call USP_LIS_PERSONAL_MAESTRO()');
        $locales = DB::table('empresas_locales')->get();
        $pais = DB::select('call USP_LIS_UBIGEO_PAISES()');
        $departamento = DB::select('call USP_LIS_UBIGEO_DEPARTAMENTOS(?)', ['51']);
        $tipo_usuarios = DB::select('call USP_LIS_USUARIOS_TIPOS()');

        return view('almacen.usuario.create', ['tipo_usuarios' => $tipo_usuarios, 'personal' => $personal, 'local' => $locales, 'depart' => $departamento, 'codusu' => $codusu, 'pais' => $pais, 'datusu' => $datusu]);
    }

    public function store(Request $request)
    {
        $countusu = DB::table('usuarios_personal')->count();
        if ($countusu == 0) {
            $CodUsu = '001';
        } else {
            $countusu = $countusu + 1;
            $maxpacformat = '000' . $countusu;
            $CodUsu = substr($maxpacformat, -3, 3);
        }
        $Personal = DB::table('personal_maestro')
            ->where('personal_maestro.Cod_Per', '=', $request->get('SelectPer'))
            ->first();
        $usuario = array(
            'Cod_Emp' => session('key')['CodEmp'],
            'Cod_Sis' => '01',
            'Cod_Usu' => $CodUsu,
            'Nom_Usu' => $request->get('NomUsu'),
            'Key_Usu' => $request->get('KeyUsu'),
            'Cod_Per' => $request->get('SelectPer'),
            'Cod_Doc' => $Personal->Cod_Doc,
            'Tip_Doc' => $Personal->Tip_Doc,
            'Num_Doc' => $Personal->Num_Doc,
            'Cod_Tip_Usu' => $request->get('CodTipUsu'),
            'Estado' => 'A',
            'Usuario' => session('key')['CodUsu'],
            'Fecha' => date("Y-m-d H:i:s"),
            'Operacion' => 'I',
            'cod_Pais' => $request->get('CodPais'),
            'Cod_Dep' => $request->get('CodDep'),
            'Cod_Loc' => $request->get('CodLoc')
        );
        Usuarios::create($usuario);
        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario registrado satisfactoriamente.');

    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Usuarios $usuario)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($CodUsu)
    {
        $codusu = session('key')['CodUsu'];
        $datusu = DB::table('usuarios_personal')
            ->join('personal_maestro', 'usuarios_personal.Cod_Per', '=', 'personal_maestro.Cod_Per')
            ->where('usuarios_personal.Cod_Usu', $codusu)
            ->first();
        $locales = DB::table('empresas_locales')->get();
        $pais = DB::select('call USP_LIS_UBIGEO_PAISES()');
        $departamento = DB::select('call USP_LIS_UBIGEO_DEPARTAMENTOS(?)', ['51']);
        $tipo_usuarios = DB::select('call USP_LIS_USUARIOS_TIPOS()');

        $usuario = DB::table('usuarios_personal')
            ->where('Cod_Usu', '=', $CodUsu)
            ->first();
        $persona = DB::table('personal_maestro')->where('Cod_Per', '=', $usuario->Cod_Per)->first();
        return view('almacen.usuario.edit', ['usuario' => $usuario, 'tipo_usuarios' => $tipo_usuarios, 'persona' => $persona, 'local' => $locales, 'depart' => $departamento, 'codusu' => $codusu, 'pais' => $pais, 'datusu' => $datusu]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Usuarios $Usuario)
    {
        $Personal = DB::table('personal_maestro')
            ->where('personal_maestro.Cod_Per', '=', $request->get('SelectPer'))
            ->first();
        if ($request->get('KeyUsu')) {
            $password = $request->get('KeyUsu');
            $KeyAnt = $Usuario->Key_Usu;
        } else {
            $password = $Usuario->Key_Usu;
            $KeyAnt = $Usuario->Key_Ant;
        }
        $usuario = array(
            'Cod_Emp' => session('key')['CodEmp'],
            'Cod_Sis' => '01',
            'Cod_Usu' => $request->get('CodUsu'),
            'Nom_Usu' => $request->get('NomUsu'),
            'Key_Usu' => $password,
            'Cod_Per' => $request->get('SelectPer'),
            'Cod_Doc' => $Personal->Cod_Doc,
            'Tip_Doc' => $Personal->Tip_Doc,
            'Num_Doc' => $Personal->Num_Doc,
            'Key_Ant' => $KeyAnt,
            'Cod_Tip_Usu' => $request->get('CodTipUsu'),
            'Estado' => 'A',
            'Usuario' => session('key')['CodUsu'],
            'Fecha' => date("Y-m-d H:i:s"),
            'Operacion' => 'M',
            'cod_Pais' => $request->get('CodPais'),
            'Cod_Dep' => $request->get('CodDep'),
            'Cod_Loc' => $request->get('CodLoc')
        );
        $Usuario->update($usuario);
        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario actualizado satisfactoriamente.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $usuario = Usuarios::find($id);
        $usuario->delete();
        return redirect()->route('usuarios.index')
            ->with('success', 'Usuario eliminado satisfactoriamente.');
    }
}
