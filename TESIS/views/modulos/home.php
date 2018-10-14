<?php
use ProximaFecha\Tools\Session;
use ProximaFecha\Model\Usuario;

/**
 * @var Usuario $usuarioActual
 */

?>

<main>
	<div id='fotoExpandida'>
		<div class="dosCol">
			<h2 class="mayusculas">organiza o busca torneos deportivos</h2>
		</div>
		<div class="dosCol">
			<?php if (Session::has("usuario")) {
				$usuarioActual = Session::get("usuario");
				echo "<div id='DivBienvenido'>";
				echo "<h2>Bienvenido " . $usuarioActual->getNombre() ."</h2>";

				if(file_exists('images/usuarios/'.$usuarioActual->getUsuarioId() . '.jpg')){
					echo "<img src='images/usuarios/".$usuarioActual->getUsuarioId() . ".jpg' alt='foto perfil' />";
				}else {
					echo "<img src='images/icons/UserJugador.png' alt='foto perfil' />";
				}
				echo "<a href='usuarios/" .$usuarioActual->getUsuarioId() ."' title='Ingresar'>Ver mi usuario </a>";

				echo "</div>";
			}else{
			?>
			<div id="DivFormLogin">
				<a id='btnFacebook' href="#">Ingresar con Facebook</a>
				<form action="validar_ingreso" method="POST">
					<div class="DIVinputs">
						<img src="images/mail.png" alt="icono Mail" style="height:20px;width:20px;"/>&nbsp;
						<input class='inputFormHome' type="text" name="usuario" placeholder="Usuario"/>
					</div>
					<div class="DIVinputs">
						<img src="images/candadoVerde.png" alt="Icono Candado" style="height:20px;width:20px;"/>&nbsp;
						<input class='inputFormHome' type="password" name="password" placeholder="Clave"/>
					</div>
					<div class='btnIngresar'>
						<input type="submit" value="INGRESAR"/>
					</div>
				</form>
				<a href="#">Olvidé Mi Contraseña</a>
				<?php
				if (Session::has('errorLogin')) {
					echo("<h3> " . Session::get('errorLogin') . " </h3>");
					Session::clearValue('errorLogin');
				};
				echo "</div>";
				} ?>
			</div>
		</div>
		<div class="filaCompleta">
			<ul>
				<li class="tresCol"><img src='<?= $ruta ?>../public/images/torneo.png' alt='icono torneo' /><div>Organiza tus <span class="mayusculas negrita">torneos</span></div></li>
				<li class="tresCol"><img src='<?= $ruta ?>../public/images/liga.png' alt='icono liga' /><div>Gestiona las <span class="mayusculas negrita">ligas</span></div></li>
				<li class="tresCol"><img src='<?= $ruta ?>../public/images/buscarligas.png' alt='icono liga' /><div>Inscríbete en <span class="mayusculas negrita">campeonatos</span></div></li>
			</ul>
		</div>
		<div id='EquiposActuales'>
			<h2><a href="verEquipos"> Mirá los equipos que ya participan! </a></h2>
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
<?php if (!Session::has("publicidad")){
	Session::set("publicidad", "Y");
	echo "<div id='publicidad' style='bottom: 0px; left: 0px; height:60px; left: 0px;'>";
	echo "<img src='<?= $ruta ?>../public/images/publicidad_1.png' alt='publicidad'/>";
	echo "<a href='#' title='Cerrar'>Cerrar</a>";
	echo "</div>";
	echo "<script src='js/publicidad.js'></script>";
};
?>

