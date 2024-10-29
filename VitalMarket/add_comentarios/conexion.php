<?php
$servername = "localhost";
$username = "SoyEl_Admin-de phpmy";
$password = "E8k!69bu3upIjGua";
$dbname = "data_base";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);
$conn->set_charset("utf-8");

// Verificar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function formatearfecha($fecha){
    return date('g:i a', strtotime($fecha));
}

?>