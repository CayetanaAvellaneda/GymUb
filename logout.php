<?php
session_start();
session_destroy();
echo "<p>Cerrando sesión. Redirigiendo...</p>";
echo "<meta http-equiv='refresh' content='2;url=index.php'>";
?>
