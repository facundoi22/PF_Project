<!DOCTYPE html>
<html lang="es">
	<?php
		include( 'config.php' );
		include('funciones.php' );

		Session::start();

		$usuario = "";
/*
		session_start();
		if (isset($_SESSION['usuario'])){
			$usuario = $_SESSION['usuario'];
		}*/
		if (Session::has("usuario")){
			$usuario = Session::get("usuario");
		}


		$seccionActual = 'home';
		if (isset($_GET['seccion'])){
			$seccionActual = $_GET['seccion'];
		} ;
		switch($seccionActual){
			case 'resultado':
			case 'home':
				break;
			case 'miequipo':
			case 'miusuario':
				if (!Session::has("usuario")){
					$seccionActual = 'home';
				};
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
	</body>
</html>
