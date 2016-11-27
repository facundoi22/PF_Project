<?php
include('config.php');

session_start();

$u = $_POST['usuario'];
$c = $_POST['password'];

$con = "SELECT * FROM usuarios WHERE USUARIO_ID='$u' AND PASS=SHA1('$c') LIMIT 1";
$f = mysqli_query($cnx, $con);
$a = mysqli_fetch_assoc($f);

$error = "Nombre de usuario y/o contraseña invalidos.";

if($a){

	$_SESSION['USUARIO_ID'] = $u;
    $_SESSION['NOMBRE'] = $a['NOMBRE'];
	$_SESSION['EMAIL'] = $a['EMAIL'];
	$_SESSION['ACTIVO'] = $a['ACTIVO'];
	
	echo json_encode([
				'status' => 1
			]);			
}else{
    echo json_encode([
				'status' => 0,
				'data' => $error 
			]);		
}

?>