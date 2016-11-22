<?php
	date_default_timezone_set( "America/Argentina/Buenos_Aires" );
	ini_set( 'display_errors' , 1 ); 
	error_reporting( E_ALL ); 
	ini_set('upload_max_filesize','100M');
	$conexion = @mysqli_connect('localhost','root','','DW3_SALERNO_FACUNDO');
	mysqli_query( $conexion, "SET NAMES UTF8" );
?>