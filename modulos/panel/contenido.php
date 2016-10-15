<section id="Panel">
	<?php 	
		$esAdmin=false;
		session_start();
		if (! isset($_SESSION['usuario'])){
			$_SESSION['error'] = "Para ingresar a esta sección debe ingresar al sistema";
			header("Location: index.php?seccion=login");			
		} else {
			$usuario = New Usuario($_SESSION['usuario']);
			$esAdmin =  $usuario->tieneRol("admin");
		}
		
		$titulo = "";
		$texto= "";
		$id = ""; 
		$noticia = Noticia::getNoticiaActiva();
		
		if( $noticia ) {
			$id= $noticia['noticia_id'];
			$titulo = $noticia['titulo'];
			$texto = $noticia['noticia'];
		};
	?>
	
	<h1> El Cedrón </h1>
	<h2>Bienvenido</h2>
	<?php if($esAdmin) {	?>
	<h3>Editar Home</h3>
	<form id="editar" action="modulos/panel/actualizar_home.php" method="post">
		<label>	Titulo Noticia Home<input id="titulo" type="text" name="titulo" <?php echo("value='$titulo'")?>/></label>
		<label>Contenido Noticia Home <textarea id="texto" cols="10" rows="8" name="texto"><?php echo $texto?></textarea></label>
		<input type="hidden" id="idNoticia" value="<?php echo $id ?>" name="id" />
		<div><input type="submit" value="Actualizar Home" /></div>
	</form>	
	<?php 	}	?>
	<h3>Agregar Comida</h3>
	<form id="agregar" action="modulos/panel/agregar_comida.php" method="post" enctype="multipart/form-data">		
		<label>Nombre<input type="text" name="nombre"/></label>
		<label>Ingredientes <textarea cols="10" rows="10" name="ingredientes"></textarea></label>
		<input id="archivo" type="file" name="foto" accept="image/*" />
		<label for="Pizzas">Pizzas</label><input id="Pizzas" type="radio" name="tipo" checked value="1" />	
		<label for="Minutas">Minutas</label><input id="Minutas" type="radio" name="tipo"  value="2" />	
		<input type="hidden" name="ajax" />
		<div><input type="submit" value="Agregar Comida" /></div>
	</form>
	<?php 
	if($esAdmin) {	
		echo('<div id="EstadoComidas">');
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
	<?php }
		echo ("</div>");
	}	?>
</section>