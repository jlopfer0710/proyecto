<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    session_start();
    ?>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MotorClick</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://unpkg.com/fullcalendar@5.11.3/main.min.css" rel="stylesheet" />

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
                        <a href="servicios.php" class="nav-link">Servicios</a>
                    </li>
                    <li class="nav-item">
                        <a href="reservas.php" class="nav-link active">Reservas</a>
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
    <section style='margin-top: -100px;' class="hero2" id="hero">
        <div class="container">
            <h2 class="h2-sub">
                <span class="fil">RESERVAS</span>&nbsp
            </h2>
        </div>
        <div id="calendar"></div>
        <!-- Formulario de filtro -->
        <form class="filtro-container">
            <div class="filtro-grid">
                <div class="filtro-group">
                    <label class="filtro-label">Mes</label>
                    <select id="mesSelect" class="filtro-select">
                        <option value="1">Enero</option>
                        <option value="2">Febrero</option>
                        <option value="3">Marzo</option>
                        <option value="4">Abril</option>
                        <option value="5">Mayo</option>
                        <option value="6">Junio</option>
                        <option value="7">Julio</option>
                        <option value="8">Agosto</option>
                        <option value="9">Septiembre</option>
                        <option value="10">Octubre</option>
                        <option value="11">Noviembre</option>
                        <option value="12">Diciembre</option>
                    </select>
                </div>
                <div class="filtro-group">
                    <label class="filtro-label">Día</label>
                    <select id="diaSelect" class="filtro-select"></select>
                </div>
            </div>
            <button type="submit" class="filtro-btn">Filtrar</button>
        </form>

        <!-- Contenedor para mostrar información de las reservas y el formulario de solicitud -->
        <div id="reservationsInfo" style="text-align: center; margin-top: 20px;"></div>
        <div id="reservationFormContainer" style="margin-top: 20px;"></div>

    </section>

    <script src="https://unpkg.com/fullcalendar@5.11.3/main.min.js"></script>
    <script>
        // Función para actualizar el select de días en función del mes seleccionado
        function actualizarDias() {
            // Definimos la cantidad de días en cada mes (enero tiene 31, febrero 28, etc.)
            const diasPorMes = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];

            // Obtenemos el mes seleccionado por el usuario
            const mes = document.getElementById('mesSelect').value;

            // Referencia al select de días
            const diaSelect = document.getElementById('diaSelect');

            // Limpiamos el select de días antes de agregar nuevas opciones
            diaSelect.innerHTML = '';

            // Llenamos el select con los días correspondientes al mes seleccionado
            for (let i = 1; i <= diasPorMes[mes - 1]; i++) {
                diaSelect.innerHTML += `<option value="${i}">${i}</option>`;
            }
        }

        // Esperamos a que el contenido del DOM esté completamente cargado
        document.addEventListener('DOMContentLoaded', () => {

            // Inicializamos el calendario con FullCalendar
            const calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
                initialView: 'dayGridMonth', // Vista inicial del calendario (mes)
                locale: 'es', // Idioma en español
                headerToolbar: {
                    left: 'prev,next', // Botones de navegación (anterior y siguiente)
                    center: 'title,today', // Muestra el título del mes y el botón de "hoy"
                    right: 'dayGridMonth,timeGridWeek,timeGridDay' // Opciones de visualización
                },
                slotMinTime: '08:00:00', // Hora mínima permitida para reservas
                slotMaxTime: '15:00:00', // Hora máxima permitida para reservas
                slotLabelFormat: { hour: '2-digit', minute: '2-digit', hour12: false }, // Formato de horas en 24h
                contentHeight: 'auto', // Altura del calendario automática
                expandRows: false, // No expandir filas automáticamente
                events: 'getCalendarEvents.php' // Carga de eventos desde el servidor
            });

            // Renderizamos el calendario
            calendar.render();

            // Inicializamos el select de días según el mes seleccionado
            actualizarDias();

            // Detectamos cambios en el select de meses y actualizamos los días
            document.getElementById('mesSelect').addEventListener('change', actualizarDias);

            // Evento cuando el usuario envía el formulario de filtro de fecha
            document.querySelector('.filtro-container').addEventListener('submit', function (e) {
                e.preventDefault(); // Evita que la página se recargue

                // Obtenemos los valores seleccionados en el formulario
                const mes = document.getElementById('mesSelect').value;
                const dia = document.getElementById('diaSelect').value;

                // Construimos la fecha en formato YYYY-MM-DD
                const year = new Date().getFullYear();
                const mesFormateado = mes.padStart(2, '0'); // Asegura que tenga dos dígitos
                const diaFormateado = dia.padStart(2, '0'); // Asegura que tenga dos dígitos
                const fechaSeleccionada = `${year}-${mesFormateado}-${diaFormateado}`;

                // Petición AJAX para obtener las reservas de la fecha seleccionada
                fetch('getReservations.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: 'fecha=' + encodeURIComponent(fechaSeleccionada)
                })
                    .then(response => response.json()) // Convertimos la respuesta del servidor en JSON
                    .then(data => {
                        let reservedText = "";

                        // Si hay horas reservadas, las mostramos
                        if (data.reserved_hours && data.reserved_hours.length > 0) {
    reservedText = `<p style="color: white;">Horas reservadas para ${fechaSeleccionada}: ${data.reserved_hours.join(', ')}</p>`;
} else {
    reservedText = `<p style="color: white;">No hay reservas para ${fechaSeleccionada}</p>`;
}

                        // Mostramos las horas reservadas en el HTML
                        document.getElementById('reservationsInfo').innerHTML = reservedText;

                        // Generamos las opciones del select de horas disponibles (de 8 a 15)
                        let availableHoursOptions = "";
                        for (let h = 8; h <= 15; h++) {
                            const formattedHour = (h < 10 ? "0" + h : h) + ":00:00";

                            // Si la hora ya está reservada, la omitimos
                            if (data.reserved_hours && data.reserved_hours.includes(formattedHour)) {
                                continue;
                            }

                            availableHoursOptions += `<option value="${formattedHour}">${formattedHour}</option>`;
                        }

                        // Construimos el formulario de solicitud de cita
                        const formHTML = `
                <style>
  /* Cambia el color del texto de las etiquetas dentro del formulario a blanco */
  #reservationForm label {
    color: #fff !important;
  }
  /* Evita que los inputs y selects hereden el color blanco de sus padres */
  #reservationForm label input,
  #reservationForm label select,
  #reservationForm label option {
    color: #000 !important;
  }
</style>

                    <form class="reservarForm" id="reservationForm" action="procesar_reserva.php" method="POST">
                        <p>
                            <label>Nombre: 
                                <input type="text" name="nombre" required>
                            </label>
                        </p>
                        <p>
                            <label>Fecha de la cita a solicitar: 
                                <input type="date" name="fecha" value="${fechaSeleccionada}" required>
                            </label>
                        </p>
                        <p>
                            <label>Hora de la cita: 
                                <select name="hora" required>
                                    ${availableHoursOptions ? availableHoursOptions : '<option value="">No hay horas disponibles</option>'}
                                </select>
                            </label>
                        </p>
                        <p>
                            <label>Motivo de la cita: 
                                <select name="motivo" required>
                                    <option value="Cambio de Aceite y Filtro">Cambio de Aceite y Filtro</option>
                                    <option value="Cambio de Rueda">Cambio de Rueda</option>
                                    <option value="Revisión de ITV">Revisión de ITV</option>
                                    <option value="Nivelar la Batería">Nivelar la Batería</option>
                                    <option value="Revisión de Luces">Revisión de Luces</option>
                                    <option value="Revisión Completa">Revisión Completa</option>
                                </select>
                            </label>
                        </p>
                        <p><button type="submit">Solicitar Cita</button></p>
                    </form>
                `;

                        // Insertamos el formulario en el contenedor HTML
                        document.getElementById('reservationFormContainer').innerHTML = formHTML;

                        // Evento cuando se envía el formulario de reserva
                        document.getElementById('reservationForm').addEventListener('submit', function (e) {
                            e.preventDefault(); // Evita la recarga de la página

                            // Recopilamos los datos del formulario
                            const formData = new FormData(this);

                            // Enviamos la reserva al servidor
                            fetch('procesar_reserva.php', {
                                method: 'POST',
                                body: formData
                            })
                                .then(response => response.json()) // Convertimos la respuesta en JSON
                                .then(data => {
                                    if (data.status === "success") {
                                        alert('Reserva realizada exitosamente');
                                        window.location.href = "reservas.php"; // Recargamos la página para actualizar la información
                                    } else {
                                        alert('Error al realizar la reserva: ' + data.message);
                                    }
                                })
                                .catch(error => {
                                    alert('Hubo un error: ' + error.message);
                                });
                        });
                    })
                    .catch(error => console.error('Error en la petición AJAX:', error));
            });
        });
    </script>
    <footer>
        <div class="container">
            <div class="footer-content">

                <div class="footer-content-about">
                    <h4>Nosotros</h4>
                    <div class="circle">
                        <i class="fas fa-circle"></i>
                    </div>
                    <p>Bienvenido a MotorClick. Somos tu taller de mecánica de confianza, donde puedes reservar citas en
                        línea
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
