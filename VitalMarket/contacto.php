<?php
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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/contacto.css">
    <title>Contacto - VitalMarket</title>
</head>
<body>
    <header>
        <h1>Contacto</h1>
    </header>

    <div class="content">
        <div class="contact-container">
            <h2>Información de Contacto</h2>
            <p>Correo Electrónico: <a class="contact-email" href="mailto:moisesfranco.cano@gmai.com">info@vitalmarket.com</a></p>

            <h2>Horario de Atención</h2>
            <p>Lunes a Viernes: 3:00 PM - 5:00 PM (UTC-6)</p>
        </div>
    </div>

    <footer>
        <p>© 2024 VitalMarket. Todos los derechos reservados.</p>
        <a href="terminos.php">Términos y Condiciones</a>
        <a href="politicas.php">Políticas de Privacidad</a>
        <a href="contacto.php">Contacto</a>
    </footer>
</body>
</html>
