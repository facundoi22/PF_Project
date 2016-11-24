			<main>
				<div>
					<h2 class="mayusculas negrita">Bienvenido Usuario</h2>
					<p >Todavía no sos parte de ningún equipo.</p>
					<h3 class="mayusculas negrita">¿Que querés hacer?</h3>
					<a href="#registorModal">Crear Un Equipo</a>
					<a href="#">Buscar un Equipo</a>
					<a href="#">Ver Equipos</a>
				</div>
				<div id="registro" class="tresCol">
					<div>
						<div id="registorModal">
							<div>
								<div>
									<h2 class='mayusculas'>Crear tu equipo</h2>
										<a href='#' title='Volver'> Volver</a>
								</div>
								<div>
									<form id='formRegistro' action="../php/crearEquipo.php" method="post" enctype="multipart/form-data">
										<label>Nombre<input type="text" name="nombre"/></label>
										<label>Capitán<input type="text" name="capitan"/></label>
										<label>Escudo<input id="archivo" type="file" name="foto" accept="image/*" /></label>
										<input type="hidden" name="ajax" />
										<div class='btnIngresar'>
											<input  type="submit" value="Crear Equipo" />
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
