<?php
include('../../config.php');
Session::start();
if (Session::has('logueadoAdmin') && Session::get('logueadoAdmin')=='S') {
    if(isset($_GET['id']) && !empty($_GET['id'])) {
        Usuario::ActualizarEstado($_GET['id'], "0");
    };
};

header("Location: ../index.php?c=usuarios" );
?>

