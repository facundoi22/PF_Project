<?php
use ProximaFecha\Tools\Session;
use ProximaFecha\Model\Usuario;

/**
 * @var Usuario $usuarioActual
 */
$EsPerfilUsuarioConectado = false;
if (Session::has("usuario") && Session::get("usuario")->getUsuarioId() == $usuario_id) {
	$EsPerfilUsuarioConectado= true;
};

?>
<body><div id='miusuario'>
<main class='container'>
	<div id='primerafilamiusuario' class='row'>
		<div class='col-md-5'>
			<div>
			<?php

			if(file_exists('../views/images/usuarios/'.$usuarioActual->getUsuarioId() . '.jpg')){
				echo "<img src='../../views/images/usuarios/".$usuarioActual->getUsuarioId() . ".jpg' alt='foto perfil' />";
			}else {
				echo "<img src='../../public/images/icons/UserJugador.png' alt='foto perfil' />";
			}
			if ($EsPerfilUsuarioConectado){
				echo "<a id='subirFotoPerfil' href='#subirFotoModal' title='Subir Foto'><span class='oculto'>Subir Foto</span></a>";
			}
			?>
			</div>
			<div>
				<?php
                echo "<a href='../posteos/" . $usuarioActual->getUsuarioId() . "' class='LinkVerPosteos' title='Ver Posteos'>Ver Posteos </a>";
                if (Session::has("usuario") && Session::get("usuario")->getUsuarioId() != $usuario_id) {
					if (Session::get("usuario")->esAmigoDe( $usuario_id) ) {
						echo "<form id='formEliminarAmigo' action='../eliminarAmigo' method='post' >";
						echo "<input type='hidden' name='usuario_id' value='".Session::get("usuario")->getUsuarioId()."'/>";
						echo "<input type='hidden' name='amigo_id' value='".$usuario_id."'/>";
						echo "<input class='LinkVerPosteos' type='submit' value='Eliminar Amigo' />";
						echo "</form>";

						echo "<a href='../chats/" . Session::get("usuario")->getUsuarioId() . "/". $usuario_id ."' class='LinkVerPosteos' title='Ver Chats'>Ver Chats</a>";
					} else {
						echo "<form id='formAgregarAmigo' action='../agregarAmigo' method='post' >";
						echo "<input type='hidden' name='usuario_id' value='".Session::get("usuario")->getUsuarioId()."'/>";
						echo "<input type='hidden' name='amigo_id' value='".$usuario_id."'/>";
						echo "<input  class='LinkVerPosteos' type='submit' value='Agregar Amigo' />";
						echo "</form>";
					}
				}
				?>
			</div>
		</div>
		<section class='col-md-7' id='datosusuario'>
			<ul>
				<li class='nombreUser'><?php echo $usuarioActual->getNombreCompleto()?></li>
					<?php
					if ($EsPerfilUsuarioConectado){
						echo"<li><a id='editarPerfil' href='#registroModal' title='Editar Perfil'><span class='oculto'>Editar Perfil</span></a></li>";
					}
					?>


				<li><?php echo $usuarioActual->getEmail()?></li>
				<li><?php echo $usuarioActual->getDescripcion()?></li>

			</ul>
			<?php
			if ($EsPerfilUsuarioConectado && $usuarioActual->tieneAmigos()) {
				echo "<h2> Amigos </h2>";
				echo "<ul id='listaAmigos'>";
				foreach( $usuarioActual->getAmigos() as $amigo) {
					echo "<li>";
					if(file_exists('../views/images/usuarios/'.$amigo->getUsuarioId() . '.jpg')){
						echo "<img class='fotoChica' src='../../views/images/usuarios/".$amigo->getUsuarioId() . ".jpg' alt='foto perfil' />";
					}else {
						echo "<img class='fotoChica' src='../../public/images/icons/UserJugador.png' alt='foto perfil' />";
					}

					echo "<a href='" .$amigo->getUsuarioId() ."' class='negrita'>" . $amigo->getNombreCompleto() ."</a><a href='../chats/" . Session::get("usuario")->getUsuarioId() . "/". $amigo->getUsuarioId() ."' title='Ver Chat'>Ver Chat</a>";
					if ( $usuarioActual->tieneMensajesDe($amigo->getUsuarioId())){
						echo("<span> Tiene Mensajes Nuevos </span>");
					}
					echo "</li>";
				}
				echo "</ul>";

			};
			?>

		</section>

		<?php
		if ($EsPerfilUsuarioConectado){
		?>
		<div id='DivCrearPosteo'>
			<div>
				<a id='crearPosteo' href="#crearPosteoModal">
					<img src='<?= $ruta ?>../views/images/icons/postear.png' alt='icono crear posteo' />
					Crear Un Posteo
				</a>
			</div>
		</div>
		<?php } ?>



	</div>

	<div id="modalSubirFoto">
		<div>
			<div id="subirFotoModal">
				<div>
					<div id='cabeceraSubirFoto'>
						<h2 class='mayusculas'>Actualizá tu Foto de Perfil</h2>
						<a href='#' title='Volver' id='cruzCerrar'><span class='oculto'>Volver</span></a>
					</div>
					<div id='cuerpoSubirFoto'>
						<form id='formRegistro' action="actualizarFotoPerfil" method="post" enctype="multipart/form-data">
							<input type="hidden" name="usuario" value="<?php echo $usuario_id?>"/>
							<label for='archivo'>Elegí la foto a subir</label>
							<input id="archivo" type="file" name="foto" accept="image/jpeg" />
							<div class='btnIngresar'>
								<input  type="submit" value="Actualizar Foto de Perfil" />
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
	if (Session::has("camposError")){
		$camposError = Session::get("camposError");
		$camposViejos = Session::get("campos");
		$nombre=$camposViejos['nombre'];
		$apellido=$camposViejos['apellido'];
		$email=$camposViejos['email'];
		$descripcion=$camposViejos['descripcion'];
		Session::clearValue("camposError");
		Session::clearValue("campos");
	} else {
		$nombre=$usuarioActual->getNombre();
		$apellido=$usuarioActual->getApellido();
		$email=$usuarioActual->getEmail();
		$descripcion=$usuarioActual->getDescripcion();
	};
	?>
	<div id="registro" class="tresCol">
		<div>
			<div id="registroModal">
				<div>
					<div>
						<h2 class='mayusculas'>Actualizar Datos</h2>
						<a href='#' title='Volver'> Volver</a>
					</div>
					<div>
						<form id='formRegistro' action="actualizar" method="post">
						<!--	<input type="hidden" name="usuario" value="<?php echo $usuario_id?>"/>-->
							<input <?php echo "value='$nombre'"?> class='inputRegistro' type="text" name="nombre" placeholder="Nombre"/>
							<input <?php echo "value='$apellido'"?> class='inputRegistro' type="text" name="apellido" placeholder="Apellido"/>
							<input <?php echo "value='$email'"?> class='inputRegistro' type="text" name="email" placeholder="Mail"/>
							<textarea class='inputRegistro' name="descripcion" placeholder="Breve Biografía"><?=$descripcion?> </textarea>
							<?php if (isset($camposError)){
								echo("<div class='DivErrores'><ul>");
								foreach ($camposError as $error => $descr) {
									echo ("<li style='color:#F00'>".ucfirst($error).": ".$descr."</li>");
								}
								echo("</ul></div>");
							}
							?>
							<div class='btnIngresar'>
								<input type="submit" value="Actualizar Datos"/>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
	if ($EsPerfilUsuarioConectado){
	?>
	<div id="registro">
		<div>
			<div id="crearPosteoModal">
				<div>
					<div id='cabeceraSubirPosteo'>
						<h2 class='mayusculas'>Crear un Posteo</h2>
						<a href='#' title='Volver' id='cruzCerrar'><span class='oculto'>Volver</span></a>
					</div>
					<div id='cuerpoSubirPosteo'>
						<form id='formRegistro' action="crearPosteo" method="post" enctype="multipart/form-data">
							<input type="hidden" name="usuario" value="<?=$usuario_id?>"/>
							<label for="titulo">Titulo</label>
							<input id="titulo" class='inputRegistro' type="text" name="titulo"/>
							<textarea class="inputRegistro" name="contenido"  rows="5" cols="50" id="contenido"></textarea>
							<label>Foto<input id="archivo" type="file" name="foto" accept="image/jpeg" /></label>
							<div class='btnIngresar'>
								<input  type="submit" value="Subir Posteo" />
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>


	<?php
	}
	?>
</main>



