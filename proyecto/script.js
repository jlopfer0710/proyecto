$(document).ready(function() {
    $('#formulario_registro').submit(function(event) {
        event.preventDefault(); // Evita el envío del formulario de manera tradicional
        console.log('Formulario enviado'); // Verificar si se ejecuta el submit
        var nombre = $('#nombre').val();
        var apellidos = $('#apellidos').val();
        var email = $('#email').val();
        var telefono = $('#telefono').val();
        var usuario = $('#usuario').val();
        var password = $('#password').val();
        if (usuario.length < 6 || usuario.length > 8) {
            alert("El nombre de usuario debe tener entre 6 y 8 caracteres.");
            return; // Detener la ejecución si la validación falla
        }
        var passwordRegex = /^(?=[A-Za-z\d]{6,})[A-Za-z\d]+$/; // Expresión regular para validar la contraseña
        if (!passwordRegex.test(password)) {
            alert("La contraseña debe tener al menos 6 caracteres y contener tanto letras como números.");
            return; // Detener la ejecución si la validación falla
        }
        var nombreRegex= /^[a-z A-Z]{6}$/;
        if(!nombreRegex.test('nombre')){
            alert("El nombre debe tener al menos 6 caracteres.");
            return;
        }
        // Verificar los valores que se están enviando
        console.log({
            nombre: nombre,
            apellidos: apellidos,
            email: email,
            telefono: telefono,
            usuario: usuario,
            password: password
        });

        // Usar AJAX para enviar los datos
        $.ajax({
            url: 'index.php', // Cambia a la ruta de tu archivo PHP de registro
            type: 'POST',
            data: {
                nombre: nombre,
                apellidos: apellidos,
                email: email,
                telefono: telefono,
                usuario: usuario,
                password: password
            },
            success: function(response) {
                // Manejar la respuesta del servidor
                alert(response); // O muestra algún mensaje en el frontend
                if(response === "Usuario registrado correctamente.") {
                    window.location.href = 'iniciar_sesion.html'; // Redirigir a la página de inicio de sesión
                }
            },
            error: function(xhr, status, error) {
                console.error("Error: " + error);
            }
        });
    });
    $("#formulario_inicio").submit(function(event) {
        event.preventDefault();
    
        let formData = new FormData(this);
        formData.append("login", true);
    
        fetch("index.php", {
            method: "POST",
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            console.log(data);  // Verifica lo que devuelve el servidor
    
            if (data.status === "success") {
                // Guardamos el nombre del usuario en localStorage
                localStorage.setItem("username", data.usuario);
    
                alert("Inicio de sesión exitoso");
                window.location.href = data.redirect;
            } else {
                alert("Error en el inicio de sesión: " + data.message);
            }
        })
        .catch(error => {
            console.log("Error en la solicitud:", error);
        });
    });
});