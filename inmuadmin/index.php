<?php

require_once('conexion.php');

// vaciamos todas las tablas
$conn = new conexion();
if ($conn->truncar_tablas()) {
	echo "Truncado exitoso <br> ";
	// cargamos las tablas de inmobiliaria salas - alquiler
	// include('salas_alquiler.php');
	// echo "Fin salas alquiler <br>";
	// include('salas_venta.php');
	// echo "Fin salas venta <br>";
	include('bottai_alquiler.php');
	echo "Fin BOTTAI alquiler <br>";
}
else {
	echo "Error en el truncado <br>";
}





?>