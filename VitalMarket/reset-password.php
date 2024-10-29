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

require 'CONEXION/conexion.php';

// Verificar si el token está presente en la URL
if (!isset($_GET['token']) || empty($_GET['token'])) {
    header("Location: Login.php"); // Redirigir si no hay token
    exit();
}

$token = $_GET['token'];

// Verificar si el token es válido en la base de datos
$stmt = $conn->prepare("SELECT * FROM usuarios WHERE token = ?");
$stmt->bind_param("s", $token);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: Login.php"); // Redirigir si el token no es válido
    exit();
}

// Si el token es válido, proceder con el manejo del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nueva_contrasena = $_POST['nueva_contrasena'];
    $confirmar_contrasena = $_POST['confirmar_contrasena'];

    if ($nueva_contrasena === $confirmar_contrasena) {
        $hashed_password = password_hash($nueva_contrasena, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE usuarios SET password = ?, token = NULL WHERE token = ?");
        $stmt->bind_param("ss", $hashed_password, $token);
        $stmt->execute();

        echo "<p class='success-message'>Tu contraseña ha sido restablecida exitosamente.</p>";
        header("Location: Login.php");
        exit();
    } else {
        echo "<p class='error-message'>Las contraseñas no coinciden.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="description" content="Restablece tu contraseña en VitalMarket.">
    <meta name="keywords" content="VitalMarket, Restablecer Contraseña, Seguridad">
    <link rel="icon" href="IMG/VitalMarket-Vk.png" type="image/png">
    <title>VitalMarket - Restablecer Contraseña</title>
    <style>
        /* Estilos adaptados de sing-up.css */
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f2f2f2;
        }
        header {
            text-align: center;
            padding: 20px;
            background-color: #007bff;
        }
        h1 {
            color: #fff;
            margin: 0;
        }
        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            height: 100vh;
            margin-top: 40px;
        }
        .form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 280px;
            animation: fadeIn 0.8s ease;
        }
        input {
            width: 90%; /* Más compacto */
            padding: 10px; /* Reducido */
            margin-bottom: 12px; /* Más compacto */
            border: 1px solid #ced4da;
            border-radius: 6px;
            font-size: 14px; /* Reducido */
            outline: none;
        }
        button {
            width: 100%;
            padding: 10px; /* Reducido */
            background: linear-gradient(to bottom, #007bff, #0056b3);
            color: #fff;
            border: none;
            border-radius: 6px;
            cursor: pointer;
        }
        button:hover {
            background: linear-gradient(to bottom, #0056b3, #004080);
        }
        a {
            color: #007bff;
            text-decoration: none;
            display: block;
            text-align: center;
            margin-top: 8px;
        }
        .welcome-message {
            text-align: center;
            color: #495057;
            font-size: 16px;
            margin-bottom: 8px;
        }
        .footer {
            margin-top: 15px;
            text-align: center;
            color: #495057;
            font-size: 12px;
        }
        .footer a {
            color: #007bff;
            text-decoration: none;
        }
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <header>
        <a class="VitalM-a" href="/VitalMarket"><h1>VitalMarket</h1></a>
    </header>

    <div class="container">
        <div class="form">
            <form method="POST" action="">
                <span class="welcome-message">Restablece contraseña</span>
                <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
                <input type="password" name="nueva_contrasena" required placeholder="Nueva Contraseña">
                <input type="password" name="confirmar_contrasena" required placeholder="Confirmar Nueva Contraseña">
                <button type="submit" class="entrar boton">Restablecer Contraseña</button>
            </form>
            <div id="error-message" class="error-message"></div>
            <a href="/VitalMarket/Login.php">Regresar a Iniciar Sesión</a>
        </div>
    </div>
    <div class="footer">
        <p><a href="terminos.php" target="_blank">Términos y Condiciones</a> | <a href="privacidad.php" target="_blank">Políticas de Privacidad</a></p>
        <p>&copy; 2023 VitalMarket. Todos los derechos reservados.</p>
    </div>
</body>
</html>
