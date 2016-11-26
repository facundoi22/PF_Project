<header>
	<div id="arriba">
		<a href="index.php" title="home" id="logoPrincipal"><img src="images/LOGOPF-Sin-Fondo.png" alt="Logo" style="margin:3px;" /></a>
		<div>
			<form id="FORMbuscador" action="index.php?seccion=resultado" method="post">
				<img src="images/Icons/lupa11.png" alt="Logo" style="height:20px;width:20px;" />&nbsp;
				<input id="INPUTbuscador" placeholder='Buscar...' value="" name="contenidoAbuscar" />
			</form>
		</div>
		<div id="DIVbtnRegistro">
			<div>
				<div id="btnRegistro">
					<?php
						Session::start();
						if (Session::has('logueado') && Session::get('logueado')=='S') {
							$usuarioLogueado = true;
						}else{
							$usuarioLogueado = false;
						}

						if ($usuarioLogueado ){
							echo "<a href='php/desloguear.php'>CERRAR SESIÓN</a>";
						} else {
							echo "<a href='#registroModal'>REGISTRARSE</a>";
						}
					?>

				</div>
			</div>
		</div>
	</div>
	<?php
		if (! $usuarioLogueado ){
			if (Session::has("camposError")){
				$camposError = Session::get("camposError");
				$camposViejos = Session::get("campos");
				$usuario=$camposViejos['usuario'];
				$nombre=$camposViejos['nombre'];
				$apellido=$camposViejos['apellido'];
				$email=$camposViejos['email'];
				Session::clear("camposError");
				Session::clear("campos");
			} else {
				$usuario="";
				$nombre="";
				$apellido="";
				$email="";
			};
	?>
	<div id="registro" class="tresCol">
		<div>
			<div id="registroModal">
				<div>
					<div>
						<h2 class='mayusculas'>REGISTRARSE</h2>
						<a href='#' title='Volver'> Volver</a>
					</div>
					<div>
						<form id='formRegistro' action="php/registrar.php" method="post">
							<input <?php echo "value='$usuario'"?> class='inputRegistro' type="text" name="usuario" placeholder="Usuario"/>
							<input <?php echo "value='$nombre'"?> class='inputRegistro' type="text" name="nombre" placeholder="Nombre"/>
							<input <?php echo "value='$apellido'"?> class='inputRegistro' type="text" name="apellido" placeholder="Apellido"/>
							<input <?php echo "value='$email'"?> class='inputRegistro' type="text" name="email" placeholder="Mail"/>
							<input class='inputRegistro' type="password" name="clave" placeholder="Clave"/>
							<input class='inputRegistro' type="password" name="confClave" placeholder="Confirmar Clave"/>
							<div><input type="checkbox" name="terminos" id="terminos" value="Y"/>
								<label for="terminos"> Acepto los términos y condiciones </label></div>
							<?php
							if (! $usuarioLogueado && isset($camposError)){
								echo("<div class='DivErrores'><ul>");
								foreach ($camposError as $error => $descr) {
									echo ("<li style='color:#F00'>".ucfirst($error).": ".$descr."</li>");
								}
								echo("</ul></div>");
							}
							?>


							<div class='btnIngresar'>
								<input type="submit" value="REGISTRARSE"/>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<?php
	};
	?>
</header>
