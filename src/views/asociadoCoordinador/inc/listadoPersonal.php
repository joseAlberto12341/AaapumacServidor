<div class="card card-rounded">
  <div class="card-body">
    <div class="d-sm-flex justify-content-between align-items-start">
      <div>
        <br>

        <!-- ALERTA DE ÉXITO -->
        <?php if (isset($_SESSION['success_message'])): ?>
          <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-bottom: 80px;">
            <i class="mdi mdi-check-circle-outline"></i>
            <?php echo $_SESSION['success_message']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          <?php unset($_SESSION['success_message']); ?>
        <?php endif; ?>

        <h4 class="card-title card-title-dash" style="font-size: 42px; font-weight: 700; color: #0056b3; margin-bottom: 20px;">
          <?php echo $answer['data']['title']; ?>
        </h4>
        <p class="card-subtitle card-subtitle-dash" style="color: #175fa9; font-size: 22px; font-weight: 700; margin: 15px 0;">
          <?php echo $answer['data']['subtitle']; ?>
        </p>

        <?php if (isset($_GET['error'])): ?>
          <div class="alert alert-success" role="alert">
            <?php echo $_GET['error']; ?>
          </div>
        <?php endif; ?>
      </div>
      <div><br>
        <a href="/Aaapumac/asociadoCoordinador/AltaPersonal" class="btn btn-primary">
          <i class="mdi mdi-account-plus"></i> <?php echo $answer['data']['button']; ?>
        </a>
      </div>
    </div>

    <br>
    <div class="table-responsive">
      <table id="order-listing" class="table table-responsive table-hover table-bordered">
        <thead class="table-primary">
          <tr>
            <th>Acciones</th>
            <th>Nombre de usuario</th>
            <th>Correo electrónico</th>
            <th>Rol</th>
            <th>Fecha de registro</th>
            <th>Estatus</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($answer['listadoPersonal'])): ?>
            <?php foreach ($answer['listadoPersonal'] as $personal): ?>
              <tr>
                <td>
                  <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle d-flex align-items-center" type="button"
                      id="dropdownMenuButton<?php echo $personal->id; ?>" data-bs-toggle="dropdown" aria-expanded="false">
                      <i class="mdi mdi-dots-vertical" style="font-size: 22px; margin-right: 6px;"></i> Acciones
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton<?php echo $personal->id; ?>">
                      <li>
                        <a href="/Aaapumac/asociadoCoordinador/editarPersonal?id=<?php echo $personal->id; ?>" class="dropdown-item">
                          <i class="ti-pencil-alt text-gray"> </i> Editar
                        </a>
                      </li>
                      <li>
                        <a href="/Aaapumac/asociadoCoordinador/verPersonal?id=<?php echo $personal->id; ?>" class="dropdown-item">
                          <i class="ti-eye text-gray"> </i> Ver
                        </a>
                      </li>
                      <li>
                        <a href="/Aaapumac/asociadoCoordinador/informacionGeneral?id=<?php echo $personal->id; ?>" class="dropdown-item">
                          <i class="ti-plus text-gray"> </i> Información
                        </a>
                     </li>
                    </ul>
                  </div>
                </td>
                <td><?php echo htmlspecialchars($personal->username); ?></td>
                <td><?php echo htmlspecialchars($personal->email); ?></td>
                <td>
                  <?php 
                  $rol = $personal->id_role;
                  echo $rol == 9 ? 'Personal de la agencia aduanal' : 'Rol ' . $rol;
                  ?>
                </td>
                <td>
                  <?php 
                  if (!empty($personal->created_at) && strtotime($personal->created_at)) {
                    echo date('d/m/Y', strtotime($personal->created_at));
                  } else {
                    echo 'N/A';
                  }
                  ?>
                </td>
                <td>
                  <?php
                  $status = $personal->id_status;
                  switch ((int) $status) {
                    case 1:
                      echo '<span class="badge bg-success">Activo</span>';
                      break;
                    case 2:
                      echo '<span class="badge bg-danger">Inactivo</span>';
                      break;
                    case 3:
                      echo '<span class="badge bg-warning">Pendiente</span>';
                      break;
                    default:
                      echo '<span class="badge bg-secondary">Eliminado</span>';
                  }
                  ?>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="6" class="text-center">No hay personal con rol 9 registrado</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="/Aaapumac/src/views/assets/js/listadoPersonal.js"></script>