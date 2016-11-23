<!DOCTYPE html>
<html lang="es">
	<?php
		include( 'config.php' );
		include('funciones.php' );
	
		$usuario = "";
		session_start();
		if (isset($_SESSION['usuario'])){
			$usuario = $_SESSION['usuario'];
		}



		$seccionActual = 'home';
		if (isset($_GET['seccion'])){
			$seccionActual = $_GET['seccion'];
		} ;
		switch($seccionActual){
			case 'home':
			case 'miequipo':
			case 'miusuario':
			case 'resultado':
			case 'login':
			case 'panel':
				break;
			default: $seccionActual = 'home';
		}

	?>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<link href="css/reset.css" rel="stylesheet" >
		<link href="css/estilos.css" rel="stylesheet" >
		<title>Próxima Fecha</title>
	</head>

	<body>

	<?php
		echo "<div id='$seccionActual'>" ;
		require('modulos/header.php');
		include("modulos/$seccionActual.php");
		require('modulos/footer.php');
	?>
		</div>
		<div id="publicidad" style="bottom: 0px; left: 0px; height:60px; left: 0px;">
			<img src="images/publicidad_1.png" alt="publicidad"/>
			<a href="#" title="Cerrar">Cerrar</a>
		</div>
		<script src='js/publicidad.js'></script>
	</body>
</html>
