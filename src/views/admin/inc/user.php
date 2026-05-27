<div class="card card-rounded">
  <div class="card-body">
    <div class="d-sm-flex justify-content-between align-items-start">
      <div>
        <h4 class="card-title card-title-dash">Listado de <?php echo $answer['data']['title']; ?></h4>
        <p class="card-subtitle card-subtitle-dash"><?php echo $answer['data']['subtitle']; ?></p>
      </div>
      <div>
        <a class="btn btn-primary btn-lg text-white mb-0 me-0">
          <i class="<?php echo $answer['data']['icon']; ?>">&nbsp;</i>
          <?php echo $answer['data']['button']; ?>
        </a>
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
          <?php foreach ($answer['user'] as $u): ?>
            <tr>
              <td>
                <a href='/admin/<?php echo $u->getId_Job(); ?>/user' class="btn btn-warning btn-icon"><i
                    class="ti-pencil-alt"></i></a>
                <a href='/admin/<?php echo $u->getId_Job(); ?>/na' class="btn btn-danger btn-icon"><i
                    class="ti-trash"></i></a>
              </td>
              <!-- <td><?php echo $u->getId(); ?></td> -->
              <td><?php echo $u->getName() ?></td>
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