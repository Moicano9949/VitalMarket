<?php
session_start();

if (!isset($_SESSION["id"])) {
    header("Location: Onion_log");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $comentario = $_POST["comentario"];
    $id_usuario = $_SESSION["id"];

    require_once("conexion.php");
    
    $sql = "INSERT INTO comentarios (id_usuario, comentario, fecha) VALUES (?, ?, NOW())";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $id_usuario, $comentario);
    
    if ($stmt->execute()) {
        header("Location: ../Home");
    } else {
        echo "Error al guardar el comentario.";
    }
    $stmt->close();
    $conn->close();
}
?>
