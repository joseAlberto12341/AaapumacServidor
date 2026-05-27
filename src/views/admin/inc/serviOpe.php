<link rel="stylesheet" href="/Aaapumac/src/views/assets/css/serviOpe.css">
<!-- Minimal Header -->
<div class="minimal-header">
    <div class="header-content">
        <span class="header-badge">Departamento</span>
        <h2 class="header-title">Operativo</h2>
        <p class="header-text">Servicios operativos especializados</p>
    </div>
</div>

<!-- Services Row -->
<div class="row g-4">
    <!-- Andenes -->
    <div class="col-lg-4 col-md-6">
        <div class="minimal-card">
            <div class="minimal-card-header">
                <div class="minimal-icon">
                    <i class="mdi mdi-warehouse"></i>
                </div>
                <h3 class="minimal-title">Andenes</h3>
            </div>
            <p class="minimal-description">
                Administra y consulta toda la información relacionada con los andenes de carga.
            </p>
            <div class="minimal-features">
                <span class="feature-tag">Disponibilidad</span>
                <span class="feature-tag">Horarios</span>
                <span class="feature-tag">Estado ocupación</span>
            </div>
            <a href="#" data-bs-toggle="modal" data-bs-target="#authModal" class="minimal-link">
                Ver andenes
                <i class="mdi mdi-arrow-right"></i>
            </a>
        </div>
    </div>

    <!-- Trazabilidad -->
    <div class="col-lg-4 col-md-6">
        <div class="minimal-card">
            <div class="minimal-card-header">
                <div class="minimal-icon minimal-icon-purple">
                    <i class="mdi mdi-file-document-check"></i>
                </div>
                <h3 class="minimal-title">Trazabilidad</h3>
            </div>
            <p class="minimal-description">
                Mantén un control preciso y detallado de cada etapa del proceso mediante herramientas digitales.
            </p>
            <div class="minimal-features">
                <span class="feature-tag">Tiempo real</span>
                <span class="feature-tag">Historial completo</span>
                <span class="feature-tag">Alertas automáticas</span>
            </div>
            <a href="trazabilidad" class="minimal-link">
                Explorar trazabilidad
                <i class="mdi mdi-arrow-right"></i>
            </a>
        </div>
    </div>

    <!-- Sistema QR -->
    <div class="col-lg-4 col-md-6">
        <div class="minimal-card">
            <div class="minimal-card-header">
                <div class="minimal-icon minimal-icon-pink">
                    <i class="mdi mdi-qrcode"></i>
                </div>
                <h3 class="minimal-title">Sistema QR</h3>
            </div>
            <p class="minimal-description">
                Accede a toda la información de tu sistema de gestión mediante códigos QR.
            </p>
            <div class="minimal-features">
                <span class="feature-tag">Escaneo inventario</span>
                <span class="feature-tag">Verificación</span>
                <span class="feature-tag">Acceso rápido</span>
            </div>
            <a href="qr" class="minimal-link">
                Ver sistema QR
                <i class="mdi mdi-arrow-right"></i>
            </a>
        </div>
    </div>
</div>

<!-- Modal para autenticación -->
<div class="modal fade" id="authModal" tabindex="-1" aria-labelledby="authModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content modern-modal">
            <div class="modal-header">
                <div class="modal-header-content">
                    <div class="modal-icon">
                        <i class="mdi mdi-lock-outline"></i>
                    </div>
                    <div>
                        <h5 class="modal-title" id="authModalLabel">Autenticación de Andenes</h5>
                        <p class="modal-subtitle">Ingrese sus credenciales para continuar</p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php if (isset($_SESSION['message'])): ?>
                    <div class="alert alert-danger alert-modern" role="alert">
                        <i class="mdi mdi-alert-circle-outline me-2"></i>
                        <?= $_SESSION['message'] ?>
                    </div>
                    <?php unset($_SESSION['message']); ?>
                <?php endif; ?>
                <form id="authForm" method="POST" action="/admin/">
                    <div class="mb-3">
                        <label for="patente" class="form-label">
                            <i class="mdi mdi-card-account-details-outline me-2"></i>
                            Patente
                        </label>
                        <input type="text" class="form-control modern-input" id="patente" name="patente" 
                               placeholder="Ingrese su patente" required>
                    </div>
                    <div class="mb-3">
                        <label for="cd_dependiente" class="form-label">
                            <i class="mdi mdi-identifier me-2"></i>
                            CD Dependiente
                        </label>
                        <input type="text" class="form-control modern-input" id="cd_dependiente" 
                               name="cd_dependiente" placeholder="Ingrese el código" required>
                    </div>
                    <div class="modal-footer-buttons">
                        <button type="button" class="btn btn-secondary-modern" data-bs-dismiss="modal">
                            <i class="mdi mdi-close me-2"></i>
                            Cancelar
                        </button>
                        <button type="submit" class="btn btn-primary-modern">
                            <i class="mdi mdi-login me-2"></i>
                            Ingresar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

