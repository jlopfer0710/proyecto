<?php
session_start();

// Conexión a la base de datos
$servername = "localhost";
$username = "admin";
$password = "admin";
$dbname = "MotorClick_DB";

$conn = new mysqli($servername, $username, $password, $dbname ,"3307");
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Verificar que el usuario sea admin
if (!isset($_SESSION['usuario']['tipo']) || $_SESSION['usuario']['tipo'] !== 'admin') {
    header("Location: iniciar_sesion.php");
    exit;
}

// Recibir parámetros de búsqueda
$fechaBuscada = isset($_GET['fecha']) ? $_GET['fecha'] : '';
$localizadorBuscado = isset($_GET['localizador']) ? $_GET['localizador'] : '';

// Construir condiciones de búsqueda
$conditions = [];
$params = [];
$types = "";

if (!empty($fechaBuscada)) {
    $conditions[] = "fecha = ?";
    $params[] = $fechaBuscada;
    $types .= "s";
}

if (!empty($localizadorBuscado)) {
    $conditions[] = "localizador = ?";
    $params[] = $localizadorBuscado;
    $types .= "s";
}

$query = "SELECT r.*, u.usuario AS nombre_usuario FROM reservas r JOIN usuarios u ON r.usuario_id = u.id";
if (count($conditions) > 0) {
    $query .= " WHERE " . implode(" OR ", $conditions);
}

$stmt = $conn->prepare($query);
if ($stmt) {
    if (count($params) > 0) {
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    echo "Error en la consulta: " . $conn->error;
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administración de Reservas - MotorClick</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <br><br><br><br><br><br>
    <header>
        <div class="container">
            <nav class="nav">
                <div class="menu-toggle">
                    <i class="fas fa-bars"></i>
                    <i class="fas fa-times"></i>
                </div>
                <a href="#" class="logo">LOGO</a>
                <ul class="nav-list">
                    <li class="nav-item">
                        <a href="home.php" class="nav-link active">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a href="servicios.php" class="nav-link ">Servicios</a>
                    </li>
                    <li class="nav-item">
                        <a href="reservas.php" class="nav-link ">Reservas</a>
                    </li>
                    <li class="nav-item">
                        <a href="#" class="nav-link ">Contacto</a>
                    </li>
                    <li class="nav-item">
                        <a href="registro.php" class="nav-link">Registrarme</a>
                    </li>
                    <li class="nav-item">
                        <a href="iniciar_sesion.php" class="nav-link">Iniciar Sesión</a>
                    </li>
                    <li class="nav-item">
                        <a href="admin_reservas.php" class="nav-link">Administrar Reservas</a>
                    </li>
                </ul>
            </nav>
        </div>
    </header>

    <section class="container mt-5">
        <h1 class="text-center">Administración de Reservas</h1>
        <form method="GET" action="" class="my-4">
    <div class="row g-3 align-items-end">
        <div class="col-md-5">
            <label for="fecha" class="form-label">Filtrar por Fecha:</label>
            <input type="date" name="fecha" id="fecha" class="form-control" value="<?php echo htmlspecialchars($fechaBuscada); ?>">
        </div>
        <div class="col-md-5">
            <label for="localizador" class="form-label">Filtrar por Localizador:</label>
            <input type="text" name="localizador" id="localizador" class="form-control" value="<?php echo htmlspecialchars($localizadorBuscado); ?>">
        </div>
        <div class="col-md-2">
            <button type="submit" class="btn btn-primary w-100">Buscar</button>
        </div>
    </div>
</form>


        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Usuario</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Motivo</th>
                    <th>Localizador</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo $row['nombre_usuario']; ?></td>
                        <td><?php echo $row['fecha']; ?></td>
                        <td><?php echo $row['hora']; ?></td>
                        <td><?php echo $row['motivo']; ?></td>
                        <td><?php echo $row['localizador']; ?></td>
                        <td>
                            <a href="eliminar_reserva.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm"
                                onclick="return confirm('¿Está seguro de eliminar esta reserva?');">Eliminar</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </section>

    <footer>
        <div class="container">
            <div class="footer-content">

                <div class="footer-content-about">
                    <h4>Nosotros</h4>
                    <div class="circle">
                        <i class="fas fa-circle"></i>
                    </div>
                    <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit.
                        Praesentium odio labore dolorum veritatis, culpa cumque eum
                        reprehenderit iure, commodi, repellat eaque possimus obcaecati
                        assumenda exercitationem?
                        Aperiam provident accusantium laboriosam. Necessitatibus!</p>
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>