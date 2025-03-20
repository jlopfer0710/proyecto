<?php
session_start();
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
                    <li class="nav-item">
                        <a href="home.php" class="nav-link active">Inicio</a>
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
        <div class="oscurecer"></div>
        <div class="container">
            <h2 class="h2-sub">
                <span class="fil">Bienvenido</span>&nbsp 
                <div id="message" class="fil">
                    <?php
                    if (isset($_SESSION['usuario'])) {
                        echo $_SESSION['usuario']['usuario']; // Mostrar el nombre de usuario
                    }
                    ?>
                </div>
            </h2>
            <h1 class="head">MotorClick</h1>
            <div class="he-des">
  <div class="search-bar">
    <input type="text" id="searchInput" placeholder="Buscar en MotorClick...">
    <div id="suggestions" class="suggestions-box"></div>
  </div>
</div>



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

    <section class="dis-sto">
        <div class="container">
            <div class="res-info">
                <div>
                    <img src="images/nosotros_moto.jpg" alt="">
                </div>

                <div class="res-des pad-rig" >
                    <div class="global">
                        <h2 class="h2-sub">
                        <span class="fil">Descubre nuestros</span>&nbsp 
                        </h2>
                        <h1 class="head hea-dark">Servicios</h1>
                        <div class="circle">
                            <i class="fas fa-circle"></i>
                        </div>
                    </div>
                    &nbsp;<p style="margin-left:10px;">
                        Ofrecemos una variedad de servicios donde cubrimos todas tus necesidades.
                        Si quieres saber más pulsa en el botón
                    </p>
                    <a href="servicios.php" class="btn cta-btn">Descrube más</a>
                </div>

            </div>
        </div>
    </section>


    <section class="taste bt">
        <div class="container">
            <div class="global">
                <h2 class="h2-sub">
                    <span class="fil">P</span>ide ya tu
                </h2>
                <h1 class="head">CITA</h1>
            </div>
        </div>
    </section>


    <section class="disco">
        <div class="container">
            <div class="res-info">
                <div class="res-des">
                    <div class="global">
                        <h2 class="h2-sub">
                            <span class="fil">S</span>olicita
                        </h2>
                        <h1 class="head hea-dark">Reservas</h1>
                        <div class="circle">
                            <i class="fas fa-circle"></i>
                        </div>
                    </div>
                    <p style="margin-right:20px;" >
                        Si necesitas nuestra ayuda podemos ayudarte con solo una cita.
                        Regístrate, pide ya tu reserva y nosotros nos encargamos del resto
                    </p>
                    <a href="reservas.php" class="btn cta-btn">Pide tu cita</a>
                </div>
                <div class="image-group pad-rig">
                    <img src="images/herramientas-1.jpg" alt="">
                    <img src="images/herramientas-2.jpg" alt="">
                    <img src="images/herramientas-4.jpg" alt="">
                    <img src="images/herramientas-3.jpg" alt="">
                </div>

            </div>
        </div>
    </section>

    <section class="pb bt">
        <div class="container">
            <div class="global">
                <h2 class="h2-sub">
                    <span class="fil">D</span>escubre tu
                </h2>
                <h1 class="head">Avería</h1>
            </div>
        </div>
    </section>

    <section id="perfil-section">
  <div class="container">
    <div class="res-info">
      <div class="image-group">
        <img src="images/taller-1.jpg" alt="">
        <img src="images/taller-2.jpg" alt="">
      </div>
      <div class="res-des pad-rig">
        <div class="global">
          <h2 class="h2-sub">
            <span class="fil">P</span>ersonaliza tu
          </h2>
          <h1 class="head hea-dark">Perfil</h1>
          <div class="circle">
            <i class="fas fa-circle"></i>
          </div>
        </div>
        <p style="margin-left:20px;" >
          Puedes modificar tu perfil para poder comunicarnos contigo más fácil.
          Además podrás ver tus reservas y si necesitas modificar o eliminar alguna contáctanos!!
        </p>
        <a href="perfil.php" class="btn cta-btn">Tu perfil</a>
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
    <script src="script.js"></script>
    <!--BARRA DE NAVEGACION-->
    <script>
  // Lista de sugerencias (ajústala según los términos que desees)
  const suggestions = [
    "Cambio de aceite",
    "Revisión de frenos",
    "Cambio de neumáticos",
    "Diagnóstico computarizado",
    "Reparación de motor",
    "Reserva de cita",
    "Agendar reserva",
    "Contacto",
    "Ayuda",
    "Perfil",
    "Personaliza tu perfil"
  ];

  const searchInput = document.getElementById("searchInput");
  const suggestionsBox = document.getElementById("suggestions");

  // Función que determina la URL o acción según la consulta ingresada.
  function getRedirectURL(query) {
    const lowerQuery = query.toLowerCase();
    if (lowerQuery.includes("perfil")) {
      // Redirige a la sección del perfil en la misma página
      return "#perfil-section";
    }
    if (lowerQuery.includes("contacto") || lowerQuery.includes("ayuda")) {
      return "contacto.php?query=" + encodeURIComponent(query);
    }
    if (
      lowerQuery.includes("servicio") ||
      lowerQuery.includes("cambio de aceite") ||
      lowerQuery.includes("revisión") ||
      lowerQuery.includes("diagnóstico") ||
      lowerQuery.includes("reparación") ||
      lowerQuery.includes("mecánica") ||
      lowerQuery.includes("mecánico")
    ) {
      return "servicios.php?query=" + encodeURIComponent(query);
    }
    if (
      lowerQuery.includes("reserva") ||
      lowerQuery.includes("cita")
    ) {
      return "reservas.php?query=" + encodeURIComponent(query);
    }
    // Página genérica de resultados si no coincide con ninguno
    return "home.php?query=" + encodeURIComponent(query);
  }

  // Función para mostrar las sugerencias filtradas
  function showSuggestions(filteredSuggestions) {
    suggestionsBox.innerHTML = "";
    if (filteredSuggestions.length > 0) {
      suggestionsBox.style.display = "block";
      const ul = document.createElement("ul");
      filteredSuggestions.forEach(item => {
        const li = document.createElement("li");
        li.textContent = item;
        li.addEventListener("click", function() {
          searchInput.value = item;
          suggestionsBox.style.display = "none";
          const redirectURL = getRedirectURL(item);
          if (redirectURL.startsWith("#")) {
            // Desplazamiento interno a la sección de perfil
            document.querySelector(redirectURL).scrollIntoView({ behavior: 'smooth' });
          } else {
            window.location.href = redirectURL;
          }
        });
        ul.appendChild(li);
      });
      suggestionsBox.appendChild(ul);
    } else {
      suggestionsBox.style.display = "none";
    }
  }

  // Mostrar sugerencias mientras se escribe
  searchInput.addEventListener("input", function() {
    const query = this.value;
    if (query.length === 0) {
      suggestionsBox.style.display = "none";
      return;
    }
    const filteredSuggestions = suggestions.filter(item =>
      item.toLowerCase().includes(query.toLowerCase())
    );
    showSuggestions(filteredSuggestions);
  });

  // Manejar la tecla Enter: redirige según la consulta actual
  searchInput.addEventListener("keydown", function(e) {
    if (e.key === "Enter") {
      e.preventDefault();
      const query = this.value;
      const redirectURL = getRedirectURL(query);
      if (redirectURL.startsWith("#")) {
        document.querySelector(redirectURL).scrollIntoView({ behavior: 'smooth' });
      } else {
        window.location.href = redirectURL;
      }
    }
  });

  // Ocultar sugerencias al hacer clic fuera del input
  document.addEventListener("click", function(e) {
    if (!searchInput.contains(e.target)) {
      suggestionsBox.style.display = "none";
    }
  });
</script>



</body>

</html>