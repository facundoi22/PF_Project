<?php

/**
 * Created by PhpStorm.
 * User: BNB
 * Date: 12/10/2016
 * Time: 15:27
 */
require_once 'ClasePadre.php';
class Deporte extends ClasePadre
{
    public function __construct( $pk = null)
    {
        parent::__construct('DEPORTES',$pk);

    }
}