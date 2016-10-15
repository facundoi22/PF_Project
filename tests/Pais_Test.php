<?php
require_once '../classes/Pais.php';

$pais = new Pais(['PAIS_ID'=>'ARG']);

Pais::imprimir($pais);


$datos = [
    'PAIS_ID' => "CEI",
    'PAIS' => "Carlos Iglesias",
    'ISO' => "CI"
];

$nuevoID = Pais::create($datos);

$pais2= new Pais(['PAIS_ID'=>'CEI']);

Pais::imprimir($pais2);
