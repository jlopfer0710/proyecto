<?php
session_start();
session_unset();   // Elimina todas las variables de sesión
session_destroy(); // Destruye la sesión
header("Location: home.php"); // Redirige a la página principal (o a donde desees)
exit;
?>