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

        <!-- ALERTA DE ERROR -->
        <?php if (isset($_SESSION['error_message'])): ?>
          <div class="alert alert-danger alert-dismissible fade show" role="alert" style="margin-bottom: 80px;">
            <i class="mdi mdi-alert-circle-outline"></i>
            <?php echo $_SESSION['error_message']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
          <?php unset($_SESSION['error_message']); ?>
        <?php endif; ?>

        <h4 class="card-title card-title-dash"
          style="font-size: 42px; font-weight: 700; color: #0056b3; margin-bottom: 20px;">
          <?php echo $answer['data']['title']; ?>
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
    </div>

    <br>
    <div class="table-responsive">
      <table id="order-listing" class="table table-responsive table-hover table-bordered">
        <thead class="table-primary">
          <tr>
            <th>Acciones</th>
            <th>Token</th>
            <th>Patente</th>
            <th>Nombre Completo</th>
            <th>Folio Aduana</th>
            <th>Fecha</th>
            <th>Estatus</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($answer['data']['Folioaduana'])): ?>
            <?php foreach ($answer['data']['Folioaduana'] as $pedimento): ?>
              <tr>
                <td>
                  <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle d-flex align-items-center" type="button"
                      id="dropdownMenuButton<?php echo $pedimento->id; ?>" data-bs-toggle="dropdown" aria-expanded="false">
                      <i class="mdi mdi-dots-vertical" style="font-size: 22px; margin-right: 6px;"></i> Acciones
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton<?php echo $pedimento->id; ?>">
                      <li>
                        <a href="/Aaapumac/Gestion/observacionesFolio?id=<?php echo $pedimento->id; ?>" class="dropdown-item"
                          >
                          <i class="mdi mdi-file-pdf text-danger"> </i> Agregar observaciones
                        </a>
                      </li>
                      <li>
                        <a href="/Aaapumac/asociado/generarPDF?id=<?php echo $pedimento->id; ?>" class="dropdown-item"
                          target="_blank">
                          <i class="mdi mdi-file-pdf text-danger"> </i> Finalizar Folio Aduana
                        </a>
                      </li>
                    </ul>
                  </div>
                </td>
                <td><?php echo htmlspecialchars($pedimento->Token); ?></td>
                <td><?php echo htmlspecialchars($pedimento->patente); ?></td>
                <td><?php echo htmlspecialchars($pedimento->nombre_completo); ?></td>
                <td>
                  <?php if (!empty($pedimento->folios_aduana)): ?>
                    <span class="badge bg-info text-white">
                      <i class="mdi mdi-tag me-1"></i>
                      <?php echo htmlspecialchars($pedimento->folios_aduana); ?>
                    </span>
                    <br>
                    <small class="text-muted">
                      <i class="mdi mdi-calendar-clock me-1"></i>
                      <?php
                      if (!empty($pedimento->updated_at) && $pedimento->updated_at != $pedimento->created_at) {
                        echo 'Actualizado: ' . date('d/m/Y H:i', strtotime($pedimento->updated_at));
                      } else {
                        echo 'Creado: ' . date('d/m/Y H:i', strtotime($pedimento->created_at));
                      }
                      ?>
                    </small>
                  <?php else: ?>
                    <span class="badge bg-secondary">
                      <i class="mdi mdi-tag-off me-1"></i>
                      Sin folio
                    </span>
                  <?php endif; ?>
                </td>
                <td>
                  <?php
                  if (!empty($pedimento->fecha) && strtotime($pedimento->fecha)) {
                    echo date('d/m/Y', strtotime($pedimento->fecha));
                  } else {
                    echo 'N/A';
                  }
                  ?>
                </td>
                <td>
                  <?php
                  $status = $pedimento->Estatus;
                  switch ((int) $status) {
                    case 1:
                      echo '<span class="badge bg-success">Activo</span>';
                      break;
                    case 2:
                      echo '<span class="badge bg-primary">Aduana</span>';
                      break;
                    case 3:
                      echo '<span class="badge bg-warning">Pendiente</span>';
                      break;
                    default:
                      echo '<span class="badge bg-secondary">Desconocido</span>';
                  }
                  ?>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="7" class="text-center">No hay folios registrados</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    modal.addEventListener('hidden.bs.modal', function () {
      if (form) {
        form.reset();
        document.getElementById('pedimento_id').value = '';
        document.getElementById('modal_token_display').textContent = '-';
      }
      if (input) {
        input.style.borderColor = '#e2e8f0';
        input.style.boxShadow = 'none';
      }
      // Restaurar título por defecto
      modalTitle.innerHTML = '<i class="mdi mdi-plus me-2"></i> Nuevo Folio Aduana';
      iconContainer.className = 'mdi mdi-plus text-white';
    });
  });
</script>