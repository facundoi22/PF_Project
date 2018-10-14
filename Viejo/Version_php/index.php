<!DOCTYPE html>
<html lang="es">
	<?php
		include( 'config.php' );

		Session::start();

		$usuario = "";
		if (Session::has("usuario")){
			$usuario = Session::get("usuario");
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
			case 'error404':
			case 'equipos':
				break;
			default: $seccionActual = 'home';
		}

	?>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<link href="css/reset.css" rel="stylesheet" >
		<link rel="stylesheet" href="css/bootstrap-theme.css" />
		<link rel="stylesheet" href="css/bootstrap.min.css" />
		<link rel="stylesheet" href="css/bootstrap.css" />
		<link rel="stylesheet" href="css/bootstrap-theme.min.css" />
		<link href="css/estilos.css" rel="stylesheet">
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
		<script type="text/javascript" src="js/jsPF.js"></script>
	</body>
</html>
