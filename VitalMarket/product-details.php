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
    $sql = "SELECT id, nombre, descripcion, precio, stock, categoria, fecha_creacion FROM productos WHERE id = ?";
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

    // Obtener las imágenes del producto
    $sql_images = "SELECT ruta_imagen FROM imagenes_productos WHERE producto_id = ? AND es_principal = TRUE";
    $stmt_images = $conn->prepare($sql_images);
    $stmt_images->bind_param("i", $product_id);
    $stmt_images->execute();
    $result_images = $stmt_images->get_result();
    $images = [];
    while ($row = $result_images->fetch_assoc()) {
        $images[] = $row['ruta_imagen'];
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="IMG/VitalMarket-Vk.png" type="image/png">
    <title>Detalles del Producto</title>
</head>
<body>
    <header>
        <h1>VitalMarket</h1>
    </header>
    <div class="navbar">
        <a href="Home.php" class="active">Inicio</a>
        <a href="Wallet.php">Categorias</a>
        <a href="Categories.php">Ofertas</a>
        <a href="cart-c.php">Carrito</a>
        <a href="account.php">Mi Cuenta</a>
    </div>
    <div class="content">
        <h2><?php echo $product['nombre']; ?></h2>
        <div class="product-details">
            <div class="image-container">
                <?php if (isset($images[0])) { ?>
                    <img src="<?php echo $images[0]; ?>" alt="<?php echo $product['nombre']; ?>" class="responsive-image" onclick="openImage(0)">
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

    <!-- Ventana emergente para imagen grande -->
    <div id="overlay">
        <span class="close-btn" onclick="closeOverlay()">X</span>
        <img id="overlay-image" src="" alt="Imagen de producto">
        <div class="arrows">
            <span class="arrow" onclick="changeImage(-1)">&#60;</span>
            <span class="arrow" onclick="changeImage(1)">&#62;</span>
        </div>
    </div>

    <script>
        let images = <?php echo json_encode($images); ?>;
        let currentIndex = 0;

        // Abre la imagen en tamaño grande
        function openImage(index) {
            currentIndex = index;
            document.getElementById('overlay-image').src = images[currentIndex];
            document.getElementById('overlay').style.display = 'block';
        }

        // Cierra la ventana emergente
        function closeOverlay() {
            document.getElementById('overlay').style.display = 'none';
        }

        // Cambia la imagen
        function changeImage(direction) {
            currentIndex += direction;
            if (currentIndex < 0) {
                currentIndex = images.length - 1;
            } else if (currentIndex >= images.length) {
                currentIndex = 0;
            }
            document.getElementById('overlay-image').src = images[currentIndex];
        }
    </script>
    <style>
    /* Estilos generales */
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f2f2f2;
            scrollbar-width: thin;
            scrollbar-color: #007bff #f3f3f3;
        }

        /* Cabecera */
        header {
            text-align: center;
            padding: 20px;
            background-color: #007bff;
            color: #fff;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
        }

        h1 {
            margin: 0;
        }

        .navbar {
            display: flex;
            justify-content: center;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            position: fixed;
            top: 76px;
            left: 0;
            width: 100%;
            z-index: 100;
        }

        .navbar a {
            color: #007bff;
            text-decoration: none;
            padding: 15px;
            display: block;
            transition: color 0.3s ease;
        }

        .navbar a:hover,
        .navbar a.active {
            color: #004080;
            border-bottom: 2px solid #004080;
        }

        .content {
            max-width: 800px;
            margin: 150px auto 20px; /* Ajustar margen para header fijo */
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }

        h2 {
            text-align: center;
            color: #007bff;
        }

        .product-details {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .image-container {
            width: 100%;
            max-width: 400px;
            height: 300px;
            overflow: hidden;
            border-radius: 10px;
            margin: 20px 0;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .responsive-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease-in-out;
        }

        .responsive-image:hover {
            transform: scale(1.05);
        }

        .product-info p {
            margin: 10px 0;
        }

        .product-info p strong {
            color: #004080;
        }

        .add-to-cart, .buy-now {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            margin: 10px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        .add-to-cart:hover, .buy-now:hover {
            background-color: #0056b3;
        }

        footer {
            text-align: center;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
        /* Estilos para la ventana emergente de imagen */
        #overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.8);
            z-index: 1000;
        }
        #overlay img {
            max-width: 90%;
            max-height: 90%;
            margin: auto;
            display: block;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }
        .close-btn {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 2em;
            color: white;
            cursor: pointer;
        }
        .arrows {
            position: absolute;
            top: 50%;
            width: 100%;
            display: flex;
            justify-content: space-between;
        }
        .arrow {
            color: white;
            font-size: 2em;
            cursor: pointer;
            padding: 0 20px;
        }
        /* Resto de estilo */
        body {
            font-family: Arial, sans-serif;
        }
        .product-details {
            display: flex;
            justify-content: space-between;
            padding: 20px;
        }
        .image-container {
            width: 45%;
        }
        .product-info {
            width: 45%;
        }
        .responsive-image {
            width: 100%;
            cursor: pointer;
        }
    </style>
</body>
</html>
