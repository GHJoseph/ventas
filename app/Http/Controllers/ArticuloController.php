<?php

namespace SisVentas\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use SisVentas\Articulo;
use DB;
use Illuminate\Pagination\Paginator;

class ArticuloController extends Controller
{

    public function index()
    {
        $articulos = DB::table('articulos_maestro')
            ->where('Operacion', '<>', 'E')
            ->where('Cod_Emp', '=', '01')
            ->get();


        $codusu = session('key')['CodUsu'];
        $datusu = DB::table('usuarios_personal')
            ->join('personal_maestro', 'usuarios_personal.Cod_Per', '=', 'personal_maestro.Cod_Per')
            ->where('usuarios_personal.Cod_Usu', $codusu)
            ->first();


        return view('almacen.articulo.index', ['articulos' => $articulos, 'codusu' => $codusu, 'datusu' => $datusu]);
    }

    public function edit($codEmp, $CodALM, $CodArt, $NomArt, $pmin, $pventa)
    {

        $codusu = session('key')['CodUsu'];
        $datusu = DB::table('usuarios_personal')
            ->join('personal_maestro', 'usuarios_personal.Cod_Per', '=', 'personal_maestro.Cod_Per')
            ->where('usuarios_personal.Cod_Usu', $codusu)
            ->first();

        //Obteniendo registros
        $articulo = DB::select('call USP_SEEK_ARTICULOS_MAESTRO(?, ?, ?, ?)', [$codEmp, $CodALM, $CodArt, $NomArt]);
        $rubro = DB::select('CALL USP_LIS_ARTICULOS_RUBROS()');
        $unidad = DB::select('CALL USP_LIS_ARTICULOS_UNIDADES()');
        $moneda = DB::select('CALL USP_LIS_MONEDAS_MAESTRO()');
        //dd($articulo);

        return view('almacen.articulo.edit', ['articulo' => $articulo, 'rubro' => $rubro, 'unidad' => $unidad, 'moneda' => $moneda, 'codusu' => $codusu, 'datusu' => $datusu, 'pmin' => $pmin, 'pventa' => $pventa, 'pminME' => $articulo[0]->Pre_Min_ME,'pventaME' => $articulo[0]->Pre_Vta_ME]);
    }

    public function postEdit(Request $request)
    {
        //return $request;

        $CodEmp = '01';
        $CodArt = $request->get('CodArt');
        $NomArt = $request->get('NomArt');
        $CodRub = $request->get('CodRub');
        $CodUnd = $request->get('CodUnd');
        $StockMin = $request->get('StockMin');
        $StockMax = $request->get('StockMax');
        $FecArt = date("Y-m-d H:i:s");

        $Usuario = '001';
        $Fecha = date("Y-m-d H:i:s");
        $Operacion = 'M';
        $pmin = $request->get('pmin');
        $pventa = $request->get('pventa');
        $pminME = $request->get('pminME');
        $pventaME = $request->get('pventaME');
        //subir archivo/imagen a la carpeta correspondiente
        if ($request->file('FotoArt') !== null) {
            $dir = public_path() . '/Fotos/articulo/';
            $file = $request->file('FotoArt');
            $image = $request->get('NomArt') . '.' . $file->getClientOriginalExtension();
            $file->move($dir, $image);

            $FotoArt = 'Fotos/articulo/' . $image;
        } else {
            $FotoArt = $request->FotoArt;
        }

        DB::select('CALL USP_UPD_ARTICULOS_MAESTRO(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)', array($CodEmp, $CodArt, $NomArt, $CodRub, $CodUnd, $StockMin, $StockMax, $FecArt, $FotoArt, $Usuario, $Fecha, $Operacion, $pmin, $pventa, $pminME, $pventaME));
        return redirect('almacen/articulo')->with('success', 'Artículo actualizado satisfactoriamente');

    }

    public function create()
    {
        $codusu = session('key')['CodUsu'];
        $datusu = DB::table('usuarios_personal')
            ->join('personal_maestro', 'usuarios_personal.Cod_Per', '=', 'personal_maestro.Cod_Per')
            ->where('usuarios_personal.Cod_Usu', $codusu)
            ->first();

        $rubro = DB::select('CALL USP_LIS_ARTICULOS_RUBROS()');
        $unidad = DB::select('CALL USP_LIS_ARTICULOS_UNIDADES()');
        $moneda = DB::select('CALL USP_LIS_MONEDAS_MAESTRO()');

        return view('almacen.articulo.create', ['rubro' => $rubro, 'unidad' => $unidad, 'moneda' => $moneda, 'codusu' => $codusu, 'datusu' => $datusu]);
    }

    public function postCreate(Request $request)
    {
        $CodEmp = '01';
        $CodArt = $request->get('CodArt');
        $NomArt = $request->get('NomArt');
        $CodRub = $request->get('CodRub');
        $CodUnd = $request->get('CodUnd');
        $StockMin = $request->get('StockMin');
        $StockMax = $request->get('StockMax');
        $FecArt = date("Y-m-d H:i:s");

        $Usuario = '001';
        $Fecha = date("Y-m-d H:i:s");
        $Operacion = 'I';
        $pmin = $request->get('pmin');
        $pventa = $request->get('pventa');
        $pminME = $request->get('pminME');
        $pventaME = $request->get('pventaME');

        //subir archivo/imagen a la carpeta correspondiente
        $dir = public_path() . '/Fotos/articulo/';
        $file = $request->file('FotoArt');
        $image = $request->get('NomArt') . '.' . $file->getClientOriginalExtension();
        $file->move($dir, $image);

        $FotoArt = 'Fotos/articulo/' . $image;

        $insertar = array($CodEmp, $CodArt, $NomArt, $CodRub, $CodUnd, $StockMin, $StockMax, $FecArt, $FotoArt, $Usuario, $Fecha, $Operacion, $pmin, $pventa, $pminME, $pventaME);

        DB::select('CALL USP_UPD_ARTICULOS_MAESTRO(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)', $insertar);

        return redirect('almacen/articulo')->with('success', 'Artículo creado satisfactoriamente');
    }

    public function eliminar($CodArt)
    {

        $CodEmp = '01';
        $Usuario = '01';
        $Fecha = '2018-02-22 20:33:22';
        $Operacion = 'E';

        DB::select('call USP_UPD_ARTICULOS_MAESTRO_DEL(?, ?, ?, ?, ?)', [$CodEmp, $CodArt, $Usuario, $Fecha, $Operacion]);
        //dd($articulo);
        return redirect('almacen/articulo')->with('success', 'Artículo eliminado satisfactoriamente');
    }

    public function pdf()
    {

        $articulos = DB::select("call USP_LIS_ARTICULOS_MAESTRO()");
        dd($articulos);
        return view('almacen.articulo.pdf', ['articulos' => $articulos]);
    }

}
