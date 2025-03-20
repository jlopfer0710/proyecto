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

<style>
  .logo {
    display: flex;
    align-items: center;
    height: 0%;
}
.logo img{
    border-radius:50%;
}
    /* Estilos propios para el chatbot y FAQ */
    body {
      background-color: #f5f5f5;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }
    /* Fondo de la sección, igual que en perfil.php */
    /*.hero {
      position: relative;
      display: flex;
      flex-direction: column;
      justify-content: flex-start;
      align-items: center;
      padding-top: 100px;
      padding: 50px 20px;
      background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url("images/moto.jpg");
      background-size: cover;
      background-position: center 20%;
      min-height: 100vh;
      overflow: hidden;
    }*/
    /* Capa para oscurecer el fondo */
    .oscurecer {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0,0,0,0.3);
      z-index: 1;
    }
    /* Para que el contenido quede por encima del fondo */
    .content-wrapper {
      position: relative;
      z-index: 2;
    }
    .chat-container {
      border-radius: 10px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
      background-color: #fff;
      overflow: hidden;
      margin-bottom: 30px;
      /* Aumenta el tamaño de fuente en el chatbot */
      font-size: 1.8rem;
    }
    .chat-header {
      background-color: #4e73df;
      color: white;
      padding: 15px;
      font-weight: bold;
      border-top-left-radius: 10px;
      border-top-right-radius: 10px;
    }
    .chat-messages {
      height: 400px;
      overflow-y: auto;
      padding: 15px;
      background-color: #f9f9f9;
    }
    .message {
      margin-bottom: 15px;
      padding: 10px 15px;
      border-radius: 20px;
      max-width: 75%;
      white-space: pre-wrap;
    }
    .user-message {
      background-color: #e3f2fd;
      margin-left: auto;
      border-bottom-right-radius: 5px;
    }
    .bot-message {
      background-color: #f1f1f1;
      margin-right: auto;
      border-bottom-left-radius: 5px;
    }
    .chat-input {
      padding: 15px;
      background-color: #fff;
      border-top: 1px solid #eee;
    }
    /* Nueva regla para aumentar el tamaño de la barra de chat */
    .chat-input input {
      font-size: 2rem;
      padding: 1.2rem;
    }
    .typing-indicator {
      display: none;
      padding: 10px 15px;
      background-color: #f1f1f1;
      border-radius: 20px;
      margin-bottom: 15px;
      width: fit-content;
      color: #666;
    }
    .dot {
      display: inline-block;
      width: 8px;
      height: 8px;
      border-radius: 50%;
      background-color: #666;
      animation: wave 1.3s linear infinite;
      margin-right: 3px;
    }
    .dot:nth-child(2) { animation-delay: -1.1s; }
    .dot:nth-child(3) { animation-delay: -0.9s; }
    @keyframes wave {
      0%, 60%, 100% { transform: initial; }
      30% { transform: translateY(-5px); }
    }
    /* Estilos para el FAQ */
    .faq-container {
      background-color: #fff;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 5px 15px rgba(0,0,0,0.1);
      margin-bottom: 30px;
      /* Aumenta el tamaño de fuente en el FAQ */
      font-size: 1.8rem;
    }
    /* Aumentar la tipografía en el acordeón del FAQ */
    .faq-container .accordion-button {
      font-size: 1.8rem;
    }
    .faq-container .accordion-body {
      font-size: 1.8rem;
    }
    .chat-input button {
  font-size: 1.5rem;
  padding: 1.2rem 2rem;
}
  </style>
