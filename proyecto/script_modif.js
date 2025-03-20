$(document).ready(function() {
    // Función para capitalizar la primera letra de una cadena
    function capitalizeFirstLetter(str) {
        return str.charAt(0).toUpperCase() + str.slice(1).toLowerCase();
    }

    // Evento onblur para el campo de nombre
    document.getElementById('nombre').addEventListener('blur', function() {
        this.value = capitalizeFirstLetter(this.value.trim());
    });

    // Evento onblur para el campo de apellidos
    document.getElementById('apellidos').addEventListener('blur', function() {
        this.value = capitalizeFirstLetter(this.value.trim());
    });

    // Validación del formulario
    document.getElementById('formulario_registro').addEventListener('submit', function (event) {
        // Obtener los valores de los campos
        const nombre = document.getElementById('nombre').value.trim();
        const apellidos = document.getElementById('apellidos').value.trim();
        const usuario = document.getElementById('usuario').value.trim();
        const password = document.getElementById('password').value.trim();
        const email = document.getElementById('email').value.trim();
        const telefono = document.getElementById('telefono').value.trim();

        // Expresiones regulares para validar
        const usuarioRegex = /^[a-zA-Z]{6,8}$/; // Nombre de usuario: 6-8 carácteres
        const telefonoRegex = /^[0-9]{9}$/; // Teléfono: 9 dígitos numéricos
        const passwordRegex = /^[A-Za-z0-9]{6}$/; // Contraseña: 6-8 caracteres, letras y/o números

        // Validar nombre de usuario
        if (!usuarioRegex.test(usuario)) {
            alert('El nombre de usuario debe tener entre 6 y 8 caracteres y solo puede contener letras.');
            event.preventDefault(); // Evitar que el formulario se envíe
            return;
        }

        // Validar teléfono
        if (!telefonoRegex.test(telefono)) {
            alert('El teléfono debe tener exactamente 9 dígitos numéricos.');
            event.preventDefault(); // Evitar que el formulario se envíe
            return;
        }

        // Validar contraseña
        if (!passwordRegex.test(password) && password!=="") {
            alert('La contraseña debe tener 6 caracteres y puede contener letras y/o números.');
            event.preventDefault(); // Evitar que el formulario se envíe
            return;
        }
        // Si todo está correcto, el formulario se enviará automáticamente
    });
});