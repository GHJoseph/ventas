<?php

namespace SisVentas\Http\Controllers;

use Illuminate\Http\Request;

use DB;

class EnvioSunatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('almacen.EnvioSunat.03_firmarFactura');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('almacen.EnvioSunat.03_firmarFactura');
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

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function crear_xml()
    {

        $pendientes = DB::select('CALL USP_SEEK_SUNAT_DOCUMENTOS_TIPOS_PROCESO()');
        if (count($pendientes) > 0) {
            $codusu = session('key')['CodUsu'];
            $datusu = DB::table('usuarios_personal')
                ->join('personal_maestro', 'usuarios_personal.Cod_Per', '=', 'personal_maestro.Cod_Per')
                ->where('usuarios_personal.Cod_Usu', $codusu)
                ->first();

            $cCodDoc = $pendientes[0]->COD_DOC;
            $cCodDocRef = $pendientes[0]->COD_DOC_REF;
            $cEstado = $pendientes[0]->ESTADO;
            $cImprimir = $pendientes[0]->IMPRIMIR;

            if (($cCodDoc == "03" || (($cCodDoc == "07" || $cCodDoc == "08") && $cCodDocRef == "03")) && ($cEstado == "A" || $cEstado == "P")) $cCodDoc = "70";
            if (($cCodDoc == "01" || (($cCodDoc == "07" || $cCodDoc == "08") && $cCodDocRef == "01")) && ($cEstado == "A" || $cImprimir == "E")) $cCodDoc = "71";
            // dump($pendientes);
            $cCodDoc = '01';
//dump($cCodDoc);
            switch ($cCodDoc) {
                case "01":
                    $factura = DB::select('call USP_SEEK_VENTAS_FACTURAS_SUNAT(?,?,?,?)', [$datusu->Cod_Emp, $datusu->Cod_Loc, $pendientes[0]->SER_DOC, $pendientes[0]->NUM_DOC]);
                    //dump($factura);

                    return view('almacen.EnvioSunat.02_generarFactura', ['factura' => $factura]);
                    break;
                case "70":
                    //dump($pendientes[0]->FEC_DOC);
                    $fecha = date('Y-m-d', strtotime($pendientes[0]->FEC_DOC));
                    $resumen = DB::select('call USP_SEEK_VENTAS_BOLETAS_SUNAT(?,?,?)', [$datusu->Cod_Emp, $datusu->Cod_Loc, $pendientes[0]->FEC_DOC]);
                    $correlativo = DB::table('sistemas_correlativos')
                        ->where([
                                'Cod_Emp' => $datusu->Cod_Emp,
                                'Cod_Doc' => $cCodDoc
                            ]
                        )->first();
                    //dump($resumen);
                    return view('almacen.EnvioSunat.generarResumen', ['resumen' => $resumen, 'fecha' => $fecha,'correlativo' => $correlativo]);
                    break;
                case "07":

                case "08":
                    //cMsg = proc.SunatNotasDebitos();
                    break;
                case "09":
                    //cMsg = proc.SunatGuiaRemisionRemite();
                    break;
                case "71":

                case "20":
                    //cMsg = proc.SunatRetenciones();
                    break;
            }
        } else {
            return redirect()->back()->with('error', 'No existe documentos CPE pendientes de envio a Sunat.');
        }

    }

    public function enviar_sunat()
    {
        return view('almacen.EnvioSunat.04_enviarFactura');
    }
}
