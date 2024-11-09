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
$sql = "SELECT id, nombre, precio, imagen FROM productos";
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
    <link rel="stylesheet" href="css/Home.css">
    <title>VitalMarket - Inicio</title>
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
    <div class="search-cart">
        <input type="text" placeholder="Buscar productos..." />
        <button class="cart-button">
            <img src="IMG/cart-icon.png" alt="Carrito" style="width: 20px; height: 20px; margin-right: 5px;">
            Carrito de Compras
        </button>
    </div>
    <div class="content">
        <h2 class="textos">Productos Destacados</h2>
        <div class="product-list">
    <?php while ($row = $result->fetch_assoc()) { ?>
        <div class="product">
            <a class="p-d" href="product-details.php?id=<?php echo $row['id']; ?>">
                <div class="product-image">
                    <?php if ($row['imagen']) { ?>
                        <img src="<?php echo $row['imagen']; ?>" alt="<?php echo $row['nombre']; ?>">
                    <?php } else { ?>
                        <div class="no-image">Imagen no disponible</div>
                    <?php } ?>
                </div>
                <div class="product-info">
                    <h3><?php echo $row['nombre']; ?></h3>
                    <p class="price">$<?php echo number_format($row['precio'], 2); ?></p>
                </div>
            </a>
            <button class="add-to-cart">Agregar al carrito</button>
        </div>
    <?php } ?>
</div>
    </div>
    <footer>
        <p>© 2024 VitalMarket. Todos los derechos reservados.</p>
    </footer>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- Importamos jQuery -->

<script>
    $(document).ready(function(){
        // Detectar clic en el botón "Agregar al carrito"
        $(".add-to-cart").click(function() {
            // Obtener datos del producto
            var producto_id = $(this).closest(".product").find("img").attr("src");
            var nombre = $(this).closest(".product-info").find("h3").text();
            var precio = $(this).closest(".product-info").find(".price").text().replace('$', '').trim();
            var imagen = $(this).closest(".product").find("img").attr("src");

            // Enviar solicitud AJAX
            $.ajax({
                type: "POST",
                url: "add-cart.php",  // Asegúrate de tener este archivo
                data: {
                    producto_id: producto_id,
                    nombre: nombre,
                    precio: precio,
                    imagen: imagen
                },
                success: function(response) {
                    // Mostrar la notificación flotante
                    showNotification(response);
                },
                error: function() {
                    alert("Hubo un error al agregar el producto.");
                }
            });
        });

        // Función para mostrar la notificación
        function showNotification(message) {
            var notification = $('<div class="notification">' + message + '</div>');

            // Agregar la notificación al body
            $('body').append(notification);

            // Estilos de la notificación
            notification.css({
                position: 'fixed',
                top: '20px',
                right: '20px',
                backgroundColor: '#007bff', // Fondo azul
                color: 'white',
                padding: '10px 20px',
                borderRadius: '5px',
                boxShadow: '0 2px 5px rgba(0, 0, 0, 0.1)',
                zIndex: 1001,
                opacity: 1,
                transition: 'opacity 1s ease-out',
                border: '3px solid white', // Borde blanco más marcado
            });

            // Desaparecer la notificación después de 5 segundos
            setTimeout(function() {
                notification.css('opacity', '0');
                setTimeout(function() {
                    notification.remove();
                }, 1000); // Espera 1 segundo para asegurar que la animación de desaparición se complete
            }, 5000);
        }
    });
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
            border-bottom: 2px solid #004080;
        }

        /* Input de búsqueda y carrito de compras */
        .search-cart {
            display: flex;
            justify-content: flex-end; /* Alinear a la derecha */
            margin-top: 10px;
            padding: 10px 20px; /* Espaciado adicional */
        }

        .search-cart input {
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            margin-right: 10px;
        }

        .cart-button {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px 15px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s ease;
            display: flex;
            align-items: center;
        }

        .cart-button:hover {
            background-color: #218838;
        }

        /* Contenedor de contenido principal */
        .content {
            padding: 120px 20px 20px;
            height: calc(100vh - 120px);
            overflow-y: auto;
        }

        /* Estilo del contenedor de productos */
        .product-list {
            display: grid;
            grid-template-columns: repeat(3, 1fr); /* Tres columnas en desktop */
            gap: 20px;
            padding: 20px;
        }

        /* Estilo para cada producto */
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
            min-height: 300px;
        }

        /* Contenedor de imagen */
        .product-image {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 150px;
            background-color: #f0f0f0;
            border-radius: 8px;
            overflow: hidden; /* Para ocultar desbordes de la imagen */
        }

        /* Estilo de imagen */
        .product-image img {
            width: 100%; /* Ajusta la imagen al 100% del contenedor */
            height: auto;
            object-fit: contain; /* Mantiene la proporción de la imagen */
            border-radius: 8px;
        }

        /* Placeholder para imagen faltante */
        .no-image {
            font-size: 14px;
            color: #888;
        }

        /* Información del producto */
        .product-info h3 {
            font-size: 18px;
            margin: 10px 0;
        }

        .product-info p {
            color: #555;
            font-size: 14px;
            margin: 5px 0;
        }
       .p-d {
       text-decoration: none;
       color: #007bff;
       }
       .p-d:hover {
       color: #0056b3;
       }
       .price {
       color: red;
       }

        /* Botón de agregar al carrito */
        .add-to-cart {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .add-to-cart:hover {
            background-color: #0056b3;
        }
     footer {
    text-align: center;
    padding: 20px;
    background-color: #007bff;
    color: white;
    position: fixed;
    bottom: 0;
    width: 100%;
}

        /* Responsive para dispositivos móviles */
        @media only screen and (max-width: 768px) {
            .product-list {
                grid-template-columns: repeat(2, 1fr); /* Dos columnas en tablet */
            }
        }

        @media only screen and (max-width: 480px) {
            .product-list {
                grid-template-columns: 1fr; /* Una columna en móvil */
            }

            .search-cart {
                flex-direction: column; /* Colocar el input y botón en columna en móvil */
                align-items: flex-end; /* Alinear a la derecha */
            }

            .search-cart input {
                width: 100%; /* Tomar el ancho completo en móvil */
                margin-bottom: 10px; /* Espaciado inferior */
            }
        }
</style>
</body>
</html>
