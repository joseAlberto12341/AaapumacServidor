document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('formEditarPersonal');
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('confirm_password');
    const username = document.getElementById('username');
    const email = document.getElementById('email');
    const statusSelect = document.getElementById('id_status');
    
    // Preview en tiempo real
    username.addEventListener('input', function() {
        document.getElementById('preview-username').textContent = this.value || '<?php echo htmlspecialchars($personal->getUsername()); ?>';
    });
    
    email.addEventListener('input', function() {
        document.getElementById('preview-email').textContent = this.value || '<?php echo htmlspecialchars($personal->getEmail()); ?>';
    });
    
    statusSelect.addEventListener('change', function() {
        const statusText = this.options[this.selectedIndex].text.split(' ')[1];
        const statusBadge = document.getElementById('preview-status');
        statusBadge.textContent = statusText;
        
        // Cambiar color del badge según el estado
        if (this.value == '1') {
            statusBadge.className = 'badge bg-success';
        } else if (this.value == '0') {
            statusBadge.className = 'badge bg-danger';
        } else {
            statusBadge.className = 'badge bg-warning';
        }
    });
    
    // Validación de contraseñas
    function validatePassword() {
        if (password.value !== '' && password.value.length < 6) {
            password.setCustomValidity('La contraseña debe tener al menos 6 caracteres');
            return false;
        }
        
        if (password.value !== '' && password.value !== confirmPassword.value) {
            confirmPassword.setCustomValidity('Las contraseñas no coinciden');
            return false;
        } else {
            confirmPassword.setCustomValidity('');
        }
        
        password.setCustomValidity('');
        return true;
    }
    
    password.addEventListener('input', validatePassword);
    confirmPassword.addEventListener('input', validatePassword);
    
    // Confirmación antes de enviar
    form.addEventListener('submit', function(e) {
        if (!validatePassword()) {
            e.preventDefault();
            return;
        }
        
        if (password.value !== '') {
            e.preventDefault();
            Swal.fire({
                title: '¿Actualizar contraseña?',
                text: 'Estás a punto de cambiar la contraseña del usuario. ¿Continuar?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, actualizar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                }
            });
        }
        // Si no hay cambio de contraseña, se envía directamente
    });
    
    // Capitalizar username automáticamente
    username.addEventListener('blur', function() {
        this.value = this.value.charAt(0).toUpperCase() + this.value.slice(1).toLowerCase();
        document.getElementById('preview-username').textContent = this.value;
    });
});