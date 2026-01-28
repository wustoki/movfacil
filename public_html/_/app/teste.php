<?php
include_once "../classes/send_mail.php";
$mail = new enviaEmail();
$email = "lipscellplay@gmail.com";
$msg = "Teste de envio de email";
$assunto = "Teste de envio de email";
echo $mail->sendEmail($email, $assunto, $msg);
?>