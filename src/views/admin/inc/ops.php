<div class="card card-rounded" style="background-color: #f8f9fa; padding: 20px;">
    <div class="card-body">
        <div class="d-sm-flex justify-content-between align-items-center" style="margin-bottom: 20px;">
            <div>
                <h4 class="card-title card-title-dash" style="font-size: 1.8em; color: #007bff; margin-bottom: 10px;">
                    Listado de <?php echo htmlspecialchars($answer['data']['title']); ?>
                </h4>
                <p class="card-subtitle card-subtitle-dash" style="font-size: 1.2em; color: #6c757d;">
                    <?php echo htmlspecialchars($answer['data']['subtitle']); ?>
                </p>
                <?php if (isset($_GET['error'])): ?>
                    <div class="alert alert-success" role="alert" style="margin-bottom: 20px;">
                        <?php echo htmlspecialchars($_GET['error']); ?>
                    </div>
                <?php endif; ?>
            </div>
            <button type="button" class="btn btn-primary btn-lg text-white mb-0 me-0" data-bs-toggle="modal"
                data-bs-target="#addContactModal">
                <i class="<?php echo $answer['data']['icon']; ?>" style="margin-right: 8px;"></i>
                <?php echo $answer['data']['button']; ?>
            </button>
        </div>
        <div style="display: flex; flex-wrap: wrap; gap: 20px; justify-content: center;">
            <?php if (!empty($answer['contacts'])): ?>
                <?php foreach ($answer['contacts'] as $s): ?>
                    <div
                        style="display: flex; flex-direction: column; justify-content: space-between; position: relative; width: 300px; background: #fff; box-shadow: 0 10px 7px -5px rgba(0, 0, 0, 0.4); border: 1px solid #e1e1e1; border-radius: 12px; overflow: hidden; margin-bottom: 20px;">
                        <!-- Header -->
                        <div style="position: relative; width: 100%; height: 60px; background-color: #3afe;">
                            <div
                                style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: inherit; transform: skewY(-8deg); transform-origin: 100% 100%;">
                            </div>
                            <div
                                style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: inherit; transform: skewY(8deg); transform-origin: 0 100%;">
                            </div>
                            <div
                                style="position: absolute; left: 50%; top: 40px; transform: translateX(-50%); width: 100px; height: 100px; border-radius: 50%; overflow: hidden; background: #ccc; border: 3px solid #fff;">
                                <img src="/src/faces/<?php echo $s->getFoto(); ?>"
                                    alt="Foto de <?php echo htmlspecialchars($s->getNombre()); ?>"
                                    style="width: 100px; height: auto;">
                            </div>
                        </div>

                        <!-- Name -->
                        <h3 style="position: relative; margin: 80px 0 30px; text-align: center;">
                            <?php echo htmlspecialchars($s->getNombre()); ?>
                        </h3>

                        <!-- Description -->
                        <div style="padding: 0 1rem 2rem; text-align: center; line-height: 1.5; color: #777;">
                            <p style="font-size: 16px; margin: 0.5rem 0; color: #555;">
                                <strong style="color: #333;">Email:</strong>
                                <span style="color: #666;"><?php echo htmlspecialchars($s->getEmail()); ?></span>
                            </p>
                            <p style="font-size: 16px; margin: 0.5rem 0; color: #555;">
                                <strong style="color: #333;">Teléfono:</strong>
                                <span style="color: #666;"><?php echo htmlspecialchars($s->getTelefono()); ?></span>
                            </p>
                            <p style="font-size: 16px; margin: 0.5rem 0; color: #555;">
                                <strong style="color: #333;">Razón Social:</strong>
                                <span style="color: #666;"><?php echo htmlspecialchars($s->getRsocial()); ?></span>
                            </p>
                        </div>

                        <!-- Contacts -->
                        <div
                            style="width: 200px; max-width: 100%; margin: 0 auto 3rem; display: flex; justify-content: space-between;">
                            <a href="#" style="color: #c8c; text-align: center;">
                                <i class="mdi mdi-plus" style="font-size: 1.3em;"></i>
                            </a>
                            <a href="#" style="color: #c8c; text-align: center;">
                                <i class="mdi mdi-whatsapp" style="font-size: 1.3em;"></i>
                            </a>
                            <a href="#" style="color: #c8c; text-align: center;">
                                <i class="mdi mdi-email" style="font-size: 1.3em;"></i>
                            </a>
                        </div>

                        <!-- Footer -->
                        <div style="position: relative; padding: 1rem; background-color: #3afe; text-align: center;">
                            <p style="font-size: 16px; margin: 0.5rem 0; color: #555;">
                                <strong style="color: #333;">Patente:</strong>
                                <span style="color: #666;"><?php echo htmlspecialchars($s->getPatente()); ?></span>
                            </p>
                            <div
                                style="position: absolute; top: -27px; left: 50%; margin-left: -15px; border: 15px solid transparent; border-bottom-color: #3afe;">
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p style="font-size: 1.2em; color: #6c757d;">No hay contactos</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Modal para agregar contacto -->
<div class="modal fade" id="addContactModal" tabindex="-1" aria-labelledby="addContactModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 10px; overflow: hidden;">
            <div class="modal-header"
                style="background-color: #3afe; color: white; display: flex; justify-content: center; align-items: center;">
                <i class="mdi mdi-account-plus" style="font-size: 1.5em; margin-right: 10px;"></i>
                <h5 class="modal-title" id="addContactModalLabel">Agregar Contacto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                    style="filter: invert(1); position: absolute; right: 15px;"></button>
            </div>
            <div class="modal-body" style="padding: 2rem;">
                <form method="post" id="addContactForm" action="/admin/addContact">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="mdi mdi-account"></i></span>
                            <input type="text" class="form-control" id="nombre" name="nombre" required
                                style="border-radius: 0 5px 5px 0; border: 1px solid #ccc;">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="mdi mdi-email"></i></span>
                            <input type="email" class="form-control" id="email" name="email" required
                                style="border-radius: 0 5px 5px 0; border: 1px solid #ccc;">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="foto" class="form-label">Foto</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="mdi mdi-camera"></i></span>
                            <input type="file" class="form-control" id="foto" name="foto" accept=".jpg, .png" required
                                style="border-radius: 0 5px 5px 0; border: 1px solid #ccc;">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="telefono" class="form-label">Teléfono</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="mdi mdi-phone"></i></span>
                            <input type="text" class="form-control" id="telefono" name="telefono" required
                                style="border-radius: 0 5px 5px 0; border: 1px solid #ccc;">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="r_social" class="form-label">Razón Social</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="mdi mdi-domain"></i></span>
                            <input type="text" class="form-control" id="r_social" name="r_social" required
                                style="border-radius: 0 5px 5px 0; border: 1px solid #ccc;">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="patente" class="form-label">Patente</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="mdi mdi-certificate"></i></span>
                            <input type="text" class="form-control" id="patente" name="patente" required
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

<!-- Incluir SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.getElementById('addContactForm').addEventListener('submit', function (e) {
        e.preventDefault();
        Swal.fire({
            title: "Buen Trabajo!",
            text: "El contacto ha sido agregado exitosamente!",
            icon: "success",
            confirmButtonText: 'Ok'
        }).then((result) => {
            if (result.isConfirmed) {
                this.submit();
            }
        });
    });
</script>