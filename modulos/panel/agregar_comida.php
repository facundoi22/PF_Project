<?php 
	require_once( '../../config.php' );

	$tipoComida= $_POST['tipo'];
	$nombre = $_POST['nombre'];
	$ingredientes = $_POST['ingredientes'];

    $comidaNueva = New Comida();
    $comida_id = Comida::insertarComida($nombre, $tipoComida, $ingredientes);

	if (isset($_FILES['foto']['tmp_name']) ){
		$archivo_tmp = $_FILES['foto']['tmp_name'];
		$nombre_nuevo = "../../modulos/galeria/images/$comida_id"."_"."$nombre.jpg";

		$original = imagecreatefromjpeg($archivo_tmp);

		$ancho = imagesx( $original );
		$alto = imagesy( $original );


		$alto_max= 300;
		$ancho_max = round( $ancho *  $alto_max / $alto );

		$copia = imagecreatetruecolor( $ancho_max, $alto_max );

		imagecopyresampled( $copia, $original,
							0,0, 0,0,
							$ancho_max,$alto_max,
							$ancho,$alto);
		imagejpeg( $copia , $nombre_nuevo);
	}
		
	if( isset($_POST['ajax'])) {
		echo json_encode([
			'status' => 0		
		]);			
	} else {
		header('Location: ../../index.php?seccion=galeria&tipocomida='.$tipoComida);
	};
?>