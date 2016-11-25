<?php	
	include('../config.php');
	include('../funciones.php');
	$inputs = $_POST;
	
	$error =0;
	$errorActual = "";
	
	Session::start();

    $formValidator = new FormValidator( $inputs);

	imprimir($formValidator->getCampos());
	imprimir($formValidator->getCamposError());


	// Si hay algún campo en error, vuelvo al formulario, indicando que hay errores;
	//if ( $_SESSION['camposError'] ){
    if ( !empty($formValidator->getCamposError()) ){
        Session::set("camposError",$formValidator->getCamposError());
        Session::set("campos",$formValidator->getCampos());
		header("Location: ../index.php?error=1#registroModal");
	} else {
        Session::set("campos",$formValidator->getCampos());
		$usuario_id = Usuario::CrearUsuario($inputs);
        Session::set('usuario',$usuario_id);
        Session::set('logueado','S');
        header("Location: ../index.php?seccion=miusuario");
	}

?>