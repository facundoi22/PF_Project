<?php


require_once 'ClasePadre.php';
class Provincia extends ClasePadre
{
    public function __construct( $pk = null)
    {
        parent::__construct('PROVINCIAS' ,$pk);

    }


}