<?php
session_start(); // Asegúrate de iniciar la sesión
include_once($_SERVER['DOCUMENT_ROOT'] . '/VitalMarket/CONEXION/conexion.php');

// Configura los límites de intentos y bloqueos
$maxAttempts = 5; // Número máximo de intentos
$blockTime = 300; // Tiempo de bloqueo en segundos (5 minutos)
$ip = $_SERVER['REMOTE_ADDR']; // Obtener IP del usuario

// Manejo de intentos de inicio de sesión
if (isset($_SESSION['login_attempts'][$ip])) {
    $attempts = $_SESSION['login_attempts'][$ip]['attempts'];
    $lastAttemptTime = $_SESSION['login_attempts'][$ip]['time'];

    if ($attempts >= $maxAttempts && (time() - $lastAttemptTime) < $blockTime) {
        http_response_code(403);
        exit("Demasiados intentos. Por favor, espera un momento antes de intentarlo de nuevo.");
    }

    if ((time() - $lastAttemptTime) >= $blockTime) {
        unset($_SESSION['login_attempts'][$ip]);
    }
}

// Procesar el inicio de sesión
if (isset($_POST["LoginO"])) {
    // Validar los campos de entrada
    $user = trim($_POST["usernombre"] ?? '');
    $pass = trim($_POST["passcontraseña"] ?? '');

    if (!empty($user) && !empty($pass)) {
        // Consulta segura utilizando hashing
        $stmt = $conn->prepare("SELECT id, username, password, email FROM usuarios WHERE username=?"); // Agregar email a la consulta
        $stmt->bind_param("s", $user);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $datos = $result->fetch_object();

            // Verificar la contraseña usando password_verify
            if (password_verify($pass, $datos->password)) {
                // Regenerar el ID de la sesión para mayor seguridad
                session_regenerate_id(true);

                // Guardar datos de sesión
                $_SESSION["id"] = $datos->id;
                $_SESSION["usernombre"] = $datos->username;
                $_SESSION["correo"] = $datos->email; // Guardar el correo en la sesión

                // Redirigir al usuario a la página de inicio
                header('Location: /VitalMarket/Home.php');
                exit();
            }
        }

        // Manejar el fallo en la autenticación
        if (!isset($_SESSION['login_attempts'][$ip])) {
            $_SESSION['login_attempts'][$ip] = ['attempts' => 1, 'time' => time()];
        } else {
            $_SESSION['login_attempts'][$ip]['attempts']++;
            $_SESSION['login_attempts'][$ip]['time'] = time();
        }

        header('Location: /VitalMarket/Login.php?error=1');
        exit();
    }
}
?>
