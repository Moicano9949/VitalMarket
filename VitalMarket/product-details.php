<?php
session_start();
include 'CONEXION/conexion.php';

if (!isset($_SESSION['id'])) {
    header("Location: Login.php");
    exit();
}
if (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] !== 'on') {
    $redirectUrl = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header("Location: $redirectUrl");
    exit();
}
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
$conn->set_charset("utf8");

if (isset($_GET['id'])) {
    $product_id = $_GET['id'];
    $sql = "SELECT id, nombre, descripcion, precio, stock, categoria, fecha_creacion, imagen FROM productos WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $product = $result->fetch_assoc();
        if (!$product) {
            echo "Producto no encontrado.";
            exit();
        }
    } else {
        echo "Error en la consulta: " . $conn->error;
        exit();
    }
} else {
    echo "ID de producto no especificado.";
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="description" content="Detalles del producto">
    <meta http-equiv="Content-Security-Policy" content="frame-ancestors 'none';">
    <meta http-equiv="X-Content-Type-Options" content="nosniff">
    <meta name="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="IMG/VitalMarket-Vk.png" type="image/png">
    <link rel="stylesheet" href="css/Home.css">
    <title>Detalles del Producto</title>
</head>
<body>
    <header>
        <h1>VitalMarket</h1>
        <div class="navbar">
            <a href="Home.php" class="active">Inicio</a>
            <a href="Wallet.php">Billetera</a>
            <a href="Categories.php">Categorías</a>
            <a href="Offers.php">Ofertas</a>
            <a href="account.php">Mi Cuenta</a>
        </div>
    </header>
    <div class="content">
        <h2><?php echo $product['nombre']; ?></h2>
        <div class="product-details">
            <div class="product-image">
                <?php if ($product['imagen']) { ?>
                    <img src="<?php echo $product['imagen']; ?>" alt="<?php echo $product['nombre']; ?>">
                <?php } else { ?>
                    <div class="no-image">Imagen no disponible</div>
                <?php } ?>
            </div>
            <div class="product-info">
                <p><strong>Descripción:</strong> <?php echo $product['descripcion']; ?></p>
                <p><strong>Precio:</strong> $<?php echo number_format($product['precio'], 2); ?></p>
                <p><strong>Stock:</strong> <?php echo $product['stock']; ?></p>
                <p><strong>Categoría:</strong> <?php echo $product['categoria']; ?></p>
                <p><strong>Fecha de Creación:</strong> <?php echo $product['fecha_creacion']; ?></p>
                <button class="add-to-cart">Agregar al carrito</button>
                <button class="buy-now">Comprar</button>
            </div>
        </div>
    </div>
    <footer>
        <p>© 2024 VitalMarket. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
