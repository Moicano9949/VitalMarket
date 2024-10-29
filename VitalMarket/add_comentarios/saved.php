<?php
session_start();

if (!isset($_SESSION["usernombre"]) || empty($_SESSION["usernombre"])) {
    header("Location: Onion_log");
    exit();
}

require_once("conexion.php");

$sql = "SELECT c.comentario, u.username, c.fecha FROM comentarios c
        INNER JOIN usuarios u ON c.id_usuario = u.id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $nombreUsuarioActual = $_SESSION['usernombre'];
        $nombreUsuarioComentario = htmlspecialchars($row['username']);
        
        echo '<p><span style="color: ' . ($nombreUsuarioActual === $nombreUsuarioComentario ? 'red' : 'green') . ';">' . $nombreUsuarioComentario . ':</span> ';
        echo '<span style="color: blue;">' . htmlspecialchars($row['comentario']) . '</span> ';
        echo '<span style="float: right; color: purple;">' . formatearfecha($row['fecha']) . '</span></p>';        
    }
} else {
    echo "No hay comentarios todavía.";
}

$conn->close();
?>
