<?php

namespace SisVentas\Http\Controllers;
use Illuminate\Http\Request;
use DB;

class TestController extends Controller{
    
    public function index(){
        $servicios = DB::select('CALL USP_LIS_SERVICIOS()');
        $test= DB::table('test')->get();
        //dd($test);
        return view('almacen.test.index', ['servicios' => $servicios, 'test' => $test]);
    }
    
    public function ajaxRequestPost(Request $request)
    {
        DB::table('test')->insert(
        ['nombre' => $request->get('name'), 'password' => $request->get('password'),
            'email' => $request->get('email'), 'fila' => $request->get('fila'), 'columna' => $request->get('columna')]
        );
        $input = request()->all();
        return response()->json(['success' => 'Got Simple Ajax Request.']);
    }
}
