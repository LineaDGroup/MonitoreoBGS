<?php

//ini_set ('display_errors',1);
//error_reporting(E_ALL);
//error_reporting(E_ERROR | E_WARNING | E_PARSE);

include("db.php");

//{"mac":"5c:cf:7f:b2:c8:cb","fecha":"220917","hora":"000200","voltaje":"224","consumo":"0.00"}[]

//http://localhost/biobarica/service/post.php?mac=33:44:55:88:aa:ff&fecha=220917&hora=000200&voltaje=224&consumo=0.00

$mac = $_REQUEST["mac"];
$fecha = date("Y-m-d", strtotime($_REQUEST["fecha"]));
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
if (!isset($mac) || !isset($ip) || !isset($hora) || !isset($voltaje) || !isset($consumo) ) {
	echo("HTTP/1.1 403 Forbidden");
	header("HTTP/1.1 403 Forbidden");
	exit();
}



/*****************************************************************
Recupero Id de camara
*****************************************************************/
$data = ejecutar("select * from bio_camara where id_mac='".$mac."'");

if ($data[0][0]) {
	$id_bio_camara = $data[0][0];
}else{
	//el dispositivo no esta dado de alta o la mac es erronea
	echo("HTTP/1.1 403 Forbidden");
	header("HTTP/1.1 403 Forbidden");
	exit();
}

/*****************************************************************
Inserto Log
*****************************************************************/

$sql = "INSERT INTO bio_estadistica(id_bio_camara, ip, fecha, hora, voltaje, consumo, created_at)
		values (".$id_bio_camara.",'".$ip."','".$fecha."', '".$hora."', ".$voltaje.", ".$consumo.", '".date("Y-m-d H:i:s")."')";

ejecutar($sql);

echo("HTTP/1.1 201 Created");
header("HTTP/1.1 201 Created");
exit();

?>