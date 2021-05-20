<?php 
require_once('scrap.php');
require_once('conexion.php');

/*
basic scraping
$html = file_get_contents('https://www.salasinmobiliaria.com.ar/alquileres.html'); //Convierte la información de la URL en cadena
echo $html;
*/
/*
curl scraping
$sitioweb = curl('https://www.salasinmobiliaria.com.ar/alquileres.html');  // Ejecuta la función curl escrapeando el sitio web
$sitioweb = get_web_curl('https://www.salasinmobiliaria.com.ar/alquileres.html');  // Ejecuta la función curl escrapeando el sitio web
echo $sitioweb;
*/


// Scraping Title, description y keywords
// $url	= $_GET['url']; para scrapping by form
/*
$html = get_web_curl('https://www.salasinmobiliaria.com.ar/alquileres.html');                    
$doc = new DOMDocument();
@$doc->loadHTML($html);
$nodes 	= 	$doc->getElementsByTagName('title');
$title 	= 	limpiarString($nodes->item(0)->nodeValue);
$metas 	= 	$doc->getElementsByTagName('meta');
for ($i = 0; $i < $metas->length; $i++):
	$meta = $metas->item($i);
    if($meta->getAttribute('name') == 'description')
       	$description = limpiarString($meta->getAttribute('content'));
    if($meta->getAttribute('name') == 'keywords')
        	$keywords = limpiarString($meta->getAttribute('content'));
endfor;
echo "TITLE :<br>".$title."<br>";
echo "DESCRIPTION :<br>".$description."<br>";
echo "KEYWORDS :<br>".$keywords;
*/

// scrapeando a salasinmobiliaria
// cargamos la web de origen
$html = get_web_curl('https://www.salasinmobiliaria.com.ar/alquileres.html');                    
// creamos el documento dom
$doc = new DOMDocument();
@$doc->loadHTML($html);
// tomamos los nodes
// $nodes 	= 	$doc->getElementsByTagName('title');
// $title 	= 	limpiarString($nodes->item(0)->nodeValue);
// leemos todos los enlaces
$enlaces 	= 	$doc->getElementsByTagName('a');
// leemos todas las url que apuntan a una imagen y las guardamos en imagenes
preg_match_all('/\b(?:(?:https?|ftp):\/\/|www\.)[-a-z0-9+&@#\/%?=~_|!:,.;]*\.(?:jpg|gif|png)/i', $html, $imagenes);
// Cantidad de dormitorios
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

// analizamos la tabla de datos para sacar domicilio, tipo, dormitorios, precio y barrio
$domicilio_list = array();
$tipo_list = array();
$dormitorios_list = array();
$barrio_list = array();
$precio_list = array();
for ($i = 1; $i < $tabla_datos->length; $i=$i+9):
	$tabla = $tabla_datos->item($i);
	// analisis para la primer pagina
	$domicilio_list[] 	= 	limpiarString($tabla_datos->item($i)->nodeValue);
	$tipo_list[] 	= 	limpiarString($tabla_datos->item($i+1)->nodeValue);
	$dormitorios_list[] 	= 	limpiarString($tabla_datos->item($i+2)->nodeValue);
	$barrio_list[]	= 	limpiarString($tabla_datos->item($i+3)->nodeValue);
	$precio_list[]	= 	limpiarString($tabla_datos->item($i+4)->nodeValue);
	
	/*
	echo "<br> domicilio: ".$domicilio_list[$i];
	echo "<br> tipo: ".$tipo_list[$i];
	echo "<br> dormitorios: ".$dormitorios_list[$i];
	echo "<br> barrio:".$barrio_list[$i];
	echo "<br> precio:".$precio_list[$i];
	*/
endfor;

// print_r($url_list);
// print_r($img_list);

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
	// como había enlaces extra definimos un máximo obtenido de las imágenes útiles
	$max = 0;	
	$flag = true;
	for ($i = 0; $i < $enlaces->length; $i++):
		$enlace = $enlaces->item($i);
		// capturo los enlaces de las propiedades de la primer página
		if(preg_match_all('/propiedad/', $enlace->getAttribute('href'))){
			// que no incluyan facebook twitter y whatsapp
			if(! preg_match_all('/facebook|twitter|whatsapp/', $enlace->getAttribute('href'))){
				// echo "<br>Enlace :".$enlace->getAttribute('href');
				if($flag) {
					$max++;
					if($max <= ($count_img)) {
						$url_list[] = $enlace->getAttribute('href');
						// echo "<br>Enlace guardado:".$enlace->getAttribute('href');
					}
					$flag = false;
				} else {
					$flag = true;
				}
			}
		}
	endfor;	

	// analizamos la tabla de datos para sacar domicilio, tipo, dormitorios, precio y barrio
	for ($i = 1; $i < $tabla_datos->length; $i=$i+9):
		$tabla = $tabla_datos->item($i);
		// analisis para la primer pagina
		$domicilio_list[] 	= 	limpiarString($tabla_datos->item($i)->nodeValue);
		$tipo_list[] 	= 	limpiarString($tabla_datos->item($i+1)->nodeValue);
		$dormitorios_list[] 	= 	limpiarString($tabla_datos->item($i+2)->nodeValue);
		$barrio_list[]	= 	limpiarString($tabla_datos->item($i+3)->nodeValue);
		$precio_list[]	= 	limpiarString($tabla_datos->item($i+4)->nodeValue);
		
		/*
		// comentar estas lineas
		echo "<br> domicilio: ".$domicilio_list[$i];
		echo "<br> tipo: ".$tipo_list[$i];
		echo "<br> dormitorios: ".$dormitorios_list[$i];
		echo "<br> barrio:".$barrio_list[$i];
		echo "<br> precio:".$precio_list[$i];
		// comentar hasta aca
		*/
	endfor;
	if($test_break == 2) break;
}



/*
echo "<br> domicilios: ".count($domicilio_list);
echo "<br> tipos: ".count($tipo_list);
echo "<br> dormitorios: ".count($dormitorios_list);
echo "<br> barrios: ".count($barrio_list);
echo "<br> precios: ".count($precio_list);
echo "<br> imagenes: ".count($img_list);
echo "<br> url: ".count($url_list);

for ($i=1; $i < count($domicilio_list); $i++) {
echo "<br> domicilio: ".$domicilio_list[$i];
echo "<br> tipo: ".$tipo_list[$i];
echo "<br> dorm: ".$dormitorios_list[$i];
echo "<br> barrio: ".$barrio_list[$i];
echo "<br> precio: ".$precio_list[$i];
echo "<br> url_img: ".$img_list[$i];
echo "<br> url: ".$url_list[$i];
}
*/
// foreach ($url_list as $una_url) echo "<br>Enlace: ".$una_url;

// cargamos los datos obtenidos a la dba_close

$conn = new conexion();
echo "Resultado: ".$conn->insertar_alquiler($domicilio_list[1], $tipo_list[1], $dormitorios_list[1], $barrio_list[1], $precio_list[1], $img_list[1], $url_list[1]);
	
?>
