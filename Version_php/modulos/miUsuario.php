<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<link href="../css/reset.css" rel="stylesheet" >
		<link href="../css/estilos.css" rel="stylesheet" >
		<script>
			document.createElement( "picture" );
		</script>
		<script src = "../../js/picturefill.js" async></script>
		<script src="../../js/prefixfree.min.js"></script>
		<script src="../../js/jquery-2.1.3.js"></script>
		<title>Próxima Fecha</title>
	</head>
	
	<body>
		<div id="usuario">
			<header>
				<div id="arriba">
					<a href="../index.php" title="home" id="logoPrincipal"><img src="../images/LOGOPF-Sin-Fondo.png" alt="Logo" style="margin:3px;" /></a>
					<div>
						<form method="post" id="FORMbuscador" action="resultado.php">
							<img src="images/Icons/lupa11.png" alt="Logo" style="height:20px;width:20px;" />
							<input id="INPUTbuscador" placeholder='Buscar...' value="" name="contenidoAbuscar" />
						</form>
					</div>
					<div id="DIVbtnRegistro">
						<div>
							<div id="btnRegistro">
								<a href="../index.php" class='mayusculas'>cerrar sesión</a>
							</div>
						</div>
					</div>
				</div>				
			</header>		
			<main>
				<div>
					<h2 class="mayusculas negrita">Bienvenido Usuario</h2>
					<p >Todavía no sos parte de ningún equipo.</p>
					<h3 class="mayusculas negrita">¿Que querés hacer?</h3>
					<a href="#registorModal">Crear Un Equipo</a>
					<a href="#">Buscar un Equipo</a>
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
			<img src="../images/publicidad_1.png" alt="publicidad"/>
			<a href="#" title="Cerrar">Cerrar</a>
		</div>
		<script src='../js/publicidad.js'></script>
	</body>
</html>
