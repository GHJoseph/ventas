<?php

namespace SisVentas\Http\Controllers;

use Illuminate\Http\Request;
use SisVentas\ventasresumen;
USE Barryvdh\Snappy\Facades\SnappyPdf AS PDF;
// use App\SistemasCorrelativos;
use SisVentas\ventasdetalletmp;
use SisVentas\VentasDetalle;
use Illuminate\Support\Facades\Input;
use SisVentas\SistemasCorrelativas;

use DB;

class FacturacionController extends Controller
{

    public function index(Request $request)
    {
        $inicio = $request->fechaInicio;
        $fin = $request->fechaFin;
        if ($inicio === null & $fin === null) {
            $inicio = date('Y-m-d');
            $fin = date('Y-m-d');
        } else {
            $inicio = date("Y-m-d", strtotime($inicio));
            $fin = date("Y-m-d", strtotime($fin));
        }
        $anioactual = date("Y");
        $mesactual = date("m");
        $codusu = session('key')['CodUsu'];
        $codusu = session('key')['CodUsu'];

        $datusu = DB::table('usuarios_personal')
            ->join('personal_maestro', 'usuarios_personal.Cod_Per', '=', 'personal_maestro.Cod_Per')
            ->where('usuarios_personal.Cod_Usu', $codusu)
            ->first();
        $ventas = DB::select('call USP_SEL_VENTAS_RESUMEN2(?, ?, ?,?)', [$datusu->Cod_Emp, $datusu->Cod_Loc, $inicio, $fin]);
        $ventas_anulados = DB::table('ventas_resumen')
            ->where('Fec_Doc', '>=', $inicio)
            ->where('Fec_Doc', '<=', $fin)
            ->where('Imprimir', '=', 'A')
            ->get();
        $countResumenVenta = DB::table('ventas_resumen')->count();
        $maxmes = DB::table('ventas_resumen')->max('RegMes');
        if (empty($maxmes)) {
            $valormesfactF = '0001';
        } else {
            $maxmes = $maxmes + 1;
            $maxmesformat = '0000' . $maxmes;
            $valormesfact = substr($maxmesformat, -4, 4);
        }
        if ($countResumenVenta == 0) {
            $cNumVnt = $anioactual . $mesactual . '0001';
        } else {
            $cNumVnt = $anioactual . $mesactual . $valormesfact;
        }
        $inicio = date("d-m-Y", strtotime($inicio));
        $fin = date("d-m-Y", strtotime($fin));
        //traemos los pendientes
        $pendientes = DB::select('CALL USP_SEEK_SUNAT_DOCUMENTOS_TIPOS_PROCESO()');
//dump($pendientes);
        return view('almacen.facturacion.index', ['ventas' => $ventas, 'ventas_anulados' => $ventas_anulados, 'cNumVnt' => $cNumVnt, 'codusu' => $codusu, 'datusu' => $datusu, 'inicio' => $inicio, 'fin' => $fin, 'pendientes' => $pendientes]);
    }

    public function MandadatosFactEletronica(Request $request)
    {
        // dd($request->all());
        $fechadate = $request->datepickVenta;
        $mesdate = substr($fechadate, -5, 2);
        $anniodate = substr($fechadate, 0, 4);
        $fechadate2 = $request->datepickVenta2;
// dd($anniodate);


        $ventas = DB::select('call USP_SEL_VENTAS_RESUMEN2(?, ?, ?, ?)', ['01', '01', $fechadate, $fechadate2]);

        $countfactAct = DB::select('call USP_COUNT_FACTURAS_ACTIVO(?, ?, ?,?)', ['01', '01', $request->selectanio, $request->selectmes]);

        $sumfactAct = DB::select('call USP_SUM_FACTURAS_Tot_Vta_MN(?, ?, ?,?)', ['01', '01', $request->selectanio, $request->selectmes]);

        $countBoletaAct = DB::select('call USP_COUNT_BOLETA_ACTIVO(?, ?, ?,?)', ['01', '01', $request->selectanio, $request->selectmes]);

        $sumBolAct = DB::select('call USP_SUM_Boletas_Tot_Vta_MN(?, ?, ?,?)', ['01', '01', $request->selectanio, $request->selectmes]);

        $SumBolActME = DB::select('call USP_SUM_Boletas_Tot_Vta_ME(?, ?, ?,?)', ['01', '01', $request->selectanio, $request->selectmes]);

        $SumfactActME = DB::select('call USP_SUM_FACTURAS_Tot_Vta_ME(?, ?, ?,?)', ['01', '01', $request->selectanio, $request->selectmes]);

        $codusu = session('key')['CodUsu'];
        $datusu = DB::table('usuarios_personal')
            ->join('personal_maestro', 'usuarios_personal.Cod_Per', '=', 'personal_maestro.Cod_Per')
            ->where('usuarios_personal.Cod_Usu', $codusu)
            ->first();

        return view('almacen/facturacion/index', compact('ventas', 'countfactAct', 'sumfactAct', 'countBoletaAct', 'sumBolAct', 'SumBolActME', 'SumfactActME', 'codusu', 'datusu'));

    }

    public function pdfventa($NumVnt)
    {
        $resultR = DB::table('ventas_resumen')->where('Num_Vnt', '=', $NumVnt)->first();
        $resultVD = DB::table('ventas_detalle')->where('Num_Vnt', '=', $NumVnt)->get();
        $Moneda = DB::table('monedas_maestro')->where('Cod_Mon', '=', $resultR->Cod_Mon)->first();

        return view('Reportes/reporteventa', compact('resultR', 'resultVD', 'Moneda'));
    }

// Update del modal 
    public function edit(Request $request)
    {
        $codusu = session('key')['CodUsu'];
        $e = ventasdetalletmp::where('Item_Vnt', $request->modal_vta)
            ->where('Usuario', $codusu)
            ->update(['Dst_Art' => $request->modal_descuento, 'Cod_Art' => $request->modal_producto, 'Nom_Art' => $request->modal_nomProducto, 'Can_Art' => $request->modal_cantidad, 'Pre_Art_MN' => $request->modal_precio, 'Val_Art_MN' => $request->modal_valor, 'Igv_Art_MN' => $request->modal_igv, 'Vta_Art_MN' => $request->modal_monto, 'Pre_Vnt_MN' => $request->modal_precioventa]);
        return response()->json("Producto Editado");
    }

