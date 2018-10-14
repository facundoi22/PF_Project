<nav>
	<ul>
		<?php	
			$botonera = array( 
				'home' => 'home',
				'galeria' => 'galeria',
				'reservas' => 'reservas',
				'login' => 'login',
			);
			foreach( $botonera as $texto => $href ){
				$idCSS = "";
				if(isset($_GET['seccion'])){
					if ($_GET['seccion'] == $href){
						$idCSS = " id='iconoElegido' ";
					}
				}
				echo "<li><a class='icono' ". $idCSS . " href='index.php?seccion=$href'>$texto</a></li>";
			}	
	?>
	</ul>
</nav>

		