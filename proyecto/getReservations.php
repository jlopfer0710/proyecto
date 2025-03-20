<?php
// getReservations.php

// Conectar a la base de datos
$conexion = mysqli_connect("localhost", "jorge", "KXiZ4xzfMclSLKv", "jorge");
if(mysqli_connect_errno()){
    echo json_encode(['error' => 'Error de conexión a la base de datos']);
    exit;
}

if(isset($_POST['fecha'])){
    // Sanitizar la fecha recibida
    $fecha = mysqli_real_escape_string($conexion, $_POST['fecha']);
    
    // Consultar las horas reservadas para esa fecha
    $query = "SELECT hora FROM reservas WHERE fecha = '$fecha'";
    $result = mysqli_query($conexion, $query);
    $reserved_hours = [];
    
    if($result){
        while($row = mysqli_fetch_assoc($result)){
            $reserved_hours[] = $row['hora'];
        }
    }
    
    // Devolver la información en formato JSON
    echo json_encode(['reserved_hours' => $reserved_hours]);
} else {
    echo json_encode(['error' => 'Fecha no proporcionada']);
}
?>

