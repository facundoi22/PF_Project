<?php

// Función explicada en la imagen:\images\función.jpg
function ejecutar_script( $consulta ){
	global $conexion;
	$respuesta = mysqli_query($conexion, $consulta);
	
	if( mysqli_error( $conexion ) != false ){
		echo '<div class="error" id="Error"><div><div><a href="#">Cerrar</a></div>';
		echo '<p>' . $consulta . '<p/>';
		echo '<h2>' . mysqli_error($conexion) . '</h2>' ;
		echo '</div></div>';
	}
	return $respuesta;
};

// Función que trae Los detalles de una comida comida 
function get_Noticia_Activa(){
	global $conexion;
	$rta="";
	if( $conexion ) {
		$script = "SELECT NOTICIA_ID, TITULO, NOTICIA FROM NOTICIAS_HOME WHERE ACTIVA = 1";
		$select = ejecutar_script( $script);
		if($datos = mysqli_fetch_assoc($select)){
			$rta = array();
			$rta['ID'] = $datos['NOTICIA_ID'];
			$rta['TITULO'] = $datos['TITULO'];
			$rta['TEXTO'] = $datos['NOTICIA'];
		}
		mysqli_free_result($select);	
	};
	return $rta;
};


// Función que trae un ID de comida 
function get_ID_Comida( $tipoComida, $condicionExtra, $whereAdicional ){
	global $conexion;
	if ($condicionExtra) {
		$CampoSelect = $condicionExtra . "(COMIDA_ID)";		
	}else{
		$CampoSelect = "COMIDA_ID";		
	}
	$rta = "0";
	if( $conexion ) {
		$script = "SELECT $CampoSelect AS COMIDA_ID FROM COMIDAS WHERE TIPO_ID = '$tipoComida' AND ACTIVA = 1  $whereAdicional LIMIT 1";
		$select = ejecutar_script( $script);
		if($filaComida = mysqli_fetch_assoc($select)){
			$rta = $filaComida['COMIDA_ID'];
		};
		mysqli_free_result($select);	
	};
	return $rta;
};

// Función que trae Los detalles de una comida comida 
function get_Detalles_Comida( $idComida ){
	global $conexion;
	$rta = "";
	if( $conexion ) {
		$script = "SELECT C.NOMBRE , GROUP_CONCAT(I.DETALLE SEPARATOR '</li><li>') AS INGREDIENTES FROM COMIDAS C , INGREDIENTES I WHERE C.COMIDA_ID = I.COMIDA_ID AND C.ACTIVA = 1 AND C.COMIDA_ID = '$idComida' GROUP BY C.NOMBRE";
		$select = ejecutar_script( $script);
		if($filaComida = mysqli_fetch_assoc($select)){
			$rta = array();
			$rta['NOMBRE'] = $filaComida['NOMBRE'];
			$rta['INGREDIENTES'] = $filaComida['INGREDIENTES'];
		};
		mysqli_free_result($select);	
	};
	return $rta;
};


// Función que elimina una comida 
function estado_Comida($idComida, $estado){
	global $conexion;
	
	if( $conexion ) {
		$script = "UPDATE COMIDAS SET ACTIVA= $estado WHERE COMIDA_ID = '$idComida' LIMIT 1 ";
		$update = ejecutar_script( $script);
	};
};

// Función que trae Los detalles de una comida comida 
function print_Comidas( $whereAdicional){
	global $conexion;
	$rta = "";
	if( $conexion ) {
		if ($whereAdicional) {
			$where = "WHERE " . $whereAdicional;
		}
		$script = "SELECT C.COMIDA_ID, C.TIPO_ID, C.NOMBRE  FROM COMIDAS C $where";
		$select = ejecutar_script( $script);
		$indiceComida = 0;
		$cantidad = mysqli_num_rows($select);
		if ($cantidad > 0 ){
			while($filaComida = mysqli_fetch_assoc($select)){
				$dato = $filaComida['NOMBRE'];
				$indiceComida = $filaComida['COMIDA_ID'];
				$indiceTipo = $filaComida['TIPO_ID'];
				$rta .=  "<label for='$dato'> $dato </label>";
				$rta .=  "<input id='$dato' type='radio' name='comida' value='$indiceComida' />";
			};
		};
		mysqli_free_result($select);	
		return $rta;
	};
};

//Función que inserta una comida y sus ingredientes
function Insertar_Comida($nombre, $tipo, $ingredientes){
	global $conexion;
	$nombre = mysqli_real_escape_string($conexion,$nombre);
	$ingredientes = mysqli_real_escape_string($conexion,$ingredientes);
	$comida_id = 0;
	$vIngredientes = explode ( '\r\n' , nl2br($ingredientes));
	
	if( $conexion ) {
		$script = "INSERT INTO COMIDAS VALUES (null, $tipo , LCASE('$nombre'), 1)";
		$insert = ejecutar_script( $script);
		$comida_id = mysqli_insert_id( $conexion );
		if ($comida_id){
			foreach( $vIngredientes as $i => $ingrediente){
				$ingrediente = mysqli_real_escape_string($conexion,$ingrediente);
				$script = "INSERT INTO INGREDIENTES VALUES (null, $comida_id , LCASE('$ingrediente'))";
				$insert = ejecutar_script( $script);	
			}
		}
	}
	return $comida_id;
} 

