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
$sql = "
    SELECT p.id, p.nombre, p.precio, ip.ruta_imagen
    FROM productos p
    LEFT JOIN imagenes_productos ip
    ON p.id = ip.producto_id AND ip.es_principal = 1
    GROUP BY p.id
";
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
            <a href="Wallet.php">Categorias</a>
            <a href="Categories.php">Ofertas</a>
            <a href="cart-c.php">Carrito</a>
            <a href="account.php">Mi Cuenta</a>
        </div>
        <div class="search-box">
            <input type="text" class="search-input" placeholder="Buscar...">
            <button class="cart-btn">🛒</button>
        </div>
    </header>
    </div>
    <div class="content">
        <h2 class="textos">Productos Destacados</h2>
        <div class="product-list">
    <?php while ($row = $result->fetch_assoc()) { ?>
    <div class="product">
        <a class="p-d" href="product-details.php?id=<?php echo $row['id']; ?>">
            <div class="product-image">
                <?php if ($row['ruta_imagen']) { ?>
                    <img src="<?php echo $row['ruta_imagen']; ?>" alt="<?php echo $row['nombre']; ?>">
                <?php } else { ?>
                    <div class="no-image">Imagen no disponible</div>
                <?php } ?>
            </div>
            <div class="product-info">
                <h3><?php echo $row['nombre']; ?></h3>
                <p class="price">$<?php echo number_format($row['precio'], 2); ?></p>
            </a>
                <button class="add-to-cart">Agregar al carrito</button>
            </div>
    </div>
<?php } ?>
</div>
    </div>
<!-- Menú flotante del carrito -->
    <div id="cart-menu" class="cart-menu">
        <h3>Tu Carrito</h3>
        <div id="cart-items">
            <!-- Aquí se mostrarán los productos del carrito con Ajax -->
        </div>
        <button id="close-cart" class="close-cart">Cerrar</button>
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
                left: '20px',  // Cambié 'right' por 'left'
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

        /* Input de búsqueda y carrito de compras */
        .search-box {
            position: absolute;
            top: 20px;
            right: 60px;
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
            padding: 10px;
            background-color: #007bff;
            color: #fff;
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
