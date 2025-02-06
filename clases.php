<?php include 'includes/db.php'; ?>
<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    echo "<p>Acceso restringido. Redirigiendo a la página de inicio de sesión...</p>";
    echo "<meta http-equiv='refresh' content='2;url=login.php'>";
    exit();
}

$usuario_id = $_SESSION['usuario_id'];
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Clases Disponibles</title>
</head>
<body>
    <header>
        <h1>Clases Disponibles</h1>
    </header>
    <main>
        <!-- Tabla de clases disponibles -->
        <h2>Reservar Clase</h2>
        <table>
            <thead>
                <tr>
                    <th>Clase</th>
                    <th>Horario</th>
                    <th>Cupos Disponibles</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM clases";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['nombre_clase']}</td>
                                <td>{$row['horario']}</td>
                                <td>{$row['cupo']}</td>
                                <td>
                                    <form action='reserva_clases.php' method='post'>
                                        <input type='hidden' name='clase_id' value='{$row['id']}'>
                                        <button type='submit'>Reservar</button>
                                    </form>
                                </td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No hay clases disponibles.</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- Tabla de reservas activas -->
        <h2>Mis Reservas</h2>
        <table>
            <thead>
                <tr>
                    <th>Clase</th>
                    <th>Horario</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $reservas = $conn->query("SELECT r.id AS reserva_id, c.nombre_clase, c.horario
                                          FROM reservas r
                                          INNER JOIN clases c ON r.clase_id = c.id
                                          WHERE r.usuario_id = $usuario_id");

                if ($reservas->num_rows > 0) {
                    while ($reserva = $reservas->fetch_assoc()) {
                        echo "<tr>
                                <td>{$reserva['nombre_clase']}</td>
                                <td>{$reserva['horario']}</td>
                                <td>
                                    <form action='cancelar_reserva.php' method='post'>
                                        <input type='hidden' name='reserva_id' value='{$reserva['reserva_id']}'>
                                        <button type='submit'>Cancelar</button>
                                    </form>
                                </td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>No tienes reservas activas.</td></tr>";
                }
                ?>
            </tbody>
        </table>

        <!-- Enlace al historial de reservas -->
        <a href="historial_reservas.php">Ver historial de reservas</a>
        
    </main>
</body>
</html>
