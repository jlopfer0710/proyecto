<?php
session_start();

// Conexión a la base de datos
$servername = "localhost";
$username = "admin";
$password = "admin";
$dbname = "MotorClick_DB";

$conn = new mysqli($servername, $username, $password, $dbname,"3307");
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
    header("Location: admin_reservas.php");
    exit;
} else {
    echo "Error al eliminar: " . $stmt->error;
}
?>
