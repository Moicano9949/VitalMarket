<?php
session_start();

if (isset($_SESSION["id"])) {
    header("Location: Home.php");
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
    <meta name="description" content="Inicia sesión en VitalMarket para acceder a tus servicios. ¡Bienvenido de nuevo!">
    <meta name="keywords" content="VitalMarket, Iniciar Sesión, Acceso, Compras en línea, Productos, Servicios, Mi Cuenta, Vital Market login, plataforma online">
    <meta http-equiv="X-Content-Type-Options" content="nosniff">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Security-Policy" content="default-src 'self'; script-src 'self'">
    <meta http-equiv="X-Content-Type-Options" content="nosniff">
    <meta http-equiv="X-Frame-Options" content="DENY">
    <meta http-equiv="X-XSS-Protection" content="1; mode=block">
    <meta name="referrer" content="no-referrer">
    <meta http-equiv="Permissions-Policy" content="geolocation=(), microphone=()">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/Login.css">
    <link rel="icon" href="IMG/VitalMarket-Vk.png" type="image/png">
    <title>VitalMarket - Inicia sesión</title>
</head>
<body>
    <header>
        <a class="VitalM-a" href="Login.php"><h1>VitalMarket</h1></a>
    </header>

    <div class="container">
        <div class="textos"></div>
        <div class="form">
            <div class="welcome-message">
                ¡Hola! Ingresa tus datos para iniciar sesión.
            </div>
            <div id="error-message" class="error-message"></div>

            <form method="POST" onsubmit="return validarFormulario()">
                <input type="text" name="usernombre" id="usernombre" placeholder="Nombre de usuario" maxlength="30" value="<?php echo htmlspecialchars($_POST['usernombre'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                <input type="password" name="passcontraseña" id="passcontraseña" placeholder="Contraseña" maxlength="30" value="<?php echo htmlspecialchars($_POST['passcontraseña'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                <button type="submit" class="entrar boton" name="LoginO">Iniciar Sesión</button>
            </form>
            <a href="forgot-password.php">¿Olvidaste tu Contraseña?</a>
            <a href="sign-up.php">¿No tienes una cuenta? Crea una ahora</a>
        </div>
        <div class="cont-ul">
            <?php
                include "CONEXION/conexion.php";
                include "CONTROLL/log-in-control.php";
            ?>
        </div>
    </div>
    <div class="footer">
        <p><a href="terminos.php" target="_blank">Términos y Condiciones</a> | <a href="politicas.php" target="_blank">Políticas de Privacidad</a></p>
        <p>&copy; 2024 VitalMarket. Todos los derechos reservados.</p>
    </div>
    <script>
        function validarFormulario() {
            var nombreUsuario = document.getElementById('usernombre').value;
            var contraseña = document.getElementById('passcontraseña').value;
            var errorMessage = document.getElementById('error-message');

            if (nombreUsuario.trim() === '' || contraseña.trim() === '') {
                errorMessage.innerHTML = 'Por favor, completa todos los campos.';
                errorMessage.style.display = 'block';

                setTimeout(function () {
                    errorMessage.style.display = 'none';
                }, 10000);

                return false;
            }

            errorMessage.style.display = 'none';
            return true;
        }
    </script>
</body>
</html>
