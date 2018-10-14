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





function ajaxRequestImagen(options, form) {
	var defaults = {
		'method': 'POST',
		'url': null,
		'data': null,
		'noCache': false,
		'success': function() {},
		'error': function() {}
	};

	var o = merge(defaults, options),
		sendData = null;

	if(o.noCache) {
		o.data = o.data != null ? '&' : '';
		o.data += Math.random();
	}

	// Instanciamos el objeto XHR
	var xhr = new XMLHttpRequest();

	// Configuramos la petición
	xhr.open(o.method, o.url);

	xhr.addEventListener('load', function() {
		o.success(xhr.responseText);
	}, false);

    var data = new FormData(form);
    xhr.send(data);

}
