<?php 
include( '../config.php' );
Session::start();
?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
	<meta charset="UTF-8">
	<title>Admin ProximaFecha</title>
	<link rel="stylesheet" type="text/css" href="css/estilos.admin.css" />
	<link rel="stylesheet" type="text/css" href="css/font-awesome.css" />
</head>
<body>

	<div id="todo">
		<div id="logo">
			<img src="images/LOGOPF-Sin-Fondo.png" alt="Logo" />
			<h1>Administración ProximaFecha.com</h1>
		</div>
		<?php
		if (Session::has('logueadoAdmin') && Session::get('logueadoAdmin')=='S') {
			include("modulos/admin.php");
		}else {
			include("modulos/login.php");
		};
		?>
    </div>
</body>
</html>

