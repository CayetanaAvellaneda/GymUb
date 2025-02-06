<?php include 'includes/db.php'; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/register.css">
    <title>Registrarse</title>
</head>
<body>
    <form action="register.php" method="post">
        <h2>Registrarse</h2>
        <input type="text" name="dni" placeholder="DNI" required>
        <input type="text" name="nombre" placeholder="Nombre Completo" required>
        <input type="email" name="correo" placeholder="Correo Electrónico" required>
        <input type="password" name="contrasena" placeholder="Contraseña" required>
        <button type="submit" name="register">Registrarse</button>
    </form>
    <?php
    if (isset($_POST['register'])) {
        $dni = $_POST['dni'];
        $nombre = $_POST['nombre'];
        $correo = $_POST['correo'];
        $contrasena = password_hash($_POST['contrasena'], PASSWORD_BCRYPT);

        $sql = "INSERT INTO usuarios (dni, nombre, correo, contrasena) VALUES ('$dni', '$nombre', '$correo', '$contrasena')";
        if ($conn->query($sql) === TRUE) {
            echo "<p>Registro exitoso.</p>";
        } else {
            echo "<p>Error: " . $conn->error . "</p>";
        }
    }
    ?>
    <a href="login.php" class="iniciar-sesion">Iniciar Sesión</a>
    <a href="index.php" class="volver">Volver</a>

</body>
</html>
