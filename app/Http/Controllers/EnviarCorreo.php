<?php

namespace SisVentas\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use SisVentas\Mail\EnviarComprobante;
use Illuminate\Support\Facades\Mail;


class EnviarCorreo extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function enviar($NumVnt)
    {
        $resultR = DB::table('ventas_resumen')->where('Num_Vnt', '=', $NumVnt)->first();
        $resultVD = DB::table('ventas_detalle')->where('Num_Vnt', '=', $NumVnt)->get();
        $Moneda = DB::table('monedas_maestro')->where('Cod_Mon', '=', $resultR->Cod_Mon)->first();
        if ($resultR->Tip_CP === 'C') {
            $persona = DB::table('clienprov_maestro')
                ->select(DB::raw("CONCAT(IFNULL(Ape_CP,'') , ' ' ,IFNULL(Nom_CP,'')) AS Nom_CP"), 'Cod_CP', 'Tel_CP', 'Cel_CP', 'Mail_CP', 'Num_Doc', 'Dir_CP', 'Tip_CP', 'Cod_Doc', 'Tip_Doc')
                ->where('Cod_CP', '=', $resultR->Cod_CP)
                ->first();
        }
        if ($resultR->Tip_CP === 'P') {
            $persona = DB::table('pacientes_maestro')
                ->select(DB::raw("CONCAT(IFNULL(Nom_Pac,''),' ',IFNULL(PAT_Pac,''),' ',IFNULL(MAT_Pac,'')) AS Nom_CP"), 'Cod_Pac as Cod_CP', 'Dir_Pac as Dir_CP', 'Tel_Pac as Tel_CP', 'Mail_Pac as Mail_CP', 'Cel_Pac as Cel_CP', 'Num_Doc', DB::raw('"P" as Tip_CP'), 'Cod_Doc', 'Tip_Doc')
                ->where('Cod_Pac', '=', $resultR->Cod_CP)
                ->first();
        }
        if ($resultR->Tip_CP === 'T') {
            $persona = DB::table('personal_maestro')
                ->select(DB::raw("CONCAT(IFNULL(Nom_Per,''),' ',IFNULL(PAT_Per,''),' ',IFNULL(MAT_Per,'')) AS Nom_CP"), 'Cod_Per as Cod_CP', 'Cod_Doc AS Cod_Doc_CP', 'Tip_Doc AS Tip_Doc_CP', 'Dir_Per as Dir_CP', 'Tel_Per as Tel_CP', 'Mail_Per as Mail_CP', 'Cel_Per as Cel_CP', 'Num_Doc', DB::raw('"T" as Tip_CP'), 'Cod_Doc', 'Tip_Doc')
                ->where('Cod_Per', '=', $resultR->Cod_CP)
                ->first();
        }
        // Construyendo el Correo
        if ($resultR->Cod_Doc === '01') {
            $tipo_documento = 'FACTURA';
        } elseif ($resultR->Cod_Doc === '03') {
            $tipo_documento = 'BOLETA';
        }
        $nombre_pdf = 'pdf/' . $persona->Num_Doc . '-' . $resultR->Cod_Doc . '-' . $resultR->Ser_Doc . '-' . (int)$resultR->Num_Doc . '-' . $resultR->Tot_Vta_MN . '.pdf';
        $subject = $tipo_documento . ' DE VENTA ELECTRÓNICA ' . $resultR->Ser_Doc . ' N° ' . $resultR->Num_Doc;
        //cambiar email a donde se desea enviar para pruebas
        $address = 'josephingsis@gmail.com'; // podemos cambiar a nuestro correo para comprobar si envia el correo
        $mailer = new EnviarComprobante($address, $subject, $persona, $resultR, storage_path($nombre_pdf));
        $mail = Mail::send($mailer);
        return view('correo.success');
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
