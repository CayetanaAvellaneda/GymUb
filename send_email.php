<?php
// Incluye el autoload de Composer
require 'vendor/autoload.php';

// Define tu API Key de SendGrid
$sendgridApiKey = 'TU_API_KEY';  // Reemplaza con tu API Key de SendGrid

// Crea una instancia del cliente SendGrid
$sendgrid = new \SendGrid($sendgridApiKey);

// Crea el mensaje de correo
$email = new \SendGrid\Mail\Mail(); 
$email->setFrom("gym@example.com", "Gimnasio");
$email->setSubject("Confirmación de reserva");
$email->addTo("usuario@example.com", "Usuario");  // Reemplaza con el correo del usuario
$email->addContent("text/plain", "Tu reserva para la clase ha sido confirmada.");

// Enviar el correo
try {
    $response = $sendgrid->send($email);
    echo "Notificación enviada con éxito.";
} catch (Exception $e) {
    echo 'Error al enviar el correo: ' . $e->getMessage();
}
?>
