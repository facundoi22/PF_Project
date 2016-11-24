<?php	
	include('config.php');
	include('funciones.php');
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
    Session::set('campos',array());


	// Valido los inputs;
	foreach( $inputs as $nombreCampo => $valor){
        Session::get('campos')[$nombreCampo] = $valor;
		//$_SESSION['campos'][$nombreCampo] = $valor;
		$errorActual = ValidarCampo($nombreCampo, $valor);
		if ($errorActual){
		    if (Session::has('camposError')){
                Session::set('camposError',array());
            }
            Session::get('camposError')[$nombreCampo] = $errorActual;
			//$_SESSION['camposError'][$nombreCampo] = $errorActual;
		}		
	}
	
	// Si hay algún campo en error, vuelvo al formulario, indicando que hay errores;
	//if ( $_SESSION['camposError'] ){
    if ( Session::has('camposError') ){
		header("Location: ../index.php?error=1#registroModal");
		//header("Location: miusuario.php");
	} else {
		$usuario_id = CrearUsuario($inputs);
        Session::set('usuario',$usuario_id);
        header("Location: ../index.php?seccion=miusuario");
	} 	
?>