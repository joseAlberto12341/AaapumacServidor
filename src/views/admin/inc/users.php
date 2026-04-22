<div class="card card-rounded">
  <div class="card-body">
    <div class="d-sm-flex justify-content-between align-items-start">
      <div>
        <h4 class="card-title card-title-dash">Listado de <?php echo $answer['data']['title']; ?></h4>
        <p class="card-subtitle card-subtitle-dash"><?php echo $answer['data']['subtitle']; ?></p>
      </div>
      <div>
      <button type="button" class="btn btn-primary btn-lg text-white mb-0 me-0" data-bs-toggle="modal"
                data-bs-target="#addUserModal">
                <i class="<?php echo $answer['data']['icon']; ?>" style="margin-right: 8px;"></i>
                <?php echo $answer['data']['button']; ?>
            </button>
      </div>
    </div>
    <br>
    <div class="table-responsive">
      <table id="order-listing" class="table table-responsive table-hover table-bordered">
        <thead class="table-primary">
          <tr>
            <th>Actions</th>
            <!-- <th>ID #</th> -->
            <th>Nombre</th>
            <th>Email</th>
            <!-- <th>Contraseña</th> -->
            <th>Creado</th>
            <th>Actualizado</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($answer['users'] as $u): ?>
            <tr>
              <td>
                <a href='/admin/<?php echo $u->getId(); ?>/user' class="btn btn-warning btn-rounded btn-icon">
                  <i class="ti-pencil-alt text-light"></i>
                </a>
                <a href='/admin/<?php echo $u->getId(); ?>/del' class="btn btn-danger btn-rounded btn-icon">
                  <i class="ti-trash text-light"></i>
              </td>
              </td>
              <!-- <td><?php echo $u->getId(); ?></td> -->
              <td><?php echo $u->getUsername() ?></td>
              <td><?php echo $u->getEmail(); ?></td>
              <!-- <td><?php echo $u->getPassword(); ?></td> -->
              <td><?php echo $u->getCreatedAt(); ?></td>
              <td><?php echo $u->getUpdatedAt(); ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addContactModalLabel" aria-hidden="true">
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
                <form method="post" id="addUserForm" action="/admin/NewUser">
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="mdi mdi-account"></i></span>
                            <input type="text" class="form-control" id="username" name="username" required
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
                        <label for="patente" class="form-label">Role</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="mdi mdi-certificate"></i></span>
                            <input type="text" class="form-control" id="role" name="role" required
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