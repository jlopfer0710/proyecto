<?php
session_start();
$conexion = mysqli_connect("localhost", "jorge", "KXiZ4xzfMclSLKv", "jorge");
if (!isset($_SESSION['usuario'])) {
    header("Location: iniciar_sesion.php");
    exit();
}
$query = "SELECT id, usuario FROM usuarios";
$result = mysqli_query($conexion, $query);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MotorClick</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <!-- Bootstrap JS y jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
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
    <header>
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
                    <li class="nav-item"><a href="home.php" class="nav-link ">Inicio</a></li>
                    <li class="nav-item"><a href="servicios.php" class="nav-link">Servicios</a></li>
                    <li class="nav-item"><a href="reservas.php" class="nav-link">Reservas</a></li>
                    <li class="nav-item"><a href="contacto.php" class="nav-link">Contacto</a></li>
                    <?php if (isset($_SESSION['usuario']) && $_SESSION['usuario']['tipo'] === 'admin'): ?>
                        <li class="nav-item"><a href="admin_reservas.php" class="nav-link">Administrar Reservas</a></li>
                    <?php endif; ?>
                    <?php if (!isset($_SESSION['usuario'])): ?>
                        <li class="nav-item"><a href="registro.php" class="nav-link">Registrarme</a></li>
                        <li class="nav-item"><a href="iniciar_sesion.php" class="nav-link">Iniciar Sesión</a></li>
                    <?php endif; ?>
                    <?php if (isset($_SESSION['usuario'])): ?>
                        <li class="nav-item"><a href="perfil.php" class="nav-link active">Perfil</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>
    <section class="hero" id="hero">
        <div class="oscurecer"></div>
        <div class="container">
            <div class="contenedor-principal">
                <!-- Div de perfil -->
                <div class="perfil">
                    <?php if (isset($_SESSION['usuario']) && is_array($_SESSION['usuario'])): ?>
                        <div class="card shadow-lg p-5 rounded-4 border-0" style="background: #f9f9f9;">
                            <h2 class="text-center mb-5 text-dark fw-bold" style="font-size: 2.5rem;">Perfil de Usuario</h2>
                            <div class="text-center mb-5">
                                <i class="fas fa-user-circle fa-8x mb-4 text-primary"></i>
                            </div>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center bg-light shadow-sm border-0 rounded-3 mb-4"
                                    style="font-size: 1.4rem;">
                                    <strong>Nombre:</strong>
                                    <span
                                        class="text-muted"><?php echo htmlspecialchars($_SESSION['usuario']['nombre'] ?? 'No disponible'); ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center bg-light shadow-sm border-0 rounded-3 mb-4"
                                    style="font-size: 1.4rem;">
                                    <strong>Apellidos:</strong>
                                    <span
                                        class="text-muted"><?php echo htmlspecialchars($_SESSION['usuario']['apellidos'] ?? 'No disponible'); ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center bg-light shadow-sm border-0 rounded-3 mb-4"
                                    style="font-size: 1.4rem;">
                                    <strong>Usuario:</strong>
                                    <span
                                        class="text-muted"><?php echo htmlspecialchars($_SESSION['usuario']['usuario'] ?? 'No disponible'); ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center bg-light shadow-sm border-0 rounded-3 mb-4"
                                    style="font-size: 1.4rem;">
                                    <strong>Email:</strong>
                                    <span
                                        class="text-muted"><?php echo htmlspecialchars($_SESSION['usuario']['email'] ?? 'No disponible'); ?></span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center bg-light shadow-sm border-0 rounded-3 mb-4"
                                    style="font-size: 1.4rem;">
                                    <strong>Teléfono:</strong>
                                    <span
                                        class="text-muted"><?php echo htmlspecialchars($_SESSION['usuario']['telefono'] ?? 'No disponible'); ?></span>
                                </li>
                            </ul>
                            <div class="d-flex flex-column flex-md-row justify-content-center gap-4 mt-5">
                                <a href="modificar_usuario.php" class="btn btn-primary btn-lg px-4 py-2 shadow-sm">Editar
                                    Perfil</a>
                                <a href="cerrar_sesion.php" name="cerrar"
                                    class="btn btn-danger btn-lg px-4 py-2 shadow-sm">Cerrar Sesión</a>
                            </div>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-warning text-center shadow-sm border-0 rounded-3">
                            <strong>No has iniciado sesión.</strong><br>
                            <a href="iniciar_sesion.php" class="btn btn-success mt-3 btn-lg shadow-sm">Iniciar Sesión</a>
                        </div>
                    <?php endif; ?>
                </div>

                <!-- Div de modificar perfiles (solo para administradores) -->
                <?php if ($_SESSION['usuario']['tipo'] == 'admin'): ?>
                    <div class="modificar-perfiles">
                        <div class="contenido-modificar">
                            <div class="card shadow-lg p-3 rounded-4 border-0" style="background: #f9f9f9;">
                                <h3 class="text-center mb-4 text-dark fw-bold" style="font-size: 2rem;">Modificar datos de
                                    otro usuario</h3>
                                <form action="modificar_usuario.php" method="POST" class="mt-4">
                                    <div class="mb-3">
                                        <label for="usuario_select" class="form-label">Selecciona un usuario:</label>
                                        <select id="usuario_select" name="usuario_id" class="form-control" required>
                                            <option value="">Selecciona un usuario</option>
                                            <?php
                                            if ($result && mysqli_num_rows($result) > 0) {
                                                while ($row = mysqli_fetch_assoc($result)) {
                                                    echo "<option value='" . $row['id'] . "'>" . htmlspecialchars($row['usuario']) . "</option>";
                                                }
                                            } else {
                                                echo "<option value=''>No hay usuarios disponibles</option>";
                                            }
                                            ?>
                                        </select>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-lg px-4 py-2 shadow-sm"
                                        style="width: 100%;">Modificar datos</button>
                                </form>
                            </div>
                        </div>
                        <br><br>
                        <!-- Div de eliminar perfiles (solo para administradores) -->
                        <?php
                        $result = mysqli_query($conexion, $query);
                        if ($_SESSION['usuario']['tipo'] == 'admin'): ?>
                            <div class="contenido-modificar">
                                <div class="card shadow-lg p-3 rounded-4 border-0" style="background: #f9f9f9;">
                                    <h3 class="text-center mb-4 text-dark fw-bold" style="font-size: 2rem;">Eliminar usuario
                                    </h3>
                                    <form action="index.php" method="POST" class="mt-4">
                                        <div class="mb-3">
                                            <label for="usuario_select" class="form-label">Selecciona un usuario:</label>
                                            <select id="usuario_select" name="usuario_id" class="form-control" required>
                                                <option value="">Selecciona un usuario</option>
                                                <?php
                                                if ($result && mysqli_num_rows($result) > 0) {
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        // Verificar si el nombre de usuario es "admin"
                                                        if ($row['usuario'] !== 'admin') {
                                                            echo "<option value='" . $row['id'] . "'>" . htmlspecialchars($row['usuario']) . "</option>";
                                                        }
                                                    }
                                                } else {
                                                    echo "<option value=''>No hay usuarios disponibles</option>";
                                                }
                                                ?>
                                            </select>
                                            <?php 
                                                if (isset($_SESSION['mensaje'])) {
                                                    echo "<div class='alert alert-succes'>" . $_SESSION['mensaje'] . "</div>";
                                                    unset($_SESSION['mensaje']); // Limpiar el mensaje después de mostrarlo
                                                }
                                            ?>
                                        </div>
                                        <button type="submit" name="eliminar" class="btn btn-danger btn-lg px-4 py-2 shadow-sm"
                                            style="width: 100%;">Eliminar</button>
                                    </form>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
                <!-- Tabla de reservas -->
            </div>
            <div id="contenedor-secundario">
                <div class="table-container">
                    <?php
                    $usuario_id = $_SESSION['usuario']['id'];
                    $query = "SELECT fecha, hora, localizador, motivo, estado FROM reservas WHERE usuario_id = $usuario_id";
                    $result = mysqli_query($conexion, $query);
                    ?>
                    <h2 class="text-center mb-5 text-dark fw-bold" style="font-size: 2.5rem;">Mis Reservas</h2>
                    <div style="overflow-x: auto;"> <!-- Contenedor para hacer la tabla responsiva -->
                        <table id="tabla-reservas">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Hora</th>
                                    <th>Localizador</th>
                                    <th>Motivo</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<tr>";
                                    echo "<td>" . htmlspecialchars($row['fecha']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['hora']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['localizador']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['motivo']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['estado']) . "</td>";
                                    echo "</tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
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
    <script>

        const selectElement = function (element) {
            return document.querySelector(element);
        }


        let menuToggle = selectElement('.menu-toggle');
        let body = selectElement('body');

        menuToggle.addEventListener('click', function () {
            body.classList.toggle('open');
        })

    </script>
</body>

</html>