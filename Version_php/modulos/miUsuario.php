			<main id="miusuario" class='container'>
				
				<div id='primerafilamiusuario' class='row'>
					<div class='col-md-4'>
						<img src="images/icons/UserJugador.png" alt='foto perfil' />
						<a id='subirFotoPerfil'>subir foto</a>
					</div>
					<div class='col-md-7' id='datosusuario'>
						<ul>
							<li class='nombreUser'>Vanesa Ponce</li>
							<li><span class='negrita'>Equipos:</span>	
								<ul>	
									<li>Todavía no sos parte de ningún equipo.</li>
								</ul>	
							</li>
							<li><span class='negrita'>Torneos en los que participas:</span>
								<ul>	
									<li>No participas de ningún torneo</li>
								</ul>
							</li>
							<li><span class='negrita'>Torneos creados:</span>
								<ul>	
									<li>No has creado ningún torneo</li>
								</ul>
							</li>
						</ul>
					</div>
					<div class='col-md-1'>
						<a href="#">editar datos</a>
					</div>	
				</div>
				<div class='row' id='accionesEquipo'>
					<div class='col-md-3'>	
						<h3 class="mayusculas negrita">Acciones - Equipo</h3>
					</div>	
					<div class='col-md-3'>	
						<a id='crearEquipo' href="#registroEquipo">
							Crear Un Equipo
							<img src='images/crearEquipo-200px.png' alt='icono crear equipo' />
						</a>
					</div>
					<div class='col-md-3'>	
						<a id='buscarEquipo' href="#">
							Buscar un Equipo
							<img src='images/buscarEquipo2-200px.png' alt='icono buscar equipo' />
						</a>
					</div>
					<div class='col-md-3'>
						<a id='verEquipos' href="#">
						Ver Equipos
							<img src='images/verEquipo-200px.png' alt='icono ver equipos' />
						</a>
					</div>
				</div>
				<div id="registro">
					<div>
						<div id="registroEquipo">
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
			</main>
