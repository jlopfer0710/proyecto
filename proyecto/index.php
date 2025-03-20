<?php
session_start();
error_reporting(E_ALL);
ini_set("display_errors", 1);

// Establecer la conexión a la base de datos
$conexion = mysqli_connect("localhost", "jorge", "KXiZ4xzfMclSLKv", "jorge");

if (mysqli_connect_errno()) {
    die("Error de Conexión: " . mysqli_connect_error());
}

// Establecer la codificación correcta
mysqli_set_charset($conexion, 'utf8mb4');

// Inicializar las variables
$nombre = $apellidos = $email = $usuario = $password = $telefono = '';

// Verificar si el formulario se ha enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['registro'])) {
    // Obtener los valores del formulario
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $email = $_POST['email'];
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];
    $telefono = $_POST['telefono'];

    // Sanitizar los datos para evitar inyecciones SQL
    $nombre = mysqli_real_escape_string($conexion, $nombre);
    $apellidos = mysqli_real_escape_string($conexion, $apellidos);
    $email = mysqli_real_escape_string($conexion, $email);
    $usuario = mysqli_real_escape_string($conexion, $usuario);
    $password = mysqli_real_escape_string($conexion, $password);
    $telefono = mysqli_real_escape_string($conexion, $telefono);

    // Verificar si los campos están vacíos
    if (empty($nombre) || empty($apellidos) || empty($email) || empty($usuario) || empty($password) || empty($telefono)) {
        $_SESSION['error'] = "Por favor, completa todos los campos.";
        header("Location: registro.php"); // Redirigir de vuelta al formulario
        exit;
    }

    // Verificar si el usuario o correo ya existe
    $query_check_user = "SELECT * FROM usuarios WHERE usuario = '$usuario' OR email = '$email'";
    $result_check_user = mysqli_query($conexion, $query_check_user);

    if (mysqli_num_rows($result_check_user) > 0) {
        $_SESSION['error'] = "El usuario o correo electrónico ya está registrado.";
        header("Location: registro.php"); // Redirigir de vuelta al formulario
        exit;
    }

    // Encriptar la contraseña antes de guardarla
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    // Insertar los datos en la base de datos
    $query = "INSERT INTO usuarios (nombre, usuario, apellidos, email, telefono, password, tipo) 
              VALUES ('$nombre', '$usuario', '$apellidos', '$email', '$telefono', '$password_hash', 'cliente')";

    if (mysqli_query($conexion, $query)) {
        // Registro exitoso, redirigir a iniciar_sesion.php
        header("Location: iniciar_sesion.php?mensaje=registro_exitoso");
        exit;
    } else {
        // Error al insertar el usuario
        $_SESSION['error'] = "Error al registrar el usuario: " . mysqli_error($conexion);
        header("Location: registro.php"); // Redirigir de vuelta al formulario
        exit;
    }
}
/*if (isset($_POST['login'])) {
    $usuario = mysqli_real_escape_string($conexion, $_POST['usuario']);
    $password = $_POST['password']; // Contraseña en texto plano

    if (empty($usuario) || empty($password)) {
        $error = "Por favor, completa todos los campos.";
    } else {
        // Consulta para obtener los datos del usuario
        $query = "SELECT id, nombre, usuario, apellidos, email, telefono, password, tipo 
                  FROM usuarios 
                  WHERE usuario = '$usuario' OR email = '$usuario'";
        $result = mysqli_query($conexion, $query);

        if ($row = mysqli_fetch_assoc($result)) {
            // Verificar si la contraseña coincide
            if (password_verify($password, $row['password'])) {
                // Contraseña correcta, iniciar sesión
                $_SESSION['usuario'] = [
                    "id" => $row['id'],
                    "nombre" => $row['nombre'],
                    "usuario" => $row['usuario'],
                    "apellidos" => $row['apellidos'],
                    "email" => $row['email'],
                    "telefono" => $row['telefono'],
                    "tipo" => $row['tipo']
                ];
                header("Location: home.php"); // Redirigir al home
                exit;
            } else {
                // Contraseña incorrecta
                $error = "Contraseña incorrecta.";
            }
        } else {
            // Usuario no encontrado
            $error = "Usuario no encontrado.";
        }
    }
}*/
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
    $email = mysqli_real_escape_string($conexion, $_POST['email']);
    $telefono = mysqli_real_escape_string($conexion, $_POST['telefono']);
    $usuario_id = $_POST['usuario_id'];

    // Verificar si el nombre de usuario o el correo electrónico ya existen en otro usuario
    $check_query = "SELECT id FROM usuarios 
                    WHERE (usuario = '$usuario_nombre' OR email = '$email') 
                    AND id != $usuario_id"; // Excluir al usuario actual
    $check_result = mysqli_query($conexion, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        // Si hay resultados, significa que el nombre de usuario o el correo ya existen
        header("Location: perfil.php?mensaje=usuario_o_email_existente");
        exit;
    }

    // Inicializar la variable para la contraseña
    $password_update = '';

    // Verificar si se proporcionó una nueva contraseña
    if (!empty($_POST['password'])) {
        $password = mysqli_real_escape_string($conexion, $_POST['password']);
        $hashed_password = password_hash($password, PASSWORD_DEFAULT); // Hashear la contraseña
        $password_update = ", password = '$hashed_password'";
    }

    // Actualizar los datos del usuario en la base de datos
    $update_query = "UPDATE usuarios 
                     SET nombre = '$nombre', apellidos = '$apellidos', usuario = '$usuario_nombre', email = '$email', telefono = '$telefono' $password_update 
                     WHERE id = $usuario_id";
    $update_result = mysqli_query($conexion, $update_query);

    // Si la actualización es exitosa, actualizamos la sesión
    if ($update_result) {
        // Consultar los datos actualizados del usuario
        $query = "SELECT id, nombre, usuario, apellidos, email, telefono, tipo 
                  FROM usuarios 
                  WHERE id = $usuario_id";
        $result = mysqli_query($conexion, $query);

        if ($row = mysqli_fetch_assoc($result)) {
            // Actualizar la sesión con los nuevos datos
            $_SESSION['usuario'] = [
                "id" => $row['id'],
                "nombre" => $row['nombre'],
                "usuario" => $row['usuario'],
                "apellidos" => $row['apellidos'],
                "email" => $row['email'],
                "telefono" => $row['telefono'],
                "tipo" => $row['tipo']
            ];
        }

        // Redirigir a perfil.php con un mensaje de éxito
        header("Location: perfil.php?mensaje=modificado_con_exito");
        exit;
    } else {
        // Redirigir a perfil.php con un mensaje de error
        header("Location: perfil.php?mensaje=error_al_modificar");
        exit;
    }
}
//Código para eliminar un usuario de la BD
// Procesar la eliminación de usuarios
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['eliminar']) && isset($_POST['usuario_id'])) {
    $usuario_id = intval($_POST['usuario_id']); // Convertir a entero para seguridad

    if ($usuario_id > 0) {
        // Consulta para eliminar el usuario
        $query = "DELETE FROM usuarios WHERE id = $usuario_id";
        if (mysqli_query($conexion, $query)) {
            //sentencia para reiniciar los ids
            mysqli_query($conexion,"ALTER TABLE usuarios AUTO_INCREMENT =1;");
            $_SESSION['mensaje'] = "Usuario eliminado correctamente.";
        } else {
            $_SESSION['error'] = "Error al eliminar el usuario: " . mysqli_error($conexion);
        }

        // Redirigir después de procesar la eliminación
        header("Location: perfil.php");
        exit();
    } else {
        $_SESSION['error'] = "ID de usuario no válido.";
        header("Location: perfil.php");
        exit();
    }
}
// Verificar si el formulario se envió
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = mysqli_real_escape_string($conexion, $_POST['email']);
    $nueva_password = $_POST['nueva_password'];

    // Validar que los campos no estén vacíos
    if (empty($email) || empty($nueva_password)) {
        // Redirigir a recuperar_contra.php si hay campos vacíos
        header("Location: recuperar_contra.php");
        exit;
    }

    // Buscar al usuario por su correo electrónico
    $query = "SELECT id, password FROM usuarios WHERE email = '$email'";
    $result = mysqli_query($conexion, $query);

    if ($row = mysqli_fetch_assoc($result)) {
        // Verificar si la nueva contraseña es diferente a la almacenada
        if (password_verify($nueva_password, $row['password'])) {
            // Si la contraseña es igual, redirigir a recuperar_contra.php
            header("Location: recuperar_contra.php");
            exit;
        } else {
            // Aplicar hash a la nueva contraseña
            $hashed_password = password_hash($nueva_password, PASSWORD_DEFAULT);

            // Actualizar la contraseña en la base de datos
            $update_query = "UPDATE usuarios SET password = '$hashed_password' WHERE email = '$email'";
            mysqli_query($conexion, $update_query);

            // Redirigir a iniciar_sesion.php si la contraseña se actualizó correctamente
            header("Location: iniciar_sesion.php");
            exit;
        }
    } else {
        // Si el usuario no existe, redirigir a recuperar_contra.php
        header("Location: recuperar_contra.php");
        exit;
    }
}
mysqli_close($conexion);
?>