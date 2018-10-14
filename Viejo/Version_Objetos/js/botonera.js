window.addEventListener('DOMContentLoaded', function() {
	var botones = $('nav ul li a');
	for (var i = 0; i < botones.length ; i++){
		botones[i].addEventListener('click', function(ev) {
			ev.preventDefault();
			var origen = this.innerHTML;
			ajaxRequest({
				'method': 'get',
				'data': 'seccion=' + this.innerHTML+ '&ajax=1',
				'url': 'modulos/' + this.innerHTML + '/ajax_contenido.php',
				'success': function(rta) {
					var main = $('main')[0];
					main.innerHTML = rta;
					cargarJSseccion(origen);
				},
				'error': function(rta) {
					alert("Hubo un problema inexperado. Código del error: " + respuesta.status);
				}
			});			
		}, false);
	}	
}, false);