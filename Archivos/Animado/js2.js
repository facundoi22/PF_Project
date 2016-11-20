var d = document;

var body = d.getElementsByTagName("body")[0];

var contenedor = d.getElementById("contenedor");

contenedor.onclick = function(){
						window.open("http://www.proximafecha.com", "_blank"); 
					}

var logo = d.getElementById("logo");

var imagenFondo = d.getElementById("imgFondo");

var papelitos = d.getElementById("papelitos");

var papelitos2 = d.getElementById("papelitos2");

var papelitos3 = d.getElementById("papelitos3");

var frase1 = d.getElementById("frase1");
var frase2 = d.getElementById("frase2");
var frase3 = d.getElementById("frase3");

var boton = d.getElementById("botoningresar");

var circuloBlanco = d.getElementById("circuloBlanco");

var boolaux = false;
var stringDeScale = '(10,10)';

window.onload = function inicio(){
	 moverFrase1();
}

function moverFrase1(){
	if(boolaux == true){
		circuloBlanco.style.opacity ='0'; 
		circuloBlanco.style.width ='1px'; 
		circuloBlanco.style.height ='1px'; 
	}
	frase2.style.opacity ='1';
	frase3.style.opacity ='1';
	frase1.style.top = '20px';
	setTimeout(frase1.style.opacity = '1', 1000);
	setTimeout(moverFrase2, 2000);
	setTimeout(moverFrase3, 3500);
}

function moverFrase2(){
	frase2.style.left= '38px';
	}

function moverFrase3(){
	frase3.style.left= '38px';
	setTimeout(apareceLogo, 1000);
}

function apareceLogo(){
	logo.style.opacity = '1';
	setTimeout(subeLogo, 1000);
	setTimeout(apareceBoton, 4000);
}

function subeLogo(){
	logo.style.top = '175px';
	frase1.style.opacity = '0';
	frase2.style.opacity = '0';
	frase3.style.opacity = '0';
	setTimeout(finalizarBanner, 14000);
	
}

function apareceBoton(){
	boton.style.opacity = '1';
}

function finalizarBanner(){
	imagenFondo.style.opacity = '0';
	papelitos.style.opacity ='1';
	papelitos2.style.opacity ='1';
	papelitos3.style.opacity ='1';
	papelitos.style.top = '500px';
	papelitos2.style.top = '250px';
	papelitos3.style.top = '0px';
	setTimeout(agrandarCirculoBlanco, 10000);
}

function agrandarCirculoBlanco(){
		circuloBlanco.style.opacity = "1";
		circuloBlanco.style.transform = "scale(1000,1000)";
		boolaux = true;
		logo.style.opacity = '0';
		boton.style.opacity = '0';
		setTimeout(resetea, 2000);
		setTimeout(moverFrase1, 5000);
}

function resetea(){
		
		frase1.style.top ='-100px';
		frase1.style.left ='38px';
     	frase2.style.top ='120px';
		frase2.style.left ='-230px';
		frase3.style.top ='250px';
		frase3.style.left ='500px';
				
		papelitos.style.top ='-380px';
		papelitos.style.opacity ='0';
		papelitos2.style.top ='-760px';
		papelitos2.style.opacity ='0';
		papelitos3.style.top ='-1200px';
		papelitos3.style.opacity ='0';
		
		logo.style.top = '350px';
				
		imagenFondo.style.opacity = '1';
		setTimeout(circuloBlanco.style.opacity = '0', 6000);
}
