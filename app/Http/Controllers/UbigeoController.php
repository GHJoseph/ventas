<?php

namespace SisVentas\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UbigeoController extends Controller
{
    public function devuelvedepart(){

    }
    public function departamentoBuscar(Request $request){
        $departamento = DB::table('ubigeo_departamentos')
            ->where('Cod_Pais', $request->cod_pais)
            ->get();
        return response()->json($departamento);
    }
    public function departamento(Request $request){
        $departamento = DB::table('ubigeo_departamentos')
            ->where('Nom_Dep', $request->dep)
            ->get();
        return response()->json($departamento);
    }
    public function provincia(Request $request){
        $provincias = DB::table('ubigeo_provincias')
            ->where('Cod_Pais', $request->cod_pais)
            ->where('Cod_Dep', $request->cod_dep)
            ->get();
        return response()->json($provincias);
    }
    public function provinciaBuscar(Request $request){
        $provincia = DB::table('ubigeo_provincias')
            ->where('Nom_Pro', $request->pro)
            ->get();
        return response()->json($provincia);
    }

    public function distrito(Request $request){
        $distritos = DB::table('ubigeo_distritos')
            ->where('Cod_Pais', $request->cod_pais)
            ->where('Cod_Dep', $request->cod_dep)
            ->where('Cod_Pro', $request->cod_pro)
            ->get();
        return response()->json($distritos);
    }
    public function distritoBuscar(Request $request){
        $distrito = DB::table('ubigeo_distritos')
            ->where('Nom_Dis', $request->dis)
            ->get();
        return response()->json($distrito);
    }
    public function locales(Request $request){
        $locales = DB::table('empresas_locales')
            ->where('Cod_Dep', $request->CodDep)
            ->get();
        return response()->json($locales);
    }
}
