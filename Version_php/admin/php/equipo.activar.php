<?php
include('../../config.php');
Session::start();
if (Session::has('logueadoAdmin') && Session::get('logueadoAdmin')=='S') {
    if(isset($_GET['id']) && !empty($_GET['id'])) {
        Equipo::ActualizarEstado($_GET['id'], 1);
    };
};


header("Location: ../index.php?c=equipos" );
?>