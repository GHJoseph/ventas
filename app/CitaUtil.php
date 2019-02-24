<?php
namespace SisVentas;

class CitaUtil {
    
    private $citas;
    
    public function __construct($citas) {
        $this->citas = $citas;
    }
    
    public function getCita($fila, $columa){
        foreach ($this->citas as $cita){
            if($cita->Nom_Fila == $fila && $cita->Nom_Colum == $columa){
                return $cita;
            }
        }
        return null;
    }
    
}
