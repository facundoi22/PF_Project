<?php	
	require_once('../config.php');
	$inputs = $_POST;
	session_start( );
	$_SESSION['usuario'] = $_POST['usuario'];
	
	$error =0;
	$errorActual = "";
    $usuario = New Usuario($_POST['usuario'], $_POST['password']);

	$error = $usuario->validarUsuario();
	if(isset($_POST['ajax'])) {
		if ($error){
			echo json_encode([
				'status' => 1,
				'data' => $error 
			]);			
		} else {
			echo json_encode([
				'status' => 0,
			]);			
		}
	} else {
		if ($error){
			$_SESSION['error'] = $error;
            header("Location: ../index.php");
		} else {
			if ( $usuario->tieneEquipo() )  {
                //header("Location: ../modulos/miequipo.php");
                header("Location: ../index.php?seccion=miequipo");
            } else {
                header("Location: ../index.php?seccion=miusuario");
                //header("Location: ../modulos/miusuario.php");
			}
		}
	} 	
