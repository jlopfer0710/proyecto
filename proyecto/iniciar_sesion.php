<?php
session_start();

// Inicializar la variable $error
$error = "";

// Simulación de conexión a la base de datos (reemplaza con tus credenciales)
$conexion = mysqli_connect("localhost", "jorge", "KXiZ4xzfMclSLKv", "jorge");

// Verificar si se envió el formulario de inicio de sesión
if (isset($_POST['login'])) {
    $usuario = mysqli_real_escape_string($conexion, $_POST['usuario']);
    $password = $_POST['password']; // Contraseña en texto plano

    if (empty($usuario) || empty($password)) {
        $error = "Por favor, completa todos los campos.";
    } else {
        // Consulta para obtener los datos del usuario
        $query = "SELECT id, nombre, usuario, apellidos, email, telefono, password, tipo 
                  FROM usuarios 
                  WHERE usuario = '$usuario' OR email = '$usuario'";
        $result = mysqli_query($conexion, $query);

        if ($row = mysqli_fetch_assoc($result)) {
            // Verificar si la contraseña coincide
            if (password_verify($password, $row['password'])) {
                // Contraseña correcta, iniciar sesión
                $_SESSION['usuario'] = [
                    "id" => $row['id'],
                    "nombre" => $row['nombre'],
                    "usuario" => $row['usuario'],
                    "apellidos" => $row['apellidos'],
                    "email" => $row['email'],
                    "telefono" => $row['telefono'],
                    "tipo" => $row['tipo']
                ];
                header("Location: home.php"); // Redirigir al home
                exit;
            } else {
                // Contraseña incorrecta
                $error = "Contraseña incorrecta.";
            }
        } else {
            // Usuario no encontrado
            $error = "Usuario no encontrado.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <style>
        .logo{
            display: flex;
            align-items: center;
            height: 0%;
        }
        .logo img{
            border-radius: 50%;
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
                            <a href="iniciar_sesion.php" class="nav-link active">Iniciar Sesión</a>
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
            <h2 class="h2-sub"><span class="fil">Inicia Sesión</span></h2>
            <div class="form-wrapper">
                <div class="form-container">
                    <form action="" method="POST">
                        <label for="usuario">Nombre de Usuario o Correo Electrónico:</label>
                        <input type="text" id="usuario" name="usuario" required>
                        <label for="password">Contraseña:</label>
                        <input type="password" id="password" name="password" required>
                        <button type="submit" name="login" class="btn cta-btn">Entrar</button>
                        <?php if ($error === "Contraseña incorrecta."): ?>
                            <p style="color: red;"><?php echo $error; ?> <a href="recuperar_contra.php">¿Has olvidado la contraseña?</a></p>
                        <?php endif; ?>
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
        const selectElement = function(element) {
            return document.querySelector(element);
        }

        let menuToggle = selectElement('.menu-toggle');
        let body = selectElement('body');

        menuToggle.addEventListener('click', function(){
            body.classList.toggle('open');
        });
    </script>
</body>
</html>