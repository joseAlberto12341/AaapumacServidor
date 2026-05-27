<div class="row">
    <div class="col-12 grid-margin">
        <div class="card">
            <div class="card-body">
                <div class="d-sm-flex justify-content-between align-items-start">
                    <div>
                        <a href="javascript:history.back();"
                            class="btn btn-link text-primary d-inline-flex align-items-center"
                            style="font-size: 20px; text-decoration: none; margin-bottom: 15px; padding: 5px 10px; border-radius: 8px; background-color: #f0f8ff;">
                            <i class="mdi mdi-arrow-left" style="margin-right: 5px;"></i>
                            Regresar
                        </a>
                        <h4 class="card-title card-title-dash"
                            style="font-size: 42px; font-weight: 700; color: #0056b3; margin-bottom: 20px;">Listado de
                            <?php echo $answer['data']['title']; ?>
                        </h4>
                        <p class="card-subtitle card-subtitle-dash"
                            style="color: #007bff; font-size: 22px; font-weight: 700; margin: 15px 0;">
                            <?php echo $answer['data']['subtitle']; ?></p>
                        <?php if (isset($_GET['error'])): ?>
                            <div class="alert alert-success" role="alert">
                                <?php echo $_GET['error']; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div><br>
                        <button class="btn btn-primary btn-lg text-white mb-0 me-0" type="button" data-bs-toggle="modal"
                            data-bs-target="#modal-create-modal">
                            <i class="<?php echo $answer['data']['icon']; ?>">&nbsp;</i>
                            <?php echo $answer['data']['button']; ?>
                        </button>
                    </div>
                </div>
                <div class="table-responsive">
                    <table id="order-listing" class="table table-responsive table-hover table-bordered">
                        <thead class="table-primary">
                            <tr>
                                <th>Actions</th>
                                <th>Usuario</th>
                                <th>Correo Electronico</th>
                                <th>Codigo QR</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($answer['usuario'] as $f): ?>
                                <tr>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <!-- Botón de Editar -->
                                            <a href='/admin/<?php echo $f->getId(); ?>/modal' title="Editar"
                                                style="display: inline-block; padding: 6px 12px; border: 1px solid #007bff; border-radius: 4px; background-color: #f0f8ff; color: #007bff; text-decoration: none; margin-right: 5px;"
                                                onmouseover="this.style.backgroundColor='#007bff'; this.style.color='#fff';"
                                                onmouseout="this.style.backgroundColor='#f0f8ff'; this.style.color='#007bff';">
                                                <i class="ti-pencil-alt"></i> Editar
                                            </a>
                                            <!-- Botón de Eliminar -->
                                            <a href='/admin/<?php echo $f->getId(); ?>/del' title="Eliminar"
                                                style="display: inline-block; padding: 6px 12px; border: 1px solid #dc3545; border-radius: 4px; background-color: #fff0f1; color: #dc3545; text-decoration: none;"
                                                onmouseover="this.style.backgroundColor='#dc3545'; this.style.color='#fff';"
                                                onmouseout="this.style.backgroundColor='#fff0f1'; this.style.color='#dc3545';">
                                                <i class="ti-trash"></i> Eliminar
                                            </a>
                                        </div>
                                    </td>
                                    <td><?php echo $f->getUsuario(); ?></td>
                                    <td><?php echo $f->getEmail(); ?></td>
                                    <td><a href="/src/faces/qr_codes/<?php echo $f->getCodigo(); ?>" target="_blank"><img
                                                src="/src/faces/qr_codes/<?php echo $f->getCodigo(); ?>"></a></td>
                                    <td>
                                        <?php
                                        switch ($f->getStatus()) {
                                            case 0:
                                                echo '<label class="badge badge-danger">Inactivo</label>';
                                                break;
                                            case 1:
                                                echo '<label class="badge badge-success">Activo</label>';
                                                break;
                                        }
                                        ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>
</div>

<div class="modal fade" id="modal-create-modal" tabindex="-1" aria-labelledby="registroModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 10px; overflow: hidden;">
            <div class="modal-header"
                style="background-color: #3afe; color: white; display: flex; justify-content: center; align-items: center;">
                <i class="mdi mdi-account-plus" style="font-size: 1.5em; margin-right: 10px;"></i>
                <h5 class="modal-title" id="addContactModalLabel">Agregar nuevo Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                    style="filter: invert(1); position: absolute; right: 15px;"></button>
            </div>
            <div class="modal-body" style="padding: 2rem;">
                <form method="post" id="qr" action="/admin/registrar">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre de Usuario</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="mdi mdi-account"></i></span>
                            <input type="text" class="form-control" id="usuario" name="usuario" required
                                style="border-radius: 0 5px 5px 0; border: 1px solid #ccc;">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Correo Electronico</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="mdi mdi-email"></i></span>
                            <input type="email" class="form-control" id="email" name="email" required
                                style="border-radius: 0 5px 5px 0; border: 1px solid #ccc;">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="patente" class="form-label">Contraseña</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="mdi mdi-lock"></i></span>
                            <input type="password" class="form-control" id="contraseña" name="contraseña" required
                                style="border-radius: 0 5px 5px 0; border: 1px solid #ccc;">
                        </div>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                        <button type="button" class="btn btn-danger" data-bs-dismiss="modal"
                            style="border-radius: 5px;">Cancelar</button>
                        <button type="submit" class="btn btn-primary"
                            style="background-color: #3afe; border-color: #3afe; color: #fff; border-radius: 5px;">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('qr').addEventListener('submit', function (e) {
        e.preventDefault();
        Swal.fire({
            title: "Buen Trabajo, Qr Registrado!",
            text: "El Usuario ha sido agregado exitosamente!",
            icon: "success",
            confirmButtonText: 'Ok'
        }).then((result) => {
            if (result.isConfirmed) {
                this.submit();
            }
        });
    });
</script>