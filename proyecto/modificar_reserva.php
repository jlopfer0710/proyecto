<?php
session_start();

// Verificar que el usuario sea admin
if (!isset($_SESSION['usuario']['tipo']) || $_SESSION['usuario']['tipo'] !== 'admin') {
    header("Location: iniciar_sesion.php");
    exit;
}

$servername = "localhost";
$username = "jorge";
$password = "KXiZ4xzfMclSLKv";
$dbname = "jorge";

$conn = mysqli_connect("localhost", $username, $password, $dbname);
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar que se haya recibido el ID de la reserva
if (!isset($_GET['id'])) {
    echo "No se especificó reserva.";
    exit;
}

$reserva_id = $_GET['id'];

// Si se envía el formulario, procesar la actualización
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nuevo_nombre = $_POST['nombre'];
    $nuevo_motivo = $_POST['motivo'];

    // Obtener el usuario asociado a la reserva
    $stmt = $conn->prepare("SELECT usuario_id FROM reservas WHERE id = ?");
    $stmt->bind_param("i", $reserva_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $usuario_id = $row['usuario_id'];
    } else {
        echo "Reserva no encontrada.";
        exit;
    }
    $stmt->close();

    // Actualizar el nombre en la tabla de usuarios
    $stmt2 = $conn->prepare("UPDATE usuarios SET nombre = ? WHERE id = ?");
    $stmt2->bind_param("si", $nuevo_nombre, $usuario_id);
    $stmt2->execute();
    $stmt2->close();

    // Actualizar el motivo en la tabla de reservas
    $stmt3 = $conn->prepare("UPDATE reservas SET motivo = ? WHERE id = ?");
    $stmt3->bind_param("si", $nuevo_motivo, $reserva_id);
    $stmt3->execute();
    $stmt3->close();

    header("Location: admin_reservas.php");
    exit;
}

// Obtener los datos actuales de la reserva y el nombre del usuario
$stmt = $conn->prepare("SELECT r.*, u.nombre FROM reservas r JOIN usuarios u ON r.usuario_id = u.id WHERE r.id = ?");
$stmt->bind_param("i", $reserva_id);
$stmt->execute();
$result = $stmt->get_result();
if ($row = $result->fetch_assoc()) {
    $nombre_actual = $row['nombre'];
    $motivo_actual = $row['motivo'];
} else {
    echo "Reserva no encontrada.";
    exit;
}
$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Modificar Reserva - MotorClick</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<header>
<style>
/* Add these new styles */
.logo {
    display: flex;
    align-items: center;
    height: 0%;
}
.logo img{
    border-radius:50%;
}
</style>
    <div class="container">
        <nav class="nav">
            <div class="menu-toggle">
                <i class="fas fa-bars"></i>
                <i class="fas fa-times"></i>
            </div>
            <a href="home.php" class="logo">
  <img src="images/logo.png" alt="MotorClick" height="50">
</a>
            <ul class="nav-list">
                <li class="nav-item">
                    <a href="home.php" class="nav-link">Inicio</a>
                </li>
                <li class="nav-item">
                    <a href="servicios.php" class="nav-link">Servicios</a>
                </li>
                <li class="nav-item">
                    <a href="reservas.php" class="nav-link">Reservas</a>
                </li>
                <li class="nav-item">
                    <a href="contacto.php" class="nav-link">Contacto</a>
                </li>
                <?php if (isset($_SESSION['usuario']) && $_SESSION['usuario']['tipo'] === 'admin'): ?>
                    <li class="nav-item">
                        <a href="admin_reservas.php" class="nav-link">Administrar Reservas</a>
                    </li>
                <?php endif; ?>
                <?php if (!isset($_SESSION['usuario'])): ?>
                    <li class="nav-item">
                        <a href="registro.php" class="nav-link">Registrarme</a>
                    </li>
                    <li class="nav-item">
                        <a href="iniciar_sesion.php" class="nav-link">Iniciar Sesión</a>
                    </li>
                <?php endif; ?>
                <?php if (isset($_SESSION['usuario'])): ?>
                    <li class="nav-item">
                        <a href="perfil.php" class="nav-link">Perfil</a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</header>

<section class="hero" id="hero">
    <div class="container">
        <h2 class="h2-sub"><span class="fil">Modificar Reserva</span></h2>
        <div class="form-wrapper">
            <div class="form-container">
                <form method="POST" action="">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" name="nombre" id="nombre" class="form-control" value="<?php echo htmlspecialchars($nombre_actual); ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="motivo" class="form-label">Motivo</label>
                        <select name="motivo" id="motivo" class="form-select" required>
                            <option value="Cambio de Aceite y Filtro" <?php if($motivo_actual == "Cambio de Aceite y Filtro") echo "selected"; ?>>Cambio de Aceite y Filtro</option>
                            <option value="Cambio de Rueda" <?php if($motivo_actual == "Cambio de Rueda") echo "selected"; ?>>Cambio de Rueda</option>
                            <option value="Revisión de ITV" <?php if($motivo_actual == "Revisión de ITV") echo "selected"; ?>>Revisión de ITV</option>
                            <option value="Nivelar la Batería" <?php if($motivo_actual == "Nivelar la Batería") echo "selected"; ?>>Nivelar la Batería</option>
                            <option value="Revisión de Luces" <?php if($motivo_actual == "Revisión de Luces") echo "selected"; ?>>Revisión de Luces</option>
                            <option value="Revisión Completa" <?php if($motivo_actual == "Revisión Completa") echo "selected"; ?>>Revisión Completa</option>
                        </select>
                    </div>
                    <div class="mb-3 text-center">
    <button type="submit" class="btn btn-primary">Guardar Cambios</button>
    <a href="admin_reservas.php" class="btn btn-secondary" style="margin-top: 15px;">Cancelar</a>
</div>

                </form>
            </div>
        </div>
    </div>
</section>

<footer>
        <div class="container">
            <div class="footer-content">

                <div class="footer-content-about">
                    <h4>Nosotros</h4>
                    <div class="circle">
                        <i class="fas fa-circle"></i>
                    </div>
                    <p>Bienvenido a MotorClick. Somos tu taller de mecánica de confianza, donde puedes reservar citas en línea 
                        y disfrutar de servicios integrales para el cuidado de tu vehículo. 
                        ¡Calidad y atención personalizada para que siempre estés en marcha!</p>
                </div>
                <div class="footer-div">
                    <div class="social-media">
                        <h4>Siguenos</h4>
                        <ul class="social-icons">
                            <li>
                                <a href="#"><i class="fab fa-twitter"></i></a>
                            </li>
                            <li>
                                <a href="#"><i class="fab fa-facebook-square"></i></a>
                            </li>
                            <li>
                                <a href="#"><i class="fab fa-pinterest"></i></a>
                            </li>
                            <li>
                                <a href="#"><i class="fab fa-linkedin-in"></i></a>
                            </li>
                            <!--<li>
                                <a href="#"><i class="fab fa-tripadvisor"></i></a>
                            </li>-->
                        </ul>
                    </div>
                    <div>
                        <h4>Inscribete</h4>
                        <form action="" class="news-form">
                            <input type="text" class="news-input" placeholder="Escribe tu email">
                            <button class="news-btn" type="submit">
                                <i class="fas fa-envelope"></i>
                            </button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </footer>

</body>
</html>