<?php 
include( 'modulos/config.php' );

$c = "UPDATE equipos SET ACTIVO='1' WHERE EQUIPO_ID='$_POST[id]'";

$exito = mysqli_query($cnx, $c);

echo $exito;
?>