    public function GrabaTempaDetalle(Request $request)
    {
        $fechaActual = date('Y-m-d');
        $anioactual = date("Y");
        $mesactual = date("m");
        $camposdetalles = DB::table('ventas_detalle')->where('Num_Vnt', $request->NumVnt)->first();
        if ($request->Cod_Mon === 'D') {
            $Sub_Vta_MN = number_format($request->SubTotal * $request->TipoCambio, 2);
            $Val_Vta_MN = number_format($request->ValVnt * $request->TipoCambio, 2);
            $Igv_Vta_MN = number_format($request->IGVVnt * $request->TipoCambio, 2);
            $Tot_Vta_MN = number_format($request->TotVnt * $request->TipoCambio, 2);
            $Dst_Vta_MN = number_format($request->DstMonto * $request->TipoCambio, 2);

            $Sub_Vta_ME = number_format($request->SubTotal, 2);
            $Val_Vta_ME = number_format($request->ValVnt, 2);
            $Igv_Vta_ME = number_format($request->IGVVnt, 2);
            $Tot_Vta_ME = number_format($request->TotVnt, 2);
            $Dst_Vta_ME = number_format($request->DstMonto, 2);
        } else {
            $Sub_Vta_ME = number_format($request->SubTotal / $request->TipoCambio, 2);
            $Val_Vta_ME = number_format($request->ValVnt / $request->TipoCambio, 2);
            $Igv_Vta_ME = number_format($request->IGVVnt / $request->TipoCambio, 2);
            $Tot_Vta_ME = number_format($request->TotVnt / $request->TipoCambio, 2);
            $Dst_Vta_ME = number_format($request->DstMonto / $request->TipoCambio, 2);

            $Sub_Vta_MN = number_format($request->SubTotal, 2);
            $Val_Vta_MN = number_format($request->ValVnt, 2);
            $Igv_Vta_MN = number_format($request->IGVVnt, 2);
            $Tot_Vta_MN = number_format($request->TotVnt, 2);
            $Dst_Vta_MN = number_format($request->DstMonto, 2);
        }
        DB::table('ventas_resumen')
            ->where('Num_Vnt', $request->NumVnt)
            ->update(['Sub_Vta_MN' => $Sub_Vta_MN, 'Dst_Vta_MN' => $Dst_Vta_MN, 'Val_Vta_MN' => $Val_Vta_MN, 'Igv_Vta_MN' => $Igv_Vta_MN, 'Tot_Vta_MN' => $Tot_Vta_MN, 'Sub_Vta_ME' => $Sub_Vta_ME, 'Dst_Vta_Me' => $Dst_Vta_ME, 'Val_Vta_ME' => $Val_Vta_ME, 'Igv_Vta_ME' => $Igv_Vta_ME, 'Tot_Vta_ME' => $Tot_Vta_ME, 'Obs_Vnt' => $request->Obser, 'Dst_Vnt' => $request->DstPorc, 'Dst_Vta_MN' => $request->DstMonto, 'Sub_Vta_MN' => $request->SubTotal, 'Cod_Tip_Vta' => $request->tipventa, 'Cod_Tip_Cob' => $request->tipcobro, 'Efec_Vta_ME' => $request->Efec_Vta_ME, 'Efec_Vta_MN' => $request->Efec_Vta_MN, 'Vuelto_Vta_MN' => $request->Vuelto_Vta_MN, 'Tip_Cam_Esp' => $request->TipoCambio, 'Tip_Cam' => $request->TipoCambio, 'Cod_Mon' => $request->Cod_Mon]);
        DB::select('call UPD_VENTASDETALLETEMP_DETALLE(?,?,?,?,?,?,?,?,?)', [$camposdetalles->Num_Vnt, '01', '01', $anioactual, $mesactual, $camposdetalles->RegAnno, $camposdetalles->RegMes, $fechaActual, $camposdetalles->Num_Doc]);
        $data_out = ['page' => url('almacen/facturacion')];
        return response()->json($data_out);
    }

    public function editventa($Num_Vnt)
    {
        $codusu = session('key')['CodUsu'];
        $ventasdetalletmp = DB::table('ventas_detalle_tmp')->where('Usuario', $codusu)->delete();
        $datusu = DB::table('usuarios_personal')
            ->join('personal_maestro', 'usuarios_personal.Cod_Per', '=', 'personal_maestro.Cod_Per')
            ->where('usuarios_personal.Cod_Usu', $codusu)
            ->first();

        $subtotalsum = DB::table('ventas_detalle_tmp')->sum('Val_Art_MN');
        $detalle = DB::table('ventas_resumen')
            ->join('sunat_documentos_tipos', 'ventas_resumen.Cod_Doc', '=', 'sunat_documentos_tipos.Cod_Doc')
            ->join('monedas_maestro', 'ventas_resumen.Cod_Mon', '=', 'monedas_maestro.Cod_Mon')
            ->where('Num_Vnt', $Num_Vnt)
            ->first();
        if ($detalle->Tip_CP == 'C') {
            $persona = DB::table('clienprov_maestro')
                ->select(DB::raw("CONCAT(IFNULL(Ape_CP,'') , ' ' ,IFNULL(Nom_CP,'')) AS Nom_CP"), 'Cod_CP', 'Tel_CP', 'Cel_CP', 'Mail_CP', 'Num_Doc', 'Dir_CP', 'Tip_CP', 'Cod_Doc', 'Tip_Doc')
                ->where('Cod_CP', '=', $detalle->Cod_CP)
                ->first();
        }
        if ($detalle->Tip_CP == 'P') {
            $persona = DB::table('pacientes_maestro')
                ->select(DB::raw("CONCAT(IFNULL(Nom_Pac,''),' ',IFNULL(PAT_Pac,''),' ',IFNULL(MAT_Pac,'')) AS Nom_CP"), 'Cod_Pac as Cod_CP', 'Dir_Pac as Dir_CP', 'Tel_Pac as Tel_CP', 'Mail_Pac as Mail_CP', 'Cel_Pac as Cel_CP', 'Num_Doc', DB::raw('"P" as Tip_CP'), 'Cod_Doc', 'Tip_Doc')
                ->where('Cod_Pac', '=', $detalle->Cod_CP)
                ->first();
        }
        if ($detalle->Tip_CP == 'T') {
            $persona = DB::table('personal_maestro')
                ->select(DB::raw("CONCAT(IFNULL(Nom_Per,''),' ',IFNULL(PAT_Per,''),' ',IFNULL(MAT_Per,'')) AS Nom_CP"), 'Cod_Per as Cod_CP', 'Cod_Doc AS Cod_Doc_CP', 'Tip_Doc AS Tip_Doc_CP', 'Dir_Per as Dir_CP', 'Tel_Per as Tel_CP', 'Mail_Per as Mail_CP', 'Cel_Per as Cel_CP', 'Num_Doc', DB::raw('"T" as Tip_CP'), 'Cod_Doc', 'Tip_Doc')
                ->where('Cod_Per', '=', $detalle->Cod_CP)
                ->first();
        }
        $detalle2 = DB::table('ventas_resumen')
            ->where('Num_Vnt', $Num_Vnt)
            ->first();
        DB::table('ventas_detalle_tmp')->where('Num_Doc', '=', $detalle2->Num_Doc)->delete();
        // Me reinicia el contador
        $tipDoc = DB::select('CALL USP_LIS_SUNAT_DOCUMENTOS_FAC_BOL()');
        $monedas = DB::select('CALL USP_LIS_MONEDAS_MAESTRO()');
        $ventastipos = DB::select('CALL USP_LIS_VENTAS_TIPOS()');
        $tiposcobros = DB::select('CALL USP_LIS_VENTAS_TIPOS_COBROS()');
        //DB::statement("ALTER TABLE `ventas_detalle_tmp` AUTO_INCREMENT = 1;");
        DB::select('call USP_UPD_VENTAS_DETALLE_TMP(?,?)', [$Num_Vnt, $codusu]);
        return view('almacen/facturacion/edit', ['detalle' => $detalle, 'subtotalsum' => $subtotalsum, 'datusu' => $datusu, 'persona' => $persona, 'tipDoc' => $tipDoc, 'monedas' => $monedas, 'ventastipos' => $ventastipos, 'tiposcobros' => $tiposcobros,]);
    }

