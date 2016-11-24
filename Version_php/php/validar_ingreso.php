<?php	
	require_once('../config.php');
	$inputs = $_POST;
	session_start( );
    if (isset($_POST["usuario"]) && !empty($_POST["usuario"]) && isset($_POST["password"]) && !empty($_POST["password"])) {
        $_SESSION['usuario'] = $_POST['usuario'];
        $error =0;
	    $errorActual = "";
        $usuario = New Usuario($_POST['usuario'], $_POST['password']);
        $error = $usuario->validarUsuario();
    } else {
        $error = "No ha ingresado el usuario o la contraseña";
    }

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
                header("Location: ../index.php?seccion=miequipo");
            } else {
                header("Location: ../index.php?seccion=miusuario");
			}
		}
	} 	
