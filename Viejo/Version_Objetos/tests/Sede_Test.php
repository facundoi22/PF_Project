<?php
require_once '../classes/Sede.php';


$datos = [
    'SEDE_ID' => '1'
];

$sede = new Sede($datos);
Sede::imprimir($sede);



$datos = [
    'SEDE_ID' => "2",
    'sede_ID' => "TUC",
    'sede' => "Tucuman"
];

try {
    $nuevoID = Sede::create($datos);
} catch( ClavesExistentesException $e)
{
    Sede::imprimir("Se capturó correctamente la excepcion por Claves Existentes");
}

$datos = [
    'PAIS_ID' => "ARG",
    'sede_ID' => "GVI",
    'sede' => "Gonzalo Vicens"
];


$nuevoID = Sede::create($datos);
$sede2= new Sede($datos);
Sede::imprimir($sede2);
*/