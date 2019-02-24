<?php

namespace SisVentas\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $codusu = session('key')['CodUsu'];
        $datusu = DB::table('usuarios_personal')
            ->join('personal_maestro', 'usuarios_personal.Cod_Per', '=', 'personal_maestro.Cod_Per')
            ->where('usuarios_personal.Cod_Usu', $codusu)
            ->first();
        $usuarios = DB::select("call USP_SEL_USUARIOS_PERSONAL(?)", [$datusu->Cod_Emp]);
        return view('roles.index', ['usuarios' => $usuarios, 'codusu' => $codusu, 'datusu' => $datusu]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $codusu = session('key')['CodUsu'];
        $datusu = DB::table('usuarios_personal')
            ->join('personal_maestro', 'usuarios_personal.Cod_Per', '=', 'personal_maestro.Cod_Per')
            ->where('usuarios_personal.Cod_Usu', $codusu)
            ->first();
        $usuario = DB::table('usuarios_personal')
            ->leftJoin('personal_maestro', 'usuarios_personal.Cod_Per', '=', 'personal_maestro.Cod_Per')
            ->leftJoin('usuarios_tipos', 'usuarios_personal.Cod_Tip_Usu', '=', 'usuarios_tipos.Cod_Tip_Usu')
            ->where('usuarios_personal.Cod_Emp', '=', session('key')['CodEmp'])
            ->where('usuarios_personal.Cod_Usu', '=', $id)
            ->first();
        $opciones = DB::table('usuarios_opciones')
            ->join('sistemas_menus', 'usuarios_opciones.Cod_Men', '=', 'sistemas_menus.Cod_Men')
            ->where('usuarios_opciones.Cod_Emp', '=', session('key')['CodEmp'])
            ->where('usuarios_opciones.Cod_Usu', '=', $id)
            ->get();
        $menus = DB::table('sistemas_menus')->get();
        return view('roles.edit', ['usuario' => $usuario, 'menus' => $menus, 'opciones' => $opciones, 'codusu' => $codusu, 'datusu' => $datusu]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $CodUsu = session('key')['CodUsu'];
        $CodEmp = session('key')['CodEmp'];
        $prueba = DB::table('usuarios_opciones')
            ->where('Cod_Usu', '=', $id)
            ->where('Cod_Emp', '=', $CodEmp)
            ->delete();

        $insert = [];
        foreach ($request->sel as $i => $sel) {
            array_push($insert, ['Cod_Emp' => $CodEmp, 'Cod_Men' => $request->opcion[$i], 'Cod_Usu' => $id, 'Todos' => $request->sel[$i], 'Ing_Opc' => $request->nuevo[$i], 'Mod_Opc' => $request->editar[$i], 'Bor_Opc' => $request->borrar[$i], 'Imp_Opc' => $request->imprimir[$i], 'Usuario' => $CodUsu, 'Fecha' => date('Y-m-d h:m:s'), 'Operacion' => 'M']);

        }
        DB::table('usuarios_opciones')->insert($insert);

        return redirect()->route('roles.index')
            ->with('success', 'Roles actualizados correctamente');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
