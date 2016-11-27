<h1>Equipos Registrados</h1>

<table border="1" cellspacing="0" cellpadding="5" class="table table-condensed">
	<tr>
		<th>ID</th>
		<th>NOMBRE</th>
		<th>CAPITAN</th>
		<th>ESTADO</th>
		<th>ACCIONES</th>
	<tr>

<?php 	

include( 'modulos/config.php' );

$c = <<<SQL
SELECT EQUIPO_ID, NOMBRE, CAPITAN_ID,ACTIVO
FROM equipos 
ORDER BY ACTIVO
SQL;
        
$f =  mysqli_query($cnx , $c);

while( $a = mysqli_fetch_assoc($f)):
	echo '<tr>';
	echo "<td>$a[EQUIPO_ID]</td>";
	echo "<td>$a[NOMBRE]</td>";
	echo "<td>$a[CAPITAN_ID]</td>";
	echo "<td>$a[ACTIVO]</td>";
	echo "<td><a class='fa fa-pencil fa-2x' title='$a[EQUIPO_ID]' href='equipos.listado.php?id=$a[EQUIPO_ID]'>SI</a>
<a class='fa fa-trash fa-2x' title='$a[EQUIPO_ID]' href='equipos.listado.php?id=$a[EQUIPO_ID]'>NO</a></td>";
	echo "</tr>";

	
endwhile;
	?>
</table>

<script src='js/ajax.js'></script>
<script src='js/abm.js'></script>
