<?php
require_once 'includes/db.php';
session_start();

if (!isset($_SESSION['usuario_id'])) {
    echo "<p>Acceso restringido. Redirigiendo a la página de inicio de sesión...</p>";
    echo "<meta http-equiv='refresh' content='2;url=login.php'>";
    exit();
}

$usuario_id = $_SESSION['usuario_id'];
$sql = "SELECT r.id, c.nombre_clase, c.horario, r.estado 
        FROM reservas r
        JOIN clases c ON r.clase_id = c.id
        WHERE r.usuario_id = $usuario_id";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Historial de Reservas</title>
</head>
<body>
    <header>
        <h1>Historial de Reservas</h1>
    </header>
    <main>
        <table>
            <thead>
                <tr>
                    <th>Clase</th>
                    <th>Horario</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<tr>
                                <td>{$row['nombre_clase']}</td>
                                <td>{$row['horario']}</td>
                                <td>{$row['estado']}</td>
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='3'>No tienes reservas realizadas.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </main>
</body>
</html>
