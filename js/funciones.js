var d = document ;
var b = document.getElementsByTagName("body")[0];


function cargarJSseccion(seccion){
	switch (seccion) {
		case 'galeria':
			cargarEventosGaleria();
			break;
		case 'login':
			cargarEventosLogin();
			break;
		case 'panel':
			cargarEventosPanel();
			break;
		case 'reservas':
			cargarEventosReservas();
			break;
	}
}	

	
function cargarEventosPanel(){
	var formEditar = $('#editar')[0];
	if (formEditar != undefined) {
		formEditar.addEventListener('submit', function(ev) {
			ev.preventDefault();
			var idNoticia = $('#idNoticia')[0];
			var titulo = $('#titulo')[0];
			var texto = $('#texto')[0];
			ajaxRequest({
				'method': 'post',
				'url': 'modulos/panel/actualizar_home.php',
				'data': 'id=' + idNoticia.value + "&titulo=" + titulo.value  + "&texto=" + texto.value + '&ajax=1',
				'success': function(rta) {
					var respuesta = JSON.parse(rta);
					if(respuesta.status == 0) {
						ajaxRequest({
							'method': 'get',
							'url': 'modulos/panel/ajax_contenido.php',
							'success': function(rta) {
								var main = $('main')[0];
								main.innerHTML = rta;						
							}
						});
					} else {
						alert("Hubo un problema inexperado. Código del error: " + respuesta.status);
					}
				}
			});
		}, false);
	};
	
	var formAgregar = $('#agregar')[0];
	if (formAgregar != undefined){
		formAgregar.addEventListener('submit', function(ev) {
			ev.preventDefault();
			
			var nombre = document.getElementsByName("nombre")[0];
			var ajax = document.getElementsByName("ajax")[0];
			ajax.value = 1;
			var ingredientes = document.getElementsByName("ingredientes")[0];
			var tipos = document.getElementsByName("tipo");
			var tipo = tipos[0].checked ? tipos[0].value : tipos[1].value;
			
			ajaxRequestImagen({
				'method': 'post',
				'url': 'modulos/panel/agregar_comida.php',
				'success': function(rta) {
					var respuesta = JSON.parse(rta);
					if(respuesta.status == 0) {
						ajaxRequest({
							'method': 'get',
							'data': 'seccion=galeria&tipocomida=' + tipo,
							'url': 'modulos/panel/ajax_contenido.php',
							'success': function(rta) {
								var main = $('main')[0];
								main.innerHTML = rta;						
								cargarJSseccion('galeria');
							}
						});
					} else {
						alert("Hubo un problema inexperado. Código del error: " + respuesta.status);
					}
				}
			},this);
		}, false);
	};
	
	var formDesactivar = $('#desactivar')[0];
	if (formDesactivar != undefined){
		formDesactivar.addEventListener('submit', function(ev) {
			ev.preventDefault();
			var comidas = $('#desactivar input');
			var comida;
			for (var i = 0; i < comidas.length; i++){
				if (comidas[i].checked){
					comida = comidas[i].value;
				}
			}
			ajaxRequest({
				'method': 'post',
				'url': 'modulos/panel/desactivar_comida.php',
				'data': 'comida=' + comida  + '&ajax=1',
				'success': function(rta) {
					var respuesta = JSON.parse(rta);
					if(respuesta.status == 0) {
						ajaxRequest({
							'method': 'get',
							'url': 'modulos/panel/estado_comidas.php',
							'success': function(rta) {
								var estadoComidas = $('#EstadoComidas')[0];
								estadoComidas.innerHTML = rta;	
								cargarJSseccion('panel');
							}
						});
					} else {
						alert("Hubo un problema inexperado. Código del error: " + respuesta.status);
					}
				}
			});
		}, false);
	};
	var formActivar = $('#activar')[0];
	if (formActivar != undefined) {
		formActivar.addEventListener('submit', function(ev) {
			ev.preventDefault();
			var comidas = $('#activar input');
			var comida;
			for (var i = 0; i < comidas.length; i++){
				if (comidas[i].checked){
					comida = comidas[i].value;
				}
			}
			ajaxRequest({
				'method': 'post',
				'url': 'modulos/panel/activar_comida.php',
				'data': 'comida=' + comida  + '&ajax=1',
				'success': function(rta) {
					var respuesta = JSON.parse(rta);
					if(respuesta.status == 0) {
						ajaxRequest({
							'method': 'get',
							'url': 'modulos/panel/estado_comidas.php',
							'success': function(rta) {
								var estadoComidas = $('#EstadoComidas')[0];
								estadoComidas.innerHTML = rta;						
								cargarJSseccion('panel');
							}
						});
					} else {
						alert("Hubo un problema inexperado. Código del error: " + respuesta.status);
					}
				}
			});
		}, false);
	};
	
};
	
	
	
