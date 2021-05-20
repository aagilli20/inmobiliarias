<?php 
require_once('scrap.php');
require_once('conexion.php');

// scrapeando a salasinmobiliaria - alquileres
// cargamos la web de origen
$html = get_web_curl('https://www.bottai.com.ar/inmuebles_list_Alquiler_seleccione_seleccione_0');                    
// creamos el documento dom
$doc = new DOMDocument();
@$doc->loadHTML($html);

// leemos todos los enlaces
$enlaces 	= 	$doc->getElementsByTagName('a');

/*
foreach ($enlaces as $enlace) {
	echo "<br> Enlace: ".$enlace->getAttribute('href');
}
*/

// listado limpio de enlaces
$url_list = array();
// listado de enlaces de paginacion
$url_page_list= array();
// domicilio
$domicilio_list = array();

$max = 0;
for ($i = 0; $i < $enlaces->length; $i++):
	$enlace = $enlaces->item($i);
	// capturo los enlaces de las propiedades de la primer página
	if(preg_match_all('/inmueble_/', $enlace->getAttribute('href'))){
		if(! in_array($enlace->getAttribute('href'), $url_list)) {
			$url_list[] = $enlace->getAttribute('href');
		} else $domicilio_list[] = limpiarString($enlaces->item($i)->nodeValue);
	}
	// capturo los enlaces de la paginacion
	if(preg_match_all('/inmuebles_list_Alquiler/', $enlace->getAttribute('href'))){
		// echo "<br>Enlace :".$enlace->getAttribute('href');
		$url_page_list[] = $enlace->getAttribute('href');
	}
endfor;
for ($i=0; $i<count($url_list); $i++) {$url_list[$i] = "https://www.bottai.com.ar/".$url_list[$i];}

// print_r($url_list); echo "<br>";

// limpio el listado de paginacion eliminando el último y el primero
array_shift($url_page_list);
array_pop($url_page_list);


// leemos todas las url que apuntan a una imagen y las guardamos en imagenes
$imagenes 	= 	$doc->getElementsByTagName('img');
$img_list = array();
for($i=1;$i<count($imagenes);$i++){
	// echo "<br>".$imagenes[$i]->getAttribute('src');
	if(preg_match_all('/images/', $imagenes[$i]->getAttribute('src'))) $img_list[] = "https://www.bottai.com.ar/".$imagenes[$i]->getAttribute('src');
}
// print_r($img_list);

// analizamos la tabla de datos para sacar domicilio, tipo, dormitorios, precio y barrio

// lectura de la descripción
$tabla_datos 	= 	$doc->getElementsByTagName('p');
$list_datos = array();
for($i=3;$i<count($url_list)+3;$i++){
	// echo "<br>".limpiarString($tabla_datos->item($i)->nodeValue);
	$list_datos[] = limpiarString($tabla_datos->item($i)->nodeValue);
}
// print_r($list_datos);

// cantidad de dormitorios
$dormitorios_list = array();
// defino el tipo
$tipo_list = array();

foreach($list_datos as $dato){
	if(stripos($dato, "monoambiente") != False) {
		$dormitorios_list[] = "Monoambiente";
		$tipo_list[] = "Departamento";
	} else if(stripos($dato, "mononambiente") !== False) {
		$dormitorios_list[] = "Monoambiente";
		$tipo_list[] = "Departamento";
	} else if(stripos($dato, "1 dormitorio") !== False) {
		$dormitorios_list[] = "1";
		$tipo_list[] = "Departamento";
	} else if(stripos($dato, "2 dormitorio") !== False) {
		$dormitorios_list[] = "2";
		$tipo_list[] = "Departamento";
	}
	else if(stripos($dato, "3 dormitorio") !== False) {
		$dormitorios_list[] = "3";
		$tipo_list[] = "Departamento";
	}
	else if(stripos($dato, "4 dormitorio") !== False) {
		$dormitorios_list[] = "4";
		$tipo_list[] = "Departamento";
	}
	else if(stripos($dato, "5 dormitorio") !== False) {
		$dormitorios_list[] = "5";
		$tipo_list[] = "Departamento";
	}
	else if(stripos($dato, "local") !== False) {
		$dormitorios_list[] = "0";
		$tipo_list[] = "Local";
	}
	else if(stripos($dato, "cochera") !== False) {
		$dormitorios_list[] = "0";
		$tipo_list[] = "Cochera";
	} else if(stripos($dato, "oficina") !== False) {
		$dormitorios_list[] = "0";
		$tipo_list[] = "Oficina";
	}else if(stripos($dato, "cochera") !== False) {
		$dormitorios_list[] = "0";
		$tipo_list[] = "Cochera";
	}else if(stripos($dato, "consultorio") !== False) {
		$dormitorios_list[] = "0";
		$tipo_list[] = "Oficina";
	}
	else if(stripos($dato, "predio") !== False) {
		$dormitorios_list[] = "0";
		$tipo_list[] = "Terreno";
	}
	else if(stripos($dato, "terreno") !== False) {
		$dormitorios_list[] = "0";
		$tipo_list[] = "Terreno";
	}
	else if(stripos($dato, "galpon") !== False) {
		$dormitorios_list[] = "0";
		$tipo_list[] = "Galpón";
	}
	else if(stripos($dato, "galpón") !== False) {
		$dormitorios_list[] = "0";
		$tipo_list[] = "Galpón";
	}
}
// echo "<br>"."----------------------------------------"."<br>";
/*
print_r($dormitorios_list);
print_r($tipo_list);
print_r($domicilio_list);
print_r($url_list);
print_r($img_list);
*/

