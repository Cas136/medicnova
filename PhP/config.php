<?php
$host = "localhost";
$user = "root";   // tu usuario de XAMPP
$pass = "";       // si tienes contraseña cámbiala
$db   = "medic";

// Crear conexión
$conn = new mysqli($host, $user, $pass, $db);

// Verificar conexión
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}
?>
