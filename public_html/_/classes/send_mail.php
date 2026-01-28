<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class enviaEmail
{
    function sendEmail($email, $titulo, $msg)
    {

        //Load Composer's autoloader
        require $_SERVER["DOCUMENT_ROOT"] .  '/vendor/autoload.php';
        $host = $_SERVER['HTTP_HOST'];

        //Create an instance; passing `true` enables exceptions
        $mail = new PHPMailer(true);

        try {
            //Server settings
             //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
            $mail->isSMTP();                                            //Send using SMTP
            $mail->Host       = 'mail.wustoki.top';                     //Set the SMTP server to send through
            $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
            $mail->Username   = 'contato@wustoki.top';                     //SMTP username
            $mail->Password   = 'wustoki@1234';                               //SMTP password
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
            $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
            //To load the French version
            $mail->setLanguage('pt_br');
            $mail->CharSet = 'UTF-8';

            //Recipients
            $mail->setFrom('contato@wustoki.top', 'Wustoki');
            $mail->addAddress($email);     //Add a recipient
            // $mail->addAddress('ellen@example.com');               //Name is optional
            $mail->addReplyTo('contato@wustoki.top', 'Information');
            //$mail->addCC('contato@123mobi.com.br');   //envia cópia para outro email
            //  $mail->addBCC('bcc@example.com');

            //Content
            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = $titulo;
            $mail->Body    = $msg;
            // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

            $mail->send();
            // echo 'Message has been sent';

        } catch (Exception $e) {
              //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}
