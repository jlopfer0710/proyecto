<?php
// Set header to return JSON
header('Content-Type: application/json');

// Get the message from POST request
$message = isset($_POST['message']) ? $_POST['message'] : '';

// Responses customized for MotorClick mechanic workshop
$responses = [
    'hello' => '¡Hola! Bienvenido a MotorClick. ¿En qué podemos ayudarte hoy con tu vehículo?',
    'hola' => '¡Hola! Soy el asistente virtual de MotorClick. ¿Necesitas información sobre nuestros servicios o quieres agendar una cita?',
    'hi' => '¡Hola! ¿En qué puede ayudarte MotorClick hoy?',
    
    'reserva' => 'Para hacer una reserva, puedes usar nuestra página de Reservas o indicarme qué servicio necesitas y te guiaré en el proceso.',
    'cita' => 'Puedes agendar una cita en nuestra sección de Reservas. ¿Qué tipo de servicio necesita tu vehículo?',
    'agendar' => 'Para agendar una cita, necesitamos saber qué servicio requieres y la fecha preferida. ¿Puedes proporcionarme esa información?',
    
    'servicio' => 'En MotorClick ofrecemos diversos servicios como: cambio de aceite, afinación, frenos, suspensión, diagnóstico electrónico y más. ¿Qué servicio te interesa?',
    'servicios' => 'Nuestros servicios incluyen: mantenimiento preventivo, reparación de motor, sistema eléctrico, frenos, suspensión, alineación y balanceo. Puedes ver más detalles en nuestra página de Servicios.',
    
    'precio' => 'Los precios varían según el servicio y modelo de vehículo. ¿Qué servicio te interesa para darte un estimado?',
    'costo' => 'Para darte un presupuesto preciso, necesitamos conocer tu vehículo y el servicio requerido. ¿Puedes proporcionar esa información?',
    'cuanto' => 'El costo depende del servicio y tu vehículo. ¿Me puedes decir qué servicio necesitas y qué modelo de auto tienes?',
    
    'horario' => 'Nuestro horario de atención es de lunes a domingo de 8:00 AM a 15:00 PM.',
    'hora' => 'Estamos abiertos de lunes a domingo de 8:00 AM a 15:00 PM. ¿Te gustaría agendar una cita?',
    
    'contacto' => 'Puedes contactarnos al teléfono 654987321 o por email a motorclick@gmail.com.',
    'telefono' => 'Nuestro número de contacto es 654987321. ¿Deseas que te llamemos para agendar una cita?',
    
    'perfil' => 'En tu perfil puedes ver y modificar tus datos personales, así como revisar el historial de tus citas. Accede desde el menú superior una vez que hayas iniciado sesión.',
    'cuenta' => 'Para gestionar tu cuenta, inicia sesión y ve a la sección de Perfil. Allí podrás actualizar tus datos y ver tus reservas.',
    
    'tiempo' => 'El tiempo de servicio varía según la complejidad. Un cambio de aceite toma aproximadamente 30-45 minutos, mientras que servicios más complejos pueden tomar varias horas.',
    'espera' => 'Contamos con una sala de espera cómoda con WiFi y café mientras realizamos el servicio a tu vehículo.',
    
    'garantia' => 'Todos nuestros servicios tienen garantía. El período varía según el tipo de reparación, desde 1 mes hasta 1 año en algunos casos.',
    
    'cancelar' => 'Para cancelar o reprogramar una cita, puedes hacerlo desde tu perfil en la sección de Reservas o llamarnos al [número de teléfono] con al menos 24 horas de anticipación.',
    'modificar' => 'Puedes modificar tu reserva accediendo a tu perfil y seleccionando la opción de editar en la cita correspondiente.',
    
    'pago' => 'Aceptamos efectivo, tarjetas de crédito/débito y transferencias bancarias. El pago se realiza una vez completado el servicio.',
    
    'gracias' => '¡Gracias a ti por confiar en MotorClick! Estamos para servirte. ¿Hay algo más en lo que pueda ayudarte?',
    'thank' => 'Es un placer ayudarte. ¿Necesitas información sobre algún otro servicio de MotorClick?',
    
    'adios' => '¡Hasta pronto! Recuerda que en MotorClick cuidamos de tu vehículo como si fuera nuestro.',
    'bye' => '¡Que tengas un excelente día! Esperamos verte pronto en MotorClick.',
    
    'ayuda' => 'Puedo ayudarte con información sobre nuestros servicios, precios, horarios, reservas o cualquier duda sobre tu vehículo. Escribe "comandos" para ver todas las opciones disponibles.',
    'help' => 'Estoy aquí para asistirte. Puedo informarte sobre servicios, reservas, precios o cualquier consulta relacionada con MotorClick. Escribe "comandos" para ver todas las opciones disponibles.',
    
    'nombre' => 'Soy el asistente virtual de MotorClick, estoy aquí para ayudarte con tus consultas sobre nuestros servicios de mecánica automotriz.',
    'name' => 'Me llamo ClickBot, el asistente virtual de MotorClick. Estoy aquí para resolver tus dudas sobre nuestro taller.',
    
    'registro' => 'Para registrarte, haz clic en "Registrarme" en el menú superior y completa el formulario con tus datos. ¡Es rápido y sencillo!',
    'iniciar sesion' => 'Puedes iniciar sesión haciendo clic en "Iniciar Sesión" en el menú superior. Necesitarás tu correo y contraseña.',
    
    'emergencia' => 'Para emergencias mecánicas, llámanos directamente al 654987321. Ofrecemos servicio de grúa y atención prioritaria.',
    
    'descuento' => '¡Tenemos descuentos especiales para clientes frecuentes! Además, este mes ofrecemos 15% de descuento en afinaciones.',
    
    // Comando especial para mostrar todos los comandos disponibles
    'comandos' => 'Estos son los comandos que puedes utilizar:

    📝 Reservas y Citas
    - reserva, cita, agendar: Información sobre cómo hacer reservas
    - cancelar, modificar: Gestión de citas existentes

    🔧 Servicios
    - servicio, servicios: Lista de servicios disponibles
    - cambio de aceite, frenos, afinacion: Información sobre servicios específicos
    - tiempo, espera: Duración de los servicios
    - garantia: Información sobre garantías

    💰 Precios y Pagos
    - precio, costo, cuanto: Consultas sobre precios
    - pago: Métodos de pago aceptados
    - descuento: Ofertas actuales

    📍 Información General
    - horario, hora: Horarios de atención
    - contacto, telefono: Datos de contacto

    👤 Cuenta y Perfil
    - perfil, cuenta: Gestión de tu cuenta
    - registro, iniciar sesion: Cómo registrarte o iniciar sesión

    🚨 Otro
    - emergencia: Asistencia en emergencias

Puedes escribir cualquiera de estas palabras para obtener información específica.',
    
    'comando' => 'Para ver la lista de todos los comandos disponibles, escribe "comandos".',
];

// Default response
$response = 'Gracias por tu mensaje. Para información más específica sobre nuestros servicios de mecánica o para agendar una cita, te invito a explorar nuestra web o llamarnos al [número de teléfono]. También puedes escribir "comandos" para ver todas las opciones disponibles.';

// Check for keyword matches
$message = strtolower($message);
foreach ($responses as $keyword => $reply) {
    if (strpos($message, $keyword) !== false) {
        $response = $reply;
        break;
    }
}

// Add some randomness to make it seem more natural
$randomResponses = [
    'Excelente pregunta. ',
    'Gracias por preguntar. ',
    'Con gusto te informo. ',
    'En MotorClick nos encargamos de eso. ',
];

// 20% chance to add a random prefix to the response (but not for the commands list)
if (rand(1, 5) === 1 && strpos($message, 'comando') === false) {
    $randomPrefix = $randomResponses[array_rand($randomResponses)];
    $response = $randomPrefix . $response;
}

// Simulate processing delay (0.5 to 1.5 seconds)
sleep(rand(0.5, 1.5));

// Return JSON response
echo json_encode(['response' => $response]);
?>