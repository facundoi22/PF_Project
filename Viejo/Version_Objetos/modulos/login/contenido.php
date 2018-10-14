<section id="Login">
	<?php
		$usuario = "";
		session_start();
		if (isset($_SESSION['usuario'])){
			$usuario = $_SESSION['usuario'];
			$_SESSION['usuario'] = "";
		}
	?>
	<h1> El Cedrón </h1>
	<h2>Iniciar Sesión</h2>
	<form action="modulos/login/validar_ingreso.php" method="post">
		<label for="usuario">Usuario: </label>
		<input id="usuario" type="text" name="usuario" <?php echo("value='$usuario'")?>/>
		<label for="password">Contraseña: </label>
		<input id="password" type="password" name="password"/>
		<input type="submit" value="Ingresar" />
	</form>	
	<h3></h3>
	<script src='modulos/login/funciones.js'></script>
	<?php
		if (isset($_SESSION['error'])){
			echo ("<h3> ". $_SESSION['error'] ." </h3>");
			$_SESSION['error'] ="";
		}
		session_destroy();
	?>
</section>