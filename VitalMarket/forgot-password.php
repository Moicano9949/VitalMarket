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
    <meta name="description" content="Recupera tu contraseña en VitalMarket.">
    <meta name="keywords" content="VitalMarket, Recuperar Contraseña, Acceso, Productos, Servicios">
    <meta http-equiv="Content-Security-Policy" content="frame-ancestors 'none';">
    <meta http-equiv="X-Content-Type-Options" content="nosniff">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/Login.css">
    <link rel="icon" href="IMG/VitalMarket-Vk.png" type="image/png">
    <title>VitalMarket - Recuperar Contraseña</title>
    <style>
        /* Añadiendo margen al contenedor del formulario */
        .container {
            margin-top: 40px; /* Ajusta este valor según sea necesario */
        }

        .form {
            padding: 20px; /* Añadir padding para un mejor aspecto */
            border: 1px solid #ccc; /* Para darle un borde */
            border-radius: 5px; /* Bordes redondeados */
            background-color: #f9f9f9; /* Color de fondo */
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1); /* Sombra sutil */
        }

        .textos {
            margin-bottom: 20px; /* Espacio debajo del texto */
            color: black; /* Cambia el color a negro */
        }

        h2 {
            color: #FF0000; /* Cambia el color del título a un color llamativo (rojo en este caso) */
        }

        p {
            color: #000000; /* Cambia el color del párrafo a negro */
        }
    </style>
</head>
<body>
    <header>
        <a class="VitalM-a" href="Login.php"><h1>VitalMarket</h1></a>
    </header>

    <div class="container">
        <div class="form">
            <!-- Cambié la acción del formulario a request-reset.php -->
            <form method="POST" action="request-reset.php" onsubmit="return validarFormulario()">
                <div class="textos">
                    <h2>Recuperar Contraseña</h2>
                    <p>Ingresa tu dirección de correo electrónico para recibir un enlace de recuperación.</p>
                </div>
                <input type="email" name="email" id="email" placeholder="Correo electrónico" maxlength="50" required>
                <button type="submit" class="entrar boton" name="recuperar">Enviar Enlace</button>
            </form>
            <div id="error-message" class="error-message"></div>
        </div>
    </div>

    <div class="footer">
        <p><a href="terminos.php" target="_blank">Términos y Condiciones</a> | <a href="privacidad.php" target="_blank">Políticas de Privacidad</a></p>
        <p>&copy; 2023 VitalMarket. Todos los derechos reservados.</p>
    </div>

    <script>
        function validarFormulario() {
            var email = document.getElementById('email').value;
            var errorMessage = document.getElementById('error-message');

            if (email.trim() === '') {
                errorMessage.innerHTML = 'Por favor, ingresa tu correo electrónico.';
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
