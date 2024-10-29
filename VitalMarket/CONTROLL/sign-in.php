<?php
session_start(); // Asegúrate de iniciar la sesión

if (!empty($_POST["usernombre"]) && !empty($_POST["passcontraseña"]) && !empty($_POST["name"])) {
    $user = trim($_POST["usernombre"]);
    $pass = trim($_POST["passcontraseña"]);
    $name = trim($_POST["name"]);

    // Verificar si el usuario ya existe
    $stmt_check_user = $conn->prepare("SELECT id FROM usuarios WHERE username=?");
    $stmt_check_user->bind_param("s", $user);
    $stmt_check_user->execute();
    $result_check_user = $stmt_check_user->get_result();

    if ($result_check_user->num_rows > 0) {
        header("Location: ?error=2"); // Usuario ya existe
        exit();
    }

    // Hash de la contraseña antes de almacenarla
    $hashedPassword = password_hash($pass, PASSWORD_DEFAULT);

    // Insertar nuevo usuario
    $stmt = $conn->prepare("INSERT INTO usuarios (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $user, $hashedPassword);

    if ($stmt->execute()) {
        // Iniciar sesión después de registro exitoso
        $stmt_login = $conn->prepare("SELECT * FROM usuarios WHERE username=?");
        $stmt_login->bind_param("s", $user);
        $stmt_login->execute();
        $result_login = $stmt_login->get_result();

        if ($result_login->num_rows > 0) {
            $datos = $result_login->fetch_object();
            session_regenerate_id(true); // Regenerar ID de sesión

            $_SESSION["id"] = $datos->id;
            $_SESSION["usernombre"] = $datos->username;

            header("Location: ../Home.php");
            exit();
        } else {
            header("Location: ?error=1");
            exit();
        }
    } else {
        header("Location: ?error=1");
        exit();
    }
}
?>
