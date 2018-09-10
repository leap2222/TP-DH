<?php
	ini_set('memory_limit', '-1');
	ini_set('max_execution_time', 0);

	function dbConnect(){
		$ruta = 'mysql:host=localhost; dbname=tpi_db; charset=utf8; port=3306';
		$usuario = 'root';
		$password = 'root';
		$opciones = array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8");
		//$opciones = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

		try {
			$conn = new PDO($ruta, $usuario, $password, $opciones);
			$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return $conn;
		}
		catch( PDOException $ErrorEnConexion ) {
			echo "Error DB, dbConnect(): ".$ErrorEnConexion->getMessage();
			return false;
		}
	}

?>
