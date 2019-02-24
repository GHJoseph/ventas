<?php

namespace SisVentas\Http\Controllers;

use Illuminate\Http\Request;
use SisVentas\Articulo;
use DB;
use SisVentas\Servicio;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function BuscaProducto(Request $request)
    {

        $consulta = $request->input('prod');
        $servicios = Servicio::select("Nom_Serv as name", DB::raw("CONCAT(Cod_Serv,'-','S') as id"))->where("Nom_Serv", "LIKE", "%$consulta%");
        $data = Articulo::select("Nom_Art as name", DB::raw("CONCAT(Cod_Art,'-','P') as id"))->where("Nom_Art", "LIKE", "%$consulta%")
            ->union($servicios)
            ->get();

        $data_out = [];
        $data_out['incomplete_results'] = 'true';
        $data_out['items'] = $data;
        $data_out['total_count'] = count($data);
        return response()->json($data_out);


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */

    public function enviadatoproduct(Request $request)
    {
        $idproduct = $request->codprod;
        $tipo = $request->tipo;
        if ($tipo === 'P') {
            $dataprod = Articulo::select("Tip_Und as tipo", "Pre_Vta_MN as precio", "Cod_Art as cod")->where("Cod_Art", "=", $idproduct)->get();
        }
        if ($tipo === 'S') {
            $dataprod = Servicio::select("Tip_Und_Serv as tipo", "Pre_Serv as precio", "Cod_Serv as cod")->where("Cod_Serv", "=", $idproduct)->get();
        }
        return response($dataprod, 200)
            ->header('Content-Type', 'text/plain');
    }

    public function edit($id)
    {
        //
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
        //
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
