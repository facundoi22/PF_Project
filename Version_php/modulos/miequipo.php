<?php
$usuario = New Usuario(SESSION::get("usuario"));


$equipo = $usuario->getEquipo();
$equipo->setJugadores();
$equipo_id = $equipo->getEquipoID();
?>


<main>
	<?php
	echo "<div style='background-image: url(images/equipos/".$equipo_id."_equipo.jpg)'>";
	echo "<img src='images/equipos/".$equipo_id."_logo_200.png' alt='Logo del Equipo'/>";
	echo "<h2 class='mayusculas negrita'>" . $equipo->getNombre() . "</h2>";
	echo "</div>";

	if ($equipo->participaEnTorneo()){
		$torneo = $equipo->getTorneo();
	?>
	<div>
		<?php echo "<h3 class='mayusculas'>Está participando en la liga <span class='negrita'>" . $torneo->getNombre() ."</span></h3>"; ?>
		<div>
			<div class="tresColx2">
				<?php
				$torneo->printTabla($equipo_id);
				?>

			</div>
			<div class="tresCol">
				<h3> Proximo Partido - Fecha 6 </h3>
				<img src="images/equipos/1_logo_100.png" alt="Logo del Equipo"/>
				<p>VS</p>
				<img src="images/equipos/9_logo_100.png" alt="Logo del Equipo"/>
				<p>PHP Futbol Club</p>
				<p>Array de 1 Indice</p>
				<p>Fecha y Hora: 12/11/2016 - 21:00hs</p>
				<p>Sede: Club Da Vinci</p>
				<img src="images/mapa.jpg" alt="Ubicación del lugar"/>
			</div>
		</div>
	</div>
	<?php } ?>
	<div>
		<div>
			<div class="dosCol" id="companeros">
				<h3 class="mayusculas">Integrantes del Equipo</h3>
				<?php
				$equipo->printJugadoresEnUL();
				?>

				<div>
					<div id="mensajeModal">
						<div>
							<div>
								<h2> Enviar Mensaje </h2>
								<a href='#' title='Volver'> Volver</a>
						</div>
								<div>
								<form action="index.php?seccion=miequipo" method="post">
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
						<img src="images/equipos/1_logo_100.png" alt="Logo del Equipo"/>
						<p>4 - 2</p>
						<img src="images/equipos/6_logo_100.png" alt="Logo del Equipo"/>
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
</div>

