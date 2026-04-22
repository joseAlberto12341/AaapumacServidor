<?php
$title = $answer['data']['title'] ?? 'Mi Perfil';
$subtitle = $answer['data']['subtitle'] ?? '';
?>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title"><?= htmlspecialchars($title) ?></h4>
                <p class="card-description"><?= htmlspecialchars($subtitle) ?></p>
                
                <form id="profileForm">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nombre">Nombre Completo</label>
                                <input type="text" class="form-control" id="nombre" 
                                       value="<?= htmlspecialchars($_SESSION['username'] ?? '') ?>" 
                                       placeholder="Ingrese su nombre completo">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email">Correo Electrónico</label>
                                <input type="email" class="form-control" id="email" 
                                       value="<?= htmlspecialchars($_SESSION['email'] ?? '') ?>" 
                                       placeholder="correo@ejemplo.com">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="telefono">Teléfono</label>
                                <input type="tel" class="form-control" id="telefono" 
                                       placeholder="Ingrese su teléfono">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="departamento">Departamento</label>
                                <input type="text" class="form-control" id="departamento" 
                                       value="Administrativo" readonly>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password">Nueva Contraseña</label>
                                <input type="password" class="form-control" id="password" 
                                       placeholder="Ingrese nueva contraseña">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="confirm_password">Confirmar Contraseña</label>
                                <input type="password" class="form-control" id="confirm_password" 
                                       placeholder="Confirme la contraseña">
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">
                            <i class="mdi mdi-content-save me-2"></i>
                            Actualizar Perfil
                        </button>
                        <button type="button" class="btn btn-secondary">
                            <i class="mdi mdi-cancel me-2"></i>
                            Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.getElementById('profileForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    // Validación básica
    const password = document.getElementById('password').value;
    const confirmPassword = document.getElementById('confirm_password').value;
    
    if (password !== confirmPassword) {
        Swal.fire({
            title: 'Error',
            text: 'Las contraseñas no coinciden',
            icon: 'error',
            confirmButtonText: 'Aceptar'
        });
        return;
    }
    
    // Simular guardado (aquí iría tu AJAX)
    Swal.fire({
        title: '¡Perfil Actualizado!',
        text: 'Los cambios se han guardado correctamente',
        icon: 'success',
        confirmButtonText: 'Aceptar'
    });
});
</script>