<?php
$servername = "localhost";
$username = "root"; // Cambia si tienes otro usuario
$password = "";     // Cambia si tu contraseña no está vacía
$dbname = "clasificacion_arancelaria"; // Cambia al nombre real de tu base

// Crear la conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
