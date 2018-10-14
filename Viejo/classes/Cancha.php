<?php


require_once 'ClasePadre.php';
class Canchas extends ClasePadre
{
    public function __construct( $pk = null)
    {
        parent::__construct('CANCHAS',$pk);

    }
}