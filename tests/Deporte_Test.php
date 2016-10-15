<?php
require_once '../classes/Deporte.php';

$deporte = new Deporte(['DEPORTE_ID'=>'1']);

Deporte::imprimir($deporte);


$datos = [
    'DESCRIPCION' => "Futbol 7",
    'MAX_JUGADORES' => 12
];

$nuevoID = Deporte::create($datos);

$deporte2 = new Deporte(['DEPORTE_ID'=>$nuevoID]);

Deporte::imprimir($deporte2);
