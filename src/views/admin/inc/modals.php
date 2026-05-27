<div class="card card-rounded">
  <div class="card-body">

    <!-- AGREGAR AQUÍ LOS MENSAJES DE ALERTA -->
    <?php if (isset($_SESSION['success'])): ?>
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?php echo $_SESSION['success']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?php echo $_SESSION['error']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      <?php unset($_SESSION['error']); ?>
    <?php endif; ?>
    <!-- FIN DE MENSAJES DE ALERTA -->

    <div class="d-sm-flex justify-content-between align-items-start">
      <div>
        <a href="serviCall" class="btn btn-link  d-inline-flex align-items-center"
          style="font-size: 12px; margin-bottom: 40px; padding: 5px 10px; border-radius: 3px; ">
          <i class="mdi mdi-arrow-left" style="margin-right: 6px;"></i>
          Regresar
        </a>
        <h4 class="card-title card-title-dash"
          style="font-size: 42px; font-weight: 700; color: #0056b3; margin-bottom: 20px;">Listado de
          <?php echo $answer['data']['title']; ?>
        </h4>
        <p class="card-subtitle card-subtitle-dash"
          style="color: #007bff; font-size: 22px; font-weight: 700; margin: 15px 0;">
          <?php echo $answer['data']['subtitle']; ?>
        </p>
      </div>
      <div>
        <button class="btn btn-primary btn-lg text-white mb-0 me-0" type="button" data-bs-toggle="modal"
          data-bs-target="#modal-create-modal">
          <i class="<?php echo $answer['data']['icon']; ?>">&nbsp;</i>
          <?php echo $answer['data']['button']; ?>
        </button>
      </div>
    </div>
    <br>

    <div class="table-responsive">
      <table id="order-listing" class="table table-responsive table-hover table-bordered">
        <thead class="table-primary">
          <tr>
            <th>Acciones</th>
            <th>Titulo</th>
            <th>Descripción</th>
            <th>Imagen</th>
            <th>Estado</th>
            <th>Categoria</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($answer['modal'] as $m): ?>
            <tr>
              <td>
                <div class="btn-group">
                  <button type="button" class="btn btn-warning btn-sm" title="Editar" data-bs-toggle="modal"
                    data-bs-target="#modal-edit-modal-<?php echo $m->getId(); ?>">
                    <i class="ti-pencil-alt"></i>
                  </button>
                </div>
              </td>
              </td>
              <!-- <td><?php echo $m->getId(); ?></td> -->
              <td><?php echo $m->getTitle(); ?></td>
              <td><?php echo $m->getDescription(); ?></td>
              <td><a href="<?php echo $m->getImage(); ?>" target="_blank"><img
                    src="/Aaapumac/src/views/assets/img/modal/<?php echo $m->getImage(); ?>" alt="Imagen"
                    style="width: 100px; height: auto;">
                </a>
              </td>
              <td><?php switch ($m->getVisible()) {
                case 0:
                  echo '<label class="badge badge-danger">Inactivo</label>';
                  break;

                case 1:
                  echo '<label class="badge badge-success">Activo</label>';
                  break;
              } ?></td>
              <td><?php echo $m->getIdCategory(); ?></td>
              <!-- <td><?php echo $m->getCreatedAt(); ?></td>
              <td><?php echo $m->getUpdatedAt(); ?></td> -->
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<div class="card card-rounded">

