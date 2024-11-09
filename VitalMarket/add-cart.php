<?php
session_start();
include 'CONEXION/conexion.php';

if (!isset($_SESSION['id'])) {
    echo "Error: Debes estar logueado.";
    exit();
}

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    echo "Error de conexión: " . $conn->connect_error;
    exit();
}
$conn->set_charset("utf8");

// Recibir datos del formulario
$producto_id = $_POST['producto_id'];
$nombre = $_POST['nombre'];
$precio = $_POST['precio'];
$imagen = $_POST['imagen'];
$user_id = $_SESSION['id'];

// Consulta para insertar en la tabla "carrito"
$sql = "INSERT INTO carrito (user_id, producto_id, nombre, precio, imagen) VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iisss", $user_id, $producto_id, $nombre, $precio, $imagen);

if ($stmt->execute()) {
    echo "Producto agregado al carrito.";
} else {
    echo "Error: " . $conn->error;
}

$stmt->close();
$conn->close();
?>
