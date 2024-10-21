<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../libraries/PHPMailer-master/src/Exception.php';
require '../libraries/PHPMailer-master/src/PHPMailer.php';
require '../libraries/PHPMailer-master/src/SMTP.php';

$mail = new PHPMailer(true);
try {
    // Configuración del servidor SMTP
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com'; // Cambia esto por tu servidor SMTP
    $mail->SMTPAuth = true;
    $mail->Username = 'carlosbertomeu44@gmail.com'; // Cambia esto por tu correo
    $mail->Password = 'djtu nctv wdoj zanf'; // Cambia esto por tu contraseña
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    // Configuración del correo
    $mail->setFrom('carlosbertomeu44@gmail.com', 'MadKoi'); // Cambia esto por tu correo y nombre
    $mail->addAddress($email, $nombre);

    $mail->isHTML(true);
    $mail->Subject = 'Bienvenido a nuestra tienda';
    $mail->Body = "<h1>Hola, $nombre</h1><p>Gracias por registrarte en nuestra tienda.</p>";

    $mail->send();
    echo "Correo de bienvenida enviado.";
} catch (Exception $e) {
    echo "Error al enviar el correo: {$mail->ErrorInfo}";
}