<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
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

// Verifica que el usuario esté autenticado utilizando 'user_id'
if (!isset($_SESSION['usuario']['id']) || !isset($_SESSION['usuario'])) {
    echo json_encode(["status" => "error", "message" => "Usuario no autenticado"]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Datos del usuario
    $usuario_id     = $_SESSION['usuario']['id'];  // usa user_id en lugar de id
    $nombre_usuario = $_SESSION['usuario']['usuario'];
    
    // Recibir datos del formulario
    $fecha  = $_POST['fecha'];    // Formato: YYYY-MM-DD
    $hora   = $_POST['hora'];     // Formato: HH:MM:SS
    $motivo = $_POST['motivo'];
    // Suponemos que se usa un servicio fijo (por ejemplo, id = 1)
    $servicio_id = 1;

    // Generar localizador: nombre (minúsculas) + mes (2 dígitos) + día (2 dígitos) + hora (2 dígitos)
    $usuarioLower = strtolower($nombre_usuario);
    $mes          = date("m", strtotime($fecha));
    $dia          = date("d", strtotime($fecha));
    $horaFormato  = date("H", strtotime($hora));
    $localizador  = $usuarioLower . $mes . $dia . $horaFormato;
    
    // Insertar la reserva en la base de datos
    $stmt = $conn->prepare("INSERT INTO reservas (usuario_id, servicio_id, fecha, hora, motivo, localizador) VALUES (?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        echo json_encode(["status" => "error", "message" => $conn->error]);
        exit;
    }
    $stmt->bind_param("iissss", $usuario_id, $servicio_id, $fecha, $hora, $motivo, $localizador);
    if ($stmt->execute()) {
        echo json_encode([
            "status"      => "success", 
            "message"     => "Reserva realizada exitosamente", 
            "localizador" => $localizador
        ]);
    } else {
        echo json_encode(["status" => "error", "message" => $stmt->error]);
    }
}
?>
