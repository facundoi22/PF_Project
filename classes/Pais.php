<?php


require_once 'ClasePadre.php';
class Pais extends ClasePadre
{
    public function __construct( $pk = null)
    {
        parent::__construct('PAISES' ,$pk);

    }


}