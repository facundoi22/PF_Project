<?php 
include( 'modulos/config.php' );

$c = "UPDATE equipos SET ACTIVO='0' WHERE EQUIPO_ID='$_POST[id]'";

var_dump($c);

$exito = mysqli_query($cnx, $c);

echo $exito;
?>