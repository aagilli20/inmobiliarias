<?php 

    // Definimos la función cURL
	
	// original
    function curl($url) {
        $ch = curl_init($url); // Inicia sesión cURL
		//A given cURL operation should only take
		//30 seconds max.
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		//Tell cURL that it should only spend 10 seconds
		//trying to connect to the URL in question.
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); // Configura cURL para devolver el resultado como cadena
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Configura cURL para que no verifique el peer del certificado dado que nuestra URL utiliza el protocolo HTTPS
        $info = curl_exec($ch); // Establece una sesión cURL y asigna la información a la variable $info
		// captura error
		if($info == false) {
			$file = fopen("./log.txt", "w");
			fwrite($file, curl_error($ch) . PHP_EOL);
			fclose($file);
		}
        curl_close($ch); // Cierra sesión cURL
        return $info; // Devuelve la información de la función
    }
	
	function get_web_curl($url){
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // Configura cURL para que no verifique el peer del certificado dado que nuestra URL utiliza el protocolo HTTPS
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_COOKIESESSION, 1);
		curl_setopt($ch, CURLOPT_FRESH_CONNECT, 1);
		//A given cURL operation should only take
		//30 seconds max.
		curl_setopt($ch, CURLOPT_TIMEOUT, 30);
		//Tell cURL that it should only spend 10 seconds
		//trying to connect to the URL in question.
		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
		$data = curl_exec($ch);
		// captura error
		if($data == false) {
			$file = fopen("./log.txt", "w");
			fwrite($file, curl_error($ch) . PHP_EOL);
			fclose($file);
		}
		curl_close($ch);
		return $data;
	}
	
	function limpiarString($String){ 
     $String = str_replace(array("|","|","[","^","´","`","¨","~","]","'","#","{","}",".",""),"",$String);
     return $String;
	}
	
?>