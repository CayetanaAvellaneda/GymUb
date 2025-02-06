<?php
session_start();
include 'includes/db.php';

$mensaje = ""; // Variable para mostrar errores o éxito

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['login'])) {
    $correo = trim($_POST['correo']);
    $contrasena = trim($_POST['contrasena']);

    // Preparar consulta segura con prepared statements
    $sql = "SELECT id, nombre, contrasena FROM usuarios WHERE correo = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verificar si el usuario existe
    if ($result->num_rows > 0) {
        $usuario = $result->fetch_assoc();
        if (password_verify($contrasena, $usuario['contrasena'])) {
            // Iniciar sesión
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['usuario_nombre'] = $usuario['nombre'];

            // Redirigir
            header("Location: index.php");
            exit;
        } else {
            $mensaje = "⚠️ Contraseña incorrecta.";
        }
    } else {
        $mensaje = "⚠️ Correo no registrado.";
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login.css">
    <title>Iniciar Sesión</title>
</head>
<body>
    <form action="login.php" method="post">
        <h2>Iniciar Sesión</h2>
        <?php if (!empty($mensaje)) : ?>
            <div class="mensaje-error"><?= $mensaje ?></div>
        <?php endif; ?>
        <input type="email" name="correo" placeholder="Correo Electrónico" required>
        <input type="password" name="contrasena" placeholder="Contraseña" required>
        <button type="submit" name="login">Entrar</button>
    </form>
    <a href="register.php" class="registrarse">Registrarse</a>
    <a href="index.php" class="volver">Volver</a>
</body>
</html>
