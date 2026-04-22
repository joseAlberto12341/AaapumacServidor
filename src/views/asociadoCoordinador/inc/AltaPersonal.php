<div class="card card-rounded">
    <div class="card-body">
        <div class="d-sm-flex justify-content-between align-items-start">
            <div>
                <h4 class="card-title card-title-dash" style="font-size: 42px; font-weight: 700; color: #0056b3; margin-bottom: 20px;">
                    <?php echo $answer['data']['title']; ?>
                </h4>
                <p class="card-subtitle card-subtitle-dash" style="color: #175fa9; font-size: 22px; font-weight: 700; margin: 15px 0;">
                    <?php echo $answer['data']['subtitle']; ?>
                </p>
                
                <!-- Información del rol fijo -->
                <div class="alert alert-info">
                    <i class="mdi mdi-information-outline"></i>
                    <strong>Coordinador creando:</strong> Estás registrando un nuevo <strong>Asociado</strong>
                </div>
            </div>
        </div>

        <!-- Mostrar mensajes de error -->
        <?php if (isset($_SESSION['error_message'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="mdi mdi-alert-circle-outline"></i>
                <?php echo $_SESSION['error_message']; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['error_message']); ?>
        <?php endif; ?>

        <form id="formAsociado" method="POST" action="/Aaapumac/asociadoCoordinador/AltaPersonal">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="username" class="form-label">Nombre de usuario *</label>
                        <input type="text" class="form-control" id="username" name="username" 
                               value="<?php echo $_POST['username'] ?? ''; ?>" required 
                               placeholder="Ingresa el nombre de usuario">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="email" class="form-label">Correo electrónico *</label>
                        <input type="email" class="form-control" id="email" name="email" 
                               value="<?php echo $_POST['email'] ?? ''; ?>" required 
                               placeholder="ejemplo@correo.com">
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="password" class="form-label">Contraseña *</label>
                        <input type="password" class="form-control" id="password" name="password" required 
                               placeholder="Mínimo 6 caracteres">
                        <small class="form-text text-muted">La contraseña debe tener al menos 6 caracteres</small>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="confirm_password" class="form-label">Confirmar contraseña *</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" required 
                               placeholder="Repite la contraseña">
                    </div>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="form-label">Rol del usuario</label>
                        <input type="text" class="form-control bg-light" value="Asociado (Rol 9)" readonly>
                        <small class="form-text text-muted">Todos los usuarios creados serán asociados</small>
                        <!-- Campo oculto para enviar el rol 9 -->
                        <input type="hidden" name="id_role" value="9">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="id_status" class="form-label">Estatus *</label>
                        <select class="form-control" id="id_status" name="id_status" required>
                            <option value="1" selected>Activo</option>
                            <option value="2">Inactivo</option>
                            <option value="3">Eliminado</option>
                        </select>
                        <small class="form-text text-muted">Estado inicial del usuario</small>
                    </div>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <i class="mdi mdi-content-save"></i> <?php echo $answer['data']['button']; ?>
                    </button>
                    <a href="/Aaapumac/asociadoCoordinador/listadoPersonal" class="btn btn-secondary btn-lg">
                        <i class="mdi mdi-arrow-left"></i> Cancelar
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script src="/Aaapumac/src/views/assets/js/altaPersonal.js"></script>

<style>
.form-control:read-only {
    background-color: #f8f9fa;
    cursor: not-allowed;
}

.bg-light {
    background-color: #f8f9fa !important;
}

.form-text {
    font-size: 0.875rem;
}
</style>