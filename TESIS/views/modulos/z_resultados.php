<?php
use ProximaFecha\Tools\Session;
use ProximaFecha\Model\Usuario;

/**
 * @var array $resultados
 */
$EsPerfilUsuarioConectado = false;
$usuarioActual = "";
$usuario_id = "";
if (Session::has("usuario")  ){
	$EsPerfilUsuarioConectado= true;
	$usuarioActual = Session::get("usuario");
	$usuario_id = $usuarioActual ->getUsuarioId() ;
};
?>
<body><div id='miusuario'>
<main id="ResultadosBuscador">
	<div id='primerafilamiusuario'>
    	<div class='cuatroCol'>

			<?php
            if ($EsPerfilUsuarioConectado) {
                echo "<div id='DivBienvenido'>";
				echo "<h2>Bienvenido " . $usuarioActual->getNombre() ."</h2>";
                if (file_exists('../views/images/usuarios/'.$usuarioActual->getUsuarioId() . '.jpg')) {
                    echo "<img src='../views/images/usuarios/" . $usuarioActual->getUsuarioId() . ".jpg' alt='foto perfil' />";
                } else {
                    echo "<img src='../../public/images/icons/UserJugador.png' alt='foto perfil' />";
                }
			    echo "</div>";
			}else{
            ?>
            <div id="DivFormLogin">
                <form action="loguear" method="POST">
                    <div class="DIVinputs">
                        <img src="../views/images/icons/mail.png" alt="icono Mail" style="height:20px;width:20px;"/>&nbsp;
                        <input class='inputFormHome' type="text" name="usuario" placeholder="Usuario"/>
                    </div>
                    <div class="DIVinputs">
                        <img src="../views/images/icons/candadoVerde.png" alt="Icono Candado" style="height:20px;width:20px;"/>&nbsp;
                        <input class='inputFormHome' type="password" name="password" placeholder="Clave"/>
                    </div>
                    <div class='btnIngresar'>
                        <input type="submit" value="INGRESAR"/>
                    </div>
                </form>
                <span>Olvidé Mi Contraseña</span>
                <?php
                if (Session::has('errorLogin')) {
                    echo("<h3> " . Session::get('errorLogin') . " </h3>");
                    Session::clearValue('errorLogin');
                };
                echo "</div>";
                } ?>
		</div>
		<section class='col-md-7' id='datosusuario'>
			<?php
			if ($resultados) {
				echo "<h2> Resultados </h2>";
				echo "<ul id='listaAmigos'>";
				foreach ($resultados as $amigo) {
					echo "<li>";
					if (file_exists('../views/images/usuarios/' . $amigo->getUsuarioId() . '.jpg')) {
						echo "<img class='fotoChica' src='../views/images/usuarios/" . $amigo->getUsuarioId() . ".jpg' alt='foto perfil' />";
					} else {
						echo "<img class='fotoChica' src='../views/images/icons/UserJugador.png' alt='foto perfil' />";
					}

					echo "<a href='usuarios/" . $amigo->getUsuarioId() . "' class='negrita'>" . $amigo->getNombreCompleto() . "</a><a href='posteos/" . $amigo->getUsuarioId() . "' title='Ver Posteos'>Ver Posteos</a>";
					echo "</li>";
				}
				echo "</ul>";
			} else {
				echo "<h3 id='noHayPosteo'> No hay resultados para la búsqueda</h3>";
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
	<?php if ($EsPerfilUsuarioConectado) {
		?>
		<div id="modalSubirFoto">
			<div>
				<div id="subirFotoModal">
					<div>
						<div id='cabeceraSubirFoto'>
							<h2 class='mayusculas'>Actualizá tu Foto de Perfil</h2>
							<a href='#' title='Volver' id='cruzCerrar'><span class='oculto'>Volver</span></a>
						</div>
						<div id='cuerpoSubirFoto'>
							<form id='formRegistro' action="actualizarFotoPerfil" method="post"
								  enctype="multipart/form-data">
								<input type="hidden" name="usuario" value="<?php echo $usuario_id ?>"/>
								<label for='archivo'>Elegí la foto a subir</label>
								<input id="archivo" type="file" name="foto" accept="image/jpeg"/>
								<div class='btnIngresar'>
									<input type="submit" value="Actualizar Foto de Perfil"/>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>

		<?php
	}
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
		if ($EsPerfilUsuarioConectado) {
			$nombre = $usuarioActual->getNombre();
			$apellido = $usuarioActual->getApellido();
			$email = $usuarioActual->getEmail();
			$descripcion = $usuarioActual->getDescripcion();
		};
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
						<form id='formRegistro' action="usuarios/crearPosteo" method="post" enctype="multipart/form-data">
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