    public function create(Request $request)
    {

        $maxanio = DB::table('ventas_resumen')
            ->max('Reganno');
        // ----  Me genera el correlativo del Nro de Venta -----------
        if (empty($maxanio)) {
            $maxanio = '000001';
        } else {
            $maxanio = $maxanio + 1;
            $maxanioformat = '000000' . $maxanio;
            $valoraniofact = substr($maxanioformat, -6, 6);
        }
        $maxmes = DB::table('ventas_resumen')->max('RegMes');
        if (empty($maxmes)) {
            $maxmes = '0001';
        } else {
            $maxmes = $maxmes + 1;
            $maxmesformat = '0000' . $maxmes;
            $valormesfact = substr($maxmesformat, -4, 4);

        }
        $anioactual = date("Y");
        $mesactual = date("m");
        $countResumenVenta = DB::table('ventas_resumen')->count();
        if ($countResumenVenta == 0) {
            $cNumVnt = $anioactual . $mesactual . '0001';
        } else {
            $cNumVnt = $anioactual . $mesactual . $valormesfact;
        }
        $codusu = session('key')['CodUsu'];
        // ----  Fin de  genera el correlativo del Nro de Venta -----------

        $tipDoc = DB::select('CALL USP_LIS_SUNAT_DOCUMENTOS_FAC_BOL()');
        $clientes = DB::select('CALL USP_LIS_CLIENTES_MAESTRO()');
        $articulos = DB::select('CALL USP_LIS_ARTICULOS_MAESTRO()');
        $monedas = DB::select('CALL USP_LIS_MONEDAS_MAESTRO()');
        $ventastipos = DB::select('CALL USP_LIS_VENTAS_TIPOS()');
        $tiposcobros = DB::select('CALL USP_LIS_VENTAS_TIPOS_COBROS()');
        $detalletemp = DB::table('ventas_detalle_tmp')
            ->where('Usuario', '=', $codusu)
            ->orderByRaw('Item_Vnt ASC')
            ->get();
        $subtotalsum = DB::table('ventas_detalle_tmp')
            ->where('Usuario', '=', $codusu)
            ->sum('Val_Art_MN');

        $datusu = DB::table('usuarios_personal')
            ->join('personal_maestro', 'usuarios_personal.Cod_Per', '=', 'personal_maestro.Cod_Per')
            ->where('usuarios_personal.Cod_Usu', $codusu)
            ->first();

        $codusu = session('key')['CodUsu'];
        $ventasdetalletmp = DB::table('ventas_detalle_tmp')->where('Usuario', $codusu)->delete();


        return view('almacen.facturacion.create', ['clientes' => $clientes, 'tipDoc' => $tipDoc, 'articulos' => $articulos, 'monedas' => $monedas, 'cNumVnt' => $cNumVnt, 'ventastipos' => $ventastipos, 'tiposcobros' => $tiposcobros, 'detalletemp' => $detalletemp, 'subtotalsum' => $subtotalsum, 'codusu' => $codusu, 'datusu' => $datusu]);
    }

    public function MandaDatosTipoFactura(Request $request)
    {
//  ------------  Generacion del nro de Serie y del Nro de Documento  ------
        $datTipoDoc = DB::table('sunat_documentos_tipos')->where('Cod_Doc', $request->codfact)->first();


        $codusu = session('key')['CodUsu'];
        $datusu = DB::table('usuarios_personal')
            ->join('personal_maestro', 'usuarios_personal.Cod_Per', '=', 'personal_maestro.Cod_Per')
            ->where('usuarios_personal.Cod_Usu', $codusu)
            ->first();


        $Nroserie = DB::table('Sistemas_correlativos')
            ->where('Cod_Emp', '=', $datusu->Cod_Emp)
            ->Where('Cod_Loc', '=', $datusu->Cod_Loc)
            ->Where('Tip_Doc', '=', $datTipoDoc->Tip_Doc)
            ->get();

        return response($Nroserie, 200)
            ->header('Content-Type', 'text/plain');
    }

    public function DevuelvesimboloDinero(Request $request)
    {

        $simbolo = DB::table('monedas_maestro')->where('Cod_Mon', $request->SimbolDiner)->get();

        return response($simbolo, 200)
            ->header('Content-Type', 'text/plain');

    }

    public function store(Request $request)
    {
        $anioactual = date("Y");
        $mesactual = date("m");
        $maxanio = DB::table('ventas_resumen')
            ->max('Reganno')
            ->where('RegAnno', '=', $anioactual);

        if (empty($maxanio)) {
            $maxanio = '000001';
        } else {
            $maxanio = $maxanio + 1;
            $maxanioformat = '000000' . $maxanio;
            $valoraniofact = substr($maxanioformat, -6, 6);
        }
    }

    public function DeletedetalleTemp(Request $request)
    {
        $codusu = session('key')['CodUsu'];
        $ventasdetalletmp = DB::table('ventas_detalle_tmp')
            ->where('Usuario', '=', $codusu)
            ->where('Item_Vnt', '=', $request->itemdetTemp)
            ->delete();
    }

    public function cargadatosgrilla()
    {
        $codusu = session('key')['CodUsu'];
        $datosventDetTemp = DB::table('ventas_detalle_tmp')
            ->where('Usuario', '=', $codusu)
            ->orderByRaw('Item_Vnt ASC')
            ->get();
        $data = ['datosvenDetTemp' => $datosventDetTemp];
        return response($data, 200)->header('Content-Type', 'text/plain');
// $data = [
// 'masitemVnt' =>  $masitemVnt
// 'datosvenDetTemp' => $datosventDetTemp
// ] ;

//  return response($data, 200)
//                    ->header('Content-Type', 'text/plain');
    }

    public function devuelveNumeroaLetras(Request $request)
    {
        $arrayNumeros = explode(".", $request->total);

        $numletra = convierte($arrayNumeros[0]);
        $data = [
            'numletra' => $numletra . 'con ' . $arrayNumeros[1] . '/100' . '  ' . $request->nomoneda
        ];
        return response($data, 200)->header('Content-Type', 'text/plain');

    }

    public function BuscaClientexDocumento(Request $request)
    {
        $paciente = DB::table('clienprov_maestro')->where('Num_Doc', $request->cliente)
            ->select(DB::raw('Cod_CP, CONCAT(Nom_CP," ",IFNULL(Ape_CP,"")) as Nom_CP, Cod_Doc as Cod_Doc_CP,Tip_Doc as Tip_Doc_CP, Num_Doc as Num_Doc_CP, Dir_CP, Tel_CP, Mail_CP, Cel_CP'))
            ->where('Operacion', '<>', 'E')
            ->get();
        $tip_CP = 'C';

        if (count($paciente) == 0) {
            $paciente = DB::table('pacientes_maestro')->where('Num_Doc', $request->cliente)
                ->select(DB::raw('Cod_Pac as Cod_CP,RTRIM(CONCAT(Nom_Pac," ",IFNULL(Pat_Pac,"")," ",IFNULL(Mat_Pac,""))) as Nom_CP, Cod_Doc as Cod_Doc_CP,Tip_Doc as Tip_Doc_CP, Num_Doc as Num_Doc_CP, Dir_Pac as Dir_CP, Tel_Pac as Tel_CP, Mail_Pac as Mail_CP, Cel_Pac as Cel_CP'))
                ->where('Operacion', '<>', 'E')
                ->get();
            $tip_CP = 'P';

            if (count($paciente) == 0) {
                $paciente = DB::table('personal_maestro')->where('Num_Doc', $request->cliente)
                    ->select(DB::raw('Cod_Per as Cod_CP, RTRIM(CONCAT(Nom_Per," ",IFNULL(PAT_Per,"")," ",IFNULL(Mat_Per,""))) as Nom_CP, Cod_Doc as Cod_Doc_CP,Tip_Doc as Tip_Doc_CP, Num_Doc as Num_Doc_CP, Dir_Per as Dir_CP, Tel_Per as Tel_CP, Mail_Per as Mail_CP, Cel_Per as Cel_CP'))
                    ->where('Operacion', '<>', 'E')
                    ->get();
                $tip_CP = 'T';
            }
        }
        $CodClient = $paciente[0]->Cod_CP;
        $ventasresumen = DB::table('ventas_resumen')->where('Cod_CP', $CodClient)->join('monedas_maestro', 'ventas_resumen.Cod_Mon', '=', 'monedas_maestro.Cod_Mon')->get();
        $data = ['tip_CP' => $tip_CP, 'paciente' => $paciente, 'ventasresumen' => $ventasresumen];
        return response($data, 200)->header('Content-Type', 'text/plain');
    }

