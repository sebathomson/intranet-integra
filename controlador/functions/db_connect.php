<?php
function db_connect(){

	$usuario = '********';
	$password = '********';
	$basededatos = '********';
	$host = '********';
	
	$conexion = mysql_connect($host,$usuario,$password);
		
	if (!$conexion){
		die('No se puede conectar: ' . mysql_error());
	}else{
		mysql_select_db($basededatos, $conexion);
	}
}

function db_close(){

	mysql_close();

}
function db_query_insert($query){ 
	db_connect();
	$return = @mysql_query($query);
	db_close();
        return $return;
}
function db_query_logic($query){ 
	db_connect();
	$resultado = @mysql_query($query);
	$id = mysql_result($resultado, 0);
	db_close();
	return $id;
}
function db_query_create($query){ 
	db_connect();
	$resultado = @mysql_query($query);
	$id = mysql_result($resultado, 0);
	db_close();
	return $id;
}
function db_query_resulset($query){ 

	$resultado = @mysql_query($query);
	return $resultado;
}
function db_query_return($query){ 
	
	$valid_query = mysql_real_escape_string($query);
	$resultado = false;
	
	if ( ($valid_query = false)){
	
		$resultado = false;
		
	} else {
		db_connect();
		
		$resultado = @mysql_query($valid_query);
		
		if($resultado != false){
		
		$resultado_array = mysql_fetch_assoc($resultado);

		}
		db_close();
	}
	return $resultado;
}
?>