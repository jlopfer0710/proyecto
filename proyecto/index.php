<?php
session_start();
error_reporting(E_ALL);
ini_set("display_errors", 1);

// Establecer la conexión a la base de datos
$conexion = mysqli_connect("localhost", "admin", "admin", "MotorClick_DB","3307");

if (mysqli_connect_errno()) {
    die("Error de Conexión: " . mysqli_connect_error());
}

// Establecer la codificación correcta
mysqli_set_charset($conexion, 'utf8mb4');

// Inicializar las variables
$nombre = $apellidos = $email = $usuario = $password = $telefono = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['registro'])) {
        // Obtener los valores del formulario
        $nombre = $_POST['nombre'];
        $apellidos = $_POST['apellidos'];
        $email = $_POST['email'];
        $usuario = $_POST['usuario'];
        $password = $_POST['password'];
        $telefono = $_POST['telefono'];

        // Sanitizar los datos
        $nombre = mysqli_real_escape_string($conexion, $nombre);
        $apellidos = mysqli_real_escape_string($conexion, $apellidos);
        $email = mysqli_real_escape_string($conexion, $email);
        $usuario = mysqli_real_escape_string($conexion, $usuario);
        $password = mysqli_real_escape_string($conexion, $password);
        $telefono = mysqli_real_escape_string($conexion, $telefono);

        // Verificar si los campos están vacíos
        if (empty($nombre) || empty($apellidos) || empty($email) || empty($usuario) || empty($password) || empty($telefono)) {
            echo "Por favor, completa todos los campos.";
            exit;
        }

        // Verificar si el usuario ya existe
        $query_check_user = "SELECT * FROM usuarios WHERE usuario = '$usuario' OR email = '$email'";
        $result_check_user = mysqli_query($conexion, $query_check_user);

        if (mysqli_num_rows($result_check_user) > 0) {
            echo "El usuario o correo electrónico ya está registrado.";
            exit;
        }

        // Encriptar la contraseña antes de guardarla
        $password_hash = password_hash($password, PASSWORD_DEFAULT);

        // Insertar los datos en la base de datos
        $query = "INSERT INTO usuarios (nombre, usuario, apellidos, email, telefono, password, tipo) 
                  VALUES ('$nombre', '$usuario', '$apellidos', '$email', '$telefono', '$password_hash', 'cliente')";

        $result = mysqli_query($conexion, $query);

        if ($result) {
            echo "Usuario registrado correctamente.";
        } else {
            echo "Error al registrar el usuario: " . mysqli_error($conexion);
        }
    }

}
// Lógica de inicio de sesión
if (isset($_POST['login'])) {
    $usuario = mysqli_real_escape_string($conexion, $_POST['usuario']);
    $password = $_POST['password'];

    if (empty($usuario) || empty($password)) {
        echo json_encode(["status" => "error", "message" => "Por favor, completa todos los campos."]);
        exit;
    }

    // Modificar la consulta para obtener la contraseña también
    $query = "SELECT id, nombre, usuario, apellidos, email, telefono, password, tipo 
          FROM usuarios 
          WHERE usuario = '$usuario' OR email = '$usuario'";

$result = mysqli_query($conexion, $query);

if ($row = mysqli_fetch_assoc($result)) {
    // Verificar si la contraseña introducida coincide con la almacenada en la base de datos
    if ($password == $row['password']) {
        // Si la contraseña es correcta, guarda los datos del usuario en la sesión
        $_SESSION['usuario'] = [
            "id" => $row['id'],
            "nombre" => $row['nombre'],
            "usuario" => $row['usuario'],
            "apellidos" => $row['apellidos'],
            "email" => $row['email'],
            "telefono" => $row['telefono'],
            "password" => $row['password'], // Aunque no es recomendable guardar la contraseña en la sesión
            "tipo" => $row['tipo']
        ];

        echo json_encode([
            "status" => "success",
            "usuario" => $row['usuario'],
            "redirect" => "home.php"
        ]);
    } else {
        echo json_encode(["status" => "error", "message" => "Contraseña incorrecta."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Usuario no encontrado."]);
}

}
if (isset($_POST['usuario_id'])) {
    $usuario_id = $_POST['usuario_id'];  // Obtener el ID del usuario seleccionado

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
}

// Si el formulario es enviado para modificar los datos
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['nombre'])) {
    // Recoger los datos del formulario
    $nombre = mysqli_real_escape_string($conexion, $_POST['nombre']);
    $apellidos = mysqli_real_escape_string($conexion, $_POST['apellidos']);
    $usuario_nombre = mysqli_real_escape_string($conexion, $_POST['usuario']);
    $password = mysqli_real_escape_string($conexion, $_POST['password']);
    $email = mysqli_real_escape_string($conexion, $_POST['email']);
    $telefono = mysqli_real_escape_string($conexion, $_POST['telefono']);

    // Actualizar los datos del usuario en la base de datos
    $update_query = "UPDATE usuarios SET nombre = '$nombre', apellidos = '$apellidos', usuario = '$usuario_nombre', password = '$password', email = '$email', telefono = '$telefono' WHERE id = $usuario_id";
    $update_result = mysqli_query($conexion, $update_query);

    // Si la actualización es exitosa, redirigimos al perfil del usuario con un mensaje
    if ($update_result) {
        // Redirigir a perfil.php con un mensaje de éxito
        header("Location: perfil.php?mensaje=modificado_con_exito");
        exit;
    } else {
        // Redirigir a perfil.php con un mensaje de error
        header("Location: perfil.php?mensaje=error_al_modificar");
        exit;
    }
}
mysqli_close($conexion);
?>