<?php

include("conn.php");

class DB {

	private static $isConnected = false;
	
	/**
		<summary>Conexion a la Base de Datos</summary>
		<returns tipo="object">Retorna un identificador de la conexion a la base de datos</returns>
	**/
	static function realConnect($hostname, $username, $password, $db)
	{
		$connId = mysqli_connect($hostname, $username, $password, $db) or exit( "An error ocurred, couldn't connect to SQL Server" );

		DB::$isConnected = true;
		
		return $connId;
	}

	/**
		<summary>Cierra la conexión con la base de datos</summary>
	**/
	static function realDisconnect(){
		
		DB::$isConnected = false;
		
		@mysql_close();

		return;
	}	
	
}

function ejecutar($sql){

	$connId = DB::realConnect(K_HOSTNAME, K_USERNAME, K_PASSWORD, K_DB);
	
	$rs =  @mysqli_query($connId, $sql);

	if ( $rs === false ){
		echo "error";		
		header("HTTP/1.1 505 Data Base Error");
		exit();
	}

	$data = array();
	
	if(@mysqli_num_rows($rs) >0){
		while ($row = @mysqli_fetch_row($rs)){
			$data[] = $row;				
		}
	}

	DB::realDisconnect();

	return $data;
}

function var_dump_pre($object, $context = ''){
	echo '<br>'.$context.'<br>';
	echo '<pre>';
	var_dump($object);
	echo '</pre>';
	echo '<br>';
}

?>