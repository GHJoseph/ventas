<?php

namespace SisVentas\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use SisVentas\TipoCambio;

class TipoCambioController extends Controller
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
        $valores = DB::table('monedas_tipos_cambios')
            ->orderBy('Fecha', 'DESC')
            ->get();

        return view('almacen.tipoCambio.index', ['valores' => $valores, 'codusu' => $codusu, 'datusu' => $datusu]);
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
    public function edit($NumDia, $NumMes, $Anno)
    {
        $codusu = session('key')['CodUsu'];
        $datusu = DB::table('usuarios_personal')
            ->join('personal_maestro', 'usuarios_personal.Cod_Per', '=', 'personal_maestro.Cod_Per')
            ->where('usuarios_personal.Cod_Usu', $codusu)
            ->first();

        $tipoCambio = DB::table('monedas_tipos_cambios')
            ->where('NumDia', '=', $NumDia)
            ->where('NumMes', '=', $NumMes)
            ->where('Anno', '=', $Anno)
            ->first();
        return view('almacen.tipoCambio.edit', ['tipos' => $tipoCambio, 'codusu' => $codusu, 'datusu' => $datusu]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $NumDia)
    {
        $TipoCambio = TipoCambio::where(['NumDia' => $NumDia, 'NumMes' => $request->mes, 'Anno' => $request->anno]);
        $datos = array(
            'Val_Cmp' => $request->compra,
            'Val_Vta' => $request->venta,
            'Usuario' => session('key')['CodUsu'],
            'Fecha' => date('Y-m-d h:i:s'),
            'Operacion' => 'M',
        );
        $TipoCambio->update($datos);
        return redirect()->route('tipos.index')
            ->with('success', 'Tipo de cambio actualizado satisfactoriamente.');
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

    public function obtenerTC()
    {
        $url = 'http://www.sunat.gob.pe/cl-at-ittipcam/tcS01Alias';
        $content = file_get_contents($url);
        $content = strip_tags($content);
        $content = preg_replace("/[\r\n|\n|\r|\t|\s]+/", ' ', $content);
        $content = strrchr($content, 'Venta');

        $inicial = strpos($content, 'Venta');
        $final = strpos($content, 'Notas:', $inicial);

        $longitud = ($final) - ($inicial);
        $datos = substr($content, $inicial + 5, $longitud - 6);

        $datos = explode(" ", ltrim($datos));

        $dia = date('j');
        $pos_array = array_search($dia, $datos);
        if (!$pos_array) {
            $pos_array = count($datos) - 3;
        }
        $retornar = [$datos[$pos_array], $datos[$pos_array + 1], $datos[$pos_array + 2]];
        return $retornar;
        //$second_step = explode("</div>" , $first_step[1] );*/

//        echo $second_step[0];
    }
}