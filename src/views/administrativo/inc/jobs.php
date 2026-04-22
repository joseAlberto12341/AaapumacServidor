<link rel="stylesheet" href="/Aaapumac/src/views/assets/css/administrativolista.css">
<div class="card card-rounded">
  <div class="card-body">
    <div class="d-sm-flex justify-content-between align-items-start">
      <div>

        <br></br>

        <!-- ALERTA DE ÉXITO AGREGADA AQUÍ -->
        <?php if (isset($_SESSION['success_message'])): ?>
          <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="mdi mdi-check-circle-outline"></i>
            <?php echo $_SESSION['success_message']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" id="alerta" aria-label="Close"></button>
          </div>
          <?php
          // Limpiar el mensaje después de mostrarlo
          unset($_SESSION['success_message']);
          ?>
        <?php endif; ?>

        <h4 class="card-title card-title-dash" id="tituloPrincipal">
          Listado de <?php echo isset($answer) ? $answer['data']['title'] : 'Bolsa de Trabajo'; ?>
        </h4>

        <p class="card-subtitle card-subtitle-dash" id="subtitulo">
          <?php echo isset($answer) ? $answer['data']['subtitle'] : 'Empleos registrados'; ?>
        </p>

        <?php if (isset($_GET['error'])): ?>
          <div class="alert alert-success" role="alert">
            <?php echo $_GET['error']; ?>
          </div>
        <?php endif; ?>
      </div>
      <div><br>
        <!-- Este botón NO lleva id -->
        <a href="/Aaapumac/administrativo/job" class="btn btn-primary">
          <i class="mdi mdi-briefcase"></i>
          <?php echo isset($answer) ? $answer['data']['button'] : 'Crear Nuevo Empleo'; ?>
        </a>
      </div>
    </div>

    <br>
    <div class="table-responsive">
      <table id="order-listing" class="table table-hover table-bordered">
        <thead class="table-primary">
          <tr>
            <th>Acciones</th>
            <th>Título</th>
            <th>Descripción</th>
            <th>Imagen</th>
            <th>Estatus</th>
          </tr>
        </thead>
        <tbody>
          <?php
          // Determinar de dónde vienen los datos
          $jobsData = isset($answer) ? ($answer['jobs'] ?? []) : (isset($jobs) ? $jobs : []);

          if (is_array($jobsData) && count($jobsData) > 0):
          ?>
            <?php foreach ($jobsData as $j): ?>
              <tr>
                <td>
                  <?php
                  // Obtener ID de manera segura
                  $jobId = '';
                  if (is_object($j) && method_exists($j, 'getId')) {
                    $jobId = $j->getId();
                  } elseif (is_array($j) && isset($j['id'])) {
                    $jobId = $j['id'];
                  }

                  // Obtener título de manera segura
                  $jobTitle = '';
                  if (is_object($j) && method_exists($j, 'getTitle')) {
                    $jobTitle = htmlspecialchars($j->getTitle());
                  } elseif (is_array($j) && isset($j['title'])) {
                    $jobTitle = htmlspecialchars($j['title']);
                  }

                  // Obtener estatus de manera segura
                  $jobStatus = '';
                  if (is_object($j) && method_exists($j, 'getIdStatus')) {
                    $jobStatus = $j->getIdStatus();
                  } elseif (is_array($j) && isset($j['id_status'])) {
                    $jobStatus = $j['id_status'];
                  }
                  ?>

                  <?php if ($jobId): ?>
                    <a href="/Aaapumac/administrativo/editJob?id=<?php echo $jobId; ?>" class="btn btn-warning btn-icon"
                      title="Editar">
                      <i class="ti-pencil-alt text-light"></i>
                    </a>

                    <?php if ($jobStatus == 1): ?>
                      <!-- Botón para BLOQUEAR con confirmación -->
                      <a title="Bloquear" href='#'
                        class="btn btn-danger btn-icon lock-btn"
                        data-id="<?php echo $jobId; ?>"
                        data-title="<?php echo $jobTitle; ?>"
                        data-action="lock">
                        <i class="ti-lock text-light"></i>
                      </a>
                    <?php else: ?>
                      <!-- Botón para DESBLOQUEAR con confirmación -->
                      <a title="Desbloquear" href='#'
                        class="btn btn-success btn-icon unlock-btn"
                        data-id="<?php echo $jobId; ?>"
                        data-title="<?php echo $jobTitle; ?>"
                        data-action="unlock">
                        <i class="ti-unlock text-light"></i>
                      </a>
                    <?php endif; ?>
                  <?php endif; ?>
                </td>

                <td>
                  <?php
                  if (is_object($j) && method_exists($j, 'getTitle')) {
                    echo htmlspecialchars($j->getTitle());
                  } elseif (is_array($j) && isset($j['title'])) {
                    echo htmlspecialchars($j['title']);
                  } else {
                    echo 'N/A';
                  }
                  ?>
                </td>

                <td>
                  <?php
                  $description = '';
                  if (is_object($j) && method_exists($j, 'getDescription')) {
                    $description = $j->getDescription();
                  } elseif (is_array($j) && isset($j['description'])) {
                    $description = $j['description'];
                  }

                  // Mostrar solo los primeros 100 caracteres
                  echo htmlspecialchars(substr($description, 0, 100));
                  if (strlen($description) > 100) echo '...';
                  ?>
                </td>

                <td>
                  <?php
                  $image = '';
                  if (is_object($j) && method_exists($j, 'getImage')) {
                    $image = $j->getImage();
                  } elseif (is_array($j) && isset($j['image'])) {
                    $image = $j['image'];
                  }

                  if (!empty($image)):
                  ?>
                    <a href="<?php echo $image; ?>" target="_blank">
                      <img src="<?php echo $image; ?>" alt="Imagen" id="imagenid">
                    </a>
                  <?php else: ?>
                    <span class="text-muted">Sin imagen</span>
                  <?php endif; ?>
                </td>

                <td>
                  <?php
                  $status = '';
                  if (is_object($j) && method_exists($j, 'getIdStatus')) {
                    $status = $j->getIdStatus();
                  } elseif (is_array($j) && isset($j['id_status'])) {
                    $status = $j['id_status'];
                  }

                  switch ($status) {
                    case 0:
                      echo '<label class="badge badge-danger">Inactivo</label>';
                      break;
                    case 1:
                      echo '<label class="badge badge-success">Activo</label>';
                      break;
                    default:
                      echo '<label class="badge badge-secondary">Desconocido</label>';
                  }
                  ?>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="5" class="text-center">
                <div class="alert alert-info" style="margin: 20px 0;">
                  <i class="mdi mdi-information-outline"></i>
                  No hay empleos registrados en este momento.
                  <br>
                  <a href="/Aaapumac/administrativo/job" class="btn btn-primary btn-sm mt-2">
                    <i class="mdi mdi-plus"></i> Crear primer empleo
                  </a>
                </div>
              </td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<!-- ELIMINA todo el JavaScript de DataTables y reemplázalo con esto: -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  // Función para mostrar confirmación de bloqueo/desbloqueo
  function confirmJobAction(event) {
    event.preventDefault();

    const button = event.currentTarget;
    const jobId = button.getAttribute('data-id');
    const jobTitle = button.getAttribute('data-title');
    const action = button.getAttribute('data-action');

    const isLock = action === 'lock';
    const actionText = isLock ? 'bloquear' : 'desbloquear';
    const actionTitle = isLock ? 'Bloquear Empleo' : 'Desbloquear Empleo';
    const actionIcon = isLock ? 'warning' : 'success';
    const confirmButtonColor = isLock ? '#d33' : '#3085d6';

    Swal.fire({
      title: actionTitle,
      html: `¿Estás seguro que deseas <strong>${actionText}</strong> el empleo?<br><strong>"${jobTitle}"</strong>`,
      icon: actionIcon,
      showCancelButton: true,
      confirmButtonColor: confirmButtonColor,
      cancelButtonColor: '#6c757d',
      confirmButtonText: isLock ? 'Sí, bloquear' : 'Sí, desbloquear',
      cancelButtonText: 'Cancelar',
      reverseButtons: true
    }).then((result) => {
      if (result.isConfirmed) {
        const url = `/Aaapumac/administrativo/${action}?id=${jobId}`;
        window.location.href = url;
      }
    });
  }

  // Agregar event listeners
  document.addEventListener('DOMContentLoaded', function() {
    // Botones de bloqueo/desbloqueo
    document.querySelectorAll('.lock-btn, .unlock-btn').forEach(button => {
      button.addEventListener('click', confirmJobAction);
    });

    // Formulario de creación
    const form = document.getElementById('trabajos');
    if (form) {
      form.addEventListener('submit', function(e) {
        e.preventDefault();
        Swal.fire({
          title: "Buen Trabajo!",
          text: "El Empleo ha sido agregado exitosamente!",
          icon: "success",
          confirmButtonText: 'Ok'
        }).then((result) => {
          if (result.isConfirmed) {
            this.submit();
          }
        });
      });
    }
  });
</script>