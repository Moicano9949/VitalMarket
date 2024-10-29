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
</head>
<body>
    <header>
        <h1>VitalMarket</h1>

        <div class="navbar">
            <a href="Home.php">Inicio</a>
            <a href="Wallet.php">Billetera</a>
            <a href="Categories.php">Categorías</a>
            <a href="Offers.php">Ofertas</a>
            <a href="account.php" class="active">Mi Cuenta</a>
        </div>

        <div class="search-box">
            <input type="text" class="search-input" placeholder="Buscar...">
            <button class="cart-btn">&#128722;</button>
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
    
    <a href="Home.php" style="position: fixed; bottom: 20px; right: 20px; background-color: #007bff; color: #fff; padding: 10px 20px; text-decoration: none; border-radius: 6px;">Volver a Inicio</a>
</body>
</html>
