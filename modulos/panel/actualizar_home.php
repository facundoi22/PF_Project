<?php 
require_once( '../../config.php' );

Noticia::borrarNoticias();
Noticia::crearNoticia($_POST['titulo'], $_POST['texto']);

if( isset($_POST['ajax'])) {
	echo json_encode([
		'status' => 0		
	]);			
} else {
	header('Location: ../../index.php?seccion=panel');
};
?>