function cargarEventosReservas(){
	var form = document.getElementById("formname");
	var v_inputs = form.getElementsByTagName("input");

	for (var i = 0; i < v_inputs.length ; i++){
		// Cuando se hace foco en el campo, se remueve la clase de error (para cuando tenga errores);
		v_inputs[i].onfocus = function () {
			this.className = "";
		}
		// Cuando se pierde el foco del campo también se valida ;
		v_inputs[i].onblur = function () {
			ValidarCampo(this);
		};
	};
	
	var miFormulario = $('form')[0];
	miFormulario.addEventListener('submit', function(ev) {
		ev.preventDefault();
		if (ValidarFormulario(v_inputs)) {
			var ajax = document.getElementsByName("ajax")[0];
			ajax.value = 1;
				
			ajaxRequestImagen({
				'method': 'post',
				'url': 'procesar.php',
				'success': function(rta) {
					var respuesta = JSON.parse(rta);
					if(respuesta.status == 1) {
						var div = $('section div')[0];
						div.innerHTML = '<h3>' + respuesta.data + '</h3>' ;
					} else {
						ajaxRequest({
							'method': 'get',
							'data': 'reserva=' + respuesta.data,
							'url': 'modulos/gracias/ajax_contenido.php',
							'success': function(rta) {
								var main = $('main')[0];
								main.innerHTML = rta;									
							}
						});
					}
				}
			},this);
		};
	}, false);
}	;
	
	
function cargarEventosLogin(){

	var miFormulario = $('form')[0];
	miFormulario.addEventListener('submit', function(ev) {
		ev.preventDefault();
		var usuario = $('#usuario')[0];
		var password = $('#password')[0];
		var h3 = $('section h3')[0];
		ajaxRequest({
			'method': 'post',
			'url': 'modulos/login/validar_ingreso.php',
			'data': 'usuario=' + usuario.value + "&password=" + password.value + '&ajax=1',
			'success': function(rta) {
				var respuesta = JSON.parse(rta);
				if(respuesta.status == 1) {
					h3.innerHTML = respuesta.data ;
				} else {
					ajaxRequest({
						'method': 'get',
						'url': 'modulos/panel/ajax_contenido.php',
						'success': function(rta) {
							var main = $('main')[0];
							main.innerHTML = rta;		
							cargarJSseccion('panel');
						}
					});
				}
			}
		});
	}, false);

}
	
	
function cargarEventosGaleria(){
	var tiposComida  = $('.opcion');
	for (var i = 0; i < tiposComida.length ; i++){
		tiposComida[i].addEventListener('click', function(ev) {
			ev.preventDefault();
			traerComidaPorAjax( "tipocomida", this.title);
		}, false);
	}
	
	var flechas  = $('.flecha');
	for (var i = 0; i < flechas.length ; i++){
		flechas[i].addEventListener('click', function(ev) {
			ev.preventDefault();
			traerComidaPorAjax( "comida", this.title);
		}, false);
	}
};



function traerComidaPorAjax( clave, valor){
	ajaxRequest({
		'method': 'get',
		'data': clave + '=' +  valor,
		'url': 'modulos/galeria/ajax_getComida.php',
		'success': function(rta) {
			var respuesta = JSON.parse(rta);
			if(respuesta.status == 1) {
				alert(respuesta.data);
			} else {
				var divs = document.getElementById('Comidas').getElementsByTagName('div');
				var h3 = divs[0].getElementsByTagName("h3")[0];						
				h3.innerHTML = respuesta.data.nombre;
				var links = divs[0].getElementsByTagName("a");
				links[0].title = respuesta.data.comidaAnterior;
				links[0].href = "index.php?seccion=galeria&amp;tipocomida=" + respuesta.data.tipoComida+ "&amp;comida="+ respuesta.data.comidaAnterior;
				links[1].title = respuesta.data.comidaSiguiente;
				links[1].href = "index.php?seccion=galeria&amp;tipocomida=" + respuesta.data.tipoComida+ "&amp;comida="+ respuesta.data.comidaSiguiente;
				var img =divs[0].getElementsByTagName("picture")[0].getElementsByTagName("img")[0];
				img.src = "modulos/galeria/images/" + respuesta.data.comida + "_" +respuesta.data.nombre + ".jpg";
				img.alt= respuesta.data.comida;

				var ul = divs[1].getElementsByTagName("ul")[0];
				ul.innerHTML = "<li>" + respuesta.data.ingredientes + "</li>";
			}
		},
		'error': function(rta) {
			alert("Hubo un problema inexperado: " + rta);
		}
	});		
}


























