<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <!-- Mismos metadatos y enlaces que index.html -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Servicios - MotorClick</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
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
                    <li class="nav-item">
                        <a href="home.php" class="nav-link ">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a href="servicios.php" class="nav-link active">Servicios</a>
                    </li>
                    <li class="nav-item">
                        <a href="reservas.php" class="nav-link ">Reservas</a>
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
    <section class="hero3" id="hero3">
        <!-- Carrusel de Bootstrap -->
    <div id="backgroundCarousel" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <!-- Imagen 1 -->
            <div class="carousel-item active">
                <img src="images/herramientas-1.jpg" class="d-block w-100" alt="Caja de herramientas 1">
            </div>
            <!-- Imagen 2 -->
            <div class="carousel-item">
                <img src="images/herramientas-2.jpg" class="d-block w-100" alt="Caja de herramientas 2">
            </div>
            <!-- Imagen 3 -->
            <div class="carousel-item">
                <img src="images/herramientas-3.jpg" class="d-block w-100" alt="Caja de herramientas 3">
            </div>
            <!-- Imagen 4 -->
            <div class="carousel-item">
                <img src="images/herramientas-4.jpg" class="d-block w-100" alt="Caja de herramientas 4">
            </div>
        </div>
    </div>
    <section class="services-section py-5">
        <div class="container">
            <div class="row g-4">
                <!-- Servicio 1 -->
                <div class="col-md-6 col-lg-4">
                    <div class="service-card card h-100 shadow-lg">
                        <div class="card-body">
                            <i class="fas fa-oil-can fa-3x text-primary mb-4"></i>
                            <h3 class="h4 card-title">Cambio de Aceite y Filtro</h3>
                            <p class="card-text">Mantenimiento esencial para prolongar la vida de tu motor con productos de máxima calidad.</p>
                            <a href="reservas.php" class="btn cta-btn">Reservar</a>
                        </div>
                    </div>
                </div>

                <!-- Servicio 2 -->
                <div class="col-md-6 col-lg-4">
                    <div class="service-card card h-100 shadow-lg">
                        <div class="card-body">
                          <i class="fas fa-car-side fa-3x text-primary mb-4"></i>
                            <h3 class="h4 card-title">Cambio de Rueda</h3>
                            <p class="card-text">Montaje profesional y equilibrado preciso para máxima seguridad en carretera.</p>
                            <a href="reservas.php" class="btn cta-btn">Reservar</a>
                        </div>
                    </div>
                </div>

                <!-- Servicio 3 -->
                <div class="col-md-6 col-lg-4">
                    <div class="service-card card h-100 shadow-lg">
                        <div class="card-body">
                            <i class="fas fa-car-crash fa-3x text-primary mb-4"></i>
                            <h3 class="h4 card-title">Revisión de ITV</h3>
                            <p class="card-text">Pre-ITV completa para asegurar el éxito en tu inspección técnica.</p>
                            <a href="reservas.php" class="btn cta-btn">Reservar</a>
                        </div>
                    </div>
                </div>

                <!-- Servicio 4 -->
                <div class="col-md-6 col-lg-4">
                    <div class="service-card card h-100 shadow-lg">
                        <div class="card-body">
                            <i class="fas fa-battery-full fa-3x text-primary mb-4"></i>
                            <h3 class="h4 card-title">Nivelar la Batería</h3>
                            <p class="card-text">Comprobación y carga profesional para óptimo rendimiento eléctrico.</p>
                            <a href="reservas.php" class="btn cta-btn">Reservar</a>
                        </div>
                    </div>
                </div>

                <!-- Servicio 5 -->
                <div class="col-md-6 col-lg-4">
                    <div class="service-card card h-100 shadow-lg">
                        <div class="card-body">
                            <i class="fas fa-lightbulb fa-3x text-primary mb-4"></i>
                            <h3 class="h4 card-title">Revisión de Luces</h3>
                            <p class="card-text">Alineación y sustitución de sistema de iluminación para máxima visibilidad.</p>
                            <a href="reservas.php" class="btn cta-btn">Reservar</a>
                        </div>
                    </div>
                </div>

                <!-- Servicio 6 -->
                <div class="col-md-6 col-lg-4">
                    <div class="service-card card h-100 shadow-lg">
                        <div class="card-body">
                            <i class="fas fa-tools fa-3x text-primary mb-4"></i>
                            <h3 class="h4 card-title">Revisión Completa</h3>
                            <p class="card-text">Diagnóstico completo de 50 puntos para garantizar el perfecto estado de tu vehículo.</p>
                            <a href="reservas.php" class="btn cta-btn">Reservar</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    </section>
    
    <!-- Sección CTA -->
    <section style="z-index:10; position: relative;" class="bg-dark text-light py-5">
        <div class="container text-center">
            <h2 class="mb-4">¿No estas seguro de lo que necesitas?</h2>
            <p class="lead mb-4">Contacta con nuestros especialistas para una atención individualizada</p>
            <a href="contacto.php" class="btn cta-btn btn-lg">Consulta</a>
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

    <!-- Mismos scripts que index.html -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Mismo JavaScript de index.html para el menú móvil
        const selectElement = function(element) {
            return document.querySelector(element);
        }

        let menuToggle = selectElement('.menu-toggle');
        let body = selectElement('body');

        menuToggle.addEventListener('click', function(){
            body.classList.toggle('open');
        });

        // Animación al hacer scroll
        window.addEventListener('scroll', function() {
            const serviceCards = document.querySelectorAll('.service-card');
            serviceCards.forEach(card => {
                const cardPosition = card.getBoundingClientRect().top;
                const screenPosition = window.innerHeight / 1.3;
                
                if(cardPosition < screenPosition) {
                    card.style.opacity = '1';
                    card.style.transform = 'translateY(0)';
                }
            });
        });
    </script>
    
</body>
</html>