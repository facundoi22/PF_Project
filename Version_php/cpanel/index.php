<?php 
//include( 'modulos/config.php' );

//$c = "SELECT * FROM categorias ORDER BY ID";
//$f = mysqli_query($cnx, $c);

//$c1 = "SELECT * FROM secciones ORDER BY ID";
//$f1 = mysqli_query($cnx, $c1);

?>

<!DOCTYPE HTML>
<html lang="en-US">
	<?php
		include( '../config.php' );
		include('../funciones.php' );

		Session::start();

		$usuario = "";
	?>
<head>
	<meta charset="UTF-8">
	<title>Administracion</title>
	<link rel="stylesheet" type="text/css" href="css/estilos.admin.css" />
	<link rel="stylesheet" type="text/css" href="css/font-awesome.css" />
</head>
<body>


<div id="todo">

	<div id="DivFormLogin">
				<form action="validar_ingreso.php" method="POST">
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
				<?php
				if (isset($_SESSION['errorLogin'])){
					echo ("<h3> ". $_SESSION['errorLogin'] ." </h3>");
					$_SESSION['errorLogin'] ="";
				}
				session_destroy();
				?>
			</div>

	<div id="alta"></div>

    <div id="contenido">
		<?php 
//			if(!$_SESSION){
//			}else{
			//	if($_SESSION['nivel']=='admin'){
	   		//	 	include('prod.listado.php');
//			}
//		}
		?>
	</div>
</div>
	
    <script src="js/ajax.js"></script>
    <script src="js/abm.js"></script>
    <script src="js/login.js"></script>

</body>
</html>

