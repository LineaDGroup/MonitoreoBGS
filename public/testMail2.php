<?php
require 'phpMailer/PHPMailerAutoload.php';

function enviarCorreo($mailFrom, $nombreFrom, $mailTo, $nombreTo, $mailReply, $nombreReply, $asunto, $cuerpo, $adjunto = '', $mail1 = false)
{
	$mail = new PHPMailer;

	$mail->setFrom($mailFrom, "BioBarica");
	$mail->Helo = "www.camara-hiperbarica-biobarica.com";
	
	$mail->SMTPAuth=true;
	$mail->Host="smtp.biobarica.com";
	$mail->Port=25; //depende de lo que te indique tu ISP. El default es 25, pero nuestro ISP lo tiene puesto al 26
	$mail->Username="information@biobarica.com";
	$mail->Password="biobarica2017@";
	
	
	/*$mail->SMTPAuth=true;
	$mail->Host="smtp.biobarica.com";
	$mail->Port=25; //depende de lo que te indique tu ISP. El default es 25, pero nuestro ISP lo tiene puesto al 26
	$mail->Username="information@biobarica.com";
	$mail->Password="biobarica2017@";
	*/
	
	/*
	$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'ssl://email-smtp.us-west-2.amazonaws.com';  // Specify main and backup SMTP servers

$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'AKIAJGKDVGBKQTRQQZFA';                 // SMTP username
$mail->Password = 'AkXFObOYVR7CoyBotHv9t41HzAf3KisHBByPVOX2rydM';                           // SMTP password


$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 443;
	
	*/
	
	
	/*
	$mail->SMTPAuth = true;
		$mail->SMTPSecure = "ssl"; 
		$mail->Username = 'notificaciones@soldati.com';
		$mail->Password = 'notificacionesweb';
		$mail->Host = 'smtp.gmail.com'; // SMTP server
		$mail->Port = 465; // set the SMTP port
	
	*/
	$mail->addAddress($mailTo, $nombreTo);     // Add a recipient
	$mail->addReplyTo($mailReply, $nombreReply);
		//$mail->addBCC('ivo.teler@biobarica.com');
		#$mail->addCC('malena.vidal@biobarica.com');
		//$mail->addBCC('scolombo@exediait.com');

	
	//$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name
	$mail->isHTML(true);                                  // Set email format to HTML

	$mail->Subject = ($asunto);
	
	
	if (strpos($mailTo, 'hotmail'))
		$cuerpo = utf8_decode($cuerpo);
	
	$mail->Body    = $cuerpo;

	//$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

	//$result = $mail->send();
	//return $result;
	
	
	if(!$mail->Send()) {
  echo 'Message was not sent.';
  echo 'Mailer error: ' . $mail->ErrorInfo;
   return false;
} else {
 echo 'Message has been sent.';
  return true; 
}
}

enviarCorreo("information@biobarica.com", "BioBarica", "susmajestades@gmail.com", "Chris", "information@biobarica.com", "BioBarica", "test", "hola mundo 33332", "");
?>