    public function CalculaTotal()
    {
        $codusu = session('key')['CodUsu'];
        $totalventa = DB::table('ventas_detalle_tmp')
            ->where('usuario', '=', $codusu)
            ->sum('Val_Art_MN');

        $data = ['totalventa' => $totalventa];
        return response($data, 200)->header('Content-Type', 'text/plain');
        return response()->json("Calculado");
    }


    public function MandaDatoDetalle_Edit(Request $request)
    {
        // dd($request->NumVnt);
//   $grilla= DB::table('ventas_detalle')->where('Num_Vnt', $request->NumVnt)->get();
// dd($grilla);
    }

    public function MandaDatoDetalle_SaveEdit(Request $request)
    {
        $countitemVnt = DB::table('ventas_detalle')->count();

        $hoy = date("Y-m-d H:i:s");
        $DatosDetalles = DB::table('ventas_detalle')->where('Num_Vnt', $request->NumVnt)->first();
        if ($request->tipo == 'P') {
            $datosartic = DB::table('articulos_maestro')->where('Cod_Art', $request->Codart)->first();
        }
        if ($request->tipo == 'S') {
            $datosartic = DB::table('servicios_maestro')->where('Cod_Serv', $request->Codart)->first();
        }
        $TipoMonedacod = $request->moneda_imput;
        $valodolar = $request->tipoCambio;
        if ($TipoMonedacod == 'S') {
            $PreArtMN = $request->precartMn;
            $ValArtMN = $request->valartMn;
            $IgvArtMN = $request->Igv;
            $PreVntMN = $request->pventa;
            $VtaArtMN = $request->txtMonto;

            if ($valodolar > 0) {
                $PreArtME = number_format($request->precartMn / $valodolar, 2);
                $ValArtME = number_format($request->valartMn / $valodolar, 2);
                $IgvArtME = number_format($request->Igv / $valodolar, 2);
                $PreVntME = number_format($request->pventa / $valodolar, 2);
                $VtaArtME = number_format($request->txtMonto / $valodolar, 2);
            } else {
                $PreArtME = 0;
                $ValArtME = 0;
                $IgvArtME = 0;
                $PreVntME = 0;
                $VtaArtME = 0;
            }
        } else {    // Puede ser Dolar o Euros etc.
            $PreArtMN = number_format($request->precartMn * $valodolar, 2);
            $ValArtMN = number_format($request->valartMn * $valodolar, 2);
            $IgvArtMN = number_format($request->Igv * $valodolar, 2);
            $PreVntMN = number_format($request->pventa * $valodolar, 2);
            $VtaArtMN = number_format($request->txtMonto * $valodolar, 2);

            $PreArtME = $request->precartMn;
            $ValArtME = $request->valartMn;
            $IgvArtME = $request->Igv;
            $PreVntME = $request->pventa;
            $VtaArtME = $request->txtMonto;
        };
        $ventasdetalletmp = new ventasdetalletmp;
        $ventasdetalletmp->Cod_Doc = $DatosDetalles->Cod_Doc;
        $ventasdetalletmp->Tip_Doc = $DatosDetalles->Tip_Doc;
        $ventasdetalletmp->Ser_Doc = $DatosDetalles->Ser_Doc;
        $ventasdetalletmp->Num_Doc = $DatosDetalles->Num_Doc;
        $ventasdetalletmp->Fec_Doc = $DatosDetalles->Fec_Doc;
        $ventasdetalletmp->Cod_Rub = $DatosDetalles->Cod_Rub;
        $ventasdetalletmp->Cod_Mod = $DatosDetalles->Cod_Mod;
        $ventasdetalletmp->Cod_Mar = $DatosDetalles->Cod_Mar;
        $ventasdetalletmp->Cod_Art = $request->Codart;
        if ($request->tipo === 'P') {
            $ventasdetalletmp->Nom_Art = $datosartic->Nom_Art;
            $ventasdetalletmp->Cod_Und = $datosartic->Cod_Und;
            $ventasdetalletmp->Tip_Und = $datosartic->Tip_Und;
        }
        if ($request->tipo === 'S') {
            $ventasdetalletmp->Nom_Art = $datosartic->Nom_Serv;
            $ventasdetalletmp->Cod_Und = $datosartic->Cod_Und_Serv;
            $ventasdetalletmp->Tip_Und = $datosartic->Tip_Und_Serv;
        }
        $ventasdetalletmp->Can_Art = $request->txtcant;
        $ventasdetalletmp->Dst_Art = $request->txtdesc;
        $ventasdetalletmp->Pre_Art_MN = $PreArtMN;
        $ventasdetalletmp->Val_Art_MN = $ValArtMN;
        $ventasdetalletmp->Igv_Art_MN = $IgvArtMN;
        $ventasdetalletmp->Dsct_Art_MN = $request->txtMontoDesc;
        $ventasdetalletmp->Pre_Vnt_MN = $PreVntMN;
        $ventasdetalletmp->Vta_Art_MN = $VtaArtMN;
        $ventasdetalletmp->Pre_Art_ME = $PreArtME;
        $ventasdetalletmp->Val_Art_ME = $ValArtME;
        $ventasdetalletmp->Igv_Art_ME = $IgvArtME;
        $ventasdetalletmp->Pre_Vnt_ME = $PreVntME;
        $ventasdetalletmp->Vta_Art_ME = $VtaArtME;
        $ventasdetalletmp->Cod_Mon = $request->moneda_imput;
        $ventasdetalletmp->Tip_Cam = $valodolar;
        $ventasdetalletmp->Fec_Cam = $hoy;
        $ventasdetalletmp->Cod_CP = $request->idcliente;
        $ventasdetalletmp->Tip_CP = '';
        $ventasdetalletmp->Cod_Doc_CP = '';
        $ventasdetalletmp->Tip_Doc_CP = '';
        $ventasdetalletmp->Num_Doc_CP = '';

        $codusu = session('key')['CodUsu'];

        $ventasdetalletmp->Usuario = $codusu;
        $ventasdetalletmp->Fecha = $hoy;
        $ventasdetalletmp->Operacion = 'M';
        $ventasdetalletmp->save();

        return response()->json("Producto enviado");

    }

