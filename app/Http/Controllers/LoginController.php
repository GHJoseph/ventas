<?php

namespace SisVentas\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{

    public function index(Request $request)
    {

        $paises = DB::table('ubigeo_paises')->get();
        $locales = DB::table('empresas_locales')
            ->where('Cod_Dep','=','15')
            ->get();
        $idLocales = DB::table('empresas_locales')
            ->distinct()
            ->get(['Cod_Dep']);
        $id = [];
        foreach ($idLocales as $local) {
            array_push($id,$local->Cod_Dep);
        }
        $departamentos = DB::table('ubigeo_departamentos')
            ->whereIn('Cod_Dep', $id)
            ->get();
        return view('login/login', compact('locales', 'paises', 'departamentos'));

    }

    public function login(Request $request)
    {
        $users = DB::table('usuarios_personal')
            ->where('Nom_Usu', $request->usuario)
            ->where('cod_Pais', $request->pais)
            ->where('Cod_Dep', $request->departamento)
            ->where('Cod_Loc', $request->local)
            ->first();
        if ($users) {
            $estado = 1;
            $request->session()->put('key', ['CodUsu' => $users->Cod_Usu, 'CodEmp' => $users->Cod_Emp, 'CodLoc' => $users->Cod_Loc]);
        } else {
            $estado = 0;
        }
        $data = ['estado' => $estado,];
        return response($data, 200)->header('Content-Type', 'text/plain');
        // dd($users);
        #echo $users;
        /*if ($request->usuario = "jeff" && $request->clave == "123456") {
         // dd('Bienvenido');

            $estado= 1;
            $request->session()->put('key', ['CodUsu' => "001"]);

        }else{
            $estado= 0;
        }
        dump($users);
         $data = ['estado' => $estado,];*/
        //return response($data, 200)->header('Content-Type', 'text/plain');

        // $data = ['paciente' => $paciente,'ventasresumen' => $ventasresumen];
        //   return response($data, 200)->header('Content-Type', 'text/plain');


        // $k='$2y$10$eBuITsejSRuMsv.ka15WSOH1WVeNKObZlDL6Djdrnwef8fLN26bWy';
        // $hash = Hash::make($request->clave);
        // if(Hash::check($request->clave, $k) && $request->usuario=='jorge'){
        //  dd('Ingreso');
        // }


    }

    public function logout(Request $request){
        $request->session()->flush();
        return redirect()->route('index');
    }
}
