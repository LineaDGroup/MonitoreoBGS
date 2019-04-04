<?php

ini_set ('display_errors',1);
error_reporting(E_ALL);
//error_reporting(E_ERROR | E_WARNING | E_PARSE);

include("db.php");

/***************************************************************************/
// ESCRITURA DE REQUEST
/***************************************************************************/

if (K_SHOW_REQUEST) {
	$file = '$_REQUEST.txt';
	$line = '*********************** inicio ****************************'.chr(13);
	$line .= 'Fecha: '.date('d-m-y H:i:s').chr(13);
	foreach ($_REQUEST as $key => $value) {
		$line .= $key.': '.$value.chr(13);
	}
	$line .= '************************* fin *****************************'.chr(13);
	file_put_contents("/var/www/html/biobarica/service/".$file, $line, FILE_APPEND | LOCK_EX);
	exit();
}

/***************************************************************************/
// FIN ESCRITURA DE REQUEST
/***************************************************************************/

$token = $_REQUEST["token"];

if (K_DEBUG && !isset($_REQUEST["token"])) {
	$token = "asdasd";
}

//deberia venir un token
if (!$token) {
	echo("HTTP/1.1 401 Unauthorized");
	header("HTTP/1.1 401 Unauthorized");
	exit();
}

$mac = $_REQUEST["mac"];
$fecha = $_REQUEST["fecha"];
$hora = $_REQUEST["hora"];
$voltaje = $_REQUEST["voltaje"];
$consumo = $_REQUEST["consumo"];



if (K_DEBUG && !isset($_REQUEST["mac"])) {
	$mac = "5c:cf:7f:b2:bf:4f";
}

if (K_DEBUG && !isset($_REQUEST["fecha"])) {
	$fecha = date("Y-m-d");
}

if (K_DEBUG && !isset($_REQUEST["hora"])) {
	$hora = date("H:i:s");
}

if (K_DEBUG && !isset($_REQUEST["voltaje"])) {
	$voltaje = rand(210,230);
}

if (K_DEBUG && !isset($_REQUEST["consumo"])) {
	$consumo = rand(1000,500) / 100;
}

$ip = $_SERVER['REMOTE_ADDR'];

//deberian venir todos los parametros requeridos 
if (!$mac || !$ip || !$hora || !$voltaje || !$consumo) {
	echo("HTTP/1.1 403 Forbidden");
	header("HTTP/1.1 403 Forbidden");
	exit();
}


//valido que la mac que pega contra el servicio exista

/*
$array_mac = array(
				"1" => "33:33:33:33:33:33",
				"2" => "5c:cf:7f:b2:bf:4f"
			);

if (!in_array($mac, $array_mac)) {
	echo("HTTP/1.1 406 Not Acceptable");
	header("HTTP/1.1 406 Not Acceptable");
	exit();
}
*/

//***************************************************************************
//	DEBERIA OBTENER EL ID DE LA MAC PARA GUARDAR EN LA ESTADISTICA
//***************************************************************************
if (K_DEBUG) {
	$id_bio_camara = rand(1,2);
}

$sql = "INSERT INTO bio_estadistica(id_bio_camara, id_bio_ip, fecha, hora, voltaje, consumo, created_at)
		values (".$id_bio_camara.",'".$ip."','".$fecha."', '".$hora."', ".$voltaje.", ".$consumo.", '".date("Y-m-d H:i:s")."')";

ejecutar($sql);
//if todo ok
	echo("HTTP/1.1 201 Created");
	header("HTTP/1.1 201 Created");
	exit();
//else
	//echo("HTTP/1.1 202 Accepted but not completed");
	//header("HTTP/1.1 202 Accepted but not completed");
	//exit();
//end if

?>