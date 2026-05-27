<link rel="stylesheet" href="/Aaapumac/src/views/assets/css/tiSIDE.css">
<div class="card card-rounded">
  <div class="card-body">
    <div class="d-sm-flex justify-content-between align-items-start">
      <div>
        <br>

        <!-- ALERTA DE ÉXITO GENERAL -->
        <?php if (isset($_SESSION['success_message'])): ?>
          <div class="alert alert-success alert-dismissible fade show" role="alert" id="AlertaExito">
            <i class="mdi mdi-check-circle-outline"></i>
            <?php echo $_SESSION['success_message']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          <?php unset($_SESSION['success_message']); ?>
        <?php endif; ?>

        <!-- ALERTA DE ERROR GENERAL -->
        <?php if (isset($_SESSION['error_message'])): ?>
          <div class="alert alert-danger alert-dismissible fade show" role="alert" id="AlertaError">
            <i class="mdi mdi-alert-circle-outline"></i>
            <?php echo $_SESSION['error_message']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          <?php unset($_SESSION['error_message']); ?>
        <?php endif; ?>

        <!-- ALERTA POR GET - Edición exitosa -->
        <?php if (isset($_GET['success']) && $_GET['success'] == 2): ?>
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="mdi mdi-check-circle-outline"></i>
            Usuario editado exitosamente
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        <?php endif; ?>

        <!-- ALERTA POR GET - Contraseña cambiada exitosamente -->
        <?php if (isset($_GET['success']) && $_GET['success'] == 3): ?>
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="mdi mdi-check-circle-outline"></i>
            Contraseña cambiada exitosamente
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        <?php endif; ?>

        <!-- ALERTA POR GET - Usuario creado exitosamente -->
        <?php if (isset($_GET['success']) && $_GET['success'] == 1): ?>
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="mdi mdi-check-circle-outline"></i>
            Usuario creado exitosamente
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        <?php endif; ?>

        <!-- ALERTA POR GET - Error -->
        <?php if (isset($_GET['error'])): ?>
          <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="mdi mdi-alert-circle-outline"></i>
            <?php echo htmlspecialchars($_GET['error']); ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        <?php endif; ?>

        <h4 class="card-title card-title-dash" id="titulo">
          <?php echo $answer['data']['title']; ?>
        </h4>
        <p class="card-subtitle card-subtitle-dash" id="subtitulo">
          <?php echo $answer['data']['subtitle']; ?>
        </p>
      </div>
      <div><br>
        <a href="/Aaapumac/ti/nuevoUsuario" class="btn btn-primary">
          <i class="mdi mdi-plus"></i> Nuevo Usuario
        </a>
      </div>
    </div>

    <br>
    <div class="table-responsive">
      <table id="order-listing" class="table table-responsive table-hover table-bordered">
        <thead class="table-primary">
          <tr>
            <th>Acciones</th>
            <th>Username</th>
            <th>Email</th>
            <th>Rol</th>
            <th>Estatus</th>
            <th>Fecha Creación</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($answer['data']['listaUsuarios'])): ?>
            <?php foreach ($answer['data']['listaUsuarios'] as $usuario): ?>
              <tr>
                <td>
                  <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle d-flex align-items-center" type="button"
                      id="dropdownMenuButton<?php echo $usuario->id; ?>" data-bs-toggle="dropdown" aria-expanded="false">
                      <i class="mdi mdi-dots-vertical" id="btnAcciones"></i> Acciones
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton<?php echo $usuario->id; ?>">
                      <li>
                        <a href="/Aaapumac/ti/CambiarPassword?id=<?php echo $usuario->id; ?>" class="dropdown-item">
                          <i class="ti-key text-gray"></i> Cambiar Contraseña
                        </a>
                      </li>
                      <li>
                        <a href="/Aaapumac/ti/editarUsuario?id=<?php echo $usuario->id; ?>" class="dropdown-item">
                          <i class="ti-pencil text-primary"></i> Editar Usuario
                        </a>
                      </li>
                    </ul>
                  </div>
                 </div>
                <td><?php echo htmlspecialchars($usuario->username); ?></td>
                <td><?php echo htmlspecialchars($usuario->email); ?></td>
                <td><?php echo htmlspecialchars($usuario->rol_nombre ?? 'N/A'); ?></td>
                <td>
                  <?php
                  if ($usuario->id_status == 1) {
                    echo '<span class="badge bg-success">Activo</span>';
                  } else {
                    echo '<span class="badge bg-danger">Inactivo</span>';
                  }
                  ?>
                </td>
                <td>
                  <?php
                  if (!empty($usuario->created_at)) {
                    echo date('d/m/Y H:i', strtotime($usuario->created_at));
                  } else {
                    echo 'N/A';
                  }
                  ?>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="7" class="text-center">No hay usuarios registrados</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<script>
function eliminarUsuario(id) {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "No podrás revertir esta acción",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = '/Aaapumac/ti/eliminarUsuario?id=' + id;
        }
    });
}

// Auto cerrar alertas después de 5 segundos
document.addEventListener('DOMContentLoaded', function() {
    const alerts = document.querySelectorAll('.alert');
    alerts.forEach(function(alert) {
        setTimeout(function() {
            if (alert) {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }
        }, 5000);
    });
});
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>