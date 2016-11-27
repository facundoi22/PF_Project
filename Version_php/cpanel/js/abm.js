
	function func_btn(){
		var agregar = document.getElementById('agregar');
		if (agregar!=undefined){
			agregar.addEventListener('click', function(ev) {
				ev.preventDefault();
					ajaxRequest({
						'url': 'prod.alta.php',
						'success': function(rta) {
							document.getElementById('alta').innerHTML = rta;
							formulario(1);
						}
					});
			}, false);
		}


		var editar = document.getElementsByClassName('fa fa-pencil fa-2x');
		for (var i=0; i < editar.length; i++){
			editar[i].addEventListener('click', function(ev) {

				ev.preventDefault();
					ajaxRequest({
						'url': 'equipo.activar.php',
						'data': 'id=' + this.title ,
						'cache': false,
	           			'contentType': false, 
	           			'processData': false, 
						'success': function(rta) {
							document.getElementById('alta').innerHTML = rta;
							formulario(2);
						}
					});
			}, false);
		};

		var del = document.getElementsByClassName('fa fa-trash fa-2x');
		for (var j=0; j < del.length; j++){
			
			del[j].addEventListener('click', function(ev) {
				ev.preventDefault();

					ajaxRequest({
						'url': 'equipo.desactivar.php',
						'data': 'id=' + this.title ,
						'success': function(rta) {
							refresh_listado();
						}
					});
			}, false);

	var btn_exit = document.getElementById('btn_exit');

		
		btn_exit.addEventListener('click', function(ev) {
			ev.preventDefault();
				ajaxRequest({
					'method': 'post',
					'url': 'modulos/cerrar.sesion.php',
					'success': function(rta) {
						ajaxRequest({
							'method': 'get',
							'url': 'modulos/login.php',
							'success': function(rta) {
								document.getElementById('login').innerHTML = rta;
								cargarlogin();								}
						});
					}
				});
		});


	}






	function formulario(accion){

		var alta_prod = document.getElementById('alta_prod');
		alta_prod.addEventListener('click', function(ev) {
			ev.preventDefault();

			var id = document.getElementById('art_id');
			var titulo = document.getElementById('titulo');
			var descripcion = document.getElementById('descripcion');
			var precio = document.getElementById('precio');
			var categoria = document.getElementById('categoria');
			var seccion = document.getElementById('seccion');


			if(accion == 1){
				ajaxRequest({
					'method': 'post',
					'url': 'prod.new.php',
					'data': 'titulo=' + titulo.value + "&descripcion=" + descripcion.value + "&precio=" + precio.value + "&categoria=" + categoria.value + "&seccion=" + seccion.value + '&ajax',
					'success': function(rta) {
						refresh_listado();
					},
					'error': function(rta){
						alert(rta);
					}

				});
			} else if(accion == 2) {
					ajaxRequest({
					'method': 'post',
					'url': 'prod.edit.php',
					'data': 'titulo=' + titulo.value + '&id=' + id.value + "&descripcion=" + descripcion.value + "&precio=" + precio.value + "&categoria=" + categoria.value + "&seccion=" + seccion.value + '&ajax',
					'success': function(rta) {
						refresh_listado();
					},
					'error': function(rta){
						alert(rta);
					}

				});
			}
		}, false);
	}



	function refresh_listado (){
		ajaxRequest({
			'method': 'post',
			'url': 'prod.listado.php',
			'success': function(rta) {
				document.getElementById('contenido').innerHTML = rta;
				func_btn();
			}
		});	

	}
}


