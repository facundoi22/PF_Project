<?php
	
	date_default_timezone_set( "America/Argentina/Buenos_Aires" );
	ini_set( 'display_errors' , 1 ); 
	error_reporting( E_ALL ); 
	ini_set('upload_max_filesize','100M');

    function __autoload($className)
    {
        try {
            require_once "/classes/" . $className . ".php";
        } catch (Exception $e_class) {
			try {
				require_once "/exceptions/" . $className . ".php";
			} catch (Exception $e_exception) {
				throw new ArchivoNoEncontradoException("No se pudo cargar el archivo de la clase " . $className . ".php");
            }
        }
    }
?>