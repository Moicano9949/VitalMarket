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
    <link rel="stylesheet" href="css/terminos.css">
    <title>Términos y Condiciones - VitalMarket</title>
</head>
<body>
    <header>
        <h1>Términos y Condiciones</h1>
    </header>

    <div class="content">
        <h2>1. Aceptación de Términos</h2>
        <p>Al acceder a este sitio web, aceptas cumplir con estos términos y condiciones. Si no estás de acuerdo, por favor no uses el sitio.</p>

        <h2>2. Uso del Sitio</h2>
        <p>El contenido de este sitio es solo para uso personal y no comercial. Queda prohibido el uso no autorizado del contenido.</p>

        <h2>3. Propiedad Intelectual</h2>
        <p>Todo el contenido de este sitio está protegido por derechos de autor y no puede ser reproducido sin permiso.</p>

        <h2>4. Limitación de Responsabilidad</h2>
        <p>No somos responsables de daños o pérdidas que puedan surgir del uso de este sitio.</p>

        <h2>5. Modificaciones</h2>
        <p>Nos reservamos el derecho de modificar estos términos en cualquier momento. Los cambios serán efectivos al ser publicados en el sitio.</p>

        <h2>6. Ley Aplicable</h2>
        <p>Estos términos se rigen por las leyes del Estado de Texas, Estados Unidos, y se aplican a todos los usuarios, independientemente de su país de origen.</p>
    </div>

    <footer>
        <p>© 2024 VitalMarket. Todos los derechos reservados.</p>
        <a href="terminos.php">Términos y Condiciones</a>
        <a href="politicas.php">Políticas de Privacidad</a>
        <a href="contacto.php">Contacto</a>
    </footer>
</body>
</html>
