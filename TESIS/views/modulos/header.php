<?php
use ProximaFecha\Tools\Session;

?>
<!DOCTYPE html>
<html lang='es'>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<link href="<?= $ruta ?>../views/css/reset.css" rel="stylesheet" >
	<link href="<?= $ruta ?>../views/css/bootstrap-theme.css"  rel="stylesheet" >
	<link href="<?= $ruta ?>../views/css/bootstrap.min.css"  rel="stylesheet" >
	<link href="<?= $ruta ?>../views/css/bootstrap.css"  rel="stylesheet" >
	<link href="<?= $ruta ?>../views/css/bootstrap-theme.min.css"  rel="stylesheet" >
	<link href="<?= $ruta ?>../views/css/estilos.css" rel="stylesheet">
	<title>Próxima Fecha</title>
</head>
<body>

<header>
	<div id="arriba">
		<a href="<?= $ruta ?>../public" title="home" id="logoPrincipal"><img src="<?= $ruta ?>../public/images/LOGOPF-Sin-Fondo.png" alt="Logo" style="margin:3px;" /></a>
		<div>
			<form id="FORMbuscador" action="<?= $ruta.'buscar' ?>"  method="post">
				<img src="<?= $ruta ?>../public/images/icons/lupa11.png" alt="Logo" style="height:20px;width:20px;" />&nbsp;
				<input id="INPUTbuscador" placeholder='Buscar...' value="" name="contenidoAbuscar" />
			</form>
		</div>
		<div id="DIVbtnRegistro">
			<div>
				<div id="btnRegistro">
					<?php
					Session::start();
					if (Session::has('logueado') && Session::get('logueado')=='S') {
						$usuarioLogueado = true;
					}else{
						$usuarioLogueado = false;
					}

					if ($usuarioLogueado ){
						echo "<a href='". $ruta."desloguear'>CERRAR SESIÓN</a>";
					} else {
						echo "<a href='#registroModal'>REGISTRARSE</a>";
					}
					?>

				</div>
			</div>
		</div>
	</div>
	<?php
	if (! $usuarioLogueado ){
		if (Session::has("camposError")){
			$camposError = Session::get("camposError");
			$camposViejos = Session::get("campos");
			$usuario=$camposViejos['usuario'];
			$nombre=$camposViejos['nombre'];
			$apellido=$camposViejos['apellido'];
			$email=$camposViejos['email'];
			Session::clearValue("camposError");
			Session::clearValue("campos");
		} else {
			$usuario="";
			$nombre="";
			$apellido="";
			$email="";
		};
		?>
		<div id="registro" class="tresCol">
			<div>
				<div id="registroModal">
					<div>
						<div>
							<h2 class='mayusculas'>REGISTRARSE</h2>
							<a href='#' title='Volver'> Volver</a>
						</div>
						<div>
							<form id='formRegistro' action="registrar" method="post">
								<input <?= "value='$usuario'"?> class='inputRegistro' type="text" name="usuario" placeholder="Usuario"/>
								<input <?= "value='$nombre'"?> class='inputRegistro' type="text" name="nombre" placeholder="Nombre"/>
								<input <?= "value='$apellido'"?> class='inputRegistro' type="text" name="apellido" placeholder="Apellido"/>
								<input <?= "value='$email'"?> class='inputRegistro' type="text" name="email" placeholder="Mail"/>
								<input class='inputRegistro' type="password" name="clave" placeholder="Clave"/>
								<input class='inputRegistro' type="password" name="confClave" placeholder="Confirmar Clave"/>
								<div><input type="checkbox" name="terminos" id="terminos" value="Y"/>
									<label for="terminos"> Acepto los términos y condiciones </label></div>
								<?php
								if (! $usuarioLogueado && isset($camposError)){
									echo("<div class='DivErrores'><ul>");
									foreach ($camposError as $error => $descr) {
										echo ("<li style='color:#F00'>".ucfirst($error).": ".$descr."</li>");
									}
									echo("</ul></div>");
								}
								?>
								<div class='btnIngresar'>
									<input type="submit" value="REGISTRARSE"/>
								</div>
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
		<?php
	};
	?>
</header>