// leemos los precios
$tabla_precios 	= 	$doc->getElementsByTagName('span');
$precio_list = array();
for($i=0;$i<count($tabla_precios);$i++){
	// echo "<br>".limpiarString($tabla_precios->item($i)->nodeValue);
	if(preg_match_all('/\$/', limpiarString($tabla_precios->item($i)->nodeValue))) $precio_list[] = limpiarString($tabla_precios->item($i)->nodeValue);
	else if(preg_match_all('/Consultar/', limpiarString($tabla_precios->item($i)->nodeValue))) $precio_list[] = limpiarString($tabla_precios->item($i)->nodeValue);
}
// print_r($precio_list);

// repetir el scrapeado para cada página
$test_break = 0;
foreach($url_page_list as $paginado){
	$test_break++;
	$html = get_web_curl("https://www.bottai.com.ar/".$paginado);  
	$doc = new DOMDocument();
	@$doc->loadHTML($html);
	$nodes 	= 	$doc->getElementsByTagName('title');
	$title 	= 	limpiarString($nodes->item(0)->nodeValue);
	$enlaces 	= 	$doc->getElementsByTagName('a');
	$cantidad_nuevos_enlaces = 0;
	// tomamos las imagenes útiles
	// leemos todas las url que apuntan a una imagen y las guardamos en imagenes
	// leemos todos los enlaces

	// listado limpio de enlaces
	$max = 0;
	$inicio = count($url_list);
	for ($i = 0; $i < $enlaces->length; $i++):
		$enlace = $enlaces->item($i);
		// capturo los enlaces de las propiedades de la primer página
		if(preg_match_all('/inmueble_/', $enlace->getAttribute('href'))){
			if(! in_array($enlace->getAttribute('href'), $url_list)) {
				$url_list[] = $enlace->getAttribute('href'); 
				$cantidad_nuevos_enlaces++;
			} else $domicilio_list[] = limpiarString($enlaces->item($i)->nodeValue);
		}
	endfor;
	for ($i=$inicio; $i<$inicio+$cantidad_nuevos_enlaces; $i++) {$url_list[$i] = "https://www.bottai.com.ar/".$url_list[$i];}
	// leemos todas las url que apuntan a una imagen y las guardamos en imagenes
	$imagenes 	= 	$doc->getElementsByTagName('img');
	for($i=1;$i<count($imagenes);$i++){
		// echo "<br>".$imagenes[$i]->getAttribute('src');
		if(preg_match_all('/images/', $imagenes[$i]->getAttribute('src'))) $img_list[] = "https://www.bottai.com.ar/".$imagenes[$i]->getAttribute('src');
	}
	// print_r($img_list);

	
	// leemos las descripciones
	$tabla_datos 	= 	$doc->getElementsByTagName('p');
	$list_datos = array();
	for($i=3;$i<$cantidad_nuevos_enlaces+3;$i++){
		// echo "<br>".limpiarString($tabla_datos->item($i)->nodeValue);
		$list_datos[] = limpiarString($tabla_datos->item($i)->nodeValue);
	}
	// print_r($list_datos);

	foreach($list_datos as $dato){
		if(stripos($dato, "monoambiente") != False) {
			$dormitorios_list[] = "Monoambiente";
			$tipo_list[] = "Departamento";
		} else if(stripos($dato, "mononambiente") !== False) {
			$dormitorios_list[] = "Monoambiente";
			$tipo_list[] = "Departamento";
		} else if(stripos($dato, "1 dormitorio") !== False) {
			$dormitorios_list[] = "1";
			$tipo_list[] = "Departamento";
		} else if(stripos($dato, "2 dormitorio") !== False) {
			$dormitorios_list[] = "2";
			$tipo_list[] = "Departamento";
		}
		else if(stripos($dato, "3 dormitorio") !== False) {
			$dormitorios_list[] = "3";
			$tipo_list[] = "Departamento";
		}
		else if(stripos($dato, "4 dormitorio") !== False) {
			$dormitorios_list[] = "4";
			$tipo_list[] = "Departamento";
		}
		else if(stripos($dato, "5 dormitorio") !== False) {
			$dormitorios_list[] = "5";
			$tipo_list[] = "Departamento";
		}
		else if(stripos($dato, "local") !== False) {
			$dormitorios_list[] = "0";
			$tipo_list[] = "Local";
		}
		else if(stripos($dato, "cochera") !== False) {
			$dormitorios_list[] = "0";
			$tipo_list[] = "Cochera";
		} else if(stripos($dato, "oficina") !== False) {
			$dormitorios_list[] = "0";
			$tipo_list[] = "Oficina";
		}else if(stripos($dato, "cochera") !== False) {
			$dormitorios_list[] = "0";
			$tipo_list[] = "Cochera";
		}else if(stripos($dato, "consultorio") !== False) {
			$dormitorios_list[] = "0";
			$tipo_list[] = "Oficina";
		}
		else if(stripos($dato, "predio") !== False) {
			$dormitorios_list[] = "0";
			$tipo_list[] = "Terreno";
		}
		else if(stripos($dato, "terreno") !== False) {
			$dormitorios_list[] = "0";
			$tipo_list[] = "Terreno";
		}
		else if(stripos($dato, "galpon") !== False) {
			$dormitorios_list[] = "0";
			$tipo_list[] = "Galpón";
		}
		else if(stripos($dato, "galpón") !== False) {
			$dormitorios_list[] = "0";
			$tipo_list[] = "Galpón";
		}
	}
	/*
	print_r($dormitorios_list);
	print_r($tipo_list);
	print_r($domicilio_list);
	print_r($url_list);
	print_r($img_list);
	*/

	// leemos los precios
	$tabla_precios 	= 	$doc->getElementsByTagName('span');
	for($i=0;$i<count($tabla_precios);$i++){
		// echo "<br>".limpiarString($tabla_precios->item($i)->nodeValue);
		if(preg_match_all('/\$/', limpiarString($tabla_precios->item($i)->nodeValue))) $precio_list[] = limpiarString($tabla_precios->item($i)->nodeValue);
		else if(preg_match_all('/Consultar/', limpiarString($tabla_precios->item($i)->nodeValue))) $precio_list[] = limpiarString($tabla_precios->item($i)->nodeValue);
	}
	// print_r($precio_list);
	
	// como había enlaces extra definimos un máximo obtenido de las imágenes útiles
	

	// analizamos la tabla de datos para sacar domicilio, tipo, dormitorios, precio y barrio
	
	// if($test_break == 7) break;
}

