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
    <link rel="stylesheet" href="css/politicas.css">
    <title>Política de Privacidad - VitalMarket</title>
</head>
<body>
    <header>
        <h1>Política de Privacidad</h1>
    </header>

    <div class="content">
        <h2>1. Introducción</h2>
        <p>En VitalMarket, valoramos tu privacidad y nos comprometemos a proteger tu información personal. Esta política explica cómo recopilamos, usamos, y compartimos tu información.</p>

        <h2>2. Información que Recopilamos</h2>
        <p>Podemos recopilar información personal que nos proporcionas al registrarte en nuestro sitio, como tu nombre, dirección de correo electrónico y cualquier otra información que decidas proporcionar.</p>

        <h2>3. Uso de la Información</h2>
        <p>La información que recopilamos se utiliza para:</p>
        <ul>
            <li>Proporcionar y gestionar nuestros servicios.</li>
            <li>Mejorar nuestro sitio web y la experiencia del usuario.</li>
            <li>Enviar información y actualizaciones sobre nuestros servicios.</li>
        </ul>

        <h2>4. Compartir Información</h2>
        <p>No compartimos tu información personal con terceros, salvo que sea necesario para cumplir con la ley, proteger nuestros derechos, o si has dado tu consentimiento explícito.</p>

        <h2>5. Seguridad de la Información</h2>
        <p>Implementamos medidas de seguridad para proteger tu información personal. Sin embargo, no podemos garantizar la seguridad completa de tus datos en línea.</p>

        <h2>6. Cambios a Esta Política</h2>
        <p>Nos reservamos el derecho de modificar esta política en cualquier momento. Te notificaremos sobre cambios importantes y te animamos a revisar esta política periódicamente.</p>

        <h2>7. Contacto</h2>
        <p>Si tienes preguntas sobre esta política de privacidad, puedes contactarnos a través de nuestro formulario de contacto en el sitio.</p>
    </div>

    <footer>
        <p>© 2024 VitalMarket. Todos los derechos reservados.</p>
        <a href="terminos.php">Términos y Condiciones</a>
        <a href="politicas.php">Políticas de Privacidad</a>
        <a href="contacto.php">Contacto</a>
    </footer>
</body>
</html>
