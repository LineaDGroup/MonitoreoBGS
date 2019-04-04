<?php
$tk = isset($argv[1]) ? $argv[1] : "";
$tk = (empty($tk)) ? $_REQUEST["tk"] : $tk;
if($tk != 'b1ob4r1c4'){
  $file = '$_CRONE.txt';
  $line = '*********************** inicio ****************************'.chr(13);
  $line .= 'REQUEST: '.json_encode($_REQUEST).chr(13);
  $line .= 'token error'.chr(13);
  $line .= 'Fecha: '.date('d-m-y H:i:s').chr(13);
  $line .= '************************* fin *****************************'.chr(13);
  file_put_contents("/var/www/html/dis.dev/service/".$file, $line, FILE_APPEND | LOCK_EX);
  echo "token error: " . $tk;
  exit();
}

include("db.php");
include("../vendor/crocodicstudio/crudbooster/src/helpers/Helper.php");

$file = '$_CRONE.txt';

$line = '*********************** inicio ****************************'.chr(13);
$line .= 'REQUEST: '.json_encode($_REQUEST).chr(13);
file_put_contents("/var/www/html/dis.dev/service/".$file, $line, FILE_APPEND | LOCK_EX);

//Procesamos las sesiones
ejecutar("CALL process_session_last_day();");

$line = 'Se ejecuto process_session_last_day();'.chr(13);
file_put_contents("/var/www/html/dis.dev/service/".$file, $line, FILE_APPEND | LOCK_EX);

//Calculamos los amperajes promedios
ejecutar("CALL set_amperaje_promedio();");


//Calculamos el voltaje promedio
ejecutar("CALL set_voltaje_promedio();");

$line = 'Se ejecuto set_amperaje_promedio();'.chr(13);
file_put_contents("/var/www/html/dis.dev/service/".$file, $line, FILE_APPEND | LOCK_EX);

//Revisamos si alguna maquina dejo de enviar data
$data = ejecutar("CALL check_service_report();");

$line = 'Se ejecuto check_service_report;'.chr(13);
file_put_contents("/var/www/html/dis.dev/service/".$file, $line, FILE_APPEND | LOCK_EX);

if(count($data)){
  $firstMail = $data[0][4];
}

$html = '';

foreach ($data as $key => $camara) {
    if($firstMail != $camara[4]){
          $html = "<table><tr><td>Los siguientes dispositivos no reportan informaci&oacute;n:<td></tr></table></br>".$html;
	  //echo $html;
	  
	  //Envio mail
	  //$to = $camara[4];
	  //$subject = "Reporte de servicio";
	  //send_mail_custom($to,$subject,$html);
	  
	  //Lo marcamos como enviado
	  ejecutar("CALL set_send_mail(".$camara[0].");");

	  $line = 'Se envio mail a: '.$firstMail.chr(13);
	  file_put_contents("/var/www/html/dis.dev/service/".$file, $line, FILE_APPEND | LOCK_EX);
	  
	  $html = '';
	  $html .= "<table>";
	  $html .= "<tr>";
	      $html .= "<td>Mac:</td>";
	      $html .= "<td>".$camara[1]."</td>";
	  $html .= "</tr>";
	  $html .= "<tr>";
	      $html .= "<td>Nombre:</td>";
	      $html .= "<td>".$camara[2]."</td>";
	  $html .= "</tr>";
	  $html .= "<tr>";
	      $html .= "<td>Usuario:</td>";
	      $html .= "<td>".$camara[3]."</td>";
	  $html .= "</tr>";
	  $html .= "<tr>";
	      $html .= "<td>Email:</td>";
	      $html .= "<td>".$camara[4]."</td>";
	  $html .= "</tr>";
	  $html .= "</table>";
	  $html .= "</br>";
	  
	  $firstMail = $camara[4];
	  
      }else{
	  $html .= "<table>";
	  $html .= "<tr>";
	      $html .= "<td>Mac:</td>";
	      $html .= "<td>".$camara[1]."</td>";
	  $html .= "</tr>";
	  $html .= "<tr>";
	      $html .= "<td>Nombre:</td>";
	      $html .= "<td>".$camara[2]."</td>";
	  $html .= "</tr>";
	  $html .= "<tr>";
	      $html .= "<td>Usuario:</td>";
	      $html .= "<td>".$camara[3]."</td>";
	  $html .= "</tr>";
	  $html .= "<tr>";
	      $html .= "<td>Email:</td>";
	      $html .= "<td>".$camara[4]."</td>";
	  $html .= "</tr>";
	$html .= "</table>";
	$html .= "</br>";
	
	$firstMail = $camara[4];
	
      }
      
      $lastCamaraId = $camara[0]; 
}

if (strlen($html) > 1){
    $html = "<table><tr><td>Los siguientes dispositivos no reportan informaci&oacute;n:<td></tr></table></br>".$html;
    
    //Envio el ultimo mail
    //$to = "$firstMail";
    //$subject = "Reporte de servicio";
    //send_mail_custom($to,$subject,$html);
    
    //Lo marcamos como enviado
    ejecutar("CALL set_send_mail(".$lastCamaraId.");");
    
    $line = 'Se envio mail a: '.$firstMail.chr(13);
    file_put_contents("/var/www/html/dis.dev/service/".$file, $line, FILE_APPEND | LOCK_EX);

}

$line = 'Fecha: '.date('d-m-y H:i:s').chr(13);
$line .= '************************* fin *****************************'.chr(13);
file_put_contents("/var/www/html/dis.dev/service/".$file, $line, FILE_APPEND | LOCK_EX);
exit();


?>