// Función que valida el campo que recibe por parámetro basándose en su  ID;
// Devuelve un booleano: True si es válido, False si no lo es;
function ValidarCampo(campo){
	switch(campo.id){
		case 'nombre':
		case 'apellido':
			return ValidarCampoEspecifico(campo, /^[a-z\s]+$/i, "El campo solo puede ser texto o espacios");
			break;                        
		case 'usuario':
			return ValidarCampoEspecifico(campo, /^[a-z]+$/i, "El campo solo puede ser texto");
			break;                        
		case 'telefono':                       
			return ValidarCampoEspecifico(campo, /^\d{8,}$/, "El campo solo admite números (Mínimo 8)");
			break;                        
		case 'fecha':                     
			return ValidarCampoEspecifico(campo, /^[012]\d\d\d\-(0?[1-9]|1[0-2])\-([0-9]|[0-2]\d||3[01])$/, "La fecha debe tener formato AAAA-MM-DD");
			break;                        
		case 'hora':                     
			return ValidarCampoEspecifico(campo, /^([01]\d|2[0123]):[012345]\d$/i, "La hora debe tener formato HH:MM");			
			break;                        
		case 'cantidad':                   
			return ValidarCampoEspecifico(campo, /^\d+$/, "El campo solo admite números");
			break;                        
		default:
			return true;		
	};
}


// Función que valida que el campo parámetro en base a la expresión del segundo parámetro;
// Si no es válido crea un cartel con el texto del tercer parámetro (o de campo requerido si corresponde);
function ValidarCampoEspecifico(campo, expReg, texto){
	var valido = (expReg.test(campo.value));
	if ( !valido ) {
		campo.className = "campoError";
		if (campo.value == "" ){
			MostrarMensajeError("El campo es requerido");
		}else{
			MostrarMensajeError(texto);
		}
	}
	return valido ;
};

// Función que recorre los campos y revisa si son todos válidos;
// Si alguno es inválido evita que el flujo del Submit siga, y muestra un mensaje de error;
function ValidarFormulario(v_inputs){
	var huboError =false;
	for (var i = 0; i < v_inputs.length ; i++){
		if(v_inputs[i].type != "submit" && !ValidarCampo(v_inputs[i])){
			huboError = true;
		}
	};	
	return (!huboError );	
};





// Función que crea el botón cerrar para agregarlo en la ventana Modal;
function CrearBotonCerrar( dModal) {
	var dCerrar  = document.createElement("div");
	var aCerrar = document.createElement("a");
	aCerrar.href = '#';
	aCerrar.innerHTML = 'Cerrar';
	aCerrar.addEventListener('click', function(ev) {
		ev.preventDefault();
		b.removeChild(dModal);
	});
	
	dCerrar.appendChild(aCerrar)
	return dCerrar;
}

// Función que crea una ventana modal y muestra el mensaje pasado por parámetro;
function MostrarMensajeError(mensaje){
	var dMensaje = CrearVentanaModal();
	var dMensajeH2 = document.createElement("h2");
	dMensajeH2.innerHTML = mensaje;
	dMensaje.appendChild(dMensajeH2);
}

// Función que crea una ventana modal y devuelve el DIV que se muestra como modal;
function CrearVentanaModal(){
	var dModal = document.getElementById("Error");
	if (dModal!=null){
		b.removeChild(dModal);
	}
	dModal = document.createElement("div");
	dModal.id = "Error";
	dModal.className = "error";
	b.appendChild(dModal);

	var contenedor = document.createElement("div");
	dModal.appendChild(contenedor);
		
	contenedor.appendChild(CrearBotonCerrar(dModal));
		
	return contenedor;
}



// Cuando apretás escape se cierra la ventana Modal.
// (si, me resultaba molesto andar yendo hasta el botón en cada prueba de la validación);
window.onkeydown = function(e)
{
	console.log(e.keyCode);
	switch(e.keyCode)
	{
		// Escape:
		case 27:
			var dModals = b.getElementsByTagName("div");
			for (var i = dModals.length - 1; i>= 0 ; i--){
				if (dModals[i].className == "error"){
					b.removeChild(dModals[i]);
				}
			}
		break;
	}
}