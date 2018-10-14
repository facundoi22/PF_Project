var d = document;


var publicidad = d.getElementById('publicidad');
publicidad.onmouseover = function(){
	this.getElementsByTagName('img')[0].src = "images/publicidad_2.png";
	this.style.height = "220px";	
};

publicidad.onmouseout = function(){
	this.getElementsByTagName('img')[0].src = "images/publicidad_1.png";
	this.style.height = "60px";	
};

publicidad.getElementsByTagName('a')[0].onclick = function(){
		var removido = d.getElementsByTagName("body")[0].removeChild(d.getElementById("publicidad"));
};

publicidad.getElementsByTagName('img')[0].onclick = function(){
	window.open("http://www.canal13.com.ar", "_blank"); 
}