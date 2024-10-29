<?php
session_start(); // Asegúrate de iniciar la sesión
include_once($_SERVER['DOCUMENT_ROOT'] . '/VitalMarket/CONEXION/conexion.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recibir datos del formulario
    $username = trim($_POST["usernombre"]); // Nombre de usuario
    $password = trim($_POST['passcontraseña']); // Contraseña
    $email = trim($_POST['correo']); // Correo electrónico

    // Validación básica
    if (empty($username) || empty($password) || empty($email)) {
        header("Location: /VitalMarket/sign-up.php?error=1");
        exit;
    }

    // Escapar caracteres peligrosos
    $username = mysqli_real_escape_string($conn, $username);
    $password = mysqli_real_escape_string($conn, $password);
    $email = mysqli_real_escape_string($conn, $email); // Escapar el correo electrónico
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT); // Hash de la contraseña

    // Verificar si el usuario ya existe
    $sql_check = "SELECT id FROM usuarios WHERE username='$username'";
    $result_check = mysqli_query($conn, $sql_check);

    if (mysqli_num_rows($result_check) > 0) {
        header("Location: /VitalMarket/sign-up.php?error=2"); // Usuario ya existe
        exit;
    }

    // Insertar nuevo usuario incluyendo el correo electrónico
    $sql = "INSERT INTO usuarios (username, password, email) VALUES ('$username', '$hashedPassword', '$email')"; // Asegúrate de que la tabla tiene un campo para 'email'

    if (mysqli_query($conn, $sql)) {
        $_SESSION["id"] = mysqli_insert_id($conn);
        $_SESSION["usernombre"] = $username;
        $_SESSION["correo"] = $email; // Guardar el correo en la sesión

        header("Location: /VitalMarket/Home.php");
        exit;
    } else {
        echo "Error al registrar: " . mysqli_error($conn);
    }

    $conn->close();
}
?>
