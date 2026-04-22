<a href="/Aaapumac/ti/listaUsuarios">Regresar</a>
<br></br>

<?php
// Mostrar mensajes de éxito o error
if (isset($_GET['success'])) {
    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
            Usuario guardado exitosamente
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
          </div>';
}

if (isset($_GET['error'])) {
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
            Error: ' . htmlspecialchars($_GET['error']) . '
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
          </div>';
}
?>

<div class="content-wrapper">
    <div class="row">
        <div class="col-12 grid-margin">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title"><?php echo $answer['data']['title']; ?></h4>
                    <form method="post" id="formUsuario" enctype="multipart/form-data" action="/Aaapumac/ti/nuevoUsuario">
                        <p class="card-description">
                            <?php echo $answer['data']['subtitle']; ?>
                        </p>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Nombre de usuario</label>
                                    <div class="col-sm-9">
                                        <input name="username" id="username" type="text" class="form-control"
                                            placeholder="Nombre de usuario" required 
                                            value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Contraseña</label>
                                    <div class="col-sm-9">
                                        <input type="password" class="form-control" name="password" id="password"
                                            placeholder="Contraseña" required />
                                        <small class="form-text text-muted">Mínimo 6 caracteres</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Correo Electrónico</label>
                                    <div class="col-sm-9">
                                        <input type="email" name="email" id="email" class="form-control"
                                            placeholder="Correo Electrónico" required 
                                            value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" />
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Rol</label>
                                    <div class="col-sm-9">
                                        <select name="id_rol" id="id_rol" class="form-control" required>
                                            <option value="">Seleccione un rol</option>
                                            <option value="1" <?php echo (isset($_POST['id_rol']) && $_POST['id_rol'] == 1) ? 'selected' : ''; ?>>Admin</option>
                                            <option value="2" <?php echo (isset($_POST['id_rol']) && $_POST['id_rol'] == 2) ? 'selected' : ''; ?>>Administrativo</option>
                                            <option value="3" <?php echo (isset($_POST['id_rol']) && $_POST['id_rol'] == 3) ? 'selected' : ''; ?>>Tecnologías de la información</option>
                                            <option value="4" <?php echo (isset($_POST['id_rol']) && $_POST['id_rol'] == 4) ? 'selected' : ''; ?>>Operativo</option>
                                            <option value="5" <?php echo (isset($_POST['id_rol']) && $_POST['id_rol'] == 5) ? 'selected' : ''; ?>>CallCenter</option>
                                            <option value="6" <?php echo (isset($_POST['id_rol']) && $_POST['id_rol'] == 6) ? 'selected' : ''; ?>>Navieras y recintos</option>
                                            <option value="7" <?php echo (isset($_POST['id_rol']) && $_POST['id_rol'] == 7) ? 'selected' : ''; ?>>Jurídico</option>
                                            <option value="8" <?php echo (isset($_POST['id_rol']) && $_POST['id_rol'] == 8) ? 'selected' : ''; ?>>Calidad</option>
                                            <option value="9" <?php echo (isset($_POST['id_rol']) && $_POST['id_rol'] == 9) ? 'selected' : ''; ?>>Asociado</option>
                                            <option value="10" <?php echo (isset($_POST['id_rol']) && $_POST['id_rol'] == 10) ? 'selected' : ''; ?>>Asociado coordinador</option>
                                            <option value="11" <?php echo (isset($_POST['id_rol']) && $_POST['id_rol'] == 11) ? 'selected' : ''; ?>>Gestiones</option>
                                            <option value="12" <?php echo (isset($_POST['id_rol']) && $_POST['id_rol'] == 12) ? 'selected' : ''; ?>>Asociado común</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label">Estatus</label>
                                    <div class="col-sm-9">
                                        <select name="id_status" id="id_status" class="form-control" required>
                                            <option value="">Seleccione un estatus</option>
                                            <option value="1" <?php echo (isset($_POST['id_status']) && $_POST['id_status'] == 1) ? 'selected' : ''; ?>>Activo</option>
                                            <option value="2" <?php echo (isset($_POST['id_status']) && $_POST['id_status'] == 2) ? 'selected' : ''; ?>>Inactivo</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-2 text-center">
                                <button type="submit" class="btn btn-primary mb-2">Guardar</button>
                                <a href="/Aaapumac/ti/listaUsuarios" class="btn btn-secondary mb-2">Cancelar</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Validación adicional del lado del cliente
document.getElementById('formUsuario').addEventListener('submit', function(e) {
    var password = document.getElementById('password').value;
    if (password.length < 6) {
        e.preventDefault();
        alert('La contraseña debe tener al menos 6 caracteres');
    }
});
</script>