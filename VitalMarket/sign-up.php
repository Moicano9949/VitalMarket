<?php
ob_start();
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
    <meta name="description" content="Únete a VitalMarket y descubre servicios exclusivos. ¡Bienvenido!">
    <meta http-equiv="Content-Security-Policy" content="frame-ancestors 'none';">
    <meta http-equiv="X-Content-Type-Options" content="nosniff">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/sing-up.css">
    <link rel="icon" href="IMG/VitalMarket-Vk.png" type="image/png">
    <title>VitalMarket - Únete</title>
</head>
<body>
    <header>
        <a class="VitalM-a" href="Login.php"><h1>VitalMarket</h1></a>
    </header>

    <div class="container">
        <div class="textos">

        </div>
        <div class="form" id="form-container">
            <div class="welcome-message">
                ¡Hola! Únete a VitalMarket para acceder a servicios exclusivos.
            </div>
            <div id="error-message" class="error-message"></div>
            <div id="error-message-profesional" class="error-message"></div>
            <form method="POST" onsubmit="return validarFormulario()" id="registro-form">
                <input type="text" name="usernombre" id="usernombre" placeholder="Nombre de usuario" maxlength="30" value="<?php echo htmlspecialchars($_POST['usernombre'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                <input type="password" name="passcontraseña" id="passcontraseña" placeholder="Contraseña" maxlength="30" value="<?php echo htmlspecialchars($_POST['passcontraseña'] ?? '', ENT_QUOTES, 'UTF-8'); ?>">
                <button type="button" class="entrar boton" onclick="mostrarVentana()">Continuar</button>
            </form>
            <a href="Login.php">¿Ya tienes una cuenta? Inicia sesión</a>
        </div>

        <div class="container-profesional" id="container-profesional">
            <form method="POST" onsubmit="return validarFormularioProfesional()" id="registro-form-profesional">
                <input type="hidden" name="usernombre" id="usernombre-profesional" value="">
                <input type="hidden" name="passcontraseña" id="passcontraseña-profesional" value="">
                <div>Tu correo electrónico:</div>
                <div>
                    <input type="text" name="correo" id="correo" placeholder="Correo electrónico" maxlength="50">
                </div>
                <button type="submit" class="registrarse boton" name="Registrarse">Registrarse</button>
                <a href="Login.php">¿Ya tienes una cuenta? Inicia sesión</a>
            </form>
        </div>

        <div class="cont-ul">
            <?php
                include "CONEXION/conexion.php";
                include "CONTROLL/sign-up.php";
            ?>
        </div>
    </div>
    <div class="footer">
        <p><a href="terminos.php" target="_blank">Términos y Condiciones</a> | <a href="privacidad.php" target="_blank">Políticas de Privacidad</a></p>
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

        function validarFormularioProfesional() {
            var correo = document.getElementById('correo').value;
            var errorMessage = document.getElementById('error-message-profesional');

            if (correo.trim() === '') {
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

        function mostrarVentana() {
            if (validarFormulario()) {
                var nombreUsuario = document.getElementById('usernombre').value;
                var contraseña = document.getElementById('passcontraseña').value;

                document.getElementById('usernombre-profesional').value = nombreUsuario;
                document.getElementById('passcontraseña-profesional').value = contraseña;

                document.getElementById('form-container').style.display = 'none';
                document.getElementById('container-profesional').style.display = 'block';
            }
        }
    </script>
</body>
</html>