// Función que inserta una reserva creada;
function Insertar_Reserva($vReserva){
	global $conexion;
	$values = "null";
	$values .= ", '" . mysqli_real_escape_string($conexion,$vReserva['nombre']) ."'";
	$values .= ", '" . mysqli_real_escape_string($conexion,$vReserva['apellido']) ."'";
	$values .= ", '" . mysqli_real_escape_string($conexion,$vReserva['telefono']) ."'";
	$values .= ", '" . mysqli_real_escape_string($conexion,$vReserva['fecha']) ."'";
	$values .= ", '" . mysqli_real_escape_string($conexion,$vReserva['hora']) ."'";
	$values .= ", '" . mysqli_real_escape_string($conexion,$vReserva['cantidad']) ."'";
	$values .= ", 1";
	if( $conexion ) {
		$script = "INSERT INTO RESERVAS VALUES ($values) ";
		$insert = ejecutar_script( $script);
		$reserva_id = mysqli_insert_id( $conexion );
	};
	
	if ($reserva_id == 0){
		$reserva_id = "error";
	} else {
		if (isset($vReserva['preferencia'])){
			$preferencia = $vReserva['preferencia'];
			
			foreach( $preferencia as $i => $preferencia){
				$values = "$reserva_id, '" . $preferencia ."'"	;
				if( $conexion ) {
					$script = "INSERT INTO RESERVAS_PREF VALUES ($values) ";
					$insert = ejecutar_script( $script);
				};
			};
		};
	};
	return $reserva_id;
}

/* Funcion que valida el  valor pasado en $campo en base al $nombre del campo */
function ValidarCampo($nombre, $campo){
	switch($nombre){
		case 'nombre':
		case 'apellido':
			return ValidarCampoEspecifico($campo, '/^[a-z\s]+$/i', "El campo solo puede ser texto o espacios");
			break;                        
		case 'telefono':                       
			return ValidarCampoEspecifico($campo, '/^\d{8,}$/', "El campo solo admite números (Mínimo 8)");
			break;                        
		case 'fecha':                     
			return ValidarCampoEspecifico($campo, '/^[012]\d\d\d\-(0?[1-9]|1[0-2])\-([0-9]|[0-2]\d||3[01])$/', "La fecha debe tener formato AAAA-MM-DD");
			break;                        
		case 'hora':                     
			return ValidarCampoEspecifico($campo, '/^([01]\d|2[0123]):[012345]\d$/i', "La hora debe tener formato HH:MM");			
			break;                        
		case 'cantidad':                   
			return ValidarCampoEspecifico($campo, '/^\d+$/', "El campo solo admite números");
			break;                        
		default:
			return "";		
	};
}


// Función que valida que el campo parámetro en base a la expresión del segundo parámetro;
// Si no es válido devuelve el texto del tercer parámetro o el de requerido cuando corresponda;
function ValidarCampoEspecifico($campo, $expReg, $texto){
	$valido = preg_match( $expReg, $campo );
	$rta = "";
	if ( !$valido ) {
		if ($campo == "" ){
			$rta = "El campo es requerido";
		}else{
			$rta = $texto;
		}
	}
	return $rta;
};

// Función que valida el usuario que ingresa al sistema;
function ValidarUsuario($usuario, $password){
	global $conexion;
	$rta="";
	if( $conexion ) {
		$script = "SELECT ACTIVA FROM USUARIOS WHERE USUARIO_ID = '$usuario' AND PASSWORD = '". SHA1($password) . "'";
		$select = ejecutar_script( $script);
		if($datos = mysqli_fetch_assoc($select)){
			if ($datos['ACTIVA'] == '1'){
				$rta = "";					
			} else {
				$rta = "El usuario no se encuentra activo";
			}
		} else {
			$rta = "El usuario o la contraseña son inválidos";
		}
		mysqli_free_result($select);	
		};
	return $rta;
}

// Funnción que verifica si un usuario tiene un rol
function usuario_Tiene_Rol($usuario , $rol ) {
	global $conexion;
	$rta=0;
	if( $conexion ) {
		$script = "SELECT USUARIO_ID FROM USUARIOS WHERE USUARIO_ID = '$usuario' AND ROLE_ID = '". $rol . "'";
		$select = ejecutar_script( $script);
		$rta = mysqli_fetch_assoc($select);
		mysqli_free_result($select);	
	};
	return $rta;	
}

?>