</head>
<body>

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
                        <a href="reservas.php" class="nav-link">Reservas</a>
                    </li>
                    <li class="nav-item">
                        <a href="contacto.php" class="nav-link active">Contacto</a>
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
    <div class="container content-wrapper">
        
      <!-- Fila con align-items-start para que cada columna tenga su propia altura -->
      <div class="container mt-5">
        <div class="row align-items-start">
          <!-- Chatbot -->
          <div class="col-md-6">
            <div class="chat-container">
              <div class="chat-header">
                <div class="row align-items-center">
                  <div class="col-1">
                    <i class="bi bi-chat-dots-fill"></i>
                  </div>
                  <div class="col">
                    Asistente virtual
                  </div>
                </div>
              </div>
              <div class="chat-messages" id="chatMessages">
                <div class="message bot-message">Hola! Soy tu asistente virtual. ¿Cómo puedo ayudarte?</div>
                <div class="typing-indicator" id="typingIndicator">
                  <span class="dot"></span>
                  <span class="dot"></span>
                  <span class="dot"></span>
                </div>
              </div>
              <div class="chat-input">
                <form id="chatForm">
                  <div class="input-group">
                    <input type="text" id="userInput" class="form-control" placeholder="Escribe 'comandos' para más ayuda..." autocomplete="off">
                    <button class="btn btn-primary" type="submit">Enviar</button>
                  </div>
                </form>
              </div>
            </div>
          </div>

          <!-- FAQ -->
          <div class="col-md-6">
            <div class="faq-container">
              <h2 class="text-center mb-4">Preguntas Frecuentes</h2>
              <div class="accordion" id="faqAccordion">
                <div class="accordion-item">
                  <h2 class="accordion-header" id="faqHeadingOne">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapseOne" aria-expanded="true" aria-controls="faqCollapseOne">
                      ¿Cómo agendo una cita?
                    </button>
                  </h2>
                  <div id="faqCollapseOne" class="accordion-collapse collapse show" aria-labelledby="faqHeadingOne" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                      Para agendar una cita, puedes utilizar nuestra sección de Reservas o escribir "cita" en el chat para recibir asistencia.
                    </div>
                  </div>
                </div>
                <div class="accordion-item">
                  <h2 class="accordion-header" id="faqHeadingTwo">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapseTwo" aria-expanded="false" aria-controls="faqCollapseTwo">
                      ¿Qué servicios ofrecen?
                    </button>
                  </h2>
                  <div id="faqCollapseTwo" class="accordion-collapse collapse" aria-labelledby="faqHeadingTwo" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                      Ofrecemos servicios de cambio de aceite, revisión de frenos, afinación, diagnóstico electrónico, entre otros.
                    </div>
                  </div>
                </div>
                <div class="accordion-item">
                  <h2 class="accordion-header" id="faqHeadingThree">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapseThree" aria-expanded="false" aria-controls="faqCollapseThree">
                      ¿Cuál es el horario de atención?
                    </button>
                  </h2>
                  <div id="faqCollapseThree" class="accordion-collapse collapse" aria-labelledby="faqHeadingThree" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                      Nuestro horario es de lunes a domingo de 8:00 AM a 15:00 PM.
                    </div>
                  </div>
                </div>
                <div class="accordion-item">
                  <h2 class="accordion-header" id="faqHeadingFour">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapseFour" aria-expanded="false" aria-controls="faqCollapseFour">
                      ¿Cómo me contacto con ustedes?
                    </button>
                  </h2>
                  <div id="faqCollapseFour" class="accordion-collapse collapse" aria-labelledby="faqHeadingFour" data-bs-parent="#faqAccordion">
                    <div class="accordion-body">
                      Puedes comunicarte al teléfono 654987321 o enviar un correo a motorclick@gmail.com.
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div><!-- Fin row -->
      </div><!-- Fin container interno -->
    </div><!-- Fin content-wrapper -->
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

        const selectElement = function(element) {
            return document.querySelector(element);
        }


        let menuToggle = selectElement('.menu-toggle');
        let body = selectElement('body');

        menuToggle.addEventListener('click', function(){
            body.classList.toggle('open');
        })

    </script>
      <script>
        document.addEventListener('DOMContentLoaded', function() {
            const chatForm = document.getElementById('chatForm');
            const userInput = document.getElementById('userInput');
            const chatMessages = document.getElementById('chatMessages');
            const typingIndicator = document.getElementById('typingIndicator');

            // Add event listener for form submission
            chatForm.addEventListener('submit', function(e) {
                e.preventDefault();
                const message = userInput.value.trim();
                
                if (message !== '') {
                    // Add user message to chat
                    addMessage(message, 'user');
                    
                    // Clear input field
                    userInput.value = '';
                    
                    // Show typing indicator
                    showTypingIndicator();
                    
                    // Send message to PHP backend
                    sendMessageToServer(message);
                }
            });

            // Function to add message to chat
            function addMessage(message, sender) {
                const messageElement = document.createElement('div');
                messageElement.classList.add('message');
                messageElement.classList.add(sender === 'user' ? 'user-message' : 'bot-message');
                messageElement.textContent = message;
                
                // Insert before typing indicator
                chatMessages.insertBefore(messageElement, typingIndicator);
                
                // Scroll to bottom
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }

            // Function to show typing indicator
            function showTypingIndicator() {
                typingIndicator.style.display = 'block';
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }

            // Function to hide typing indicator
            function hideTypingIndicator() {
                typingIndicator.style.display = 'none';
            }

            // Function to send message to server
            function sendMessageToServer(message) {
                // Create form data
                const formData = new FormData();
                formData.append('message', message);
                
                // Send request to server
                fetch('chatbot.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    // Hide typing indicator
                    hideTypingIndicator();
                    
                    // Add bot response to chat
                    setTimeout(() => {
                        addMessage(data.response, 'bot');
                    }, 500);
                })
                .catch(error => {
                    console.error('Error:', error);
                    hideTypingIndicator();
                    addMessage('Sorry, there was an error processing your request.', 'bot');
                });
            }
        });
    </script>

<script src="script.js"></script>
</body>
</html>

