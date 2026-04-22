<link rel="stylesheet" href="/Aaapumac/src/views/assets/css/content.css">

<!-- Minimal Header -->
<div class="minimal-header">
    <div class="header-content">
        <span class="header-badge">Bienvenido <?php echo $_SESSION['username']; ?> 
            <span class="role-badge">(<?php echo isset($_SESSION['role_name']) ? ucfirst($_SESSION['role_name']) : 'Usuario'; ?>)</span>
        </span>
        <h2 class="header-title">Asociación de Agentes Aduanales</h2>
        <p class="header-text">Puerto de Manzanillo</p>
    </div>
</div>

<!-- Stats Section -->
<div class="stats-section">
    <div class="stats-logo">
        <img src="/Aaapumac/src/views/assets/img/logo-a.png" alt="AAAPUMAC">
    </div>
    <h3 class="stats-title">Métricas Clave de Nuestro Éxito</h3>
    
    <div class="row g-4 justify-content-center">
        <!-- Visitas -->
        <div class="col-lg-4 col-md-6">
            <div class="stats-card">
                <div class="stats-icon gradient-blue">
                    <i class="mdi mdi-eye"></i>
                </div>
                <div class="stats-number">
                    <span class="timer" data-from="0" data-to="0" data-speed="1500" data-refresh-interval="5">0</span>
                </div>
                <p class="stats-label">Visitas del Sitio</p>
            </div>
        </div>

        <!-- Años -->
        <div class="col-lg-4 col-md-6">
            <div class="stats-card">
                <div class="stats-icon gradient-purple">
                    <i class="mdi mdi-calendar-clock"></i>
                </div>
                <div class="stats-number">
                    <span class="timer" data-from="0" data-to="39" data-speed="1500" data-refresh-interval="5">39</span>
                </div>
                <p class="stats-label">Años Laborando</p>
            </div>
        </div>

        <!-- Miembros -->
        <div class="col-lg-4 col-md-6">
            <div class="stats-card">
                <div class="stats-icon gradient-teal">
                    <i class="mdi mdi-account-group"></i>
                </div>
                <div class="stats-number">
                    <span class="timer" data-from="0" data-to="64" data-speed="1500" data-refresh-interval="5">64</span>
                </div>
                <p class="stats-label">Miembros del Equipo</p>
            </div>
        </div>
    </div>
</div>

<!-- Modal Registro -->
<div class="modal fade" id="registroModal" tabindex="-1" aria-labelledby="registroModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modern-modal">
            <div class="modal-header">
                <div class="modal-header-content">
                    <div class="modal-icon">
                        <i class="mdi mdi-account-plus"></i>
                    </div>
                    <div>
                        <h5 class="modal-title" id="registroModalLabel">Agregar Nuevo Usuario</h5>
                        <p class="modal-subtitle">Complete los datos del usuario</p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" id="qr" action="/admin/registrar">
                    <div class="mb-3">
                        <label for="usuario" class="form-label">
                            <i class="mdi mdi-account me-2"></i>
                            Nombre de Usuario
                        </label>
                        <input type="text" class="form-control modern-input" id="usuario" name="usuario" 
                               placeholder="Ingrese el nombre de usuario" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">
                            <i class="mdi mdi-email me-2"></i>
                            Correo Electrónico
                        </label>
                        <input type="email" class="form-control modern-input" id="email" name="email" 
                               placeholder="correo@ejemplo.com" required>
                    </div>

                    <div class="mb-3">
                        <label for="contraseña" class="form-label">
                            <i class="mdi mdi-lock me-2"></i>
                            Contraseña
                        </label>
                        <input type="password" class="form-control modern-input" id="contraseña" name="contraseña" 
                               placeholder="Ingrese la contraseña" required>
                    </div>

                    <div class="modal-footer-buttons">
                        <button type="button" class="btn btn-secondary-modern" data-bs-dismiss="modal">
                            <i class="mdi mdi-close me-2"></i>
                            Cancelar
                        </button>
                        <button type="submit" class="btn btn-primary-modern">
                            <i class="mdi mdi-check me-2"></i>
                            Guardar Usuario
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// Timer Animation
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.timer').forEach(function (timerElement) {
        const from = parseInt(timerElement.getAttribute('data-from')) || 0;
        const to = parseInt(timerElement.getAttribute('data-to')) || parseInt(timerElement.textContent);
        const speed = parseInt(timerElement.getAttribute('data-speed'));
        const refreshInterval = parseInt(timerElement.getAttribute('data-refresh-interval'));
        let currentValue = from;
        const increment = (to - from) / (speed / refreshInterval);

        const timer = setInterval(() => {
            currentValue += increment;
            if (currentValue >= to) {
                clearInterval(timer);
                currentValue = to;
            }
            timerElement.textContent = Math.floor(currentValue);
        }, refreshInterval);
    });
});

// Form Submit with SweetAlert
document.getElementById('qr').addEventListener('submit', function (e) {
    e.preventDefault();
    Swal.fire({
        title: "¡Usuario Registrado!",
        text: "El usuario ha sido agregado exitosamente",
        icon: "success",
        confirmButtonText: 'Aceptar',
        confirmButtonColor: '#667eea'
    }).then((result) => {
        if (result.isConfirmed) {
            this.submit();
        }
    });
});
</script>