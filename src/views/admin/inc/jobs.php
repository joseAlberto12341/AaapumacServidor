<div class="card card-rounded">
  <div class="card-body">
    <div class="d-sm-flex justify-content-between align-items-start">
      <div>
        <!-- Flecha de regreso -->
        <a href="serviAdmi" class="btn btn-link  d-inline-flex align-items-center"
          style="font-size: 15px;  margin-bottom: 40px; padding: 5px 10px; border-radius: 3px;">
          <i class="mdi mdi-arrow-left" style="margin-right: 6px;"></i>
          Regresar
        </a>
        <br></br>

        <!-- ALERTA DE ÉXITO AGREGADA AQUÍ -->
        <?php if (isset($_SESSION['success_message'])): ?>
          <div class="alert alert-success alert-dismissible fade show" role="alert" style="margin-bottom: 80px;">
            <i class="mdi mdi-check-circle-outline"></i>
            <?php echo $_SESSION['success_message']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          <?php
          // Limpiar el mensaje después de mostrarlo
          unset($_SESSION['success_message']);
          ?>
        <?php endif; ?>

        <h4 class="card-title card-title-dash"
          style="font-size: 42px; font-weight: 700; color: #0056b3; margin-bottom: 20px;">
          Listado de <?php echo $answer['data']['title']; ?>
        </h4>
        <p class="card-subtitle card-subtitle-dash"
          style="color: #175fa9; font-size: 22px; font-weight: 700; margin: 15px 0;">
          <?php echo $answer['data']['subtitle']; ?>
        </p>

        <?php if (isset($_GET['error'])): ?>
          <div class="alert alert-success" role="alert">
            <?php echo $_GET['error']; ?>
          </div>
        <?php endif; ?>
      </div>
      <div><br>
        <!-- Este botón NO lleva id -->
        <a href="/Aaapumac/admin/job" class="btn btn-primary">
          <i class="mdi mdi-briefcase"></i> Crear Nuevo Empleo
        </a>
      </div>
    </div>

    <br>
    <div class="table-responsive">
      <!-- <table id="order-listing" class="table table-responsive table-hover table-bordered"> -->
      <table id="order-listing" class="table table-responsive table-hover table-bordered">
        <thead class="table-primary">
          <tr>
            <th>Accciones</th>
            <th>Titulo</th>
            <th>Descripción</th>
            <th>Imagen</th>
            <th>Estatus</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($answer['jobs'] as $j): ?>
            <tr>
              <td>
                <a href="/Aaapumac/admin/editJob?id=<?php echo $j->getId(); ?>" class="btn btn-warning btn-icon"
                  title="Editar">
                  <i class="ti-pencil-alt text-light"></i>
                </a>
                <?php if ($j->getIdStatus() == 1): ?>
                  <!-- Botón para BLOQUEAR con confirmación -->
                  <a title="Bloquear" href='#' 
                    class="btn btn-danger btn-icon lock-btn"
                    data-id="<?php echo $j->getId(); ?>"
                    data-title="<?php echo htmlspecialchars($j->getTitle()); ?>"
                    data-action="lock">
                    <i class="ti-lock text-light"></i>
                  </a>
                <?php else: ?>
                  <!-- Botón para DESBLOQUEAR con confirmación -->
                  <a title="Desbloquear" href='#'
                    class="btn btn-success btn-icon unlock-btn"
                    data-id="<?php echo $j->getId(); ?>"
                    data-title="<?php echo htmlspecialchars($j->getTitle()); ?>"
                    data-action="unlock">
                    <i class="ti-unlock text-light"></i>
                  </a>
                <?php endif; ?>
              </td>
              <td><?php echo $j->getTitle(); ?></td>
              <td><?php echo $j->getDescription(); ?></td>
              <td><a href="<?php echo $j->getImage(); ?>" target="_blank"><img src="<?php echo $j->getImage(); ?>"></a>
              </td>
              <td><?php switch ($j->getIdStatus()) {
                case 0:
                  echo '<label class="badge badge-danger">Inactivo</label>';
                  break;
                case 1:
                  echo '<label class="badge badge-success">Activo</label>';
                  break;
              } ?></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

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
        // Redirigir a la URL correspondiente
        const url = `/Aaapumac/admin/${jobId}/${action}`;
        window.location.href = url;
      }
    });
  }

  // Agregar event listeners a los botones
  document.addEventListener('DOMContentLoaded', function() {
    const lockButtons = document.querySelectorAll('.lock-btn');
    const unlockButtons = document.querySelectorAll('.unlock-btn');
    
    lockButtons.forEach(button => {
      button.addEventListener('click', confirmJobAction);
    });
    
    unlockButtons.forEach(button => {
      button.addEventListener('click', confirmJobAction);
    });
  });

  // Script para el formulario de creación (si lo necesitas)
  document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('trabajos');
    if (form) {
      form.addEventListener('submit', function (e) {
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