<?php
include('../../config.php');
Session::set('logueadoAdmin','N');
Session::set('admin',null);
header("Location: ../../index.php");
?>