</div>
<!-- Modal nuevo Aviso -->
<div class="modal fade" id="modal-create-modal" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" style="border-radius: 10px; overflow: hidden;">
      <div class="modal-header"
        style="background-color: #3afe; color: white; display: flex; justify-content: center; align-items: center;">
        <i class="mdi mdi-bell-plus" style="font-size: 1.5em; margin-right: 10px;"></i>
        <h5 class="modal-title" id="ModalLabel"><strong>Agregar Nuevo Aviso</strong></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
          style="filter: invert(1); position: absolute; right: 15px;"></button>
      </div>
      <div class="modal-body" style="padding: 2rem;">
        <form method="post" id="avisos" action="/Aaapumac/admin/NewAviso" enctype="multipart/form-data">
          <div class="mb-3">
            <label for="title" class="form-label">Titulo</label>
            <div class="input-group">
              <span class="input-group-text"><i class="mdi mdi-format-size"></i></span>
              <input type="text" class="form-control" id="title" name="title" required placeholder="Titulo"
                aria-label="title" style="border-radius: 0 5px 5px 0; border: 1px solid #ccc;">
            </div>
          </div>
          <div class="mb-3">
            <label for="description" class="form-label">Descripción</label>
            <div class="input-group">
              <span class="input-group-text"><i class="mdi mdi-clipboard-text"></i></span>
              <input type="text" class="form-control" id="description" name="description" required
                placeholder="Descripción" aria-label="description"
                style="border-radius: 0 5px 5px 0; border: 1px solid #ccc;">
            </div>
          </div>
          <div class="mb-3">
            <label for="image" class="form-label">Imagen</label>
            <div class="input-group">
              <input type="file" class="form-control" id="image" name="image" required aria-label="image"
                style="border-radius: 5px; border: 1px solid #ccc;">
            </div>
          </div>
          <div class="mb-3">
            <label for="visible" class="form-label">Estado</label>
            <div class="input-group">
              <span class="input-group-text"><i class="mdi mdi-clipboard-check"></i></span>
              <select class="form-control" id="visible" name="visible" required
                style="border-radius: 0 5px 5px 0; border: 1px solid #ccc;">
                <option value="1">Activo</option>
                <option value="0">Inactivo</option>
              </select>
            </div>
          </div>
          <div class="mb-3">
            <label for="id_category" class="form-label">Categoria</label>
            <div class="input-group">
              <span class="input-group-text"><i class="mdi mdi-view-carousel"></i></span>
              <input type="text" class="form-control" id="id_category" name="id_category" required
                placeholder="Categoria" aria-label="Categoria"
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
<!-- Fin Modal nuevo Aviso -->
 
