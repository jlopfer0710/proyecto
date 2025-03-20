//Script para valida el inicio de sesión
// Esperamos a que el documento HTML esté completamente cargado antes de ejecutar el código
$(document).ready(function() {

    // Capturamos el evento de envío del formulario con ID "formulario_inicio"
    $("#formulario_inicio").submit(function(event) {
        // Evitamos que el formulario se envíe de la manera tradicional 
        event.preventDefault();

        // Creamos un objeto FormData con los datos del formulario
        let formData = new FormData(this);

        // Añadimos un campo extra con el valor "true" para indicar que es un inicio de sesión
        formData.append("login", true);

        // Enviamos los datos del formulario al servidor mediante una petición AJAX con fetch
        fetch("index.php", {
            method: "POST", // Enviamos los datos mediante el método POST
            body: formData   // Adjuntamos el FormData con la información del formulario
        })
        .then(response => response.json()) // Convertimos la respuesta del servidor a JSON
        .then(data => {
            console.log(data);  // Mostramos en la consola la respuesta del servidor para depuración

            // Si la respuesta del servidor indica que el inicio de sesión fue exitoso
            if (data.status === "success") {
                // Guardamos el nombre del usuario en el almacenamiento local (localStorage)
                localStorage.setItem("username", data.usuario);

                // Mostramos un mensaje de éxito
                alert("Inicio de sesión exitoso");

                // Redirigimos al usuario a la página que indique el servidor
                window.location.href = data.redirect;
            } else {
                // Si hubo un error en el inicio de sesión, mostramos un mensaje con la razón
                alert("Error en el inicio de sesión: " + data.message);
            }
        })
        .catch(error => {
            // Capturamos cualquier error en la solicitud y lo mostramos en la consola
            console.log("Error en la solicitud:", error);
        });
    });

});
