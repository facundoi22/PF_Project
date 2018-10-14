<?php
require '../autoload.php';

use ProximaFecha\Core\App;

$dir = realpath(__DIR__ . "/../");
$dir = str_replace('\\', '/', $dir);

require '../app/routes.php';

$app = new App($dir);
$app->run();