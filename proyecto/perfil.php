<?php
session_start();
$conexion = mysqli_connect("localhost", "admin", "admin", "MotorClick_DB","3307");
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
                        <a href="" class="nav-link">Perfil</a>
                    </li>
                </ul>
            </nav>
        </div>
    </header>


    <section class="hero" id="hero">
        <div class="oscurecer"></div>
        <div class="container">
            <section class="container mt-5" style="max-width: 900px;">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <?php if (isset($_SESSION['usuario']) && is_array($_SESSION['usuario'])): ?>
                            <div class="card shadow-lg p-5 rounded-4 border-0" style="background: #f9f9f9;">
                                <h2 class="text-center mb-5 text-dark fw-bold" style="font-size: 2.5rem;">Perfil de Usuario
                                </h2>
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
                                    <!-- Contraseña -->
                                    <li class="list-group-item d-flex justify-content-between align-items-center bg-light shadow-sm border-0 rounded-3 mb-4"
                                        style="font-size: 1.4rem;">
                                        <strong>Contraseña:</strong>
                                        <span class="text-muted text-end" id="passwordText"
                                            data-password="<?php echo htmlspecialchars($_SESSION['usuario']['password']); ?>">*****</span>
                                        <div class="input-group-append">
                                            <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                                <i class="fas fa-eye" id="eyeIcon"></i>
                                            </button>
                                        </div>
                                    </li>
                                </ul>
                                <div class="d-flex flex-column flex-md-row justify-content-center gap-4 mt-5">
                                    <a href="editar_perfil.php" class="btn btn-primary btn-lg px-4 py-2 shadow-sm"
                                        style="width: 200px;">Editar Perfil</a>
                                    <a href="cerrar_sesion.php" name="cerrar" class="btn btn-danger btn-lg px-4 py-2 shadow-sm"
                                        style="width: 200px;">Cerrar Sesión</a>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="alert alert-warning text-center shadow-sm border-0 rounded-3">
                                <strong>No has iniciado sesión.</strong><br>
                                <a href="iniciar_sesion.php" class="btn btn-success mt-3 btn-lg shadow-sm">Iniciar
                                    Sesión</a>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
                <?php if ($_SESSION['usuario']['tipo'] == 'admin'): ?>
                    <section class="container mt-5" style="max-width: 900px;">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card shadow-lg p-5 rounded-4 border-0" style="background: #f9f9f9;">
                <h3 class="text-center mb-5 text-dark fw-bold" style="font-size: 2rem;">Modificar datos de otro usuario</h3>
                <form action="modificar_usuario.php" method="POST" class="mt-4">
                    <div class="mb-3">
                        <label for="usuario_select" class="form-label">Selecciona un usuario:</label>
                        <select id="usuario_select" name="usuario_id" class="form-control" required>
                            <option value="">Selecciona un usuario</option>
                            <?php
                            // Verifica si la consulta tiene resultados
                            if ($result && mysqli_num_rows($result) > 0) {
                                // Si hay usuarios, muestra las opciones
                                while ($row = mysqli_fetch_assoc($result)) {
                                    echo "<option value='" . $row['id'] . "'>" . htmlspecialchars($row['usuario']) . "</option>";
                                }
                            } else {
                                echo "<option value=''>No hay usuarios disponibles</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg px-4 py-2 shadow-sm" style="width: 100%;">Modificar datos</button>
                </form>
            </div>
        </div>
    </div>
</section>

<?php endif; ?>
            </section>

            <script>
                const togglePassword = document.getElementById('togglePassword');
                const passwordText = document.getElementById('passwordText');
                const eyeIcon = document.getElementById('eyeIcon');

                // Estado inicial: contraseña oculta (*****)
                let isHidden = true;

                togglePassword.addEventListener('click', function () {
                    if (isHidden) {
                        // Mostrar la contraseña real
                        passwordText.textContent = passwordText.getAttribute('data-password');
                    } else {
                        // Volver a ocultar la contraseña
                        passwordText.textContent = '*****';
                    }
                    isHidden = !isHidden;

                    // Alternar icono: ojo (para mostrar) vs. ojo cruzado (para ocultar)
                    eyeIcon.classList.toggle('fa-eye');
                    eyeIcon.classList.toggle('fa-eye-slash');
                });
            </script>

        </div>
    </section>
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
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls"
            data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls"
            data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    <script src="script.js"></script>
</body>

</html>