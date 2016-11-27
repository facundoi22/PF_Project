// Este es el posta
/*
ajaxRequest('GET', 'respuesta.txt', function(respuesta) {
	// Lo que quiera con la respuesta.
});
*/
/*function ajaxRequest(metodo, recurso, successCallback) {
	// Instanciamos el objeto XHR
	var xhr = new XMLHttpRequest();

	// Configuramos la petición
	xhr.open(metodo, recurso);

	xhr.addEventListener('readystatechange', function(ev) {
		if(xhr.readyState == 4) {
			if(xhr.status == 200) {
				successCallback(xhr.responseText);
			}
		}
	});

	// Ejecutamos la petición
	xhr.send(null);
}*/
/*
JSON - JavaScript Object Notation
Array -> [valor1, valor2, valor3, ....]
Objeto -> {param1: valor1, param2: valor2, param3: valor3, ....}

ajaxRequest({
	'method': 'GET',
	'url': 'respuesta.txt',
	'data': 'u=saraza',
	'success': function(respuesta) {
		// Lo que quiera con la respuesta.
	}
});
*/
// ajaxRequest v2.0.0
function ajaxRequest(options) {
	var defaults = {
		'method': 'GET',
		'url': null,
		'data': null,
		'noCache': false,
		'success': function() {},
		'error': function() {}
	};

	var o = merge(defaults, options),
		sendData = null;

	if(o.noCache) {
		/*if(o.data != null) {
			o.data += '&';
		} else {
			o.data += '';
		}*/
		o.data = o.data != null ? '&' : '';
		o.data += Math.random();
	}

	// Instanciamos el objeto XHR
	var xhr = new XMLHttpRequest();

	if(o.method.toLowerCase() == "get") {
		o.url += "?" + o.data;
	}

	// Configuramos la petición
	xhr.open(o.method, o.url);

	xhr.addEventListener('readystatechange', function(ev) {
		if(xhr.readyState == 4) {
			if(xhr.status == 200) {
				o.success(xhr.responseText);
			} else {
				o.error();
			}
		}
	});

	if(o.method.toLowerCase() == "post") {
		sendData = o.data;
		xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
	}

	// Ejecutamos la petición
	xhr.send(sendData);
}

function merge(obj1, obj2) {
	var salida = obj1;

	for(var i in obj2) {
		salida[i] = obj2[i];
	}

	return salida;
}

/**
 * Wrapper de document.getElementById().
 * @return HTMLElement
 */
function $(id) {
	return document.getElementById(id);
}