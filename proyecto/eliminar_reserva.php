<?php
session_start();

// Conexión a la base de datos
$servername = "localhost";
$username = "jorge";
$password = "KXiZ4xzfMclSLKv";
$dbname = "jorge";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

if (!isset($_GET['id'])) {
    echo "No se especificó reserva.";
    exit;
}

$id = $_GET['id'];
$stmt = $conn->prepare("DELETE FROM reservas WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    // Ejecutar la consulta ALTER TABLE para reiniciar el contador AUTO_INCREMENT
    $resetAutoIncrement = "ALTER TABLE reservas AUTO_INCREMENT = 1";
    if ($conn->query($resetAutoIncrement) === TRUE) {
        // Si la consulta ALTER TABLE fue exitosa, redirige
        header("Location: admin_reservas.php");
        exit;
    } else {
        echo "Error al reiniciar el contador AUTO_INCREMENT: " . $conn->error;
    }
} else {
    echo "Error al eliminar: " . $stmt->error;
}
?>

