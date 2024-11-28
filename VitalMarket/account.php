<?php
session_start();

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
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="description" content="Bienvenido a VitalMarket. Descubre nuestros servicios y productos.">
    <meta http-equiv="Content-Security-Policy" content="frame-ancestors 'none';">
    <meta http-equiv="X-Content-Type-Options" content="nosniff">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/account.css">
    <link rel="icon" href="IMG/VitalMarket-Vk.png" type="image/png">
    <title>VitalMarket - Mi Cuenta</title>

    <!-- Incluir jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <header>
        <h1>VitalMarket</h1>

        <div class="navbar">
            <a href="Home.php">Inicio</a>
            <a href="Wallet.php">Categorias</a>
            <a href="Categories.php">Ofertas</a>
            <a href="cart-c.php">Carrito</a>
            <a href="account.php" class="active">Mi Cuenta</a>
        </div>

        <div class="search-box">
            <input type="text" class="search-input" placeholder="Buscar...">
            <button class="cart-btn">🛒</button>
        </div>
    </header>

    <div class="account-info">
        <h2>Hola, <?php echo $_SESSION['usernombre']; ?>!</h2>

        <div class="config-section">
            <h3>Configuración</h3>
            <div class="config-item">
                <span>Correo Electrónico:</span>
                <span><?php echo $_SESSION['correo']; ?></span>
            </div>
        </div>

        <form method="POST" action="CONTROLL/sesion-destroy.php">
            <button type="submit" class="logout-btn" name="Logout">Cerrar Sesión</button>
        </form>
    </div>

    <!-- Menú flotante del carrito -->
    <div id="cart-menu" class="cart-menu">
        <h3>Tu Carrito</h3>
        <div id="cart-items">
            <!-- Aquí se mostrarán los productos del carrito con Ajax -->
        </div>
        <button id="close-cart" class="close-cart">Cerrar</button>
    </div>

    <a href="Home.php" style="position: fixed; bottom: 20px; right: 20px; background-color: #007bff; color: #fff; padding: 10px 20px; text-decoration: none; border-radius: 6px;">Volver a Inicio</a>

<script>
    $(document).ready(function() {
        // Mostrar el carrito al hacer clic en el ícono del carrito
        $(".cart-btn").click(function() {
            $("#cart-menu").toggleClass("show");  // Mostrar/ocultar el carrito
            loadCart(); // Cargar los productos del carrito
        });

        // Cerrar el carrito
        $("#close-cart").click(function() {
            $("#cart-menu").removeClass("show");
        });

        // Cargar los productos del carrito con Ajax
        function loadCart() {
            $.ajax({
                url: "cart.php",  // Archivo PHP que obtiene los productos del carrito
                method: "GET",
                success: function(response) {
                    $("#cart-items").html(response);  // Insertar productos en el carrito
                    attachRemoveHandlers();  // Adjuntar manejadores de eventos para eliminar productos
                }
            });
        }

        // Adjuntar manejadores de eventos para eliminar productos
        function attachRemoveHandlers() {
            $(".remove-item").click(function() {
                var productName = $(this).data("name");
                $.ajax({
                    url: "cart.php",
                    method: "POST",
                    data: { remove: true, product_name: productName },
                    success: function(response) {
                        loadCart();  // Recargar el carrito después de eliminar el producto
                    }
                });
            });
        }
    });
</script>

<!-- Estilos del carrito flotante -->
<style>
    /* Estilos para el carrito flotante */
    .cart-menu {
        display: none;
        position: fixed;
        top: 0;
        right: 0;
        width: 350px; /* Aumento de ancho para un carrito más espacioso */
        height: 100%;
        background-color: #fff;
        box-shadow: -2px 0 10px rgba(0, 0, 0, 0.2);
        padding: 20px;
        z-index: 1000;
        transition: transform 0.3s ease;
        transform: translateX(100%);
    }

    .cart-menu.show {
        display: block;
        transform: translateX(0);
    }

    /* Botón para cerrar el carrito (modificado para ser menos ovalado) */
    .close-cart {
        position: absolute;
        top: 20px;
        right: 20px;
        background-color: #ff4d4d;
        color: #fff;
        padding: 10px 15px; /* Se ajusta el padding para hacerlo menos ovalado */
        border: none;
        border-radius: 5px; /* Bordes redondeados suaves */
        cursor: pointer;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .close-cart:hover {
        background-color: #ff3333;
    }

    /* Estilo de los productos en el carrito */
    .cart-item {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
        padding: 10px;
        border-radius: 8px;
        background-color: #f9f9f9;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        transition: background-color 0.3s ease, transform 0.3s ease;
    }

    .cart-item:hover {
        background-color: #f1f1f1;
        transform: translateX(5px); /* Efecto de deslizamiento suave */
        text-decoration: underline;
    }

    /* Imagen del producto */
    .cart-item-img {
        width: 70px; /* Aumento de tamaño de la imagen */
        height: 70px;
        margin-right: 15px;
        object-fit: cover; /* Asegura que la imagen se ajuste bien */
        border-radius: 5px;
        cursor: pointer;
    }

    /* Detalles del producto */
    .cart-item-details {
        display: flex;
        flex-direction: column;
        flex-grow: 1;
    }

    .cart-item-name {
        font-weight: bold;
        font-size: 16px;
        color: #333;
        text-decoration: none;
    }

    .cart-item-price {
        color: #777;
        font-size: 14px;
    }

    /* Estilo para el botón de eliminar */
    .remove-item {
        background-color: #ff4d4d;
        color: #fff;
        border: none;
        padding: 8px 15px;
        cursor: pointer;
        border-radius: 5px;
        font-size: 14px;
        transition: background-color 0.3s ease;
    }

    .remove-item:hover {
        background-color: #ff3333;
    }

    /* Personalización del scroll */
    #cart-items {
        max-height: calc(100% - 60px);
        overflow-y: auto;
        padding-right: 15px;
    }

    /* Estilo del track del scroll */
    #cart-items::-webkit-scrollbar {
        width: 10px;
    }

    /* Estilo del pulgar del scroll */
    #cart-items::-webkit-scrollbar-thumb {
        background-color: #007bff;
        border-radius: 5px;
    }

    /* Estilo del fondo del track del scroll */
    #cart-items::-webkit-scrollbar-track {
        background-color: #f3f3f3;
        border-radius: 5px;
    }

</style>
</body>
</html>
