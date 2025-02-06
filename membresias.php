<?php 
session_start();
if (!isset($_SESSION['usuario_id'])) {
    echo "<p>Acceso restringido. Redirigiendo a la página de inicio de sesión...</p>";
    echo "<meta http-equiv='refresh' content='2;url=login.php'>";
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Membresías</title>
</head>
<body>
    <header>
        <h1>Compra tu Membresía</h1>
    </header>
    <main>
        <section>
            <h2>Opciones de Membresías</h2>
            <div class="membresias">
                <div class="membresia">
                    <h3>Básica</h3>
                    <p>Acceso limitado al gimnasio.</p>
                    <p>Precio: $20 USD/mes</p>
                    <form action="pago.php" method="POST">
                        <input type="hidden" name="tipo_membresia" value="Básica">
                        <button type="submit">Comprar</button>
                    </form>
                </div>
                <div class="membresia">
                    <h3>Premium</h3>
                    <p>Acceso completo y clases incluidas.</p>
                    <p>Precio: $50 USD/mes</p>
                    <form action="pago.php" method="POST">
                        <input type="hidden" name="tipo_membresia" value="Premium">
                        <button type="submit">Comprar</button>
                    </form>
                </div>
            </div>
        </section>
    </main>
    <footer>
        <p>&copy; 2024 GimnasioUb. Todos los derechos reservados.</p>
    </footer>
    

</body>
</html>