    public function GrabaDetallesVentaTemp(Request $request)
    {
        $DocTipo = DB::table('sunat_documentos_tipos')->select('Nom_doc', 'Tip_Doc')
            ->where('Cod_Doc', '=', $request->TipDoc)
            ->first();

        $masitemVnt = DB::table('ventas_detalle_tmp')->max('item_vnt');
        if ($masitemVnt == '0') {
            $masitemVnt = 1;
        } else {
            $masitemVnt = $masitemVnt + 1;
        }
        if ($request->tipo === 'P') {
            $datart = DB::table('articulos_maestro')
                ->where('Cod_Art', $request->txtcodprod)
                ->first();
        }
        if ($request->tipo === 'S') {
            $datart = DB::table('servicios_maestro')
                ->where('Cod_Serv', $request->txtcodprod)
                ->first();
        }
        $TipoMonedacod = $request->moneda_imput;
        $valodolar = $request->txtTC;

        if ($TipoMonedacod == 'S') {
            $PreArtMN = $request->txtprecio;
            $ValArtMN = $request->txtvalor;
            $IgvArtMN = $request->txtIgv;
            $PreVntMN = $request->pventa;
            $VtaArtMN = $request->txtMonto;

            if ($valodolar > 0) {
                $PreArtME = number_format($request->txtprecio / $valodolar, 2);
                $ValArtME = number_format($request->txtvalor / $valodolar, 2);
                $IgvArtME = number_format($request->txtIgv / $valodolar, 2);
                $PreVntME = number_format($request->pventa / $valodolar, 2);
                $VtaArtME = number_format($request->txtMonto / $valodolar, 2);
            } else {
                $PreArtME = 0;
                $ValArtME = 0;
                $IgvArtME = 0;
                $PreVntME = 0;
                $VtaArtME = 0;
            }

        } else {    // Puede ser Dolar o Euros etc.
            $PreArtMN = number_format($request->txtprecio * $valodolar, 2);
            $ValArtMN = number_format($request->txtvalor * $valodolar, 2);
            $IgvArtMN = number_format($request->txtIgv * $valodolar, 2);
            $PreVntMN = number_format($request->pventa * $valodolar, 2);
            $VtaArtMN = number_format($request->txtMonto * $valodolar, 2);

            $PreArtME = $request->txtprecio;
            $ValArtME = $request->txtvalor;
            $IgvArtME = $request->txtIgv;
            $PreVntME = $request->pventa;
            $VtaArtME = $request->txtMonto;

        }
        $hoy = date("Y-m-d H:i:s");
        $ventasdetalletmp = new ventasdetalletmp;

        $ventasdetalletmp->Cod_Doc = $request->TipDoc;
        $ventasdetalletmp->Tip_Doc = $DocTipo->Tip_Doc;
        $ventasdetalletmp->Ser_Doc = $request->txtserie;
        $ventasdetalletmp->Num_Doc = $request->numero;
        $ventasdetalletmp->Fec_Doc = $request->fecEmi;
        $ventasdetalletmp->Item_Vnt = $masitemVnt;
        if ($request->tipo === 'P') {
            $ventasdetalletmp->Cod_Rub = $datart->Nom_Rub;
            $ventasdetalletmp->Cod_Mod = $datart->Cod_Mod;
            $ventasdetalletmp->Cod_Mar = $datart->Cod_Mar;
            $ventasdetalletmp->Cod_Art = $datart->Cod_Art;
            $ventasdetalletmp->Nom_Art = $datart->Nom_Art;
            $ventasdetalletmp->Cod_Und = $datart->Cod_Und;
            $ventasdetalletmp->Tip_Und = $datart->Tip_Und;
        } else {
            $ventasdetalletmp->Cod_Rub = $datart->Cod_Rub;
            $ventasdetalletmp->Cod_Mod = '000';
            $ventasdetalletmp->Cod_Mar = '000';
            $ventasdetalletmp->Cod_Art = $datart->Cod_Serv;
            $ventasdetalletmp->Nom_Art = $datart->Nom_Serv;
            $ventasdetalletmp->Cod_Und = $datart->Cod_Und_Serv;
            $ventasdetalletmp->Tip_Und = $datart->Tip_Und_Serv;
        }
        $ventasdetalletmp->Can_Art = $request->txtcant;
        $ventasdetalletmp->Dst_Art = $request->Dscto;
        $ventasdetalletmp->Pre_Art_MN = $PreArtMN;
        $ventasdetalletmp->Val_Art_MN = $ValArtMN;
        $ventasdetalletmp->Igv_Art_MN = $IgvArtMN;
        $ventasdetalletmp->Dsct_Art_MN = $request->txtMontoDesc;
        $ventasdetalletmp->Pre_Vnt_MN = $PreVntMN;
        $ventasdetalletmp->Vta_Art_MN = $VtaArtMN;
        $ventasdetalletmp->Pre_Art_ME = $PreArtME;
        $ventasdetalletmp->Val_Art_ME = $ValArtME;
        $ventasdetalletmp->Igv_Art_ME = $IgvArtME;
        $ventasdetalletmp->Pre_Vnt_ME = $PreVntME;
        $ventasdetalletmp->Vta_Art_ME = $VtaArtME;
        $ventasdetalletmp->Cod_Mon = $request->moneda_imput;
        $ventasdetalletmp->Tip_Cam = $valodolar;
        $ventasdetalletmp->Fec_Cam = $hoy;
        $ventasdetalletmp->Cod_CP = $request->idcliente;
        $ventasdetalletmp->Tip_CP = $request->TipCP;
        $ventasdetalletmp->Cod_Doc_CP = $request->CodDocCP;
        $ventasdetalletmp->Tip_Doc_CP = $request->TipDocCP;
        $ventasdetalletmp->Num_Doc_CP = $request->NumDocCP;

        $codusu = session('key')['CodUsu'];

        $ventasdetalletmp->Usuario = $codusu;
        $ventasdetalletmp->Fecha = $hoy;
        $ventasdetalletmp->Operacion = 'I';
        $ventasdetalletmp->save();

        return response()->json("Producto Ingresado");
    }