<!-- Modal Editar Aviso -->
<?php foreach ($answer['modal'] as $m): ?>
  <div class="modal fade" id="modal-edit-modal-<?php echo $m->getId(); ?>" tabindex="-1"
    aria-labelledby="EditModalLabel-<?php echo $m->getId(); ?>" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content" style="border-radius: 10px; overflow: hidden;">
        <div class="modal-header"
          style="background-color: #ffc107; color: white; display: flex; justify-content: center; align-items: center;">
          <i class="mdi mdi-bell-ring" style="font-size: 1.5em; margin-right: 10px;"></i>
          <h5 class="modal-title" id="EditModalLabel-<?php echo $m->getId(); ?>"><strong>Editar Aviso</strong></h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
            style="filter: invert(1); position: absolute; right: 15px;"></button>
        </div>
        <div class="modal-body" style="padding: 2rem;">
          <form method="post" id="edit-aviso-<?php echo $m->getId(); ?>" action="/Aaapumac/admin/ActualizarAviso"
            enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $m->getId(); ?>">

            <div class="mb-3">
              <label for="title-<?php echo $m->getId(); ?>" class="form-label">Titulo</label>
              <div class="input-group">
                <span class="input-group-text"><i class="mdi mdi-format-size"></i></span>
                <input type="text" class="form-control" id="title-<?php echo $m->getId(); ?>" name="title" required
                  value="<?php echo $m->getTitle(); ?>" placeholder="Titulo"
                  style="border-radius: 0 5px 5px 0; border: 1px solid #ccc;">
              </div>
            </div>

            <div class="mb-3">
              <label for="description-<?php echo $m->getId(); ?>" class="form-label">Descripción</label>
              <div class="input-group">
                <span class="input-group-text"><i class="mdi mdi-clipboard-text"></i></span>
                <input type="text" class="form-control" id="description-<?php echo $m->getId(); ?>" name="description"
                  required value="<?php echo $m->getDescription(); ?>" placeholder="Descripción"
                  style="border-radius: 0 5px 5px 0; border: 1px solid #ccc;">
              </div>
            </div>

            <div class="mb-3">
              <label for="image-<?php echo $m->getId(); ?>" class="form-label">Imagen</label>
              <div class="input-group">
                <input type="file" class="form-control" id="image-<?php echo $m->getId(); ?>" name="image"
                  style="border-radius: 5px; border: 1px solid #ccc;">
              </div>
              <small class="text-muted">Imagen actual: <?php echo $m->getImage(); ?></small>
              <?php if ($m->getImage()): ?>
                <div>
                  <img src="/Aaapumac/src/views/assets/img/modal/<?php echo $m->getImage(); ?>" alt="Imagen actual"
                    style="width: 100px; height: auto; margin-top: 5px;">
                </div>
              <?php endif; ?>
            </div>

            <div class="mb-3">
              <label for="visible-<?php echo $m->getId(); ?>" class="form-label">Estado</label>
              <div class="input-group">
                <span class="input-group-text"><i class="mdi mdi-clipboard-check"></i></span>
                <select class="form-control" id="visible-<?php echo $m->getId(); ?>" name="visible" required
                  style="border-radius: 0 5px 5px 0; border: 1px solid #ccc;">
                  <option value="1" <?php echo $m->getVisible() == 1 ? 'selected' : ''; ?>>Activo</option>
                  <option value="0" <?php echo $m->getVisible() == 0 ? 'selected' : ''; ?>>Inactivo</option>
                </select>
              </div>
            </div>

            <div class="mb-3">
              <label for="id_category-<?php echo $m->getId(); ?>" class="form-label">Categoria</label>
              <div class="input-group">
                <span class="input-group-text"><i class="mdi mdi-view-carousel"></i></span>
                <input type="text" class="form-control" id="id_category-<?php echo $m->getId(); ?>" name="id_category"
                  required value="<?php echo $m->getIdCategory(); ?>" placeholder="Categoria"
                  style="border-radius: 0 5px 5px 0; border: 1px solid #ccc;">
              </div>
            </div>

            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
              <button type="button" class="btn btn-danger" data-bs-dismiss="modal"
                style="border-radius: 5px;">Cancelar</button>
              <button type="submit" class="btn btn-warning" style="border-radius: 5px;">Actualizar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
<?php endforeach; ?>
<!-- Fin Modal Editar Aviso -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  // Alerta para agregar nuevo aviso
  document.getElementById('avisos').addEventListener('submit', function (e) {
    e.preventDefault();
    Swal.fire({
      title: "Buen Trabajo!",
      text: "El Aviso ha sido agregado exitosamente!",
      icon: "success",
      confirmButtonText: 'Ok'
    }).then((result) => {
      if (result.isConfirmed) {
        this.submit();
      }
    });
  });

  // Alerta de confirmación para actualizar avisos
  <?php foreach ($answer['modal'] as $m): ?>
    document.getElementById('edit-aviso-<?php echo $m->getId(); ?>').addEventListener('submit', function (e) {
      e.preventDefault();
      Swal.fire({
        title: '¿Estás seguro?',
        text: "¿Deseas actualizar este aviso?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#ffc107',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, actualizar',
        cancelButtonText: 'Cancelar'
      }).then((result) => {
        if (result.isConfirmed) {
          Swal.fire({
            title: '¡Actualizado!',
            text: 'El aviso ha sido actualizado exitosamente.',
            icon: 'success',
            confirmButtonText: 'Ok'
          }).then(() => {
            document.getElementById('edit-aviso-<?php echo $m->getId(); ?>').submit();
          });
        }
      });
    });
  <?php endforeach; ?>
</script>