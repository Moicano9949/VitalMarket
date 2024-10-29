<?php
include_once($_SERVER['DOCUMENT_ROOT'] . '/VitalMarket/CONEXION/conexion.php');

// Función para agregar un producto
function agregarProducto($nombre, $descripcion, $precio, $stock, $categoria) {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO productos (nombre, descripcion, precio, stock, categoria) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdss", $nombre, $descripcion, $precio, $stock, $categoria);
    $stmt->execute();
    $stmt->close();
}

// Función para obtener productos
function obtenerProductos() {
    global $conn;
    $query = "SELECT * FROM productos";
    $result = $conn->query($query);
    $productos = [];
    while ($row = $result->fetch_assoc()) {
        $productos[] = $row;
    }
    return $productos;
}

// Función para actualizar un producto
function actualizarProducto($id, $nombre, $descripcion, $precio, $stock, $categoria) {
    global $conn;
    $stmt = $conn->prepare("UPDATE productos SET nombre=?, descripcion=?, precio=?, stock=?, categoria=? WHERE id=?");
    $stmt->bind_param("ssdssi", $nombre, $descripcion, $precio, $stock, $categoria, $id);
    $stmt->execute();
    $stmt->close();
}

// Función para eliminar un producto
function eliminarProducto($id) {
    global $conn;
    $stmt = $conn->prepare("DELETE FROM productos WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->close();
}
?>
