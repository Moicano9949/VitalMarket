<?php
session_start();
include 'CONEXION/conexion.php';

if (!isset($_SESSION['id'])) {
    header("Location: Login.php");
    exit();
}
$user_id = $_SESSION['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['remove'])) {
        $product_name = $_POST['remove']; // Se obtiene el nombre del producto a eliminar
        $sql = "DELETE FROM carrito WHERE user_id = ? AND nombre = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $user_id, $product_name);
        $stmt->execute();
    } elseif (isset($_POST['update'])) {
        $product_name = $_POST['product_name'];
        $quantity = $_POST['quantity'];
        $sql = "UPDATE carrito SET cantidad = ? WHERE user_id = ? AND nombre = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iis", $quantity, $user_id, $product_name);
        $stmt->execute();
    }
    header("Location: cart-c.php");
    exit();
}

$sql = "SELECT nombre, precio, imagen, cantidad FROM carrito WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Carrito de Compras</title>
    <style>
/* Estilo general del cuerpo */
body {
    margin: 0;
    padding: 0;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background-color: #f2f2f2;
    scrollbar-width: thin;
    scrollbar-color: #007bff #f3f3f3;
}

/* Estilo del encabezado */
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

/* Barra de navegación */
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

/* Contenedor principal */
.container {
    max-width: 800px;
    margin: 20px auto;
    padding: 20px;
    background-color: #fff;
    border-radius: 5px;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    margin-top: 160px;
}

h2 {
    color: #333;
    text-align: center;
}

/* Estilos para los elementos del carrito */
.cart-item {
    display: flex;
    margin: 20px 0;
    border-bottom: 1px solid #ddd;
    padding-bottom: 20px;
}

.cart-item-img-wrapper {
    margin-right: 20px;
    text-align: center;
}

.cart-item-img {
    max-width: 80px;
    max-height: 80px;
    border-radius: 5px;
}

.cart-item-details {
    flex: 1;
}

.cart-item-name {
    font-size: 1.2em;
    font-weight: bold;
    margin: 0 0 10px;
}

.cart-item-price {
    font-size: 1em;
    color: #888;
}

/* Estilos para el total y los botones */
.cart-total {
    font-size: 1.5em;
    text-align: right;
    margin-top: 20px;
}

input[type="number"] {
    width: 50px;
    padding: 5px;
    font-size: 1em;
}

button {
    background-color: #007bff;
    color: #fff;
    border: none;
    padding: 8px 12px;
    cursor: pointer;
    font-size: 1em;
    border-radius: 5px;
    margin: 5px 0;
}

button:hover {
    background-color: #004080;
}

.checkout-button {
    display: inline-block;
    background-color: #28a745;
    color: #fff;
    padding: 12px 20px;
    text-align: center;
    text-decoration: none;
    font-size: 1.2em;
    border-radius: 5px;
    margin-top: 20px;
}

.checkout-button:hover {
    background-color: #218838;
}

/* Estilo del pie de página */
footer {
    text-align: center;
    padding: 10px;
    background-color: #007bff;
    color: #fff;
    margin-top: 20px;
}

/* Estilos responsivos */

/* Para pantallas más pequeñas */
@media (max-width: 768px) {
    .navbar {
        flex-direction: column;
        position: static;
        box-shadow: none;
        margin-top: 80px;
    }

    .navbar a {
        padding: 10px;
    }

    .container {
        margin-top: 0;
        padding: 15px;
    }

    .cart-item {
        flex-direction: column;
        align-items: center;
    }

    .cart-item-img-wrapper {
        margin-right: 0;
        margin-bottom: 10px;
    }

    .cart-item-img {
        max-width: 60px;
        max-height: 60px;
    }

    .cart-item-details {
        text-align: center;
    }

    .cart-item-name {
        font-size: 1em;
    }

    .cart-total {
        font-size: 1.2em;
    }

    .checkout-button {
        width: 100%;
        text-align: center;
    }
}

/* Para pantallas móviles */
@media (max-width: 480px) {
    h1 {
        font-size: 1.5em;
    }

    .cart-item {
        flex-direction: column;
        align-items: center;
        margin: 10px 0;
    }

    .cart-item-img {
        max-width: 50px;
        max-height: 50px;
    }

    input[type="number"] {
        width: 40px;
        padding: 3px;
    }

    button {
        padding: 6px 10px;
        font-size: 0.9em;
    }

    .checkout-button {
        font-size: 1em;
        padding: 10px 15px;
    }
}
    </style>
</head>
<body>
    <header>
        <h1>VitalMarket</h1>
        <div class="navbar">
            <a href="Home.php">Inicio</a>
            <a href="Wallet.php">Categorías</a>
            <a href="Categories.php">Ofertas</a>
            <a href="cart-c.php" class="active">Carrito</a>
            <a href="account.php">Mi Cuenta</a>
        </div>
    </header>

    <div class="container">
        <h2>Carrito de Compras</h2>
        <?php if ($result->num_rows > 0): ?>
            <form action="cart-c.php" method="POST">
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="cart-item">
                        <?php if ($row['imagen']): ?>
                            <div class="cart-item-img-wrapper">
                                <img src="<?php echo $row['imagen']; ?>" alt="<?php echo $row['nombre']; ?>" class="cart-item-img">
                                <p class="cart-item-price">$<?php echo number_format($row['precio'], 2); ?></p>
                            </div>
                        <?php endif; ?>
                        <div class="cart-item-details">
                            <p class="cart-item-name"><?php echo $row['nombre']; ?></p>
                            <label for="quantity-<?php echo $row['nombre']; ?>">Cantidad:</label>
                            <input type="number" name="quantity" id="quantity-<?php echo $row['nombre']; ?>" value="<?php echo $row['cantidad']; ?>" min="1">
                            <input type="hidden" name="product_name" value="<?php echo $row['nombre']; ?>">
                            <button type="submit" name="update" value="1">Actualizar</button>
                            <button type="submit" name="remove" value="<?php echo $row['nombre']; ?>">Eliminar</button>
                        </div>
                    </div>
                <?php endwhile; ?>
            </form>
            <div class="cart-total">
                <p>Total: $<?php // Calcula el total aquí ?></p>
            </div>
            <a href="checkout.php" class="checkout-button">Proceder al pago</a>
        <?php else: ?>
            <p>Tu carrito está vacío.</p>
        <?php endif; ?>
    </div>
    <footer>
        <p>© 2024 VitalMarket. Todos los derechos reservados.</p>
    </footer>
</body>
</html>
