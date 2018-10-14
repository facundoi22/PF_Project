<?php
use ProximaFecha\Tools\Session;
use ProximaFecha\Model\Usuario;
use ProximaFecha\Model\Posteo;

/**
 * @var Usuario $usuarioActual
 * @var Posteo[] $posteos
 * @var string $usuario_id
 */

?>
<body><div id='containerPosteos'>
<main>
	<div id="posteos">
		<?php
		echo "<h2> Posteos de ". $usuarioActual->getNombreCompleto() ."</h2>";
		$hayPosteos = false;
		foreach( $posteos as $posteo){
			$hayPosteos = true;
			echo "<div id='posteo". $posteo->getPosteoID() ."'>";
			echo "<h3>" . $posteo->getTitulo(). "</h3>";
			echo "<div>";
			if(file_exists('../views/images/posteos/'. $posteo->getPosteoID() . '.jpg' )) {
				echo "<img class='dosCol' src='../../views/images/posteos/" . $posteo->getPosteoID() . ".jpg' alt='foto posteo' />";
				echo "<p class='dosCol'>" . $posteo->getContenido() . "</p>";
			} else {
				echo "<p class='unaCol'>" . $posteo->getContenido() . "</p>";
			};
			echo "</div>";
			echo "<dl>";
			foreach( $posteo->getMensajes() as $mensaje) {
				echo "<dt><a href='../usuarios/" .$mensaje->getUsuarioId() ."'>". $mensaje->getUsuario()->getNombreCompleto() ."</a></dt>";
				echo "<dd>" . $mensaje->getMensaje() . "</dd>";
			};
			if (Session::has("usuario")) {
				$usuarioActual = Session::get("usuario");
				echo "<dt>".$usuarioActual->getNombreCompleto() ."</dt>";
				echo "</dl>";

				echo "<form id='formComentario' action='../agregarComentarioPosteos' method='post' >";
				echo "<input type='hidden' name='usuario_id' value='".$usuarioActual->getUsuarioId()."'/>";
				echo "<input type='hidden' name='posteo_id' value='".$posteo->getPosteoID()."'/>";
				echo "<textarea name='mensaje' rows='3' cols='50' id='mensaje'></textarea>";
				//echo "<input name='mensaje' type='text' id='mensaje'/>";
				echo "<input  type='submit' value='Enviar comentario' />";
				echo "</form>";
			} else {
				echo "</dl>";
			};
			echo "</div>";
		}
		if (! $hayPosteos ){
			echo "<h3 id='noHayPosteo'> El usuario todavía no ha realizado ningún posteo</h3>";
		}?>
	</div>
</main>
