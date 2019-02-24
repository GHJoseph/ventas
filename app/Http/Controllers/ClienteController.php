<?php

namespace SisVentas\Http\Controllers;

use Illuminate\Http\Request;
use SisVentas\Paciente;
use SisVentas\Personal;
use SisVentas\Usuarios;
use DB;

class ClienteController extends Controller
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
    public function show(Request $request)
    {
        $codclient = $request->codclient;
        $tipo = $request->tipo;
        if ($tipo === 'C') {
            $data = DB::table('clienprov_maestro')
                ->where('Cod_CP', $codclient)
                ->where('Operacion', '<>','E')
                ->select('Cod_CP', 'Tel_CP', 'Cel_CP', 'Mail_CP', 'Dir_CP', 'Cod_Doc as Cod_Doc_CP', 'Tip_Doc as Tip_Doc_CP', 'Num_Doc as Num_Doc_CP')->get();
        }
        if ($tipo === 'P') {
            $data = DB::table('pacientes_maestro')->where('Cod_Pac', $codclient)
                ->where('Operacion', '<>','E')
                ->select('Cod_Pac as Cod_CP', 'Dir_Pac as Dir_CP', 'Tel_Pac as Tel_CP', 'Mail_Pac as Mail_CP', 'Cel_Pac as Cel_CP', 'Cod_Doc as Cod_Doc_CP', 'Tip_Doc as Tip_Doc_CP', 'Num_Doc as Num_Doc_CP')
                ->get();
        }
        if ($tipo == 'T') {
            $data = DB::table('personal_maestro')->where('Cod_Per', $codclient)
                ->where('Operacion', '<>','E')
                ->select('Cod_Per as Cod_CP', 'Dir_Per as Dir_CP', 'Tel_Per as Tel_CP', 'Mail_Per as Mail_CP', 'Cel_Per as Cel_CP', 'Cod_Doc as Cod_Doc_CP', 'Tip_Doc as Tip_Doc_CP', 'Num_Doc as Num_Doc_CP')
                ->get();
        }
        $dataclient = ['paciente' => $data];
        return response($dataclient, 200)->header('Content-Type', 'text/plain');

        // return view('almacen/facturacion/create',compact('dataclient'))

        // return Response::json($dataclient);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    public function FiltraClientes(Request $request)
    {
        $consulta = $request->input('clien');

// $data = Paciente::select("CONCAT(Ape_CP,Nom_CP) as name","Cod_CP as id")
        $pacientes = Paciente::select(DB::raw("CONCAT(IFNULL(Nom_PAC,''),' ',IFNULL(Pat_Pac,''),' ',IFNULL(Mat_Pac,'')) AS name"), DB::raw("CONCAT(Cod_Pac, '-','P') as id"))
            ->where("Operacion", '<>', 'E')
            ->where(function ($query) use ($consulta) {
                $query->where('Nom_Pac', 'LIKE', '%' . $consulta . '%')
                    ->orWhere('Pat_Pac', 'LIKE', '%' . $consulta . '%')
                    ->orWhere('Mat_Pac', 'LIKE', '%' . $consulta . '%');
            });

        $personal = Personal::select(DB::raw("CONCAT(IFNULL(Nom_Per,''),' ',IFNULL(Pat_Per,''),' ',IFNULL(Mat_Per,'')) AS name"), DB::raw("CONCAT(Cod_Per, '-','T') as id"))
            ->where("Operacion", '<>', 'E')
            ->where(function ($query) use ($consulta) {
                $query->where('Nom_Per', 'LIKE', '%' . $consulta . '%')
                    ->orWhere('Pat_Per', 'LIKE', '%' . $consulta . '%')
                    ->orWhere('Mat_Per', 'LIKE', '%' . $consulta . '%');
            });

        $data = DB::table('clienprov_maestro')->select(DB::raw("CONCAT(IFNULL(Ape_CP,'') , ' ' ,IFNULL(Nom_CP,'')) AS name"), DB::raw("CONCAT(Cod_CP,'-','C') as id"))
            ->where("Operacion", '<>', 'E')
            ->where(function ($query) use ($consulta) {
                $query->where('Nom_CP', 'LIKE', '%' . $consulta . '%')
                    ->orWhere('Ape_CP', 'LIKE', '%' . $consulta . '%');
            })
            ->union($personal)
            ->union($pacientes)
            ->get();
        // dump($data);
        $data_out = [];
        $data_out['incomplete_results'] = 'true';
        $data_out['items'] = $data;
        $data_out['total_count'] = count($data);
        return response()->json($data_out);
    }

    public function FiltraPacientes(Request $request)
    {
        $consulta = $request->input('paciente');
        $pacientes = Paciente::select(DB::raw("CONCAT(IFNULL(Nom_PAC,''),' ',IFNULL(PAT_PAC,''),' ',IFNULL(MAT_PAC,'')) AS name"), "Cod_PAC as id")
            ->where("Operacion", '<>', 'E')
            ->where(function ($query) use ($consulta) {
                $query->where('Nom_PAC', 'LIKE', '%' . $consulta . '%')
                    ->orWhere('PAT_PAC', 'LIKE', '%' . $consulta . '%')
                    ->orWhere('MAT_PAC', 'LIKE', '%' . $consulta . '%');
            })
            ->get();

        $data_out = [];
        $data_out['incomplete_results'] = 'true';
        $data_out['items'] = $pacientes;
        $data_out['total_count'] = count($pacientes);
        return response()->json($data_out);
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
