document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('formAsociado');
    
    form.addEventListener('submit', function(e) {
        const username = document.getElementById('username').value.trim();
        const email = document.getElementById('email').value.trim();
        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('confirm_password').value;
        
        // Validar que todos los campos estén llenos
        if (!username || !email || !password || !confirmPassword) {
            e.preventDefault();
            Swal.fire({
                title: 'Campos incompletos',
                text: 'Todos los campos marcados con * son obligatorios',
                icon: 'warning',
                confirmButtonText: 'Entendido'
            });
            return false;
        }
        
        // Validar contraseñas
        if (password !== confirmPassword) {
            e.preventDefault();
            Swal.fire({
                title: 'Error',
                text: 'Las contraseñas no coinciden',
                icon: 'error',
                confirmButtonText: 'Ok'
            });
            return false;
        }
        
        // Validar longitud de contraseña
        if (password.length < 6) {
            e.preventDefault();
            Swal.fire({
                title: 'Contraseña muy corta',
                text: 'La contraseña debe tener al menos 6 caracteres',
                icon: 'error',
                confirmButtonText: 'Ok'
            });
            return false;
        }
        
        // Validar formato de email básico
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            e.preventDefault();
            Swal.fire({
                title: 'Email inválido',
                text: 'Por favor ingresa un formato de email válido',
                icon: 'error',
                confirmButtonText: 'Ok'
            });
            return false;
        }
        
        // Confirmación final
        Swal.fire({
            title: "¿Crear nuevo asociado?",
            html: `
                <div class="text-left">
                    <p><strong>Usuario:</strong> ${username}</p>
                    <p><strong>Email:</strong> ${email}</p>
                    <p><strong>Rol:</strong> Asociado (9)</p>
                    <p><strong>Estatus:</strong> ${document.getElementById('id_status').options[document.getElementById('id_status').selectedIndex].text}</p>
                </div>
            `,
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí, crear asociado',
            cancelButtonText: 'Cancelar'
        }).then((result) => {
            if (result.isConfirmed) {
                // Mostrar loading
                Swal.fire({
                    title: 'Creando asociado...',
                    text: 'Por favor espere',
                    icon: 'info',
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                
                // Enviar formulario
                form.submit();
            }
        });
        
        e.preventDefault();
    });

    // Validación en tiempo real para las contraseñas
    const passwordInput = document.getElementById('password');
    const confirmPasswordInput = document.getElementById('confirm_password');
    
    function validatePasswords() {
        if (passwordInput.value !== confirmPasswordInput.value) {
            confirmPasswordInput.style.borderColor = '#dc3545';
        } else {
            confirmPasswordInput.style.borderColor = '#28a745';
        }
    }
    
    passwordInput.addEventListener('input', validatePasswords);
    confirmPasswordInput.addEventListener('input', validatePasswords);
});