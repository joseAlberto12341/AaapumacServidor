
<div class="card card-rounded">
    <div class="card-body">
        <div class="d-sm-flex justify-content-between align-items-start">
            <div>
                <!-- Flecha de regreso -->
                <a href="serviAdmi" class="btn btn-link text-primary d-inline-flex align-items-center">
                    <i class="mdi mdi-arrow-left" style="margin-right: 5px;"></i>
                    Regresar
                </a>
                <br><br>
                <h4 class="card-title card-title-dash"
                    style="font-size: 42px; font-weight: 700; color: #0056b3; margin-bottom: 20px;">
                    Listado de <?php echo $answer['data']['title']; ?>
                </h4>
                <p class="card-subtitle card-subtitle-dash"
                    style="color: #007bff; font-size: 22px; font-weight: 700; margin: 15px 0;">
                    <?php echo $answer['data']['subtitle']; ?>
                </p>

                <?php if (isset($_GET['error'])): ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $_GET['error']; ?>
                    </div>
                <?php endif; ?>
            </div>
            <div><br>
            <!-- boton de agregar producto que esta su nombre y icono en el admincontroller-->
                <button type="button" class="btn btn-primary btn-lg text-white mb-0 me-0" data-bs-toggle="modal"
                    data-bs-target="#modal-agregar-producto">
                    <i class="<?php echo $answer['data']['icon']; ?>">&nbsp;</i>
                    <?php echo $answer['data']['button']; ?>
                </button>
            </div>
        </div>
        <br><br>
        <div class="table-responsive">
            <table id="order-listing" class="table table-hover table-bordered">
                <thead class="table-primary">
                    <tr>
                        <th>Acciones</th>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Descripción</th>
                    </tr>
                </thead> 
                <tbody>
                    <?php if (!empty($answer['data']['productos'])): ?>
                        <?php foreach ($answer['data']['productos'] as $i): ?>
                            <tr>
                                <td class="text-center" style="white-space: nowrap;">
                                    <div class="d-flex justify-content-center">
                                        <form method="post" action="/Aaapumac/admin/producMas" class="me-1">
                                            <input type="hidden" name="id_producto" value="<?php echo $i->getId(); ?>">
                                            <button type="submit" name="tipoMovimiento" value="entrada"
                                                style="display: inline-block; padding: 6px 12px; border: 1px solid #28a745; border-radius: 4px; background-color: #f0f8ff; color: #28a745; text-decoration: none; margin-right: 5px;"
                                                onmouseover="this.style.backgroundColor='#28a745'; this.style.color='#fff';"
                                                onmouseout="this.style.backgroundColor='#f0f8ff'; this.style.color='#28a745';">
                                                <i class="ti-plus"></i> Entrada
                                            </button>
                                        </form>
                                        <form method="post" action="/Aaapumac/admin/producMenos">
                                            <input type="hidden" name="id_producto" value="<?php echo $i->getId(); ?>">
                                            <button type="submit" name="tipoMovimiento" value="salida"
                                                <?php echo $i->getCantidad() <= 0 ? 'disabled' : ''; ?>
                                                style="display: inline-block; padding: 6px 12px; border: 1px solid #dc3545; border-radius: 4px; background-color: <?php echo $i->getCantidad() <= 0 ? '#e0e0e0' : '#f0f8ff'; ?>; color: <?php echo $i->getCantidad() <= 0 ? '#999' : '#dc3545'; ?>; text-decoration: none; <?php echo $i->getCantidad() <= 0 ? 'cursor: not-allowed; opacity: 0.6;' : ''; ?>"
                                                onmouseover="<?php echo $i->getCantidad() > 0 ? "this.style.backgroundColor='#dc3545'; this.style.color='#fff';" : ''; ?>"
                                                onmouseout="<?php echo $i->getCantidad() > 0 ? "this.style.backgroundColor='#f0f8ff'; this.style.color='#dc3545';" : ''; ?>">
                                                <i class="ti-minus"></i> Salida
                                            </button>
                                        </form>
                                    </div>
                                </td>
                                <td><?php echo $i->getNombre(); ?></td>
                                <td><?php echo $i->getCantidad(); ?></td>
                                <td><?php echo $i->getDescripcion(); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center">No hay productos disponibles.</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<!-- modal para productos -->
<div class="modal fade" id="modal-agregar-producto" tabindex="-1" aria-labelledby="modalAgregarProductoLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content" style="border-radius: 10px; overflow: hidden;">
            <div class="modal-header"
                style="background-color: #3afe; color: white; display: flex; justify-content: center; align-items: center;">
                <i class="mdi mdi-briefcase-plus" style="font-size: 1.5em; margin-right: 10px;"></i>
                <h5 class="modal-title" id="modalAgregarProductoLabel">Agregar Nuevo Producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                    style="filter: invert(1); position: absolute; right: 15px;"></button>
            </div>
            <div class="modal-body" style="padding: 2rem;">
                <form method="post" id="productos" enctype="multipart/form-data" action="/Aaapumac/admin/NewProduc">
                    <div class="mb-3">
                        <label for="title" class="form-label">Nombre del Producto</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="mdi mdi-format-size"></i></span>
                            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Título"
                                aria-label="title" required style="border-radius: 0 5px 5px 0; border: 1px solid #ccc;">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Descripción</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="mdi mdi-clipboard-text"></i></span>
                            <input type="text" class="form-control" id="descripcion" name="descripcion"
                                placeholder="Descripción" aria-label="description" required
                                style="border-radius: 0 5px 5px 0; border: 1px solid #ccc;">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="cantidad" class="form-label">Cantidad de Productos</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="mdi mdi-garage-alert-variant"></i></span>
                            <input type="number" class="form-control" id="cantidad" name="cantidad"
                                placeholder="0" aria-label="cantidad" min="0" value="0" required
                                style="border-radius: 0 5px 5px 0; border: 1px solid #ccc;">
                        </div>
                        <small class="form-text text-muted">La cantidad mínima es 0</small>
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
    // Validación del formulario
    document.getElementById('productos').addEventListener('submit', function (e) {
        e.preventDefault();
        
        const cantidad = parseInt(document.getElementById('cantidad').value);
        
        // Validar que la cantidad no sea negativa
        if (cantidad < 0) {
            Swal.fire({
                title: "Error",
                text: "La cantidad no puede ser menor a 0",
                icon: "error",
                confirmButtonText: 'Entendido'
            });
            return;
        }
        
        Swal.fire({
            title: "Buen Trabajo!",
            text: "El producto nuevo se ha sido agregado exitosamente!",
            icon: "success",
            confirmButtonText: 'Ok'
        }).then((result) => {
            if (result.isConfirmed) {
                this.submit();
            }
        });
    });

    // Validación en tiempo real del input de cantidad
    document.getElementById('cantidad').addEventListener('input', function(e) {
        if (this.value < 0) {
            this.value = 0;
        }
    });

    // Prevenir entrada de números negativos con teclado
    document.getElementById('cantidad').addEventListener('keydown', function(e) {
        if (e.key === '-' || e.key === 'e') {
            e.preventDefault();
        }
    });
</script>