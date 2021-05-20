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
	
	
	public function ejecutar(string $sql){
		if (mysqli_query($this->con, $sql)) return true;
		else return mysqli_error($this->con);
	}
	
	public function consulta_alquiler(){
		$sql = "SELECT * FROM alquiler WHERE 1";
		// return $sql;
		return mysqli_query($this->con, $sql);
	}
	
	public function consulta_alquiler_filtro($where){
		$sql = "SELECT * FROM alquiler ".$where;
		// return $sql;
		return mysqli_query($this->con, $sql);
	}
	
	public function consulta_venta_filtro($where){
		$sql = "SELECT * FROM venta ".$where;
		// return $sql;
		return mysqli_query($this->con, $sql);
	}
	
	public function consulta_venta(){
		$sql = "SELECT * FROM venta WHERE 1";
		// return $sql;
		return mysqli_query($this->con, $sql);
	}
	
}

?>
