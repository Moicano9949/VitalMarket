<?php
session_start();
include 'CONEXION/conexion.php'; // Asegúrate de que esta ruta sea correcta

if (!isset($_SESSION['id'])) {
    header("Location: Login.php");
    exit();
}
// Redirigir automáticamente de HTTP a HTTPS
if (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] !== 'on') {
    $redirectUrl = "https://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    header("Location: $redirectUrl");
    exit();
}
// Crear conexión directamente desde el archivo de conexión
$conn = new mysqli($servername, $username, $password, $dbname);
// Verificar conexión
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// Establecer el conjunto de caracteres
$conn->set_charset("utf8"); // Cambia 'utf-8' a 'utf8'
// Consulta para obtener los productos
$sql = "SELECT nombre, descripcion, precio, imagen FROM productos";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="description" content="Bienvenido a VitalMarket. Descubre nuestros servicios y productos.">
    <meta http-equiv="Content-Security-Policy" content="frame-ancestors 'none';">
    <meta http-equiv="X-Content-Type-Options" content="nosniff">
    <meta name="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="IMG/VitalMarket-Vk.png" type="image/png">
    <title>VitalMarket - Inicio</title>
<style>
body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f2f2f2;
            scrollbar-width: thin;
            scrollbar-color: #007bff #f3f3f3;
        }

        body::-webkit-scrollbar {
            width: 10px;
        }

        body::-webkit-scrollbar-thumb {
            background-color: #007bff;
            border-radius: 10px;
        }

        body::-webkit-scrollbar-track {
            background-color: #f3f3f3;
        }

        header {
            text-align: center;
            padding: 20px;
            background-color: #007bff;
            position: fixed;
            width: 100%;
            top: 0;
            z-index: 1000;
        }

        h1 {
            color: #fff;
            margin: 0;
        }

        .navbar {
            display: flex;
            justify-content: center;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            position: fixed;
            top: 80px;
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
            border-bottom: 2px solid #004080; /* Línea azul en la parte inferior */
        }

        .search-box {
            position: absolute;
            top: 20px;
            right: 20px;
            display: flex;
            align-items: center;
        }

        .search-input {
            padding: 10px;
            border: 1px solid #ced4da;
            border-radius: 6px;
            margin-right: 10px;
            font-size: 16px;
            width: 200px;
        }

        .cart-btn {
            background: none;
            border: none;
            cursor: pointer;
            font-size: 20px;
            color: #007bff;
            transition: color 0.3s ease;
        }

        .cart-btn:hover {
            color: #004080;
        }

        .textos {
            text-align: center;
            margin-bottom: 20px;
            color: #007bff;
        }

        .logout-btn:hover {
            background: linear-gradient(to bottom, #c82333, #bd2130);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media only screen and (max-width: 600px) {
            .search-box {
                margin-left: auto;
                margin-right: auto;
                width: 70%;
            }
        }

        .content {
            padding: 120px 20px 20px; /* Ajusta el padding superior para que no se superponga con la cabecera fija */
            height: calc(100vh - 120px); /* Ajusta la altura para que ocupe el espacio restante */
            overflow-y: auto; /* Permite el desplazamiento vertical */
        }

        .product-list {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            justify-content: center;
        }

        .product {
            border: 1px solid #ccc;
            border-radius: 8px;
            background-color: white;
            padding: 10px;
            text-align: center;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-height: 300px; /* Ajusta según sea necesario */
        }

        .product-image {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 10px;
        }

        .product-image img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
        }

        .product-info {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .product h3, .product .description, .product .price, .add-to-cart {
            margin: 10px 0;
        }

        .product:hover {
            transform: scale(1.05);
        }

        .add-to-cart {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
            border-radius: 5px;
        }

        .add-to-cart:hover {
            background-color: #218838;
        }

        .no-image {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 150px;
            background-color: #f0f0f0;
            color: #888;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        footer {
            text-align: center;
            padding: 10px 0;
            background-color: #007bff;
            color: white;
        }
</style>
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
        <div class="search-box">
            <input type="text" class="search-input" placeholder="Buscar...">
            <button class="cart-btn">🛒</button>
        </div>
    </header>

    <div class="content">
        <h2 class="textos">Productos Destacados</h2>
        <div class="product-list">
            <?php
            if ($result->num_rows > 0) {
                // Mostrar productos de la base de datos
                while($row = $result->fetch_assoc()) {
                    echo "<div class='product'>";
                    echo "<div class='product-image'>";
                    if (!empty($row['imagen'])) {
                        echo "<img src='IMG/" . htmlspecialchars($row['imagen']) . "' alt='" . htmlspecialchars($row['nombre']) . "' onerror='this.style.display=\"none\"'>";
                    } else {
                        echo "<div class='no-image'>Imagen no disponible</div>";
                    }
                    echo "</div>";
                    echo "<div class='product-info'>";
                    echo "<h3>" . htmlspecialchars($row['nombre']) . "</h3>";
                    echo "<p class='price'>Precio: $" . htmlspecialchars($row['precio']) . "</p>";
                    echo "<button class='add-to-cart'>Agregar al Carrito</button>";
                    echo "</div>";
                    echo "</div>";
                }
            } else {
                echo "<p>No hay productos disponibles.</p>";
            }
            $conn->close();
            ?>
        </div>
    </div>

    <footer>
        <p>© 2024 VitalMarket. Todos los derechos reservados.</p>
    </footer>
</body>