    public function cargar(Request $request)
    {
        $this->validate($request, [
            'selectcliente' => 'required',
            'txtserie' => 'required',
            'fecEmi' => 'required',
        ]);
        $cargar = Input::get('btn-agregar');
        if (isset($cargar)) {
        }

        $grabar = Input::get('Insert');
        if (isset($grabar)) {
            //Me graba  los  Detalles de Ventas
            $datosventDet = DB::table('ventas_detalle_tmp')
                ->where('usuario', '=', session('key')['CodUsu'])
                ->get();
            $countitemVnt = DB::table('ventas_detalle_tmp')
                ->where('usuario', '=', session('key')['CodUsu'])
                ->count();
            if ($countitemVnt == '0') {
                echo '<script type="text/javascript">
                        alert("Ingrese Productos Servicios");
                        history.go(-1);
                      </script>';
            } else {
                $anioactual = date("Y");
                $mesactual = date("m");
                $hoy = date("Y-m-d H:i:s");
                $maxanio = DB::table('ventas_resumen')
                    ->max('Reganno');
                if (empty($maxanio)) {
                    $maxanio = '000001';
                } else {
                    $maxanio = $maxanio + 1;
                    $maxanioformat = '000000' . $maxanio;
                    $valoraniofact = substr($maxanioformat, -6, 6);
                }
                $maxmes = DB::table('ventas_resumen')->max('RegMes');
                if (empty($maxmes)) {
                    $maxmes = '0001';
                } else {
                    $maxmes = $maxmes + 1;
                    $maxmesformat = '0000' . $maxmes;
                    $valormesfact = substr($maxmesformat, -4, 4);
                }
                $countResumenVenta = DB::table('ventas_resumen')->count();
                if ($countResumenVenta == 0) {
                    $cNumVnt = $anioactual . $mesactual . '0001';
                } else {
                    $cNumVnt = $anioactual . $mesactual . $valormesfact;
                }
                // $cNumVnt = $anioactual.$mesactual.$valormesfact;
                $DocTipo = DB::table('sunat_documentos_tipos')->select('Nom_doc', 'Tip_Doc')
                    ->where('Cod_Doc', '=', $request->TipDoc)
                    ->first();
                // dd($DocTipo);

                $num = array();
                $CodRub = array();
                $CodMod = array();
                $CodMar = array();
                $CodArt = array();
                $NomArt = array();
                $CodUnd = array();
                $TipUnd = array();
                $CanArt = array();
                $DstArt = array();
                $TipDoc = array();
                $PreArtMN = array();
                $IgvArtMN = array();
                $DsctArtMN = array();
                $ValArtMN = array();
                $PreVntMN = array();
                $VtaArtMN = array();
                $PreArtME = array();
                $IgvArtME = array();
                $ValArtME = array();
                $PreVntME = array();
                $VtaArtME = array();
                $Ser_Doc = array();
                $CodDoc = array();
                $SerDoc = array();
                $NumDoc = array();
                $i = 0;
                foreach ($datosventDet as $data) {
                    $i = $i + 1;
                    $num[] = $i;
                    $CodRub[] = $data->Cod_Rub;
                    $CodMod[] = $data->Cod_Mod;
                    $CodMar[] = $data->Cod_Mar;
                    $CodArt[] = $data->Cod_Art;
                    $NomArt[] = $data->Nom_Art;
                    $CodUnd[] = $data->Cod_Und;
                    $TipDoc[] = $data->Tip_Doc;
                    $TipUnd[] = $data->Tip_Und;
                    $CanArt[] = $data->Can_Art;
                    $DstArt[] = $data->Dst_Art;
                    $PreArtMN[] = $data->Pre_Art_MN;
                    $ValArtMN[] = $data->Val_Art_MN;
                    $IgvArtMN[] = $data->Igv_Art_MN;
                    $DsctArtMN[] = $data->Dsct_Art_MN;
                    $PreVntMN[] = $data->Pre_Vnt_MN;
                    $VtaArtMN[] = $data->Vta_Art_MN;
                    $PreArtME[] = $data->Pre_Art_ME;
                    $ValArtME[] = $data->Val_Art_ME;
                    $IgvArtME[] = $data->Igv_Art_ME;
                    $PreVntME[] = $data->Pre_Vnt_ME;
                    $VtaArtME[] = $data->Vta_Art_ME;
                    $CodMon[] = $data->Cod_Mon;
                    $TipCam[] = $data->Tip_Cam;
                    $FecCam[] = $data->Fec_Cam;
                    $CodCP[] = $data->Cod_CP;
                    $TipCP[] = $data->Tip_CP;
                    $CodDocCP[] = $data->Cod_Doc_CP;
                    $TipDocCP[] = $data->Tip_Doc_CP;
                    $NumDocCP[] = $data->Num_Doc_CP;
                    $CodDoc[] = $data->Cod_Doc;
                    $SerDoc[] = $data->Ser_Doc;
                    $NumDoc[] = $data->Num_Doc;
                }
                for ($j = 0; $j <= $countitemVnt - 1; $j++) {
                    $ventasdetalle = new VentasDetalle;
                    $maxanio = DB::table('ventas_resumen')
                        ->max('Reganno');
                    if (empty($maxanio)) {
                        $valoraniofact = '000001';
                    } else {
                        $maxanio = $maxanio + 1;
                        $maxanioformat = '000000' . $maxanio;
                        $valoraniofact = substr($maxanioformat, -6, 6);
                    }
                    $maxmes = DB::table('ventas_resumen')->max('RegMes');
                    if (empty($maxmes)) {
                        $valormesfact = '0001';
                    } else {
                        $maxmes = $maxmes + 1;
                        $maxmesformat = '0000' . $maxmes;
                        $valormesfact = substr($maxmesformat, -4, 4);
                    }
                    $codusu = session('key')['CodUsu'];
                    $datusu = DB::table('usuarios_personal')
                        ->join('personal_maestro', 'usuarios_personal.Cod_Per', '=', 'personal_maestro.Cod_Per')
                        ->where('usuarios_personal.Cod_Usu', $codusu)
                        ->first();
                    $ventasdetalle->Cod_Emp = $datusu->Cod_Emp;
                    $ventasdetalle->Cod_Loc = $datusu->Cod_Loc;
                    $ventasdetalle->Anno = $anioactual;
                    $ventasdetalle->NumMes = $mesactual;
                    $ventasdetalle->RegAnno = $valoraniofact;
                    $ventasdetalle->RegMes = $valormesfact;
                    $ventasdetalle->Num_Vnt = $cNumVnt;
                    $ventasdetalle->Fec_Vnt = $hoy;
                    $ventasdetalle->Cod_Doc = $CodDoc[$j];
                    $ventasdetalle->Tip_Doc = $TipDoc[$j];
                    $ventasdetalle->Ser_Doc = $SerDoc[$j];
                    $ventasdetalle->Num_Doc = $NumDoc[$j];
                    $ventasdetalle->Fec_Doc = $hoy;
                    $ventasdetalle->Item_Vnt = $num[$j];
                    $ventasdetalle->Cod_Rub = $CodRub[$j];
                    $ventasdetalle->Cod_Mod = $CodMod[$j];
                    $ventasdetalle->Cod_Mar = $CodMar[$j];
                    $ventasdetalle->Cod_Art = $CodArt[$j];
                    $ventasdetalle->Nom_Art = $NomArt[$j];
                    $ventasdetalle->Cod_Prd = '';
                    $ventasdetalle->Cod_Und = $CodUnd[$j];
                    $ventasdetalle->Tip_Und = $TipUnd[$j];
                    $ventasdetalle->Ser_Art = '';
                    $ventasdetalle->Can_Art = $CanArt[$j];
                    $ventasdetalle->Dst_Art = $DstArt[$j];
                    $ventasdetalle->Pre_Art_MN = $PreArtMN[$j];
                    $ventasdetalle->Val_Art_MN = $ValArtMN[$j];
                    $ventasdetalle->Igv_Art_MN = $IgvArtMN[$j];
                    $ventasdetalle->Pre_Vnt_MN = $PreVntMN[$j];
                    $ventasdetalle->Vta_Art_MN = $VtaArtMN[$j];
                    $ventasdetalle->Pre_Art_ME = $PreArtME[$j];
                    $ventasdetalle->Val_Art_ME = $ValArtME[$j];
                    $ventasdetalle->Igv_Art_ME = $IgvArtME[$j];
                    $ventasdetalle->Dsct_Art_MN = $DsctArtMN[$j];
                    $ventasdetalle->Pre_Vnt_ME = $PreVntME[$j];
                    $ventasdetalle->Vta_Art_ME = $VtaArtME[$j];
                    $ventasdetalle->Cod_Mon = $CodMon[$j];
                    $ventasdetalle->Tip_Cam = $TipCam[$j];
                    $ventasdetalle->Fec_Cam = $FecCam[$j];
                    $ventasdetalle->Cod_CP = $CodCP[$j];
                    $ventasdetalle->Tip_CP = $TipCP[$j];
                    $ventasdetalle->Cod_Doc_CP = $CodDocCP[$j];
                    $ventasdetalle->Tip_Doc_CP = $TipDocCP[$j];
                    $ventasdetalle->Num_Doc_CP = $NumDocCP[$j];
                    $ventasdetalle->Estado = 'P';
                    $ventasdetalle->Usuario = $codusu;
                    $ventasdetalle->Fecha = $hoy;
                    $ventasdetalle->Operacion = 'I';
                    $ventasdetalle->save();
                }
                $ventasresumen = new ventasresumen;
                $codusu = session('key')['CodUsu'];
                $datusu = DB::table('usuarios_personal')
                    ->join('personal_maestro', 'usuarios_personal.Cod_Per', '=', 'personal_maestro.Cod_Per')
                    ->where('usuarios_personal.Cod_Usu', $codusu)
                    ->first();
                $ventasresumen->Cod_Emp = $datusu->Cod_Emp;
                $ventasresumen->Cod_Loc = $datusu->Cod_Loc;
                $ventasresumen->Anno = $anioactual;
                $ventasresumen->NumMes = $mesactual;
                $ventasresumen->RegAnno = $valoraniofact;
                $ventasresumen->RegMes = $valormesfact;
                $ventasresumen->Num_Vnt = $cNumVnt;
                $ventasresumen->Fec_Vnt = $hoy;
                $ventasresumen->Ser_Guia = $request->txtserie;
                $ventasresumen->Num_Guia = $request->numero;
                $ventasresumen->Fec_Guia = $request->fecEmi;
                $ventasresumen->Cod_Doc = $request->TipDoc;
                $ventasresumen->Tip_Doc = $DocTipo->Tip_Doc;
                $ventasresumen->Ser_Doc = $request->txtserie;
                $ventasresumen->Num_Doc = $request->numero;
                $ventasresumen->Fec_Doc = $request->fecEmi;
                $ventasresumen->Dst_Vnt = $request->txtporc;
                $TipoMonedacod = $request->moneda_imput;
                $valodolar = $request->txtTC;
                if ($TipoMonedacod == 'S') {
                    $ventasresumen->Sub_Vta_MN = $request->SubTotal;
                    $ventasresumen->Ant_Vta_MN = '0';
                    $ventasresumen->Dst_Vta_MN = $request->txtdesc;
                    $ventasresumen->Val_Vta_MN = $request->vventa;
                    $ventasresumen->Isc_Vta_MN = '0';
                    $ventasresumen->Igv_Vta_MN = $request->IGV;
                    $ventasresumen->Carg_Vta_MN = '0';
                    $ventasresumen->Trib_Vta_MN = '0';
                    $ventasresumen->Tot_Vta_MN = $request->totaltotal;
                    $ventasresumen->Efec_Vta_MN = '0';
                    $ventasresumen->Tarj_Vta_MN = '0';
                    $ventasresumen->Vuelto_Vta_MN = '0';
                    if ($valodolar > 0) {
                        $ventasresumen->Sub_Vta_ME = $request->SubTotal / $valodolar;
                        $ventasresumen->Ant_Vta_ME = '0';
                        $ventasresumen->Dst_Vta_ME = $request->txtdesc / $valodolar;
                        $ventasresumen->Val_Vta_ME = $request->vventa / $valodolar;
                        $ventasresumen->Isc_Vta_ME = '0';
                        $ventasresumen->Igv_Vta_ME = $request->IGV / $valodolar;
                        $ventasresumen->Carg_Vta_ME = '0';
                        $ventasresumen->Trib_Vta_ME = '0';
                        $ventasresumen->Tot_Vta_ME = $request->totaltotal / $valodolar;
                        $ventasresumen->Efec_Vta_ME = $request->Efec_Vta_ME;
                        $ventasresumen->Tarj_Vta_ME = '0';
                        $ventasresumen->Vuelto_Vta_ME = '0';
                    } else {
                        $ventasresumen->Sub_Vta_ME = '0';
                        $ventasresumen->Ant_Vta_ME = '0';
                        $ventasresumen->Dst_Vta_ME = '0';
                        $ventasresumen->Val_Vta_ME = '0';
                        $ventasresumen->Isc_Vta_ME = '0';
                        $ventasresumen->Igv_Vta_ME = '0';
                        $ventasresumen->Carg_Vta_ME = '0';
                        $ventasresumen->Trib_Vta_ME = '0';
                        $ventasresumen->Tot_Vta_ME = '0';
                        $ventasresumen->Efec_Vta_ME = '0';
                        $ventasresumen->Tarj_Vta_ME = '0';
                        $ventasresumen->Vuelto_Vta_ME = '0';
                    }
                } else {
                    $ventasresumen->Sub_Vta_ME = $request->SubTotal;
                    $ventasresumen->Ant_Vta_ME = '0';
                    $ventasresumen->Dst_Vta_ME = $request->txtdesc;
                    $ventasresumen->Val_Vta_ME = $request->vventa;
                    $ventasresumen->Isc_Vta_ME = '0';
                    $ventasresumen->Igv_Vta_ME = $request->IGV;
                    $ventasresumen->Carg_Vta_ME = '0';
                    $ventasresumen->Trib_Vta_ME = '0';
                    $ventasresumen->Tot_Vta_ME = $request->totaltotal;
                    $ventasresumen->Efec_Vta_ME = $request->convDolar;
                    $ventasresumen->Tarj_Vta_ME = '0';
                    $ventasresumen->Vuelto_Vta_ME = '0';

                    $ventasresumen->Sub_Vta_MN = $request->SubTotal;
                    $ventasresumen->Ant_Vta_MN = '0';
                    $ventasresumen->Dst_Vta_MN = $request->txtdesc;
                    $ventasresumen->Val_Vta_MN = $request->vventa;
                    $ventasresumen->Isc_Vta_MN = '0';
                    $ventasresumen->Igv_Vta_MN = $request->IGV;
                    $ventasresumen->Carg_Vta_MN = '0';
                    $ventasresumen->Trib_Vta_MN = '0';
                    $ventasresumen->Tot_Vta_MN = $request->totaltotal;
                    $ventasresumen->Efec_Vta_MN = $request->convSoles;
                    $ventasresumen->Tarj_Vta_MN = '0';
                    $ventasresumen->Vuelto_Vta_MN = $request->vuelto;
                }

                $Igv = DB::table('sunat_impuestos')->where('Cod_Imp', '001')->first();
                $ventasresumen->Cod_Imp = $Igv->Cod_Imp;
                $ventasresumen->Tas_Imp = $Igv->Tas_Imp;
                $ventasresumen->Cod_Mon = $request->moneda_imput;
                $ventasresumen->Tip_Cam_Esp = $valodolar;
                $ventasresumen->Tip_Cam = $request->ndoc;
                $ventasresumen->Fec_Cam = $request->fecEmi;
                $ventasresumen->Cod_CP = $request->CodCP;
                $ventasresumen->Tip_CP = $request->Tip_CP;
                if ($request->Tip_CP == 'C') {
                    $cliente = DB::table('clienprov_maestro')->where('Cod_CP', $request->CodCP)->first();
                } elseif ($request->Tip_CP == 'P') {
                    $cliente = DB::table('pacientes_maestro')->where('Cod_Pac', $request->CodCP)->first();
                } elseif ($request->Tip_CP == 'T') {
                    $cliente = DB::table('personal_maestro')->where('Cod_Per', $request->CodCP)->first();
                }
                $ventasresumen->Cod_Doc_CP = $cliente->Cod_Doc;
                $ventasresumen->Tip_Doc_CP = $cliente->Tip_Doc;
                $ventasresumen->Num_Doc_CP = $cliente->Num_Doc;
                $ventasresumen->Cod_Con = '001';
                $ventasresumen->Cod_Tip_Vta = $request->tipventa;
                $ventasresumen->Cod_Tip_Cob = $request->tipcobro;
                $ventasresumen->Fec_Cob = $request->fecEmi;
                $ventasresumen->Obs_Vnt = $request->obser;
                $ventasresumen->Tot_Vta_Letra = $request->txtNumLetra;
                $ventasresumen->Cod_Lib = '05';
                $ventasresumen->Num_Cta = '7001';
                $ventasresumen->Num_Prf = '';
                $ventasresumen->Fec_Prf = '19000101';
                $ventasresumen->Ord_cmp = '';
                $ventasresumen->Cod_Per = '000000';
                $ventasresumen->Cod_Tur = '00';
                $ventasresumen->Estado = 'P';
                $ventasresumen->Imprimir = 'P';
                $ventasresumen->File_Zip = '-';
                $ventasresumen->Cod_Hash = '-';
                $ventasresumen->Cod_Error = '-';
                $ventasresumen->Ticket = '-';
                $ventasresumen->CDR = 'N';
                $codusu = session('key')['CodUsu'];
                $ventasresumen->Usuario = $codusu;
                $ventasresumen->Fecha = $hoy;
                $ventasresumen->Operacion = 'I';
                $ventasresumen->save();

                $Nrocorrelativo = DB::table('sistemas_correlativos')
                    ->where('Cod_Doc', $request->TipDoc)
                    ->where('Ser_Doc', $request->txtserie)
                    ->first();
                $Numdoc = $Nrocorrelativo->Num_Doc + 1;
                $number = sprintf('%06d', $Numdoc);

                $SistemaCorrelativo = SistemasCorrelativas::where([
                    'Cod_Doc' => $request->TipDoc,
                    'Ser_Doc' => $request->txtserie])->update(['Num_Doc' => $number]);

                // dd($number);
                $codusu = session('key')['CodUsu'];
                $ventasdetalletmp = DB::table('ventas_detalle_tmp')->where('Usuario', $codusu)->delete();

                return redirect('almacen/facturacion');
            }
        }
    }

