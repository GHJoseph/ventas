<?php

namespace SisVentas\Http\Controllers;

use Illuminate\Http\Request;

class TipodecambioController extends Controller
{
    public function tipodecambio(){

    	$file = fopen("http://e-consulta.sunat.gob.pe/cl-at-ittipcam/tcS01Alias","r");
        $n=0;
        while(!feof($file))  //captura de encabezados
        {
            $fila = fgets($file);  //captura de linea
            $sent[$n] = $fila;
            //echo $n." ".$sent[$n]."<br>";
            $n++;
        }
        fclose($file);

        $m = 95;$f=0;
        $meses = $sent[56];
        while($sent[$m] < 32 & $sent[$m+8]>0)
        {
            
                $dia = $sent[$m];
                $compra = $sent[$m+4];
                $venta = $sent[$m+8];
            
            if($f==3){  
                $m=$m+4;
            }else if ($f==7) {
                $m=$m+4;
            }else if ($f==11) {
                $m=$m+4;
            }else if ($f==15) {
                $m=$m+4;
            }else if ($f==19) {
                $m=$m+4;
            }else if ($f==23) {
                $m=$m+4;
            }else{
            }
            $m=$m+14;
            $f++;
        } 
        
        $response['datos'] = array(
            'mes' => trim(strip_tags($meses)),
            'dia' => trim(strip_tags($dia)),
            'compra' => trim($compra),
            'venta' => trim($venta),
          );
   
        $encoded = json_encode($response);
        
        header('Content-type: application/json');
        exit($encoded);
    }
}
