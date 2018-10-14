<?php


require_once 'ClasePadre.php';
class Sede extends ClasePadre
{
    public function __construct( $pk = null)
    {
        parent::__construct("SEDES" ,$pk);

    }


}