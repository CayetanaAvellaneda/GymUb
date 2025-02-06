<?php
require_once('includes/db.php');
session_start();

if (!isset($_SESSION['usuario_id'])) {
    echo "<p>Acceso restringido. Redirigiendo a la página de inicio de sesión...</p>";
    echo "<meta http-equiv='refresh' content='2;url=login.php'>";
    exit();
}

$usuario_id = $_SESSION['usuario_id'];
$tipo_membresia = $_POST['tipo_membresia'];

// Guardar membresía en la base de datos
$sql = "INSERT INTO membresias (usuario_id, tipo_membresia, fecha_compra) VALUES (?, ?, NOW())";
$stmt = $conn->prepare($sql);
$stmt->bind_param("is", $usuario_id, $tipo_membresia);

if ($stmt->execute()) {
    echo "<p>Membresía adquirida con éxito. Redirigiendo...</p>";
    echo "<meta http-equiv='refresh' content='2;url=membresias.php'>";
} else {
    echo "<p>Error al procesar la compra. Inténtalo de nuevo más tarde.</p>";
}

$stmt->close();
$conn->close();
?>
