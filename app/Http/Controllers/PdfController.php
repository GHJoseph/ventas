<?php


namespace SisVentas\Http\Controllers;

class PdfController extends Controller{
    
    public function index() {

//        $articulos = DB::select("call USP_LIS_ARTICULOS_MAESTRO()");
        
        return view('almacen.pdf.index');
    }
    
}
