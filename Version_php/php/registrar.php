<?php	
	include('../config.php');
	include('../funciones.php');
	$inputs = $_POST;
	
	$error =0;
	$errorActual = "";
	
	/*Creo dos variables de Sesión
	campos: Guarda todos los campos que se envian salvo la foto.
	camposError: Guarda los campos que tienen error, incluyendo la foto.*/
/*session_start( );
$_SESSION['campos'] = array();
$_SESSION['camposError'] = array();*/
    Session::start();

$campos =array();
$camposError =array();

	// Valido los inputs;
	foreach( $inputs as $nombreCampo => $valor){
        $campos[$nombreCampo] = $valor;
		//$_SESSION['campos'][$nombreCampo] = $valor;
		$errorActual = ValidarCampo($nombreCampo, $valor);
		if ($errorActual){
		    $camposError[$nombreCampo] = $errorActual;
			//$_SESSION['camposError'][$nombreCampo] = $errorActual;
		}		
	}
	imprimir($inputs);
	// Si hay algún campo en error, vuelvo al formulario, indicando que hay errores;
	//if ( $_SESSION['camposError'] ){
    if ( !empty($camposError) ){
        Session::set("camposError",$camposError);
        Session::set("campos",$campos);
		header("Location: ../index.php?error=1#registroModal");
		//header("Location: miusuario.php");
	} else {
        Session::set("campos",$campos);
		$usuario_id = Usuario::CrearUsuario($inputs);
        Session::set('usuario',$usuario_id);
        Session::set('logueado','S');
        header("Location: ../index.php?seccion=miusuario");
	} 	
?>