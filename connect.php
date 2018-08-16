<?php

	function dbConnect(){
		$ruta = 'mysql:host=localhost; dbname=tpi_db; charset=utf8; port=3306';
		$usuario = 'root';
		$password = 'root';
		$opciones = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];

		try {
			$conexion = new PDO($ruta, $usuario, $password, $opciones);
			return $conexion;

			//echo "Conexión Exitosa!<br><br>";
		}
		catch( PDOException $ErrorEnConexion ) {
			echo "Se ha producido un error: ".$ErrorEnConexion->getMessage();
			return exit;
		}
	}

?>