    public function cancelarVenta()
    {
        $codusu = session('key')['CodUsu'];
        $ventasdetalletmp = DB::table('ventas_detalle_tmp')->where('Usuario', $codusu)->delete();
        return redirect('almacen/facturacion');
    }

    public function ventasResumen(Request $request)
    {
        $ventasresumen = DB::table('ventas_resumen')
            ->where('Tip_CP', $request->Tip_CP)
            ->where('Cod_CP', $request->cod_CP)
            ->where('Cod_Doc', $request->cod_DOC)
            ->join('monedas_maestro', 'ventas_resumen.Cod_Mon', '=', 'monedas_maestro.Cod_Mon')->get();

        $ventas_notas = DB::table('ventas_notas')
            ->where('Tip_CP', $request->Tip_CP)
            ->where('Cod_CP', $request->cod_CP)
            ->where('Cod_Doc_Ref', $request->cod_DOC)->get();

        $dataclient = ['ventasresumen' => $ventasresumen, 'ventasnotas' => $ventas_notas];
        return response($dataclient, 200)->header('Content-Type', 'text/plain');
    }

    public function detalleVenta(Request $request)
    {
        $NumVnt = $request->NumVnt;
        $cabecera = DB::table('ventas_resumen')
            ->where('Num_Vnt', '=', $NumVnt)->first();
        if ($cabecera->Tip_CP === 'C') {
            $persona = DB::table('clienprov_maestro')
                ->select(DB::raw("CONCAT(IFNULL(Ape_CP,'') , ' ' ,IFNULL(Nom_CP,'')) AS Nom_CP"), 'Cod_CP', 'Tel_CP', 'Cel_CP', 'Mail_CP', 'Dir_CP', 'Cod_Doc as Cod_Doc_CP', 'Tip_Doc as Tip_Doc_CP', 'Num_Doc as Num_Doc_CP')
                ->where('Cod_CP', $cabecera->Cod_CP)
                ->where('Operacion', '<>', 'E')
                ->first();
        }
        if ($cabecera->Tip_CP === 'P') {
            $persona = DB::table('pacientes_maestro')
                ->select(DB::raw("CONCAT(IFNULL(Nom_PAC,''),' ',IFNULL(Pat_Pac,''),' ',IFNULL(Mat_Pac,'')) AS Nom_CP"), 'Cod_Pac as Cod_CP', 'Dir_Pac as Dir_CP', 'Tel_Pac as Tel_CP', 'Mail_Pac as Mail_CP', 'Cel_Pac as Cel_CP', 'Cod_Doc as Cod_Doc_CP', 'Tip_Doc as Tip_Doc_CP', 'Num_Doc as Num_Doc_CP')
                ->where('Cod_Pac', $cabecera->Cod_CP)
                ->where('Operacion', '<>', 'E')
                ->first();
        }
        if ($cabecera->Tip_CP == 'T') {
            $persona = DB::table('personal_maestro')
                ->select(DB::raw("CONCAT(IFNULL(Nom_Per,''),' ',IFNULL(Pat_Per,''),' ',IFNULL(Mat_Per,'')) AS Nom_CP"), 'Cod_Per as Cod_CP', 'Dir_Per as Dir_CP', 'Tel_Per as Tel_CP', 'Mail_Per as Mail_CP', 'Cel_Per as Cel_CP', 'Cod_Doc as Cod_Doc_CP', 'Tip_Doc as Tip_Doc_CP', 'Num_Doc as Num_Doc_CP')
                ->where('Cod_Per', $cabecera->Cod_CP)
                ->where('Operacion', '<>', 'E')
                ->first();
        }
        $detalle = DB::table('ventas_detalle')
            ->where('Num_Vnt', '=', $NumVnt)
            ->get();
        return response()->json(array(
            'cabecera' => $cabecera,
            'persona' => $persona,
            'detalle' => $detalle
        ));
    }

