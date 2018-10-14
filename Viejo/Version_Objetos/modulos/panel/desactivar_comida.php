<?php 
require_once( '../../config.php' );
if (isset($_POST['comida']) ){
	$idComida = $_POST['comida'];
    $comida = New Comida($idComida);
    $comida->updateEstado("0");
}
if( isset($_POST['ajax'])) {
	echo json_encode([
		'status' => 0		
	]);			
} else {
	header('Location: ../../index.php?seccion=panel#activar');
};
?>