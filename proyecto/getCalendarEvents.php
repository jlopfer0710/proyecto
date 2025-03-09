<?php
// getCalendarEvents.php
header('Content-Type: application/json');

// Conectar a la base de datos
$conexion = mysqli_connect("localhost", "admin", "admin", "MotorClick_DB","3307");
if (mysqli_connect_errno()) {
    echo json_encode([]);
    exit;
}

// Consulta para obtener las reservas pendientes (puedes modificar la condición si lo necesitas)
$query = "SELECT id, fecha, hora, motivo FROM reservas WHERE estado = 'pendiente'";
$result = mysqli_query($conexion, $query);

$events = array();
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        // Combinar fecha y hora para formar el datetime en formato ISO
        $start = $row['fecha'] . 'T' . $row['hora'];
        // Usar el motivo o personalizar el título
        $title = $row['motivo'];
        $events[] = array(
            'id' => $row['id'],
            'title' => $title,
            'start' => $start
        );
    }
}

echo json_encode($events);
mysqli_close($conexion);
?>
