<?php

namespace SisVentas\Http\Controllers;

/**
 * Description of CitasController
 *
 * @author usuario
 */
class CitasController extends Controller {

    public function index() {

        $lapsos = [];
        $horaCompleta = "09:00";
        $retazos = explode(":", $horaCompleta);

        $hora = (int) $retazos[0];
        $minutos = (int) $retazos[1];

        for ($i = $hora; $i < 22; $i++) {
            for ($j = $minutos; $j < 60; $j ++) {
                $lapsos[] = $i . ":" . $j;
            }
        }
        
        #dd($intervalo);

        return view('almacen.citas.index', ['lapsos' => $lapsos]);
    }

}
