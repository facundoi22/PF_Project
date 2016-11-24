<?php
require_once '../classes/Equipo.php';
require_once '../config.php';



$equipo = new Equipo("1");
$equipo->setJugadores();
Equipo::imprimir($equipo);
