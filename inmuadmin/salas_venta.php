<?php 
require_once('scrap.php');
require_once('conexion.php');

// scrapeando a salasinmobiliaria - ventas
// cargamos la web de origen
$html = get_web_curl('https://www.salasinmobiliaria.com.ar/ventas.html');                    
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
// eliminamos el duplicado del último
array_pop($url_page_list);
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
	// if($test_break == 5) break;
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

// cargamos los datos obtenidos a la dba
$conn = new conexion();
for ($i=0; $i < count($domicilio_list); $i++) {
	if(strcmp($dormitorios_list[$i], "Monoambiente") == 0){
		$conn->insertar_venta($domicilio_list[$i], "Santa Fe", $tipo_list[$i], '0', $barrio_list[$i], $precio_list[$i], $img_list[$i], $url_list[$i], 1);
	} else {
		if((strlen($dormitorios_list[$i]) == 0)){
			$conn->insertar_venta($domicilio_list[$i], "Santa Fe", $tipo_list[$i], '0', $barrio_list[$i], $precio_list[$i], $img_list[$i], $url_list[$i], 1);
		}else{
			$conn->insertar_venta($domicilio_list[$i], "Santa Fe", $tipo_list[$i], $dormitorios_list[$i], $barrio_list[$i], $precio_list[$i], $img_list[$i], $url_list[$i], 1);	
		}
	}
}

?>
