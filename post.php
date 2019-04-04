<?php

//ini_set ('display_errors',1);
//error_reporting(E_ALL);
//error_reporting(E_ERROR | E_WARNING | E_PARSE);

include("db.php");

$mac = json_encode($_GET);;

// $sql = "insert into bio_estadistica (id_bio_camara, ip, free) values (3, '11.1.1.1','" . $mac . "')";
//ejecutar($sql);

//{"mac":"5c:cf:7f:b2:c8:cb","fecha":"220917","hora":"000200","voltaje":"224","consumo":"0.00"}[]

//http://localhost/biobarica/service/post.php?mac=33:44:55:88:aa:ff&fecha=220917&hora=000200&voltaje=224&consumo=0.00

$mac = $_REQUEST["mac"];


if(strlen($_REQUEST["fecha"]) == 8 )
{
	$dia = substr($_REQUEST["fecha"], 0, 2);  // dd
	$mes = substr($_REQUEST["fecha"], 2, 2);  // mm
	$anio = substr($_REQUEST["fecha"], 6, 2);  // yy
}
else
{
	if(strlen($_REQUEST["fecha"])  != 6)
		$_REQUEST["fecha"] = '0' . $_REQUEST["fecha"];

	$dia = substr($_REQUEST["fecha"], 0, 2);  // dd
	$mes = substr($_REQUEST["fecha"], 2, 2);  // mm
	$anio = substr($_REQUEST["fecha"], 4, 2);  // yy

}

$fecha = '20'.$anio.$mes.$dia; // fecha ascii

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
if (!isset($mac) || !isset($ip) || !isset($hora) || !isset($voltaje) || !isset($consumo) || $_REQUEST['fecha'] == '10170') {
	$sql = ejecutar("insert into bio_log (created_at, log) values ('".date('Y-m-d h:i:s')."', 'ERROR: ".json_encode($_REQUEST)."')");

	echo("HTTP/1.1 403 Forbidden");
	header("HTTP/1.1 403 Forbidden");
	exit();
}
else
{
	//guardo el log de lo que se ejecuta
	$sql = ejecutar("insert into bio_log (created_at, log) values ('".date('Y-m-d h:i:s')."', '".json_encode($_REQUEST)."')");
}


/*****************************************************************
Reviso que todas la posiciones de la mac sean de dos digitos -> comlemento con 0
*****************************************************************/
$a_mac = explode(':', $mac);

if(is_array($a_mac) && count($a_mac) == 6){
	$a_mac[0] = str_pad($a_mac[0], 2, '0', STR_PAD_LEFT);
	$a_mac[1] = str_pad($a_mac[1], 2, '0', STR_PAD_LEFT);
	$a_mac[2] = str_pad($a_mac[2], 2, '0', STR_PAD_LEFT);
	$a_mac[3] = str_pad($a_mac[3], 2, '0', STR_PAD_LEFT);
	$a_mac[4] = str_pad($a_mac[4], 2, '0', STR_PAD_LEFT);
	$a_mac[5] = str_pad($a_mac[5], 2, '0', STR_PAD_LEFT);
	
	$mac = implode(':', $a_mac);
}


/*****************************************************************
Recupero Id de camara
*****************************************************************/
$data = ejecutar("select * from bio_camara where id_mac='".$mac."'");

if ($data[0][0]) {
	$id_bio_camara = $data[0][0];
}else{
	$sql = ejecutar("insert into bio_log (created_at, log) values ('".date('Y-m-d h:i:s')."', '".json_encode($_REQUEST)."')");

	//el dispositivo no esta dado de alta o la mac es erronea
	echo("HTTP/1.1 403 Forbidden");
	header("HTTP/1.1 403 Forbidden");
	exit();
}

/*****************************************************************
Inserto Log
*****************************************************************/

$sql = "call insert_estadistica (".$id_bio_camara.",'".$ip."','".$fecha."', '".$hora."', ".$voltaje.", ".$consumo.")";


ejecutar($sql);

echo("HTTP/1.1 201 Created");
header("HTTP/1.1 201 Created");
exit();

?>
