<header>
	<div id="arriba">
		<a href="index.php" title="home" id="logoPrincipal"><img src="images/LOGOPF-Sin-Fondo.png" alt="Logo" style="margin:3px;" /></a>
		<div>
			<form id="FORMbuscador" action="modulos/resultado.php" method="post">
				<img src="images/Icons/lupa11.png" alt="Logo" style="height:20px;width:20px;" />&nbsp;
				<input id="INPUTbuscador" placeholder='Buscar...' value="" name="contenidoAbuscar" />
			</form>
		</div>
		<div id="DIVbtnRegistro">
			<div>
				<div id="btnRegistro">
					<a href="#registroModal">REGISTRARSE</a>
				</div>
			</div>
		</div>
	</div>
	<div id="registro" class="tresCol">
		<div>
			<div id="registroModal">
				<div>
					<div>
						<h2 class='mayusculas'>REGISTRARSE</h2>
						<a href='#' title='Volver'> Volver</a>
					</div>
					<div>
						<form id='formRegistro' action="../php/registrar.php" method="post">
							<input class='inputRegistro' type="text" name="usuario" placeholder="Usuario"/>
							<input class='inputRegistro' type="text" name="nombre" placeholder="Nombre"/>
							<input class='inputRegistro' type="text" name="apellido" placeholder="Apellido"/>
							<input class='inputRegistro' type="text" name="mail" placeholder="Mail"/>
							<input class='inputRegistro' type="password" name="clave" placeholder="Clave"/>
							<input class='inputRegistro' type="password" name="confClave" placeholder="Confirmar Clave"/>
							<div><input type="checkbox" name="terminos" id="terminos" value="y"/>
								<label for="terminos"> Acepto los términos y condiciones </label></div>
							<div class='btnIngresar'>
								<input  type="submit" value="REGISTRARSE" />
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</header>
