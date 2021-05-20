<?php
require_once("./adodb5/adodb.inc.php");
ini_set('memory_limit', '-1');
set_time_limit ('600');
require_once("conexion.php");
// configuramos el fetch mode para que al realizar las consultas los indices del arreglo
// tengan los mismos nombres que las columnas de la base de datos
$ADODB_FETCH_MODE=ADODB_FETCH_ASSOC;

class conexion {
	private $con;
	private $dbhost="127.0.0.1";
	private $dbuser="root";
	private $dbpass="";
	private $dbname="inmobiliaria";
	function __construct(){
		$this->connect_db();
	}
	public function connect_db(){
		$this->con = mysqli_connect($this->dbhost, $this->dbuser, $this->dbpass, $this->dbname);
		if(mysqli_connect_error()){
			die("Conexión a la base de datos falló " . mysqli_connect_error() . mysqli_connect_errno());
		}
	}	
	
	public function truncar_tablas(){
		$res1 = mysqli_query($this->con, "TRUNCATE TABLE venta;");
		$res2 = mysqli_query($this->con, "TRUNCATE TABLE alquiler;");
		if($res1 && $res2) return true;
		else return false;
	}
	
	public function ejecutar(string $sql){
		if (mysqli_query($this->con, $sql)) return true;
		// else return mysqli_error($this->con);
		else return $sql;
	}
	
	public function ejecutar_array(array $sql){
		$ok = true;
		foreach ($sql as $un_sql) {
			$res1 = mysqli_query($this->con, $sql);
			if(! $res1) $ok = false;
		}
		return $ok;
	}
	
	public function insertar_alquiler($domicilio, $localidad, $tipo, $dormitorios, $barrio, $precio, $img, $url, $id_inmobiliaria){
		$sql = "INSERT INTO alquiler (domicilio, localidad, precio, barrio, dormitorios, tipo, url_foto, url, id_inmobiliaria)";
		$sql = $sql." VALUES ('".$domicilio."', '".$localidad."','".$precio."','".$barrio."','".$dormitorios."','".$tipo."','".$img."','".$url."', '".$id_inmobiliaria."');";
		// return $sql;
		return $this->ejecutar($sql);
	}
	
	public function insertar_venta($domicilio, $localidad, $tipo, $dormitorios, $barrio, $precio, $img, $url, $id_inmobiliaria){
		$sql = "INSERT INTO venta (domicilio, localidad, precio, barrio, dormitorios, tipo, url_foto, url, id_inmobiliaria)";
		$sql = $sql." VALUES ('".$domicilio."', '".$localidad."','".$precio."','".$barrio."','".$dormitorios."','".$tipo."','".$img."','".$url."', '".$id_inmobiliaria."');";
		// return $sql;
		return $this->ejecutar($sql);
	}
	
}

?>
