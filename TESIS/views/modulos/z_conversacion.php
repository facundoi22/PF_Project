<?php
use ProximaFecha\Tools\Session;
use ProximaFecha\Model\Usuario;


/**
 * @var Usuario $usuarioActual
 * @var Usuario $amigoActual
 * @var array $chats
 */
if (Session::has("usuario") && Session::get("usuario")->getUsuarioId() == $usuarioActual->getUsuarioId()) {

	?>
	<body>
<div id='home'>
	<main>
		<section id="conversacion">
			<?php
			echo "<h2> Conversación con <a href='../../usuarios/" .$amigoActual->getUsuarioId() ."' class='negrita'>"  . $amigoActual->getNombreCompleto() . "</a></h2>";
			echo "<ol>";
			foreach ($chats as $chat) {
				if ($chat->getEmisorID() == $amigoActual->getUsuarioID()) {
					$class = "chatImpar";
					$classLI = "chatLiImpar";
				} else {
					$class = "chatPar";
					$classLI = "chatLiPar";
				}
				echo "<li class='$classLI' ><span class='$class'>" . $chat->getMensaje() . "</span></li>";
			};
			?>
			</ol>
			<form id='formChat' action='../../agregarChat' method='post'>
				<input type='hidden' name='usuario_id' value='<?php echo $usuarioActual->getUsuarioId() ?>'/>
				<input type='hidden' name='amigo_id' value='<?php echo $amigoActual->getUsuarioId() ?>'/>
				<textarea name='mensaje' rows='3' cols='50' id='mensaje'></textarea>
				<input type='submit' class="LinkVerPosteos" value='Enviar'/>
			</form>
		</section>
	</main>
	<?php
} else {
	header("Location: ../../../public");
}