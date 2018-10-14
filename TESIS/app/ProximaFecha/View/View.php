<?php
namespace ProximaFecha\View;

use ProximaFecha\Core\App;

class View
{
    public static function render($view, $data = [])
    {
        $__data__ = $data;
        foreach ($__data__ as $varName => $varValue) {
            ${$varName} = $varValue;
        }
        require App::$viewsFolder . '/' . $view . '.php';
    }

    public static function renderJson($data)
    {
        echo json_encode($data);
    }
}