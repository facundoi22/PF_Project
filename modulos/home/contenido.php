<section id="Index" itemscope itemtype="http://schema.org/Place">
	<?php 
	if( file_exists("modulos/home/images/home.jpg" ) ){
		$imagen =<<<IMAGEN
			<picture>
				<img src="modulos/home/images/home.jpg" alt="Home"/>
			</picture>
IMAGEN;
		echo $imagen;
	}	?>
		
	<h1> <span itemprop="name"> El cedrón </span></h1>
	<h2> <span itemprop="description" > Pizzería </span></h2>
	<ul itemprop="address" itemscope itemtype="http://schema.org/PostalAddress">
		<li itemprop="streetAddress">Juan Bautista Alberdi 6101.</li> 
		<li><span itemprop="addressLocality">Mataderos </span>,<span itemprop="addressRegion">Capital Federal</span></li>
	    <li> Reservas y Delivery: <span itemprop="telephone">4687-0387</span></li>
	</ul>
	<a class="icono"  href="https://goo.gl/maps/zMhjbrwN4wA2"> Ver en Google Maps </a>
	<div id="mapa"> 
		<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3282.0569958130363!2d-58.50537719999998!3d-34.6532635!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0000000000000000%3A0xa934be415606ab1a!2sEl+Cedr%C3%B3n!5e0!3m2!1ses!2sar!4v1443292495454" allowfullscreen></iframe>
	</div>
	
	<?php 
	//$noticia = Noticia::getNoticiaActiva();
	$noticia = null;
	if( $noticia ) {
		echo '<aside>';
		echo '<h1>' . nl2br(htmlentities($noticia['titulo'])) . '</h1>';
		echo '<p>' . nl2br(htmlentities($noticia['noticia'])) . '</p>';
		echo '</aside>';
	}; 	?>
</section>
	