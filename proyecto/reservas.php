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
  <style>
    /* Estilos */
    #calendar {
      margin-bottom: 10px !important;
    }
    .filtro-container {
      width: 80%;
      margin: -10px auto 30px;
      padding: 0 15px;
      margin-top: 70%;
    }
  </style>
</head>
<body>
  <header>
    <div class="container">
      <nav class="nav">
        <!-- Menú de navegación -->
        <div class="menu-toggle">
          <i class="fas fa-bars"></i>
          <i class="fas fa-times"></i>
        </div>
        <a href="#" class="logo">LOGO</a>
        <ul class="nav-list">
          <li class="nav-item"><a href="home.php" class="nav-link active">Inicio</a></li>
          <li class="nav-item"><a href="servicios.php" class="nav-link">Servicios</a></li>
          <li class="nav-item"><a href="reservas.php" class="nav-link">Reservas</a></li>
          <li class="nav-item"><a href="#" class="nav-link">Contacto</a></li>
        </ul>
      </nav>
    </div>
    <div id="calendar"></div>
  </header>

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

  <script src="https://unpkg.com/fullcalendar@5.11.3/main.min.js"></script>
  <script>
    // Función para actualizar el select de días en función del mes seleccionado
    function actualizarDias() {
      const diasPorMes = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
      const mes = document.getElementById('mesSelect').value;
      const diaSelect = document.getElementById('diaSelect');
      diaSelect.innerHTML = '';
      for (let i = 1; i <= diasPorMes[mes - 1]; i++) {
        diaSelect.innerHTML += `<option value="${i}">${i}</option>`;
      }
    }

    document.addEventListener('DOMContentLoaded', () => {
    // Inicializar el calendario y el select de días (ya lo tienes)
    const calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
        initialView: 'dayGridMonth',
        locale: 'es',
        headerToolbar: {
            left: 'prev,next today',
            center: 'title',
            right: 'dayGridMonth,timeGridWeek,timeGridDay'
        },
        slotMinTime: '08:00:00',
        slotMaxTime: '15:00:00',
        slotLabelFormat: { hour: '2-digit', minute: '2-digit', hour12: false },
        contentHeight: 'auto',
        expandRows: false,
        events: 'getCalendarEvents.php'
    });
    calendar.render();

    // Inicializar select de días (ya lo tienes)
    actualizarDias();
    document.getElementById('mesSelect').addEventListener('change', actualizarDias);

    // Al enviar el filtro...
    document.querySelector('.filtro-container').addEventListener('submit', function(e) {
        e.preventDefault();
        const mes = document.getElementById('mesSelect').value;
        const dia = document.getElementById('diaSelect').value;
        // Fecha seleccionada (ya lo tienes)
        const year = new Date().getFullYear();
        const mesFormateado = mes.padStart(2, '0');
        const diaFormateado = dia.padStart(2, '0');
        const fechaSeleccionada = `${year}-${mesFormateado}-${diaFormateado}`;

        // Realizar petición AJAX para obtener las horas ya reservadas para esa fecha
        fetch('getReservations.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'fecha=' + encodeURIComponent(fechaSeleccionada)
        })
        .then(response => response.json())
        .then(data => {
            let reservedText = "";
            if (data.reserved_hours && data.reserved_hours.length > 0) {
                reservedText = `<p>Horas reservadas para ${fechaSeleccionada}: ${data.reserved_hours.join(', ')}</p>`;
            } else {
                reservedText = `<p>No hay reservas para ${fechaSeleccionada}</p>`;
            }
            document.getElementById('reservationsInfo').innerHTML = reservedText;

            // Generar las opciones para el select de horas disponibles (de 8 a 15)
            let availableHoursOptions = "";
            for (let h = 8; h <= 15; h++) {
                const formattedHour = (h < 10 ? "0" + h : h) + ":00:00";
                // Si la hora está reservada, se omite
                if (data.reserved_hours && data.reserved_hours.includes(formattedHour)) {
                    continue;
                }
                availableHoursOptions += `<option value="${formattedHour}">${formattedHour}</option>`;
            }

            // Construir el formulario de solicitud de cita
            const formHTML = `
                <form id="reservationForm" action="procesar_reserva.php" method="POST">
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
            document.getElementById('reservationFormContainer').innerHTML = formHTML;

            // Al enviar el formulario de reserva
            document.getElementById('reservationForm').addEventListener('submit', function(e) {
                e.preventDefault(); // Evitar la redirección
                const formData = new FormData(this);

                fetch('procesar_reserva.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === "success") {
                        alert('Reserva realizada exitosamente');
                        // Aquí no redirigimos, simplemente recargamos la página actual
                        window.location.href = "reservas.php";  // Esto recargará la página y mostrará el mensaje
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
</body>
</html>
