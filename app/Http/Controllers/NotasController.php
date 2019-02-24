<?php

namespace SisVentas\Http\Controllers;

use Illuminate\Http\Request;
use SisVentas\ventasresumen;
use App\SistemasCorrelativos;
use SisVentas\ventasdetalletmp;
use SisVentas\VentasDetalle;
use SisVentas\VentasNotas;
use DB;

class NotasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {


    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
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

        $codusu = session('key')['CodUsu'];
        $codEmp = session('key')['CodEmp'];
        $codloc = session('key')['CodLoc'];
        $datusu = DB::table('usuarios_personal')
            ->join('personal_maestro', 'usuarios_personal.Cod_Per', '=', 'personal_maestro.Cod_Per')
            ->where('usuarios_personal.Cod_Usu', $codusu)
            ->first();
        $notas = DB::select('CALL USP_SEL_VENTAS_NOTAS_RESUMEN(?, ?, ?,?)', [$codEmp, $codloc, $inicio, $fin]);
        $inicio = date("d-m-Y", strtotime($inicio));
        $fin = date("d-m-Y", strtotime($fin));
        return view('notas/index', compact('notas', 'datusu', 'codusu', 'inicio', 'fin'));
    }


    public function store(Request $request)
    {
        parse_str($request->Form, $Form);//This will convert the string to array
        $CodUsu = session('key')['CodUsu'];
        $CodEmp = session('key')['CodEmp'];
        $CodLoc = session('key')['CodLoc'];
        $datusu = DB::table('usuarios_personal')
            ->join('personal_maestro', 'usuarios_personal.Cod_Per', '=', 'personal_maestro.Cod_Per')
            ->where('usuarios_personal.Cod_Usu', $CodUsu)
            ->first();
        $anioactual = date("Y");
        $mesactual = date("m");
        $fechaActual = date("Y-m-d h-i-s");
        $counnotaventa = DB::table('ventas_notas')->count();
        $maxanio = DB::table('ventas_notas')
            ->max('RegAnno');
        if (empty($maxanio)) {
            $valoraniofact = '000001';
        } else {
            $maxanio = $maxanio + 1;
            $maxanioformat = '000000' . $maxanio;
            $valoraniofact = substr($maxanioformat, -6, 6);
        }
        $maxmes = DB::table('ventas_notas')->max('RegMes');
        if (empty($maxmes)) {
            $valormesfact = '0001';
        } else {
            $maxmes = $maxmes + 1;
            $maxmesformat = '0000' . $maxmes;
            $valormesfact = substr($maxmesformat, -4, 4);

        }
        if ($counnotaventa == 0) {
            $NumNota = $anioactual . $mesactual . '0001';
        } else {
            $NumNota = $anioactual . $mesactual . $valormesfact;
        }
        $Documento = DB::table('sunat_documentos_tipos')->where('Cod_Doc', $Form['TipDoc'])->first();

        $VentasNotas = new VentasNotas;
        $VentasNotas->Cod_Emp = $datusu->Cod_Emp;
        $VentasNotas->Cod_Loc = $datusu->Cod_Loc;
        $VentasNotas->Anno = $anioactual;
        $VentasNotas->NumMes = $mesactual;
        $VentasNotas->RegAnno = $valoraniofact;
        $VentasNotas->RegMes = $valormesfact;
        $VentasNotas->Num_Nota = $NumNota;
        $VentasNotas->Fec_Nota = $fechaActual;
        if ($Form['TipDoc'] === '07') {
            $VentasNotas->Cod_Tip_Dscto = $Form['TipDesc'];
            $tipoDescuento = DB::table('ctasctes_tipos_descuentos')
                ->where('Cod_Tip_Dscto', '=', $Form['TipDesc'])
                ->first();
            $VentasNotas->Nom_Con = $tipoDescuento->Nom_Tip_Dscto;
        }
        if ($Form['TipDoc'] === '08') {
            $VentasNotas->Cod_Tip_Dscto = $Form['TipIngreso'];
            $tipoIngreso = DB::table('ctasctes_tipos_ingresos')
                ->where('Cod_Tip_Ing', '=', $Form['TipIngreso'])
                ->first();
            $VentasNotas->Nom_Con = $tipoIngreso->Nom_Tip_Ing;
        }

        $CodDocRef = $request->DocRef['CodDocRef'][0][1];
        $TipDocRef = $request->DocRef['TipDocRef'][0][1];
        $SerieDocRef = $request->DocRef['SerieRef'][0][1];
        $NumeroDocRef = $request->DocRef['NumeroRef'][0][1];
        $FechaDocRef = $request->DocRef['FechaRef'][0][1];

        $VentasNotas->Cod_Doc = $Form['TipDoc'];
        $VentasNotas->Tip_Doc = $Documento->Tip_Doc;
        $VentasNotas->Ser_Doc = $Form['SerDoc'];
        $VentasNotas->Num_Doc = $Form['NumDocNota'];
        $VentasNotas->Fec_Doc = $Form['FecEmi'];
        $VentasNotas->Cod_Doc_Ref = $CodDocRef;
        $VentasNotas->Tip_Doc_Ref = $TipDocRef;
        $VentasNotas->Ser_Doc_Ref = $SerieDocRef;
        $VentasNotas->Num_Doc_Ref = $NumeroDocRef;
        $VentasNotas->Fec_Doc_Ref = $FechaDocRef;
        $VentasNotas->Cod_Doc_Ref2 = '';
        $VentasNotas->Tip_Doc_Ref2 = '';
        $VentasNotas->Ser_Doc_Ref2 = '';
        $VentasNotas->Num_Doc_Ref2 = '';
        $VentasNotas->Fec_Doc_Ref2 = $Form['FecEmi'];
        $VentasNotas->Cod_Doc_Ref3 = '';
        $VentasNotas->Tip_Doc_Ref3 = '';
        $VentasNotas->Ser_Doc_Ref3 = '';
        $VentasNotas->Num_Doc_Ref3 = '';
        $VentasNotas->Fec_Doc_Ref3 = $Form['FecEmi'];
        $VentasNotas->Cod_Doc_Ref4 = '';
        $VentasNotas->Tip_Doc_Ref4 = '';
        $VentasNotas->Ser_Doc_Ref4 = '';
        $VentasNotas->Num_Doc_Ref4 = '';
        $VentasNotas->Fec_Doc_Ref4 = $Form['FecEmi'];
        $VentasNotas->Can_Nota = $Form['Cantidad'];
        if ($Form['Moneda'] === 'D') {
            $VentasNotas->Pre_Nota_ME = $Form['Precio'];
            $VentasNotas->Val_Nota_ME = $Form['Valor'];
            $VentasNotas->Igv_Nota_ME = $Form['IGV'];
            $VentasNotas->Tot_Nota_ME = $Form['MontoDesc'];

            $VentasNotas->Pre_Nota_MN = number_format($Form['Precio'] * $Form['TipoCambio'], 2);
            $VentasNotas->Val_Nota_MN = number_format($Form['Valor'] * $Form['TipoCambio'], 2);;
            $VentasNotas->Igv_Nota_MN = number_format($Form['IGV'] * $Form['TipoCambio'], 2);;
            $VentasNotas->Tot_Nota_MN = number_format($Form['MontoDesc'] * $Form['TipoCambio'], 2);;
        } else {
            $VentasNotas->Pre_Nota_MN = $Form['Precio'];
            $VentasNotas->Val_Nota_MN = $Form['Valor'];
            $VentasNotas->Igv_Nota_MN = $Form['IGV'];
            $VentasNotas->Tot_Nota_MN = $Form['MontoDesc'];

            $VentasNotas->Pre_Nota_ME = number_format($Form['Precio'] / $Form['TipoCambio'], 2);
            $VentasNotas->Val_Nota_ME = number_format($Form['Valor'] / $Form['TipoCambio'], 2);;
            $VentasNotas->Igv_Nota_ME = number_format($Form['IGV'] / $Form['TipoCambio'], 2);;
            $VentasNotas->Tot_Nota_ME = number_format($Form['MontoDesc'] / $Form['TipoCambio'], 2);;
        }

        $VentasNotas->Tot_Nota_Letra = $Form['NumLetra'];
        $VentasNotas->Cod_Imp = '001';
        $VentasNotas->Tas_Imp = '18';
        $VentasNotas->Cod_Mon = $Form['Moneda'];
        $VentasNotas->Tip_Cam = $Form['TipoCambio'];
        $VentasNotas->Fec_Cam = $fechaActual;
        $VentasNotas->Cod_Lib = '05';
        $VentasNotas->Num_Cta = '701000';
        $VentasNotas->Cod_CP = $Form['idcliente'];
        $VentasNotas->Tip_CP = $Form['TipCP'];
        $VentasNotas->Cod_Doc_CP = $Form['CodDocCP'];
        $VentasNotas->Tip_Doc_CP = $Form['TipDocCP'];
        $VentasNotas->Num_Doc_CP = $Form['NumDoc'];
        $VentasNotas->Obs_Nota = $Form['Obs'];
        $VentasNotas->File_Zip = '-';
        $VentasNotas->Cod_Hash = '-';
        $VentasNotas->Cod_Error = '-';
        $VentasNotas->Ticket = '-';
        $VentasNotas->Estado = 'P';
        $VentasNotas->Imprimir = 'P';
        $VentasNotas->CDR = 'N';
        $VentasNotas->Usuario = $CodUsu;
        $VentasNotas->Fecha = $fechaActual;
        $VentasNotas->Operacion = 'I';
        $VentasNotas->save();

        DB::select('call USP_UPD_SISTEMAS_CORRELATIVOS(?, ?, ?, ?, ?,?, ?, ?,?)', [$CodEmp, $CodLoc, $Form['TipDoc'], $Form['SerDoc'], $Form['TipDocApli'], $CodUsu, $fechaActual, 'M', 'A']);

        DB::table('ventas_resumen')
            ->where('Cod_Emp', $datusu->Cod_Emp)
            ->where('Tip_CP', trim($Form['TipCP']))
            ->where('Cod_CP', $Form['idcliente'])
            ->where('Cod_Doc', $Form['TipDocApli'])
            ->where('Ser_Doc', $SerieDocRef)
            ->where('Num_Doc', $NumeroDocRef)
            ->where('Operacion', '<>', 'E')
            ->update([
                'Num_Nota' => $NumNota,
                'Fec_Nota' => $Form['FecEmi'],
                'Usuario' => $CodUsu,
                'Fecha' => date('Y-m-d h:m:s'),
                'Operacion' => 'M']);
        $data_out = ['page' => url('notas/index')];
        return response()->json($data_out);
    }

    public function formNotaVenta(Request $request)
    {
        $maxanio = DB::table('ventas_notas')
            ->max('Reganno');
        if (empty($maxanio)) {
            $maxanio = '000001';
        } else {
            $maxanio = $maxanio + 1;
            $maxanioformat = '000000' . $maxanio;
            $valoraniofact = substr($maxanioformat, -6, 6);
        }

        $maxmes = DB::table('ventas_notas')->max('RegMes');
        if (empty($maxmes)) {
            $maxmes = '0001';
        } else {
            $maxmes = $maxmes + 1;
            $maxmesformat = '0000' . $maxmes;
            $valormesfact = substr($maxmesformat, -4, 4);

        }
        $anioactual = date("Y");
        $mesactual = date("m");
        $countResumenVenta = DB::table('ventas_notas')->count();

        if ($countResumenVenta == 0) {
            $cNumVnt = $anioactual . $mesactual . '0001';
        } else {
            $cNumVnt = $anioactual . $mesactual . $valormesfact;
        }

        // ----  Fin de  genera el correlativo del Nro de Venta -----------
        $tipDoc = DB::select('CALL USP_LIS_SUNAT_DOCUMENTOS_NC_ND()');
        $TipDocApli = DB::select('CALL USP_LIS_SUNAT_DOCUMENTOS_FAC_BOL()');
        $tipodesc = DB::select('CALL USP_LIS_CTASCTES_TIPOS_DESCUENTOS()');
        $tipoIng = DB::select('CALL USP_LIS_CTASCTES_TIPOS_INGRESOS()');

        $clientes = DB::select('CALL USP_LIS_CLIENTES_MAESTRO()');
        $articulos = DB::select('CALL USP_LIS_ARTICULOS_MAESTRO()');
        $monedas = DB::select('CALL USP_LIS_MONEDAS_MAESTRO()');
        $ventastipos = DB::select('CALL USP_LIS_VENTAS_TIPOS()');
        $tiposcobros = DB::select('CALL USP_LIS_VENTAS_TIPOS_COBROS()');
        $detalletemp = DB::table('ventas_detalle_tmp')->get();
        $codusu = session('key')['CodUsu'];
        $datusu = DB::table('usuarios_personal')
            ->join('personal_maestro', 'usuarios_personal.Cod_Per', '=', 'personal_maestro.Cod_Per')
            ->where('usuarios_personal.Cod_Usu', $codusu)
            ->first();
        // dd($datusu);
        return view('notas.notaventa', ['clientes' => $clientes, 'tipDoc' => $tipDoc, 'TipDocApli' => $TipDocApli, 'articulos' => $articulos, 'monedas' => $monedas, 'cNumVnt' => $cNumVnt, 'ventastipos' => $ventastipos, 'tiposcobros' => $tiposcobros, 'detalletemp' => $detalletemp, 'tipodesc' => $tipodesc, 'tipoIng' => $tipoIng, 'datusu' => $datusu, 'codusu' => $codusu]);
    }

    public function MuestraMontos(Request $request)
    {
        $ventasresumen = DB::table('ventas_resumen')->where('Num_Vnt', '=', $request->total)->get();
        $data = ['ventasresumen' => $ventasresumen];
        return response($data, 200)->header('Content-Type', 'text/plain');
    }

    public function retornadatoscombos(Request $request)
    {
        $correlativoNventa = DB::select('call USP_MAX_SISTEMAS_CORRELATIVOS(?, ?, ?, ?)', ['01', '01', $request->TipDoc, $request->TipDocApli]);
        $data = ['correlativoNventa' => $correlativoNventa];
        return response($data, 200)->header('Content-Type', 'text/plain');
    }

    public function ListResumenNota(Request $request)
    {
        $codusu = session('key')['CodUsu'];
        $datusu = DB::table('usuarios_personal')
            ->join('personal_maestro', 'usuarios_personal.Cod_Per', '=', 'personal_maestro.Cod_Per')
            ->where('usuarios_personal.Cod_Usu', $codusu)
            ->first();
        $resumennota = DB::select('call USP_SEL_VENTAS_NOTAS_RESUMEN(?, ?, ?)', [$datusu->Cod_Emp, $request->datepickVenta, $request->datepickVenta2]);

        return view('almacen/facturacion/notacredito', compact('resumennota', 'codusu', 'datusu'));

    }

    public function edit($Num_Nota)
    {
        $codusu = session('key')['CodUsu'];
        $codemp = session('key')['CodEmp'];
        $codloc = session('key')['CodLoc'];

        $tipDoc = DB::select('CALL USP_LIS_SUNAT_DOCUMENTOS_NC_ND()');
        $TipDocApli = DB::select('CALL USP_LIS_SUNAT_DOCUMENTOS_FAC_BOL()');
        $tipodesc = DB::select('CALL USP_LIS_CTASCTES_TIPOS_DESCUENTOS()');
        $tipoIng = DB::select('CALL USP_LIS_CTASCTES_TIPOS_INGRESOS()');

        $monedas = DB::select('CALL USP_LIS_MONEDAS_MAESTRO()');
        $ventastipos = DB::select('CALL USP_LIS_VENTAS_TIPOS()');
        $tiposcobros = DB::select('CALL USP_LIS_VENTAS_TIPOS_COBROS()');

        $datusu = DB::table('usuarios_personal')
            ->join('personal_maestro', 'usuarios_personal.Cod_Per', '=', 'personal_maestro.Cod_Per')
            ->where('usuarios_personal.Cod_Usu', $codusu)
            ->first();
        $nota = DB::table('ventas_notas')
            ->where('ventas_notas.Num_Nota', $Num_Nota)
            ->first();
        if ($nota->Tip_CP === 'C') {
            $persona = DB::table('clienprov_maestro')
                ->select(DB::raw("CONCAT(IFNULL(Nom_CP,''),' ',IFNULL(Ape_CP,'')) AS nombre"), 'Dir_CP as direccion', 'Tel_CP as telefono', 'Cel_CP as celular', 'Mail_CP as mail')
                ->where('Cod_CP', '=', $nota->Cod_CP)
                ->first();
        }
        if ($nota->Tip_CP === 'P') {
            $persona = DB::table('pacientes_maestro')
                ->select(DB::raw("CONCAT(IFNULL(Nom_Pac,''),' ',IFNULL(Pat_Pac,''),' ',IFNULL(Mat_Pac,'')) AS nombre"), 'Dir_Pac as direccion', 'Tel_Pac as telefono', 'Cel_Pac as celular', 'Mail_Pac as mail')
                ->where('Cod_Pac', '=', $nota->Cod_CP)
                ->first();
        }
        if ($nota->Tip_CP == 'T') {
            $persona = DB::table('personal_maestro')
                ->select(DB::raw("CONCAT(IFNULL(Nom_Per,''),' ',IFNULL(PAT_Per,''),' ',IFNULL(MAT_Per,'')) AS nombre"), 'Dir_Per as direccion', 'Tel_Per as telefono', 'Mail_Per as mail', 'Cel_Per as celular')
                ->where('Cod_Per', '=', $nota->Cod_CP)
                ->first();
        }

        $detalle = DB::select('CALL USP_SEEK_VENTAS_NOTAS_DOC_APLICA(?,?,?,?,?)', [$codemp, $codloc, $nota->Cod_CP, $nota->Tip_CP, $Num_Nota]);
        if ($detalle) {
            //dump($detalle);
            return view('notas/edit', ['nota' => $nota, 'datusu' => $datusu, 'tipDoc' => $tipDoc, 'TipDocApli' => $TipDocApli, 'tipodesc' => $tipodesc, 'tipoIng' => $tipoIng, 'monedas' => $monedas, 'ventastipos' => $ventastipos, 'tiposcobros' => $tiposcobros, 'persona' => $persona, 'detalle' => $detalle]);

        } else {
            return redirect('notas/index')->with('danger', 'La nota no tiene detalle');
        }

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        parse_str($request->Form, $Form);//This will convert the string to array
        $CodUsu = session('key')['CodUsu'];
        $CodEmp = session('key')['CodEmp'];
        $CodLoc = session('key')['CodLoc'];
        $datusu = DB::table('usuarios_personal')
            ->join('personal_maestro', 'usuarios_personal.Cod_Per', '=', 'personal_maestro.Cod_Per')
            ->where('usuarios_personal.Cod_Usu', $CodUsu)
            ->first();

        $anioactual = date('Y');
        $mesactual = date('m');
        $fechaActual = date('Y-m-d');
        $counnotaventa = DB::table('ventas_notas')->count();
        $maxanio = DB::table('ventas_notas')
            ->where('Cod_Emp', $CodEmp)
            ->where('Anno', $anioactual)
            ->max('RegAnno');

        if (empty($maxanio)) {
            $valoraniofact = '000001';
        } else {
            $maxanio = $maxanio + 1;
            $maxanioformat = '000000' . $maxanio;
            $valoraniofact = substr($maxanioformat, -6, 6);
        }

        $maxmes = DB::table('ventas_notas')
            ->where('ventas_notas.Cod_Emp', $CodEmp)
            ->where('ventas_notas.Anno', $anioactual)
            ->where('ventas_notas.NumMes', $mesactual)
            ->max('RegMes');

        if (empty($maxmes)) {
            $valormesfact = '0001';
        } else {
            $maxmes = $maxmes + 1;
            $maxmesformat = '0000' . $maxmes;
            $valormesfact = substr($maxmesformat, -4, 4);

        }

        $Documento = DB::table('sunat_documentos_tipos')->where('Cod_Doc', $Form['TipDoc'])->first();

        $VentasNotas = VentasNotas::find($Form['NumNota']);
        $VentasNotas->Cod_Emp = $datusu->Cod_Emp;
        $VentasNotas->Cod_Loc = $datusu->Cod_Loc;
        $VentasNotas->Anno = $anioactual;
        $VentasNotas->NumMes = $mesactual;
        $VentasNotas->RegAnno = $valoraniofact;
        $VentasNotas->RegMes = $valormesfact;

        if ($Form['TipDoc'] === '07') {
            $VentasNotas->Cod_Tip_Dscto = $Form['TipDesc'];
            $tipoDescuento = DB::table('ctasctes_tipos_descuentos')
                ->where('Cod_Tip_Dscto', '=', $Form['TipDesc'])
                ->first();
            $VentasNotas->Nom_Con = $tipoDescuento->Nom_Tip_Dscto;
        }
        if ($Form['TipDoc'] === '08') {
            $VentasNotas->Cod_Tip_Dscto = $Form['TipIngreso'];
            $tipoIngreso = DB::table('ctasctes_tipos_ingresos')
                ->where('Cod_Tip_Ing', '=', $Form['TipIngreso'])
                ->first();
            $VentasNotas->Nom_Con = $tipoIngreso->Nom_Tip_Ing;
        }
        $CodDocRef = $request->DocRef['CodDocRef'][0][1];
        $TipDocRef = $request->DocRef['TipDocRef'][0][1];
        $SerieDocRef = $request->DocRef['SerieRef'][0][1];
        $NumeroDocRef = $request->DocRef['NumeroRef'][0][1];
        $FechaDocRef = $request->DocRef['FechaRef'][0][1];

        $VentasNotas->Cod_Doc = $Form['TipDoc'];
        $VentasNotas->Tip_Doc = $Documento->Tip_Doc;
        $VentasNotas->Ser_Doc = $Form['SerDoc'];
        $VentasNotas->Num_Doc = $Form['NumDocNota'];
        $VentasNotas->Fec_Doc = $Form['FecEmi'];
        $VentasNotas->Cod_Doc_Ref = $CodDocRef;
        $VentasNotas->Tip_Doc_Ref = $TipDocRef;
        $VentasNotas->Ser_Doc_Ref = $SerieDocRef;
        $VentasNotas->Num_Doc_Ref = $NumeroDocRef;
        $VentasNotas->Fec_Doc_Ref = $FechaDocRef;
        $VentasNotas->Cod_Doc_Ref2 = '';
        $VentasNotas->Tip_Doc_Ref2 = '';
        $VentasNotas->Ser_Doc_Ref2 = '';
        $VentasNotas->Num_Doc_Ref2 = '';
        $VentasNotas->Fec_Doc_Ref2 = $Form['FecEmi'];
        $VentasNotas->Cod_Doc_Ref3 = '';
        $VentasNotas->Tip_Doc_Ref3 = '';
        $VentasNotas->Ser_Doc_Ref3 = '';
        $VentasNotas->Num_Doc_Ref3 = '';
        $VentasNotas->Fec_Doc_Ref3 = $Form['FecEmi'];
        $VentasNotas->Cod_Doc_Ref4 = '';
        $VentasNotas->Tip_Doc_Ref4 = '';
        $VentasNotas->Ser_Doc_Ref4 = '';
        $VentasNotas->Num_Doc_Ref4 = '';
        $VentasNotas->Fec_Doc_Ref4 = $Form['FecEmi'];
        $VentasNotas->Can_Nota = $Form['Cantidad'];
        $VentasNotas->Pre_Nota_MN = $Form['Precio'];
        $VentasNotas->Val_Nota_MN = $Form['Valor'];
        $VentasNotas->Igv_Nota_MN = $Form['IGV'];
        $VentasNotas->Tot_Nota_MN = $Form['MontoDesc'];
        $VentasNotas->Pre_Nota_ME = '0';
        $VentasNotas->Val_Nota_ME = '0';
        $VentasNotas->Igv_Nota_ME = '0';
        $VentasNotas->Tot_Nota_ME = '0';
        $VentasNotas->Tot_Nota_Letra = $Form['NumLetra'];
        $VentasNotas->Cod_Imp = '001';
        $VentasNotas->Tas_Imp = '18';
        $VentasNotas->Cod_Mon = $Form['Moneda'];
        $VentasNotas->Tip_Cam = $Form['TipoCambio'];
        $VentasNotas->Fec_Cam = $fechaActual;
        $VentasNotas->Cod_CP = $Form['CodCP'];
        $VentasNotas->Tip_CP = $Form['TipCP'];
        $VentasNotas->Cod_Doc_CP = $Form['CodDocCP'];
        $VentasNotas->Tip_Doc_CP = $Form['TipDocCP'];
        $VentasNotas->Num_Doc_CP = $Form['NumDoc'];
        $VentasNotas->Obs_Nota = $Form['Obs'];;
        $VentasNotas->File_Zip = '-';
        $VentasNotas->Cod_Hash = '-';
        $VentasNotas->Cod_Error = '-';
        $VentasNotas->Ticket = '-';
        $VentasNotas->Estado = 'P';
        $VentasNotas->Imprimir = 'P';
        $VentasNotas->CDR = 'N';
        $VentasNotas->Usuario = $CodUsu;
        $VentasNotas->Fecha = $Form['FecEmi'];
        $VentasNotas->Operacion = 'M';
        $VentasNotas->save();

        DB::select('call USP_UPD_SISTEMAS_CORRELATIVOS(?, ?, ?, ?, ?,?, ?, ?,?)', [$CodEmp, $CodLoc, $Form['TipDoc'], $Form['SerDoc'], $Form['TipDocApli'], $CodUsu, $fechaActual, 'M', 'A']);

        $e = DB::table('ventas_resumen')
            ->where('Cod_Emp', $datusu->Cod_Emp)
            ->where('Tip_CP', trim($Form['TipCP']))
            ->where('Cod_CP', $Form['CodCP'])
            ->where('Cod_Doc', $Form['TipDocApli'])
            ->where('Ser_Doc', $SerieDocRef)
            ->where('Num_Doc', $NumeroDocRef)
            ->where('Operacion', '<>', 'E')
            ->update([
                'Num_Nota' => $Form['NumNota'],
                'Fec_Nota' => $Form['FecEmi'],
                'Usuario' => $CodUsu,
                'Fecha' => date('Y-m-d h:i:s'),
                'Operacion' => 'M']);
        $data_out = ['page' => url('notas/index')];

        return response()->json($data_out);
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

    public function pdfnota($NumNota)
    {
        $nota = DB::table('ventas_notas')->where('Num_Nota', '=', $NumNota)->first();
        if ($nota->Tip_CP === 'C') {
            $persona = DB::table('clienprov_maestro')
                ->select(DB::raw("CONCAT(IFNULL(Ape_CP,'') , ' ' ,IFNULL(Nom_CP,'')) AS Nom_CP"), 'Cod_CP', 'Tel_CP', 'Cel_CP', 'Mail_CP', 'Num_Doc', 'Dir_CP', 'Tip_CP', 'Cod_Doc', 'Tip_Doc')
                ->where('Cod_CP', '=', $nota->Cod_CP)
                ->first();
        }
        if ($nota->Tip_CP === 'P') {
            $persona = DB::table('pacientes_maestro')
                ->select(DB::raw("CONCAT(IFNULL(Nom_Pac,''),' ',IFNULL(PAT_Pac,''),' ',IFNULL(MAT_Pac,'')) AS Nom_CP"), 'Cod_Pac as Cod_CP', 'Dir_Pac as Dir_CP', 'Tel_Pac as Tel_CP', 'Mail_Pac as Mail_CP', 'Cel_Pac as Cel_CP', 'Num_Doc', DB::raw('"P" as Tip_CP'), 'Cod_Doc', 'Tip_Doc')
                ->where('Cod_Pac', '=', $nota->Cod_CP)
                ->first();
        }
        if ($nota->Tip_CP === 'T') {
            $persona = DB::table('personal_maestro')
                ->select(DB::raw("CONCAT(IFNULL(Nom_Per,''),' ',IFNULL(PAT_Per,''),' ',IFNULL(MAT_Per,'')) AS Nom_CP"), 'Cod_Per as Cod_CP', 'Cod_Doc AS Cod_Doc_CP', 'Tip_Doc AS Tip_Doc_CP', 'Dir_Per as Dir_CP', 'Tel_Per as Tel_CP', 'Mail_Per as Mail_CP', 'Cel_Per as Cel_CP', 'Num_Doc', DB::raw('"T" as Tip_CP'), 'Cod_Doc', 'Tip_Doc')
                ->where('Cod_Per', '=', $nota->Cod_CP)
                ->first();
        }
        $detalle = [];
        if ($nota->Cod_Tip_Dscto === '001' && $nota->Cod_Doc == '07') {
            $resumen = DB::table('ventas_resumen')
                ->where('Cod_Doc', $nota->Cod_Doc_Ref)
                ->where('Ser_Doc', $nota->Ser_Doc_Ref)
                ->where('Num_Doc', $nota->Num_Doc_Ref)
                ->first();
            $detalle = DB::table('ventas_detalle')
                ->where('Num_Vnt', $resumen->Num_Vnt)
                ->get();
        }
        return view('Reportes/reportenotas', ['nota' => $nota, 'persona' => $persona, 'detalle' => $detalle]);
    }

    public function reporte($NumNota)
    {
        $codusu = session('key')['CodUsu'];
        $datusu = DB::table('usuarios_personal')
            ->join('personal_maestro', 'usuarios_personal.Cod_Per', '=', 'personal_maestro.Cod_Per')
            ->where('usuarios_personal.Cod_Usu', $codusu)
            ->first();
        $nota = DB::table('ventas_notas')->where('Num_Nota', '=', $NumNota)->first();
        if ($nota->Tip_CP === 'C') {
            $persona = DB::table('clienprov_maestro')
                ->select(DB::raw("CONCAT(IFNULL(Ape_CP,'') , ' ' ,IFNULL(Nom_CP,'')) AS Nom_CP"), 'Cod_CP', 'Tel_CP', 'Cel_CP', 'Mail_CP', 'Num_Doc', 'Dir_CP', 'Tip_CP', 'Cod_Doc', 'Tip_Doc')
                ->where('Cod_CP', '=', $nota->Cod_CP)
                ->first();
        }
        if ($nota->Tip_CP === 'P') {
            $persona = DB::table('pacientes_maestro')
                ->select(DB::raw("CONCAT(IFNULL(Nom_Pac,''),' ',IFNULL(PAT_Pac,''),' ',IFNULL(MAT_Pac,'')) AS Nom_CP"), 'Cod_Pac as Cod_CP', 'Dir_Pac as Dir_CP', 'Tel_Pac as Tel_CP', 'Mail_Pac as Mail_CP', 'Cel_Pac as Cel_CP', 'Num_Doc', DB::raw('"P" as Tip_CP'), 'Cod_Doc', 'Tip_Doc')
                ->where('Cod_Pac', '=', $nota->Cod_CP)
                ->first();
        }
        if ($nota->Tip_CP === 'T') {
            $persona = DB::table('personal_maestro')
                ->select(DB::raw("CONCAT(IFNULL(Nom_Per,''),' ',IFNULL(PAT_Per,''),' ',IFNULL(MAT_Per,'')) AS Nom_CP"), 'Cod_Per as Cod_CP', 'Cod_Doc AS Cod_Doc_CP', 'Tip_Doc AS Tip_Doc_CP', 'Dir_Per as Dir_CP', 'Tel_Per as Tel_CP', 'Mail_Per as Mail_CP', 'Cel_Per as Cel_CP', 'Num_Doc', DB::raw('"T" as Tip_CP'), 'Cod_Doc', 'Tip_Doc')
                ->where('Cod_Per', '=', $nota->Cod_CP)
                ->first();
        }
        $detalle = [];
        if ($nota->Cod_Tip_Dscto === '001' && $nota->Cod_Doc == '07') {
            $resumen = DB::table('ventas_resumen')
                ->where('Cod_Doc', $nota->Cod_Doc_Ref)
                ->where('Ser_Doc', $nota->Ser_Doc_Ref)
                ->where('Num_Doc', $nota->Num_Doc_Ref)
                ->first();
            $detalle = DB::table('ventas_detalle')
                ->where('Num_Vnt', $resumen->Num_Vnt)
                ->get();
        }
        return view('notas.reporte', ['codusu' => $codusu, 'datusu' => $datusu, 'nota' => $nota, 'persona' => $persona, 'detalle' => $detalle]);
    }
}
