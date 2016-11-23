<!DOCTYPE html>
<html lang="es">
	<?php
		include( 'config.php' );
		include('funciones.php' );
	
		$usuario = "";
		session_start();
		if (isset($_SESSION['usuario'])){
			$usuario = $_SESSION['usuario'];
			$_SESSION['usuario'] = "";
		}
	
	?>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
		<link href="css/reset.css" rel="stylesheet" >
		<link href="css/estilos.css" rel="stylesheet" >
		<title>Próxima Fecha</title>
	</head>

	<body>
		<div>
			<?php require('modulos/header.php'); ?>
			<main>
				<div id='fotoExpandida'>
					<div class="dosCol">
						<h2 class="mayusculas">organiza o busca torneos deportivos</h2>
					</div>
					<div class="dosCol">
						<div id="DivFormLogin">
							<a id='btnFacebook' href="modulos/miequipo.php">Ingresar con Facebook</a>
							<form action="php/validar_ingreso.php" method="POST">
								<div class="DIVinputs">
									<img src="images/mail.png" alt="icono Mail" style="height:20px;width:20px;" />&nbsp;
									<input class='inputFormHome' type="text" name="usuario" placeholder="Usuario" <?php echo("value='$usuario'")?>/>
								</div>
								<div class="DIVinputs">
									<img src="images/candadoVerde.png" alt="Icono Candado" style="height:20px;width:20px;" />&nbsp;
									<input class='inputFormHome' type="password" name="password" placeholder="Clave"/>
								</div>
								<div class='btnIngresar'>
									<input  type="submit" value="INGRESAR" />
								</div>
							</form>
							<a href="#">Olvidé Mi Contraseña</a>
							<?php
								if (isset($_SESSION['errorLogin'])){
									echo ("<h3> ". $_SESSION['errorLogin'] ." </h3>");
									$_SESSION['errorLogin'] ="";
								}
								session_destroy();
							?>
						</div>
					</div>
				</div>
				<div class="filaCompleta">
					<ul>
						<li class="tresCol"><img src='images/torneo.png' alt='icono torneo' /><div>Organiza tus <span class="mayusculas negrita">torneos</span></div></li>
						<li class="tresCol"><img src='images/liga.png' alt='icono liga' /><div>Gestiona las <span class="mayusculas negrita">ligas</span></div></li>
						<li class="tresCol"><img src='images/buscarligas.png' alt='icono liga' /><div>Inscríbete en <span class="mayusculas negrita">campeonatos</span></div></li>
					</ul>
				</div>
				<div>
					<h2>¿Que puedo hacer en PróximaFecha.com?</h2>
					<div class="dosCol">
						<h3> Para los <span class="negrita">Organizadores </span></h3>
						<ul>
							<li>Organizar torneos o ligas de cualquier deporte y llevar toda la gestión desde la web</li>
							<li>Tener una web propia del torneo donde se publicará toda la información necesaria</li>
							<li>Comuncarte con cualquier equipo participante del torneo</li>
						</ul>
					</div>
					<div class="dosCol">
						<h3> Para los <span class="negrita">Jugadores </span></h3>
						<ul>
							<li>Sumarte a un equipo y a través de él participar de un torneo</li>
							<li>Ser el delegado de tu equipo, encargado de la comunicación con el organizador</li>
							<li>Informarte vía online acerca de los detalles de la próxima fecha, en la web exclusiva del torneo</li>
						</ul>
					</div>
				</div>
				<div id='DivCreaCam'>
					<a id='btnCreaCam' class="mayusculas" href="#"> Crea tu <span class="negrita">campeonato </span></a>
				</div>

			</main>
			<?php require('modulos/footer.php'); ?>
		</div>
		<div id="publicidad" style="bottom: 0px; left: 0px; height:60px; left: 0px;">
			<img src="images/publicidad_1.png" alt="publicidad"/>
			<a href="#" title="Cerrar">Cerrar</a>
		</div>
		<script src='js/publicidad.js'></script>
	</body>
</html>
