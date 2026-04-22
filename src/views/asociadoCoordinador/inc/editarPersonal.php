<div class="card card-rounded">
    <div class="card-body">
        <div class="d-sm-flex justify-content-between align-items-start">
            <div>
                <br>
                
                <!-- ALERTA DE ÉXITO -->
                <?php if (isset($_SESSION['success_message'])): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="mdi mdi-check-circle-outline"></i>
                        <?php echo $_SESSION['success_message']; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php unset($_SESSION['success_message']); ?>
                <?php endif; ?>

                <!-- ALERTA DE ERROR -->
                <?php if (isset($_SESSION['error_message'])): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="mdi mdi-alert-circle-outline"></i>
                        <?php echo $_SESSION['error_message']; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                    <?php unset($_SESSION['error_message']); ?>
                <?php endif; ?>

                <h4 class="card-title card-title-dash" style="font-size: 42px; font-weight: 700; color: #0056b3; margin-bottom: 20px;">
                    <?php echo $answer['data']['title']; ?>
                </h4>
                <p class="card-subtitle card-subtitle-dash" style="color: #175fa9; font-size: 22px; font-weight: 700; margin: 15px 0;">
                    <?php echo $answer['data']['subtitle']; ?>
                </p>
            </div>
            <div><br>
                <a href="/Aaapumac/asociadoCoordinador/listadoPersonal" class="btn btn-secondary">
                    <i class="mdi mdi-arrow-left"></i> Volver al Listado
                </a>
            </div>
        </div>

        <br>
        
        <?php if (isset($answer['data']['personal']) && $answer['data']['personal']->exists()): 
            $personal = $answer['data']['personal'];
        ?>
        <div class="row">
            <div class="col-md-8">
                <form method="POST" action="/Aaapumac/asociadoCoordinador/editarPersonal" id="formEditarPersonal">
                    <!-- Campo hidden con el ID -->
                    <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($personal->getId()); ?>">
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="username" class="form-label">
                                    <i class="mdi mdi-account-outline"></i> Nombre de usuario
                                </label>
                                <input type="text" class="form-control form-control-lg" id="username" name="username" 
                                       value="<?php echo htmlspecialchars($personal->getUsername()); ?>" 
                                       required placeholder="Ingresa el nombre de usuario">
                                <div class="form-text">El nombre será capitalizado automáticamente.</div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="email" class="form-label">
                                    <i class="mdi mdi-email-outline"></i> Correo electrónico
                                </label>
                                <input type="email" class="form-control form-control-lg" id="email" name="email" 
                                       value="<?php echo htmlspecialchars($personal->getEmail()); ?>" 
                                       required placeholder="ejemplo@correo.com">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="password" class="form-label">
                                    <i class="mdi mdi-lock-outline"></i> Contraseña
                                </label>
                                <input type="password" class="form-control form-control-lg" id="password" name="password" 
                                       placeholder="Dejar en blanco para mantener la actual"
                                       autocomplete="new-password">
                                <div class="form-text">Mínimo 6 caracteres. Solo llena si deseas cambiar la contraseña.</div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="confirm_password" class="form-label">
                                    <i class="mdi mdi-lock-check-outline"></i> Confirmar contraseña
                                </label>
                                <input type="password" class="form-control form-control-lg" id="confirm_password" name="confirm_password" 
                                       placeholder="Repite la nueva contraseña"
                                       autocomplete="new-password">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="id_status" class="form-label">
                                    <i class="mdi mdi-account-switch-outline"></i> Estatus del usuario
                                </label>
                                <select class="form-control form-control-lg" id="id_status" name="id_status" required>
                                    <option value="1" <?php echo ($personal->getIdStatus() == 1) ? 'selected' : ''; ?>> Activo</option>
                                    <option value="2" <?php echo ($personal->getIdStatus() == 2) ? 'selected' : ''; ?>> Inactivo</option>
                                    <option value="3" <?php echo ($personal->getIdStatus() == 3) ? 'selected' : ''; ?>> Eliminado</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">
                                    <i class="mdi mdi-account-key-outline"></i> Rol del usuario
                                </label>
                                <input type="text" class="form-control form-control-lg" value="Personal de la agencia aduanal" readonly style="background-color: #f8f9fa;">
                                <div class="form-text">El rol no puede ser modificado.</div>
                            </div>
                        </div>
                                           <div class="row mt-4">
                        <div class="col-md-12">
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <a href="/Aaapumac/asociadoCoordinador/listadoPersonal" class="btn btn-secondary btn-lg me-md-2">
                                    <i class="mdi mdi-close"></i> Cancelar
                                </a>
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class="mdi mdi-content-save"></i> <?php echo $answer['data']['button']; ?>
                                </button>
                            </div>
                        </div>
                    </div>
                    </div>
                </form>
            </div>
            
        </div>
        <?php else: ?>
            <div class="alert alert-danger">
                <i class="mdi mdi-alert-circle-outline"></i> No se encontró información del asociado.
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- JavaScript para validaciones y preview en tiempo real -->
<script src="/Aaapumac/src/views/assets/js/asociadoCordinadorEditarPersonal.js"></script>

<!-- Incluir SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>