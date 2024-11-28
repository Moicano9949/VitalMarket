<?php
session_start();
include 'CONEXION/conexion.php';

if (!isset($_SESSION['id'])) {
    echo "Debes iniciar sesión.";
    exit();
}

$user_id = $_SESSION['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove'])) {
    $product_name = $_POST['product_name'];
    $sql = "DELETE FROM carrito WHERE user_id = ? AND nombre = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $user_id, $product_name);
    $stmt->execute();
    echo "Producto eliminado";
    exit();
}

$sql = "SELECT id, nombre, precio, imagen FROM carrito WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<div class='cart-item'>";

        // Envolver la imagen en un enlace para redirigir a la página de detalles del producto
        echo "<a href='product-details.php?id=" . $row['id'] . "'>";
        if ($row['imagen']) {
            echo "<img src='" . $row['imagen'] . "' alt='" . $row['nombre'] . "' class='cart-item-img'>";
        }
        echo "</a>";

        // Envolver el nombre del producto en un enlace para redirigir
        echo "<div class='cart-item-details'>";
        echo "<a href='product-details.php?id=" . $row['id'] . "' class='cart-item-name'>" . $row['nombre'] . "</a>";
        echo "<p class='cart-item-price'>$" . number_format($row['precio'], 2) . "</p>";
        echo "<button class='remove-item' data-name='" . $row['nombre'] . "'>x</button>";
        echo "</div>";

        echo "</div>";
    }
} else {
    echo "<p>Tu carrito está vacío.</p>";
}
?>
