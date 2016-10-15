
$(document).ready(function(){
	if($(window).width() > 960){
		animarFoto();
	};
});


function animarFoto(){
   $("img").fadeIn(1000).delay(1000).fadeOut(1000);
   
   animarFoto();
} 

