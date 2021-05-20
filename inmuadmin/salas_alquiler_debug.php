<?php 
require_once('scrap.php');
require_once('conexion.php');

// scrapeando a salasinmobiliaria - alquileres
// cargamos la web de origen
$html = get_web_curl('https://www.salasinmobiliaria.com.ar/alquileres.html');                    
// creamos el documento dom
$doc = new DOMDocument();
@$doc->loadHTML($html);

// leemos todos los enlaces
$enlaces 	= 	$doc->getElementsByTagName('a');

// leemos todas las url que apuntan a una imagen y las guardamos en imagenes
preg_match_all('/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*\.(?:jpg|gif|png)/i', $html, $imagenes);

// leemos la tabla que tiene el resto de los datos
$tabla_datos 	= 	$doc->getElementsByTagName('td');

// tomamos las imagenes utiles
$max = 0;
$img_list = array();
foreach ($imagenes as $lista_imagen) {
	for ($i = 8; $i < count($lista_imagen); $i=$i+5) {
		if($max<7) {
			// echo "<br>Imagen :".$lista_imagen[$i];
			$img_list[] = $lista_imagen[$i];
		} else break;
		$max++;
	}
	// print_r($imagen);
}

$flag = true;
// listado limpio de enlaces
$url_list = array();
// listado de enlaces de paginacion
$url_page_list= array();
// tomamos los enlaces útiles
// como había enlaces extra definimos un máximo obtenido de las imágenes útiles
$max = 0;
for ($i = 0; $i < $enlaces->length; $i++):
	$enlace = $enlaces->item($i);
	// capturo los enlaces de las propiedades de la primer página
	if(preg_match_all('/propiedad/', $enlace->getAttribute('href'))){
		// que no incluyan facebook twitter y whatsapp
		if(! preg_match_all('/facebook|twitter|whatsapp/', $enlace->getAttribute('href'))){
			// echo "<br>Enlace :".$enlace->getAttribute('href');
			if($flag) {
				$max++;
				if($max <= (count($img_list))) {
					$url_list[] = $enlace->getAttribute('href');
					// echo "<br>Enlace guardado:".$enlace->getAttribute('href');
				}
				
				$flag = false;
			} else {
				$flag = true;
			}
		}
	}
	// capturo los enlaces de la paginacion
	if(preg_match_all('/&pag=/', $enlace->getAttribute('href'))){
		// echo "<br>Enlace :".$enlace->getAttribute('href');
		$url_page_list[] = $enlace->getAttribute('href');
	}
endfor;

// quito la página 1 porque ya se scrapeo
array_shift($url_page_list);
// echo "<br>";
// print_r($url_page_list);

// repetir el scrapeado para cada página
$test_break = 0;
foreach($url_page_list as $paginado){
	$test_break++;
	$html = get_web_curl($paginado);                    
	$doc = new DOMDocument();
	@$doc->loadHTML($html);
	$nodes 	= 	$doc->getElementsByTagName('title');
	$title 	= 	limpiarString($nodes->item(0)->nodeValue);
	$enlaces 	= 	$doc->getElementsByTagName('a');
	$tabla_datos 	= 	$doc->getElementsByTagName('td');
	// tomamos las imagenes útiles
	$count_img = 0;
	// leemos todas las url que apuntan a una imagen y las guardamos en imagenes
	preg_match_all('/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*\.(?:jpg|gif|png)/i', $html, $imagenes);
	foreach ($imagenes as $lista_imagen) {
		for ($i = 8; $i < count($lista_imagen); $i=$i+5) {
			if($count_img<7) {
				// echo "<br>Imagen :".$lista_imagen[$i];
				$img_list[] = $lista_imagen[$i];
			} else break;
			$count_img++;
		}
		// print_r($imagen);
	}
	
	if($test_break == 5) break;
}


foreach ($img_list as $img) {
	
	echo "<img src='".$img."'><br>";
	
}

?>