/*
echo "<br> domicilios: ".count($domicilio_list);
echo "<br> tipos: ".count($tipo_list);
echo "<br> dormitorios: ".count($dormitorios_list);
echo "<br> precios: ".count($precio_list);
echo "<br> imagenes: ".count($img_list);
echo "<br> url: ".count($url_list);


for ($i=0; $i < count($domicilio_list); $i++) {
echo "<br> domicilio: ".$domicilio_list[$i];
echo "<br> tipo: ".$tipo_list[$i];
echo "<br> dorm: ".$dormitorios_list[$i];
echo "<br> precio: ".$precio_list[$i];
echo "<br> url_img: ".$img_list[$i];
echo "<br> url: ".$url_list[$i];
}
*/

// foreach ($url_list as $una_url) echo "<br>Enlace: ".$una_url;

// cargamos los datos obtenidos a la dba
// No se pudo indentificar barrio asíque va para todo "Sin Definir"


$conn = new conexion();
for ($i=0; $i < count($domicilio_list); $i++) {
	if(strcmp($dormitorios_list[$i], "Monoambiente") == 0){
	$r=$conn->insertar_alquiler($domicilio_list[$i], "Santa Fe", $tipo_list[$i], '0', "Sin Definir", $precio_list[$i], str_replace(" ", "%20", $img_list[$i]), $url_list[$i], 2);
	// echo "<br>".$r;
	} else {
		if(strlen($dormitorios_list[$i]) == 0){
			$r=$conn->insertar_alquiler($domicilio_list[$i], "Santa Fe", $tipo_list[$i], '0', "Sin Definir", $precio_list[$i], str_replace(" ", "%20", $img_list[$i]), $url_list[$i], 2);
			// echo "<br>".$r;
		} else {
			$r=$conn->insertar_alquiler($domicilio_list[$i], "Santa Fe", $tipo_list[$i], $dormitorios_list[$i], "Sin Definir", $precio_list[$i], str_replace(" ", "%20", $img_list[$i]), $url_list[$i], 2);
			// echo "<br>".$r;
		}		
	}		
}

?>
