window.addEventListener('DOMContentLoaded', function() {

cargarlogin();
}, false);



function cargarlogin(){
	var login = document.getElementById('login');

var login_btn = document.getElementById('login_btn');

if(login_btn!=undefined){
	login_btn.addEventListener('click', function(ev) {
			ev.preventDefault();
			var user = document.getElementById('user');
			var pass = document.getElementById('pass');
			var mensaje = document.getElementById('msj');
			ajaxRequest({
					'method': 'post',
					'url': 'modulos/iniciar.sesion.php',
					'data': 'usuario=' + user.value + "&password=" + pass.value + '&ajax',
					'success': function(rta) {
						var estado = JSON.parse(rta);
						if(estado.status == 0) {
							mensaje.innerHTML = estado.data ;
						} else {
							ajaxRequest({
								'url': 'prod.listado.php',
								'success': function(rta) {
									document.getElementById('contenido').innerHTML = rta;
									func_btn();
								}
							});
							ajaxRequest({
								'url': 'modulos/login.php',
								'success': function(rta) {
									document.getElementById('login').innerHTML = rta;
									func_btn();
								}
							});
					}
				}
			
			});

}, false);
var cont = document.getElementById('contenido');
var alta = document.getElementById('alta');
if(cont!=undefined){
	cont.innerHTML = "";
}
if(cont!=undefined){
	alta.innerHTML = "";
}
}
};
