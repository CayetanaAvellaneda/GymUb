<?php include 'includes/db.php'; ?>
<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    echo "<p>Acceso restringido. Redirigiendo a la página de inicio de sesión...</p>";
    echo "<meta http-equiv='refresh' content='2;url=login.php'>";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $clase_id = $_POST['clase_id'];
    $usuario_id = $_SESSION['usuario_id'];

    // Verificar si hay cupo disponible
    $sql = "SELECT * FROM clases WHERE id = $clase_id";
    $result = $conn->query($sql);
    $clase = $result->fetch_assoc();

    if ($clase['cupo'] > 0) {
        // Registrar la reserva
        $sql_reserva = "INSERT INTO reservas (usuario_id, clase_id) VALUES ($usuario_id, $clase_id)";
        $conn->query($sql_reserva);

        // Reducir el cupo de la clase
        $sql_update_cupo = "UPDATE clases SET cupo = cupo - 1 WHERE id = $clase_id";
        $conn->query($sql_update_cupo);

        // Obtener el correo del usuario
        $sql_usuario = "SELECT correo FROM usuarios WHERE id = $usuario_id";
        $result_usuario = $conn->query($sql_usuario);
        $usuario = $result_usuario->fetch_assoc();
        $correo_usuario = $usuario['correo'];

        // Enviar el correo
        $asunto = "Confirmación de Reserva";
        $mensaje = "Hola,\n\nTu reserva para la clase de {$clase['nombre_clase']} el día {$clase['horario']} ha sido confirmada.\n\n¡Gracias por usar nuestro gimnasio!";
        $encabezados = "From: tuemail@gmail.com";

        if (mail($correo_usuario, $asunto, $mensaje, $encabezados)) {
            echo "<p>Reserva realizada con éxito. Notificación enviada por correo. Redirigiendo...</p>";
        } else {
            echo "<p>Reserva realizada con éxito, pero no se pudo enviar la notificación por correo. Redirigiendo...</p>";
        }
        echo "<meta http-equiv='refresh' content='2;url=clases.php'>";
    } else {
        echo "<p>No hay cupo disponible para esta clase. Redirigiendo...</p>";
        echo "<meta http-equiv='refresh' content='2;url=clases.php'>";
    }
} else {
    echo "<p>Acceso no permitido. Redirigiendo...</p>";
    echo "<meta http-equiv='refresh' content='2;url=clases.php'>";
}
?>
