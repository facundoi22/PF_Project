<?php
require_once '../classes/Provincia.php';
require_once '../exceptions/ParametroInvalidoException.php';


try {
    $provincia = new Provincia(['PAIS_ID' => 'ARG']);
}catch  (ParametroInvalidoException $e) {
    Provincia::imprimir("Se capturó correctamente la excepcion por falta de parámetros");
};

$datos = [
    'PAIS_ID' => 'ARG',
    'PROVINCIA_ID' => 'BUE'
];

$provincia = new Provincia($datos);
Provincia::imprimir($provincia);

$datos = [
    'PAIS_ID' => "ARG",
    'PROVINCIA_ID' => "TUC",
    'PROVINCIA' => "Tucuman"
];

try {
    $nuevoID = Provincia::create($datos);
} catch( ClavesExistentesException $e)
{
    Provincia::imprimir("Se capturó correctamente la excepcion por Claves Existentes");
}

$datos = [
    'PAIS_ID' => "ARG",
    'PROVINCIA_ID' => "GVI",
    'PROVINCIA' => "Gonzalo Vicens"
];


$nuevoID = Provincia::create($datos);
$provincia2= new Provincia($datos);
Provincia::imprimir($provincia2);