    public function reporte($NumVnt)
    {
        $codusu = session('key')['CodUsu'];
        $datusu = DB::table('usuarios_personal')
            ->join('personal_maestro', 'usuarios_personal.Cod_Per', '=', 'personal_maestro.Cod_Per')
            ->where('usuarios_personal.Cod_Usu', $codusu)
            ->first();
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

        $nombre_pdf = $persona->Num_Doc . '-' . $resultR->Cod_Doc . '-' . $resultR->Ser_Doc . '-' . (int)$resultR->Num_Doc . '-' . $resultR->Tot_Vta_MN . '.pdf';
        if (!file_exists(storage_path() . '/pdf/' . $nombre_pdf)) {
            $pdf = PDF::loadView('almacen.facturacion.reporte_imprimir', compact('resultR', 'resultVD', 'persona'))
                ->setTemporaryFolder('/Users/joseph/tmp')
                ->setPaper('a4')->setOrientation('landscape')->setOption('margin-bottom', 0);

            $path = 'pdf/' . $nombre_pdf;
            $pdf->save(storage_path($path));
        }
        return view('almacen.facturacion.reporte', compact('resultR', 'resultVD', 'Moneda', 'persona', 'datusu', 'codusu'));
    }

    public function reporte_imprimir($NumVnt)
    {
        $codusu = session('key')['CodUsu'];
        $datusu = DB::table('usuarios_personal')
            ->join('personal_maestro', 'usuarios_personal.Cod_Per', '=', 'personal_maestro.Cod_Per')
            ->where('usuarios_personal.Cod_Usu', $codusu)
            ->first();
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
        $nombre_pdf = $persona->Num_Doc . '-' . $resultR->Cod_Doc . '-' . $resultR->Ser_Doc . '-' . (int)$resultR->Num_Doc . '-' . $resultR->Tot_Vta_MN . '.pdf';
        $pdf = PDF::loadView('almacen.facturacion.reporte_imprimir', compact('resultR', 'resultVD', 'persona'))
            ->setTemporaryFolder('/Users/joseph/Yadira')
            ->setPaper('a4')->setOrientation('landscape')->setOption('margin-bottom', 0);
        $path = 'pdf/' . $nombre_pdf;
        return $pdf->save(storage_path($path));
        // return view('almacen.facturacion.reporte_imprimir', compact('resultR', 'resultVD', 'persona'));
    }

    public function reporte_impresora($NumVnt)
    {
        $codusu = session('key')['CodUsu'];
        $datusu = DB::table('usuarios_personal')
            ->join('personal_maestro', 'usuarios_personal.Cod_Per', '=', 'personal_maestro.Cod_Per')
            ->where('usuarios_personal.Cod_Usu', $codusu)
            ->first();
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
        return view('almacen.facturacion.reporte_impresora', compact('resultR', 'resultVD', 'persona'));
    }

    function fixed($numero, $decimales)
    {
        $expo = pow(10, $decimales);
        return intval($numero * $expo) / $expo;
    }
}
