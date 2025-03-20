$(document).ready(function() {
    // Validación del formulario
    document.getElementById('formulario_recu').addEventListener('submit', function (event) {
        // Obtener el valor del campo de contraseña
        const password = document.getElementById('nueva_password').value.trim(); // Cambiado a 'nueva_password'

        // Expresión regular para validar la contraseña
        const passwordRegex = /^[A-Za-z0-9]{6}$/; // Contraseña: 6 caracteres, letras y/o números

        // Validar contraseña
        if (!passwordRegex.test(password)) {
            alert('La contraseña debe tener exactamente 6 caracteres y puede contener letras y/o números.');
            event.preventDefault(); // Evitar que el formulario se envíe
            return;
        }

        // Si la contraseña es válida, el formulario se enviará automáticamente
    });
});