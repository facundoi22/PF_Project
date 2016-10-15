<?php 	
require_once( '../../config.php' );
$comidas = Comida::printComidas("ACTIVA = 1");
if ($comidas) { ?>
	<h3>Desactivar Comida</h3>
	<form id="desactivar" action="modulos/panel/desactivar_comida.php" method="post">		
		<div>
			<?php echo $comidas; ?>			
		</div>
		<div><input type="submit" value="Desactivar Comida" /></div>
	</form>
<?php };
$comidas = Comida::printComidas("ACTIVA = 0");
if ($comidas) { ?>
	<h3>Activar Comida</h3>
	<form id="activar" action="modulos/panel/activar_comida.php" method="post">		
		<div>
			<?php echo $comidas; ?>
		</div>
		<div><input type="submit" value="Activar Comida" /></div>
	</form>
<?php } 	?>
	