<?php

namespace SisVentas\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class ReporteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $inicio = $request->desde;
        $fin = $request->hasta;
        if ($inicio === null & $fin === null) {
            $inicio = date('Y-m-d');
            $fin = date('Y-m-d');
        } else {
            $inicio = date("Y-m-d", strtotime($inicio));
            $fin = date("Y-m-d", strtotime($fin));
        }
        $codusu = session('key')['CodUsu'];
        $datusu = DB::table('usuarios_personal')
            ->join('personal_maestro', 'usuarios_personal.Cod_Per', '=', 'personal_maestro.Cod_Per')
            ->where('usuarios_personal.Cod_Usu', $codusu)
            ->first();
        $ventas = DB::select('call USP_RPT_VENTAS_MENSUAL(?, ?, ?,?)', [$datusu->Cod_Emp, $datusu->Cod_Loc, $inicio, $fin]);
        $inicio = date("d-m-Y", strtotime($inicio));
        $fin = date("d-m-Y", strtotime($fin));
        return view('Reportes.index', ['ventas' => $ventas, 'codusu' => $codusu, 'datusu' => $datusu, 'inicio' => $inicio, 'fin' => $fin]);
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

    public function ventasExcel($desde, $hasta)
    {
        $desde = date("Y-m-d", strtotime($desde));
        $hasta = date("Y-m-d", strtotime($hasta));
        Excel::create('Reporte de Ventas', function ($excel) use ($desde, $hasta) {

            $excel->sheet('Ventas', function ($sheet) use ($desde, $hasta) {
                $CodLoc = session('key')['CodLoc'];
                $CodEmp = session('key')['CodEmp'];
                $ventas = DB::select('call USP_RPT_VENTAS_MENSUAL(?, ?, ?,?)', [$CodEmp, $CodLoc, $desde, $hasta]);
                $sheet->mergeCells('A1:R1');
                $sheet->mergeCells('C2:E2');
                $sheet->mergeCells('F2:G2');
                $sheet->mergeCells('M2:P2');

                $sheet->setMergeColumn(array(
                    'columns' => array('A', 'B', 'H', 'I', 'J', 'K', 'L', 'Q', 'R'),
                    'rows' => array(
                        array(2, 3)
                    )
                ));
                $sheet->getStyle('A2:R2')->getAlignment()->setWrapText(true);
                $sheet->cells('A1:R1', function ($cells) {
                    $cells->setBackground('#B2EBF2');
                    $cells->setFontWeight('bold');
                    $cells->setAlignment('center');
                    $cells->setValignment('center');
                    $cells->setBorder('thin');
                });
                $sheet->cells('A2:R2', function ($cells) {
                    $cells->setBackground('#B2EBF2');
                    $cells->setFontWeight('bold');
                    $cells->setAlignment('center');
                    $cells->setValignment('center');
                    $cells->setBorder('thin');
                });
                $sheet->cells('A3:R3', function ($cells) {
                    $cells->setBackground('#B2EBF2');
                    $cells->setFontWeight('bold');
                    $cells->setAlignment('center');
                    $cells->setValignment('center');
                    $cells->setBorder('thin');
                });
                $sheet->setBorder('A1:R4', 'thin');
                $sheet->cell('A1', function ($cell) use ($desde, $hasta) {
                    $cell->setValue('LIBROS ELECTRÓNICOS SUNAT REGISTRO DE VENTAS DEL ' . date("d-m-Y", strtotime($desde)) . ' HASTA ' . date("d-m-Y", strtotime($hasta)));
                });
                $sheet->cell('C2', function ($cell) {
                    $cell->setValue('COMPROBANTE DE PAGO O DOCUMENTO');
                });
                $sheet->cell('F2', function ($cell) {
                    $cell->setValue('DOC. IDENTIDAD');
                });
                $sheet->cell('A2', function ($cell) {
                    $cell->setValue('NÚMERO CORRELATIVO DEL REGISTRO CÓDIGO ÚNICO DE LA OPERACIÓN');
                });
                $sheet->cell('B2', function ($cell) {
                    $cell->setValue('FECHA DE EMISIÓN DEL COMPROBANTE DE PAGO O DOCUMENTO');
                });
                $sheet->cell('M2', function ($cell) {
                    $cell->setValue('DOCUMENTO REFERENCIA');
                });
                $sheet->cell('C3', function ($cell) {
                    $cell->setValue('TIPO');
                });
                $sheet->cell('D3', function ($cell) {
                    $cell->setValue('SERIE');
                });
                $sheet->cell('E3', function ($cell) {
                    $cell->setValue('NÚMERO');
                });
                $sheet->cell('F3', function ($cell) {
                    $cell->setValue('TIPO');
                });
                $sheet->cell('G3', function ($cell) {
                    $cell->setValue('NÚMERO');
                });
                $sheet->cell('H2', function ($cell) {
                    $cell->setValue('NOMBRE O RAZÓN SOCIAL');
                });
                $sheet->cell('I2', function ($cell) {
                    $cell->setValue('BASE IMPONIBLE DE LA OPERACIÓN GRAVADA');
                });
                $sheet->cell('J2', function ($cell) {
                    $cell->setValue('IGV');
                });
                $sheet->cell('K2', function ($cell) {
                    $cell->setValue('IMPORTE TOTAL');
                });
                $sheet->cell('L2', function ($cell) {
                    $cell->setValue('TIPO DE CAMBIO');
                });
                $sheet->cell('M3', function ($cell) {
                    $cell->setValue('FECHA');
                });
                $sheet->cell('N3', function ($cell) {
                    $cell->setValue('TIPO');
                });
                $sheet->cell('O3', function ($cell) {
                    $cell->setValue('SERIE');
                });
                $sheet->cell('P3', function ($cell) {
                    $cell->setValue('NÚMERO');
                });
                $sheet->cell('Q2', function ($cell) {
                    $cell->setValue('TASA IGV');
                });
                $sheet->cell('R2', function ($cell) {
                    $cell->setValue('ESTADO');
                });
                $data = array();
                foreach ($ventas as $venta) {
                    $data[] = (array)$venta;
                }
                if (!empty($data)) {
                    $i = 3;
                    foreach ($data as $key => $value) {
                        $i++;
                        $sheet->cell('A' . $i, $value['Cod_Lib'] . $value['NumMes'] . $value['RegMes']);
                        $sheet->cell('B' . $i, date("d-m-Y", strtotime($value['Fec_Vnt'])));
                        $sheet->cell('C' . $i, $value['Cod_Doc']);
                        $sheet->cell('D' . $i, $value['Ser_Doc']);
                        $sheet->cell('E' . $i, $value['Num_Doc']);
                        $sheet->cell('F' . $i, $value['Cod_Doc_CP']);
                        $sheet->cell('G' . $i, $value['Num_Doc_CP']);
                        $sheet->cell('H' . $i, $value['Nom_CP']);
                        $sheet->cell('I' . $i, number_format((float)$value['Val_Vta_MN'], 2, '.', ''));
                        $sheet->cell('J' . $i, number_format((float)$value['Igv_Vta_MN'], 2, '.', ''));
                        $sheet->cell('K' . $i, number_format((float)$value['Tot_Vta_MN'], 2, '.', ''));
                        $sheet->cell('L' . $i, $value['Tip_Cam']);
                        if ($value['Cod_Doc'] === '07' || $value['Cod_Doc'] === '08') {
                            $sheet->cell('M' . $i, date("d-m-Y", strtotime($value['Fec_Doc_Ref'])));
                        } else {
                            $sheet->cell('M' . $i, '');
                        }
                        $sheet->cell('N' . $i, $value['Cod_Doc_Ref']);
                        $sheet->cell('O' . $i, $value['Ser_Doc_Ref']);
                        $sheet->cell('P' . $i, $value['Num_Doc_Ref']);
                        $sheet->cell('Q' . $i, $value['Tas_Imp']);
                        $sheet->cell('R' . $i, ($value['Estado'] === 'A' ? '2' : '1'));
                        $sheet->setBorder('A1:R' . $i, 'thin');
                        $sheet->cells('A' . $i . ':R' . $i, function ($cells) {
                            $cells->setBorder('thin');
                        });
                        $sheet->cells('A' . ($i + 1) . ':R' . ($i + 1), function ($cells) {
                            $cells->setBorder('thin');
                        });
                    }
                }

            });
        })->export('xls');
    }
}
