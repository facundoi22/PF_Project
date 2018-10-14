<?php
spl_autoload_register(function($className) {
    $filePath = str_replace('\\', '/', $className) . ".php";
    $filePath = '../app/' . $filePath;

    if(file_exists($filePath)) {
        require_once $filePath;
    }
});