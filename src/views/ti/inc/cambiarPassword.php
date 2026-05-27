<?php
$usuario = $answer['data']['usuario'] ?? null;
$error = $_GET['error'] ?? null;
?>
<link rel="stylesheet" href="/Aaapumac/src/views/assets/css/cambiarPassword.css">
    <div class="header">
        <a href="/Aaapumac/ti/listaUsuarios" class="back">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M19 12H5M12 19l-7-7 7-7"/>
            </svg>
            Regresar
        </a>
    </div>
<div class="wrapper">
    <?php if ($error): ?>
        <div class="alert">
            <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <?php if ($usuario): ?>
        <div class="form-container">
            <div class="form-header">
                <h1>Cambiar contraseña</h1>
                <p>Actualiza la contraseña de acceso</p>
            </div>

            <!-- Información del usuario -->
            <div class="user-info">
                <div class="info-item">
                    <span class="info-label">Usuario:</span>
                    <span class="info-value"><?php echo htmlspecialchars($usuario->username); ?></span>
                </div>
                <div class="info-item">
                    <span class="info-label">Email:</span>
                    <span class="info-value"><?php echo htmlspecialchars($usuario->email); ?></span>
                </div>
            </div>

            <form method="POST" action="/Aaapumac/ti/CambiarPassword?id=<?php echo $usuario->id; ?>" id="passwordForm">
                
                <div class="field">
                    <label>Nueva contraseña</label>
                    <div class="field-input">
                        <input type="password" 
                               name="password" 
                               id="password"
                               required
                               autocomplete="new-password">
                    </div>
                </div>
                
                <div class="field">
                    <label>Confirmar contraseña</label>
                    <div class="field-input">
                        <input type="password" 
                               name="confirm_password" 
                               id="confirm_password"
                               required
                               autocomplete="new-password">
                    </div>
                </div>
                
                <div class="actions">
                    <button type="submit" class="btn-save" id="submitBtn">Cambiar contraseña</button>
                    <a href="/Aaapumac/ti/listaUsuarios" class="btn-cancel">Cancelar</a>
                </div>
                
            </form>
        </div>
    <?php else: ?>
        <div class="empty">
            <p>Usuario no encontrado</p>
        </div>
    <?php endif; ?>
</div>

<!-- Modal de confirmación -->
<div id="confirmModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Confirmar cambio</h3>
        </div>
        <div class="modal-body">
            <p>¿Estás seguro de que deseas cambiar la contraseña?</p>
            <p class="warning-text">Esta acción es irreversible.</p>
        </div>
        <div class="modal-footer">
            <button id="confirmBtn" class="btn-confirm">Sí, cambiar</button>
            <button id="cancelBtn" class="btn-modal-cancel">Cancelar</button>
        </div>
    </div>
</div>
<!-- JavaScript para validación y confirmación -->
<script>
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('confirm_password');
    const form = document.getElementById('passwordForm');
    const submitBtn = document.getElementById('submitBtn');
    const modal = document.getElementById('confirmModal');
    const confirmBtn = document.getElementById('confirmBtn');
    const cancelBtn = document.getElementById('cancelBtn');
    
    // Validación de contraseñas en tiempo real
    function validatePassword() {
        if (password.value !== confirmPassword.value) {
            confirmPassword.setCustomValidity('Las contraseñas no coinciden');
        } else {
            confirmPassword.setCustomValidity('');
        }
    }
    
    password.addEventListener('change', validatePassword);
    confirmPassword.addEventListener('keyup', validatePassword);
    
    // Mostrar modal de confirmación antes de enviar
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Validar que las contraseñas coincidan
        if (password.value !== confirmPassword.value) {
            alert('Las contraseñas no coinciden');
            return false;
        }
        
        // Validar longitud mínima
        if (password.value.length < 6) {
            alert('La contraseña debe tener al menos 6 caracteres');
            return false;
        }
        
        // Validar que no esté vacía
        if (password.value.trim() === '') {
            alert('La contraseña no puede estar vacía');
            return false;
        }
        
        // Mostrar modal de confirmación
        modal.style.display = 'block';
    });
    
    // Confirmar cambio de contraseña
    confirmBtn.addEventListener('click', function() {
        modal.style.display = 'none';
        form.submit();
    });
    
    // Cancelar cambio
    cancelBtn.addEventListener('click', function() {
        modal.style.display = 'none';
    });
    
    // Cerrar modal si se hace clic fuera de él
    window.addEventListener('click', function(e) {
        if (e.target === modal) {
            modal.style.display = 'none';
        }
    });
</script>