<!DOCTYPE html>
<html lang="es">
	<?php 
		require_once( 'config.php' );

		/* Busco la seccion primero ya que lo uso en varios lados */
		$seccionActual = 'home';
		if (isset($_GET['seccion'])){
			$seccionActual = $_GET['seccion'];
		} ;
		switch($seccionActual){
			case 'home':
			case 'galeria':
			case 'reservas':
			case 'gracias':
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
		<link href="css/font-awesome.css" rel="stylesheet" >
		<link href='https://fonts.googleapis.com/css?family=Handlee' rel='stylesheet' type='text/css'>
		<link href='https://fonts.googleapis.com/css?family=Cookie' rel='stylesheet' type='text/css'>
		<link href="css/estilos.css" rel="stylesheet" >
		<script>
			document.createElement( "picture" );
		</script>
		<script src = "js/picturefill.js" async></script>		
		<script src="js/prefixfree.min.js"></script>
		<script src="js/jquery-2.1.3.js"></script>
		<title>El Cedrón - Pizzería  - <?php echo $seccionActual ?> </title>
	</head>
	
	<body>
		<div>
			<header>
				<?php require('botonera.php' ); ?>			
				
				
			</header>		
			<main>
				<?php include("/modulos/$seccionActual/contenido.php");	?>		
			</main>
			<?php require('footer.php' ); ?>			
		</div>
		<script src='js/ajax.js'></script>
		<script src='js/funciones.js'></script>
		<script src='modulos/home/funciones.js'></script>
		<script src='js/botonera.js'></script>
	</body>
</html>
