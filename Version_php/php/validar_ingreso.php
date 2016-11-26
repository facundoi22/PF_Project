<?php	
	require_once('../config.php');
	$inputs = $_POST;

	Session::start();
    if (isset($_POST["usuario"]) && !empty($_POST["usuario"]) && isset($_POST["password"]) && !empty($_POST["password"])) {
        Session::set('usuario',$_POST["usuario"]);
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
		    Session::set('errorLogin', $error);
		    Session::set('usuario', null);
            Session::set('logueado','N');
			//$_SESSION['error'] = $error;
            //$_SESSION['usuario']="";
            header("Location: ../index.php");
		} else {
            Session::set('logueado','S');
			header("Location: ../index.php?seccion=miusuario");
		}
	} 	
