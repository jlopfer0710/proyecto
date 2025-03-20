<?php
session_start();
$conexion = mysqli_connect("localhost", "jorge", "KXiZ4xzfMclSLKv", "jorge");
if (isset($_POST['usuario_id'])) {
    // Si se ha enviado un usuario_id por POST, lo usamos
    $usuario_id = $_POST['usuario_id'];
} else {
    // Si no se ha enviado un usuario_id, tomamos el ID del usuario en sesión
    $usuario_id = $_SESSION['usuario']['id'];
}

// Consulta para obtener los datos del usuario seleccionado
$query = "SELECT * FROM usuarios WHERE id = $usuario_id"; 
$result = mysqli_query($conexion, $query);

if ($result && mysqli_num_rows($result) > 0) {
    // Si se encuentra el usuario, obtenemos los datos
    $usuario = mysqli_fetch_assoc($result);
} else {
    echo "Usuario no encontrado.";
    exit;
}
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

<header>
    <style>
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
                        <a href="home.php" class="nav-link ">Inicio</a>
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

    <?php if (isset($usuario)): ?>
    <section class="hero" id="hero">
        <div class="container">
            <h2 class="h2-sub"><span class="fil">Modificar Datos</span></h2>
            <div class="form-wrapper">
                <div class="form-container">
                    <form id="formulario_registro" action="index.php" method="POST">
                        <input type="hidden" name="usuario_id" value="<?php echo $usuario['id']; ?>">

                        <label for="nombre">Nombre:</label>
                        <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($usuario['nombre']); ?>" required>

                        <label for="apellidos">Apellidos:</label>
                        <input type="text" id="apellidos" name="apellidos" value="<?php echo htmlspecialchars($usuario['apellidos']); ?>" required>

                        <label for="usuario">Nombre de Usuario:</label>
                        <input type="text" id="usuario" name="usuario" value="<?php echo htmlspecialchars($usuario['usuario']); ?>" required>

                        <label for="password">Nueva Contraseña (opcional):</label>
                        <input type="password" id="password" name="password" placeholder="Ingrese nueva contraseña">

                        <label for="email">Correo Electrónico:</label>
                        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($usuario['email']); ?>" required>

                        <label for="telefono">Teléfono:</label>
                        <input type="tel" id="telefono" name="telefono" value="<?php echo htmlspecialchars($usuario['telefono']); ?>" required>

                        <button type="submit" class="btn cta-btn" id="enviar">Aplicar Cambios</button>
                    </form>
                </div>
            </div>
        </div>
    </section> 
<?php endif; ?>
    <!--<section class="hero" id="hero">
        <header>
            <div class="container">
                <nav class="nav">
                    <div class="menu-toggle">
                        <i class="fas fa-bars"></i>
                        <i class="fas fa-times"></i>
                    </div>
                    <a href="#" class="logo">LOGO</a>
                    <ul class="nav-list">
                        <li class="nav-item"><a href="index.html" class="nav-link active">Inicio</a></li>
                        <li class="nav-item"><a href="#" class="nav-link ">Menu</a></li>
                        <li class="nav-item"><a href="reservas.html" class="nav-link ">Reservas</a></li>
                        <li class="nav-item"><a href="#" class="nav-link ">Tienda</a></li>
                        <li class="nav-item"><a href="#" class="nav-link ">Contacto</a></li>
                    </ul>
                </nav>
            </div>
        </header>
    
        <!-- Tu Carrusel MANTENIDO 
        <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="/images/hero.webp" class="d-block w-100" alt="...">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>...</h5>
                        <p>...</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="/images/hero1.jpg" class="d-block w-100" alt="...">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>HFDJKF.</h5>
                        <p>...</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <img src="/images/hero.webp" class="d-block w-100" alt="...">
                    <div class="carousel-caption d-none d-md-block">
                        <h5>...</h5>
                        <p>...</p>
                    </div>
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </section>
-->

   
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

        const selectElement = function(element) {
            return document.querySelector(element);
        }


        let menuToggle = selectElement('.menu-toggle');
        let body = selectElement('body');

        menuToggle.addEventListener('click', function(){
            body.classList.toggle('open');
        })

    </script>

<div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="/images/hero.webp" class="d-block w-100" alt="...">
            <div class="carousel-caption d-none d-md-block">
                <h5>...</h5>
                <p>...</p>
            </div>
        </div>
        <div class="carousel-item">
            <img src="/images/hero1.jpg" class="d-block w-100" alt="...">
            <div class="carousel-caption d-none d-md-block">
                <h5>gf.</h5>
                <p>...</p>
            </div>
        </div>
        <div class="carousel-item">
            <img src="/images/hero.webp" class="d-block w-100" alt="...">
            <div class="carousel-caption d-none d-md-block">
                <h5>...</h5>
                <p>...</p>
            </div>
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>
<script src="script_modif.js"></script>
</body>
</html>

