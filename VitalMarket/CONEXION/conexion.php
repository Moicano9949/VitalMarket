<?php
$servername = "sql109.infinityfree.com";
$username = "if0_37584007";
$password = "b9N9NOJLb0";
$dbname = "if0_37584007_db_vitalmarket";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Establecer el conjunto de caracteres
$conn->set_charset("utf8"); // Cambia 'utf-8' a 'utf8'

?>
