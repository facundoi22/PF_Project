<?php	
	include('config.php' );
	include('funciones.php' );
	$inputs = $_POST;
	
	$error =0;
	$errorActual = "";
	
	/*Creo dos variables de Sesión
	campos: Guarda todos los campos que se envian salvo la foto.
	camposError: Guarda los campos que tienen error, incluyendo la foto.*/
	session_start( );
	$_SESSION['campos'] = array();
	$_SESSION['camposError'] = array();

	// Valido los inputs;
	foreach( $inputs as $nombreCampo => $valor){
		$_SESSION['campos'][$nombreCampo] = $valor;
		$errorActual = ValidarCampo($nombreCampo, $valor);
		if ($errorActual){
			$_SESSION['camposError'][$nombreCampo] = $errorActual;
		}		
	}
	
	// Si hay algún campo en error, vuelvo al formulario, indicando que hay errores;
	if ( $_SESSION['camposError'] ){
		header("Location: index.php?error=1#registroModal");
	} else {
		$reserva_id = Insertar_Reserva($inputs);
		header("Location: usuario.php");
	} 	
?>