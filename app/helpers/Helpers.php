<?php

use SisVentas\Clases\NumeroALetras;

function convierte($number, $moneda = 'soles', $centimos = 'centimos', $forzarCentimos = false)
{

    return NumeroALetras::convertir($number);
}