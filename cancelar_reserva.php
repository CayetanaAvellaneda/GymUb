<?php
require_once 'includes/db.php'; // Cambia la ruta si es necesario
session_start();

if (!isset($_SESSION['usuario_id'])) {
    echo "<p>Acceso restringido. Redirigiendo a la página de inicio de sesión...</p>";
    echo "<meta http-equiv='refresh' content='2;url=login.php'>";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $reserva_id = intval($_POST['reserva_id']); // ID de la reserva a cancelar

    // Obtener información de la reserva y la clase
    $sql = "SELECT r.clase_id, c.nombre_clase, c.horario, u.correo 
            FROM reservas r
            JOIN clases c ON r.clase_id = c.id
            JOIN usuarios u ON r.usuario_id = u.id
            WHERE r.id = $reserva_id";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $clase_id = $row['clase_id'];
        $nombre_clase = $row['nombre_clase'];
        $horario = $row['horario'];
        $correo_usuario = $row['correo'];

        // Eliminar la reserva
        $delete_sql = "DELETE FROM reservas WHERE id = $reserva_id";
        if ($conn->query($delete_sql)) {
            // Incrementar el cupo disponible en la clase asociada
            $update_sql = "UPDATE clases SET cupo = cupo + 1 WHERE id = $clase_id";
            if ($conn->query($update_sql)) {
                // Enviar correo de notificación
                $asunto = "Cancelación de Reserva - $nombre_clase";
                $mensaje = "Hola,\n\nTu reserva para la clase '$nombre_clase' programada a las $horario ha sido cancelada exitosamente.\n\nGracias por usar nuestro servicio.";
                $cabeceras = "From: gimnasio@example.com";

                if (mail($correo_usuario, $asunto, $mensaje, $cabeceras)) {
                    echo "<p>Reserva cancelada exitosamente. Se ha enviado una notificación a tu correo. Redirigiendo...</p>";
                } else {
                    echo "<p>Reserva cancelada exitosamente, pero no se pudo enviar la notificación por correo. Redirigiendo...</p>";
                }
            } else {
                echo "<p>Error al actualizar los cupos disponibles. Redirigiendo...</p>";
            }
        } else {
            echo "<p>Error al cancelar la reserva. Redirigiendo...</p>";
        }
    } else {
        echo "<p>No se encontró la reserva. Redirigiendo...</p>";
    }
    echo "<meta http-equiv='refresh' content='2;url=clases.php'>";
}
?>
