<section id="Gracias">
	<h1> El Cedrón </h1>
	<?php 
		if (isset($_GET['reserva'])){
			$reserva = $_GET['reserva'];

			$reservaRealizada = New Reserva($reserva);

			echo "<h3>". $reservaRealizada->getNombre() . " " . $reservaRealizada->getApellido()  . ": Gracias por elegirnos.</h3>";
			echo "<p> Su reserva para el día " . $reservaRealizada->getFecha() . " ha sido procesada con el número " . $reservaRealizada->getReservaId() . "</p>";
			echo "<p> Le pedimos que se haga presente en el lugar antes de las " . $reservaRealizada->getHora() . " hs. </p>";

			if ($reservaRealizada->eligioPreferencias()) {
				echo "<p> Trataremos de respetar sus preferencias elegidas: </p>";
				echo "<ul>";
				foreach ($reservaRealizada->getpreferenciasElegidas() as $i => $detallePref) {
					echo "<li> " . $detallePref['detalle'] . "</li>";
				}
				echo "</ul>";
			}
		}else {
			echo "<h3> Su reserva no pudo procesarse.</h3>";
			echo "<h3> Vuelva a intentarlo mas tarde.</h3>";
			echo "<h3> Perdon por las molestias ocasionadas.</h3>";
		};
	?>
</section>
