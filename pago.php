<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    echo "<p>Acceso restringido. Redirigiendo a la página de inicio de sesión...</p>";
    echo "<meta http-equiv='refresh' content='2;url=login.php'>";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener la membresía seleccionada
    $tipo_membresia = $_POST['tipo_membresia'];
    $usuario_id = $_SESSION['usuario_id'];  // Suponiendo que el ID del usuario está en la sesión
    
    // Simulación del proceso de pago (no real)
    $pago_exitoso = true; // Puedes modificar esto para simular un fallo si lo deseas
    
    if ($pago_exitoso) {
        // Aquí va la lógica para enviar el correo de confirmación
        $email_usuario = 'usuario@dominio.com'; // Suponiendo que tienes el email del usuario

        // Enviar correo de confirmación (simulación)
        $asunto = "Confirmación de compra de membresía";
        $mensaje = "¡Gracias por tu compra! Has adquirido la membresía: $tipo_membresia.";
        $cabeceras = "From: gimnasio@dominio.com";
        
        if (mail($email_usuario, $asunto, $mensaje, $cabeceras)) {
            $mensaje_exito = "Compra realizada exitosamente. Te hemos enviado un correo de confirmación.";
        } else {
            $mensaje_exito = "Error al enviar el correo de confirmación.";
        }
    } else {
        $mensaje_error = "Error en el proceso de pago. Intenta nuevamente.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Formulario de Pago</title>
</head>
<body>
    <header>
        <h1>Completa tus Datos de Pago</h1>
    </header>
    <main>
        <section>
            <h2>Datos de Pago</h2>
            
            <!-- Mostrar mensaje de éxito o error -->
            <?php if (isset($mensaje_exito)): ?>
                <div class="mensaje-exito">
                    <p><?php echo $mensaje_exito; ?></p>
                </div>
            <?php endif; ?>
            <?php if (isset($mensaje_error)): ?>
                <div class="mensaje-error">
                    <p><?php echo $mensaje_error; ?></p>
                </div>
            <?php endif; ?>

            <form action="pago.php" method="POST">
                <input type="hidden" name="tipo_membresia" value="<?php echo $_POST['tipo_membresia']; ?>">

                <label for="card-number">Número de tarjeta</label>
                <input type="text" id="card-number" name="card-number" placeholder="XXXX XXXX XXXX XXXX" required>

                <label for="expiration">Fecha de vencimiento</label>
                <input type="text" id="expiration" name="expiration" placeholder="MM/AA" required>

                <label for="cvv">Código de seguridad (CVV)</label>
                <input type="text" id="cvv" name="cvv" placeholder="CVV" required>

                <button type="submit">Realizar Pago</button>
            </form>
        </section>
    </main>

    <footer>
        <p>&copy; 2024 GimnasioUb. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
