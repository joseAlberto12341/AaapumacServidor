<?php
$usuario = $answer['data']['usuario'] ?? null;
$error = $_GET['error'] ?? null;
?>
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

<style>

    .wrapper {
        max-width: 700px;
        margin: 0 auto;
        padding: 48px 24px;
    }

    /* Header */
    .header {
        margin-bottom: 10px;
    }

    .back {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        color: #666;
        text-decoration: none;
        font-size: 14px;
        font-weight: 450;
        transition: color 0.2s;
    }

    .back:hover {
        color: #111;
    }

    /* Alert */
    .alert {
        background: #fef2f2;
        color: #991b1b;
        padding: 12px 16px;
        border-radius: 10px;
        font-size: 14px;
        margin-bottom: 24px;
        border: 1px solid #fee2e2;
    }

    /* Form Container */
    .form-container {
        background: #ffffff;
        border-radius: 20px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04), 0 1px 2px rgba(0, 0, 0, 0.03);
        overflow: hidden;
    }

    .form-header {
        padding: 28px 28px 0 28px;
    }

    .form-header h1 {
        font-size: 24px;
        font-weight: 550;
        color: #111;
        margin-bottom: 8px;
        letter-spacing: -0.3px;
    }

    .form-header p {
        font-size: 14px;
        color: #666;
        margin-bottom: 0;
    }

    /* User Info */
    .user-info {
        background: #f8f8f8;
        margin: 24px 28px;
        padding: 16px;
        border-radius: 12px;
        border: 1px solid #eaeaea;
    }

    .info-item {
        display: flex;
        justify-content: space-between;
        padding: 6px 0;
    }

    .info-item:first-child {
        margin-bottom: 8px;
    }

    .info-label {
        font-size: 13px;
        font-weight: 500;
        color: #666;
    }

    .info-value {
        font-size: 14px;
        color: #111;
        font-weight: 500;
    }

    /* Form Fields */
    form {
        padding: 0 28px 28px 28px;
    }

    .field {
        margin-top: 24px;
    }

    .field:first-of-type {
        margin-top: 28px;
    }

    label {
        display: block;
        font-size: 13px;
        font-weight: 500;
        color: #333;
        margin-bottom: 8px;
        letter-spacing: -0.2px;
    }

    .field-input input {
        width: 100%;
        padding: 12px 14px;
        font-size: 15px;
        font-family: inherit;
        color: #111;
        background: #fff;
        border: 1px solid #d4d4d4;
        border-radius: 12px;
        transition: all 0.2s;
        outline: none;
    }

    .field-input input:focus {
        border-color: #888;
        box-shadow: 0 0 0 3px rgba(0, 0, 0, 0.05);
    }

    .field-input input::placeholder {
        color: #aaa;
    }

    /* Actions Buttons */
    .actions {
        display: flex;
        gap: 12px;
        margin-top: 36px;
        padding-top: 8px;
    }

    .btn-save,
    .btn-cancel {
        flex: 1;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 12px 20px;
        font-size: 14px;
        font-weight: 500;
        font-family: inherit;
        border-radius: 40px;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
        text-align: center;
    }

    .btn-save {
        background: #1a1a1a;
        color: white;
        border: none;
    }

    .btn-save:hover {
        background: #333;
    }

    .btn-cancel {
        background: #f4f4f4;
        color: #444;
        border: 1px solid #e0e0e0;
    }

    .btn-cancel:hover {
        background: #e8e8e8;
        border-color: #ccc;
    }

    /* Modal Styles */
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        animation: fadeIn 0.2s ease-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    .modal-content {
        background-color: #fff;
        margin: 15% auto;
        width: 90%;
        max-width: 400px;
        border-radius: 16px;
        overflow: hidden;
        animation: slideIn 0.2s ease-out;
    }

    @keyframes slideIn {
        from {
            transform: translateY(-20px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    .modal-header {
        padding: 20px 24px 0 24px;
    }

    .modal-header h3 {
        font-size: 18px;
        font-weight: 600;
        color: #111;
    }

    .modal-body {
        padding: 16px 24px;
    }

    .modal-body p {
        color: #444;
        font-size: 14px;
        margin-bottom: 8px;
    }

    .warning-text {
        color: #991b1b;
        font-size: 13px;
        font-weight: 500;
    }

    .modal-footer {
        display: flex;
        gap: 12px;
        padding: 16px 24px 24px 24px;
    }

    .btn-confirm,
    .btn-modal-cancel {
        flex: 1;
        padding: 10px 20px;
        font-size: 14px;
        font-weight: 500;
        font-family: inherit;
        border-radius: 40px;
        cursor: pointer;
        transition: all 0.2s;
        text-align: center;
    }

    .btn-confirm {
        background: #1a1a1a;
        color: white;
        border: none;
    }

    .btn-confirm:hover {
        background: #333;
    }

    .btn-modal-cancel {
        background: #f4f4f4;
        color: #444;
        border: 1px solid #e0e0e0;
    }

    .btn-modal-cancel:hover {
        background: #e8e8e8;
        border-color: #ccc;
    }

    /* Empty State */
    .empty {
        background: #fff;
        border-radius: 20px;
        padding: 48px 24px;
        text-align: center;
        color: #666;
        font-size: 14px;
    }

    /* Responsive */
    @media (max-width: 560px) {
        .wrapper {
            padding: 24px 16px;
        }
        
        .form-header {
            padding: 24px 24px 0 24px;
        }
        
        form {
            padding: 0 24px 24px 24px;
        }
        
        .user-info {
            margin: 24px 24px;
        }
        
        .form-header h1 {
            font-size: 22px;
        }
        
        .actions {
            flex-direction: column;
            gap: 10px;
        }
        
        .btn-save,
        .btn-cancel {
            padding: 11px 20px;
        }
    }
</style>

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