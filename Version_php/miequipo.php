<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<link href="css/reset.css" rel="stylesheet" >
		<link href="css/estilos.css" rel="stylesheet" >
		<script>
			document.createElement( "picture" );
		</script>
		<script src = "../js/picturefill.js" async></script>		
		<script src="../js/prefixfree.min.js"></script>
		<script src="../js/jquery-2.1.3.js"></script>
		<title>Próxima Fecha</title>
	</head>
	
	<body>
		<div id="equipo">
			<header>
				<div id="arriba">
					<a href="index.php" title="home" id="logoPrincipal"><img src="images/LOGOPF-Sin-Fondo.png" alt="Logo" style="margin:3px;" /></a>
					<div>
						<form method="post" id="FORMbuscador" action="resultado.php">
							<img src="images/Icons/lupa11.png" alt="Logo" style="height:20px;width:20px;" />
							<input id="INPUTbuscador" placeholder='Hacer otra búsqueda...' value="" name="contenidoAbuscar" />
						</form>
					</div>
				</div>
				<div>
					<form id="FORMbuscador" action="resultado.php" method="post">
						<img src="images/Icons/lupa11.png" alt="Logo" style="height:20px;width:20px;" />&nbsp;
						<input id="INPUTbuscador" placeholder='Buscar...' value="" name="contenidoAbuscar" />
					</form>
				</div>
			</header>		
			<main>
				<div>
					<img src="images/PHPFutbolClub.png" alt="Logo del Equipo"/>
					<h2 class="mayusculas negrita">php futbol club</h2>
				</div>
				<div>
					<h3 class="mayusculas">Está participando en la liga <span class="negrita">Da Vinci</span></h3>
					<div>
						<div class="tresColx2">
							<table>
								<thead>
									<tr><td>Equipos</td><td>Ptos</td><td>PJ</td><td>PG</td><td>PE</td><td>PP</td><td>GF</td><td>GC</td><td>Dif</td></tr>
								</thead>
								<tbody>
									<tr><td>Programadores</td><td>15</td><td>5</td><td>5</td><td>0</td><td>0</td><td>27</td><td>8</td><td>19</td></tr>
									<tr id="miEquipo"><td>PHP Futbol Club</td><td>13</td><td>5</td><td>4</td><td>1</td><td>0</td><td>23</td><td>12</td><td>11</td></tr>
									<tr><td>Varchar de 50</td><td>13</td><td>5</td><td>4</td><td>1</td><td>0</td><td>20</td><td>14</td><td>6</td></tr>
									<tr><td>SQL Injection</td><td>12</td><td>5</td><td>4</td><td>0</td><td>1</td><td>25</td><td>15</td><td>10</td></tr>
									<tr><td>Los Array de 1 indice</td><td>8</td><td>5</td><td>2</td><td>2</td><td>1</td><td>15</td><td>12</td><td>3</td></tr>
									<tr><td>Sin Framework no programo</td><td>8</td><td>5</td><td>2</td><td>2</td><td>1</td><td>14</td><td>12</td><td>2</td></tr>
									<tr><td>Control C Control V</td><td>8</td><td>5</td><td>2</td><td>2</td><td>1</td><td>15</td><td>12</td><td>3</td></tr>
									<tr><td>Pisame la variable</td><td>5</td><td>5</td><td>1</td><td>1</td><td>3</td><td>11</td><td>10</td><td>1</td></tr>
									<tr><td>Puerto 7</td><td>4</td><td>5</td><td>0</td><td>2</td><td>3</td><td>9</td><td>19</td><td>-10</td></tr>
									<tr><td>LAMPaso</td><td>0</td><td>5</td><td>0</td><td>0</td><td>5</td><td>3</td><td>24</td><td>-21</td></tr>
								</tbody>
							</table>
						</div>
						<div class="tresCol">
							<h3> Proximo Partido - Fecha 6 </h3>
							<img src="images/PHPFutbolClub100.png" alt="Logo del Equipo"/>
							<p>VS</p>
							<img src="images/Arrayde1Indice100.png" alt="Logo del Equipo"/>
							<p>PHP Futbol Club</p>
							<p>Array de 1 Indice</p>
							<p>Fecha y Hora: 12/11/2016 - 21:00hs</p>
							<p>Sede: Club Da Vinci</p>
							<img src="images/mapa.jpg" alt="Ubicación del lugar"/>
						</div>					
					</div>					
				</div>
				<div>
					<div>
						<div class="dosCol" id="companeros">
							<h3 class="mayusculas">Compañeros de Equipo</h3>
							<ul>
								<li><img src="images/equipo/jugador1.jpg" alt="Foto del Jugador"/><span id="capitan">José F. Echassoc</span><a href="#mensajeModal" class="mayuscula">Enviar Mensaje</a></li>
								<li><img src="images/equipo/jugador2.jpg" alt="Foto del Jugador"/><span>Rómulo H. Aquitado</span></li>
								<li><img src="images/equipo/jugador3.jpg" alt="Foto del Jugador"/><span>Elías Pereza</span></li>
								<li><img src="images/equipo/jugador4.jpg" alt="Foto del Jugador"/><span>Brian De La Mano</span></li>
								<li><img src="images/equipo/jugador5.jpg" alt="Foto del Jugador"/><span>Alberto Tronchado</span></li>
								<li><img src="images/equipo/jugador6.jpg" alt="Foto del Jugador"/><span>Silvio Roscazo</span></li>
								<li><img src="images/equipo/jugador7.jpg" alt="Foto del Jugador"/><span>Francisco Guaymallén</span></li>
							</ul>
							<div> 
								<div id="mensajeModal">
									<div>			
										<div>			
											<h2> Enviar Mensaje </h2>
											<a href='#' title='Volver'> Volver</a>
									</div>
										<div>			
											<form action="miequipo.html#companeros" method="post">
												<textarea rows='10'  cols='30' name="mensaje"></textarea>
												<input type="submit" value="Enviar" />
											</form>	
										</div>
									</div>
								</div>				
							</div>
						</div>
						<div class="dosCol">
							<div>
								<div>
									<h3> Último Partido - Fecha 5 </h3>
									<img src="images/PHPFutbolClub100.png" alt="Logo del Equipo"/>
									<p>4 - 2</p>
									<img src="images/Puerto7100.png" alt="Logo del Equipo"/>
									<p>PHP Futbol Club</p>
									<p>Puerto 7</p>
									<a href="#" title="Ver Todos">Ver Resultados de Todos los Partidos Jugados</a>				
								</div>
							</div>
							<div>
								<a href="#" title="Fravega"><img style="margin: 0px" src="images/fravega.png" alt="Fravega"/></a>
							</div>
						</div>
					</div>
				</div>
			</main>
			<footer id="footer">
				
				<div class="cincoCol">
					<h2>Próxima Fecha</h2>
				</div>
				<div class="cincoCol">
					<h3>Organizadores</h3>
					<ul>
						<li><a href="#">Organizar Torneo</a></li>
						<li><a href="#">Registrarme</a></li>
						<li><a href="#">Ingresar</a></li>
						<li><a href="#">Gratuidad del Servicio</a></li>
					</ul>
				</div>
				<div class="cincoCol">
					<h3>Jugadores</h3>
					<ul>
						<li><a href="#">Buscar Campeonato</a></li>
						<li><a href="#">Registrarme</a></li>
						<li><a href="#">Ingresar</a></li>
					</ul>
				</div>
				<div class="cincoCol">
					<h3>Preguntas Frecuentes</h3>
					<ul>
						<li><a href="#">¿Es necesario hacerme un usuario?</a></li>
						<li><a href="#">¿Es gratis el servicio?</a></li>
						<li><a href="#">¿Que tipos de torneo puedo organizar?</a></li>
						<li><a href="#">¿Puedo organizar un campeonato siendo jugador de otro?</a></li>
						<li><a href="#">¿Cuantos campeonatos puedo organizar?</a></li>
					</ul>
				</div>
				<div class="cincoCol">
					<h3>Redes Sociales</h3>
					<ul>
						<li class="dosCol"><a href="#">Facebook</a></li>
						<li class="dosCol"><a href="#">Twitter</a></li>
					</ul>
				</div>
			</footer>
		</div>
		<div id="publicidad" style="bottom: 0px; left: 0px; height:60px; left: 0px;">
			<img src="images/publicidad_1.png" alt="publicidad"/>
			<a href="#" title="Cerrar">Cerrar</a>
		</div>
		<script src='js/publicidad.js'></script>
	</body>
</html>
