<?php
//Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once __DIR__ . '/../PHPMailer/Exception.php';
require_once __DIR__ . '/../PHPMailer/PHPMailer.php';
require_once __DIR__ . '/../PHPMailer/SMTP.php';

//Create an instance; passing true enables exceptions
$mail = new PHPMailer(true);

//Generate a random verification code
$CodigoVerificar = rand(100000, 999999);

try {
    //Server settings
    $mail->SMTPDebug = 1;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;  
    $mail->SMTPSecure = 'tls';                             //Enable SMTP authentication
    $mail->Username   = 'enriquebarahonayt14@gmail.com';                     //SMTP username
    $mail->Password   = 'fulu kzft lgts kvte';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS

    //Recipients
    $mail->setFrom('enriquebarahonayt14@gmail.com', 'Hector');
    $mail->addAddress('enriquebarahonayt14@gmail.com', 'Joe User');     //Add a recipient          
    // $mail->addReplyTo('info@example.com', 'Information');
    // $mail->addCC('cc@example.com');
    // $mail->addBCC('bcc@example.com');

    //Attachments
    // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
   // $mail->addAttachment('../Resources/uploads/joyas/233dae4288a42287e07e5e64043a2828.jpg', 'Imagen');    //Optional name

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Verificacion de Codigo';
    $mail->Body    = 'Ingrese el código para habilitar al Cliente Mayorista: ' . $CodigoVerificar;

    $mail->send();
    echo 'Enviado correctamente. Código de verificación: ' . $CodigoVerificar;
} catch (Exception $e) {
    echo "Error al enviar: {$mail->ErrorInfo}";
}
?>