<?php
$itemsPerPage = 6;

// Obtener filtros de fecha
$filterStart = isset($_GET['start_date']) ? trim($_GET['start_date']) : '';
$filterEnd = isset($_GET['end_date']) ? trim($_GET['end_date']) : '';

// Obtener todos los modales
$allModals = isset($answer['modal']) && is_array($answer['modal']) ? $answer['modal'] : [];

$filteredModals = array_values(array_filter($allModals, function ($item) use ($filterStart, $filterEnd) {
  // Obtener la fecha de creación
  $createdAtRaw = method_exists($item, 'getCreatedAt') ? $item->getCreatedAt() : null;
  
  if (!$createdAtRaw) {
    return false;
  }

  // Intentar crear el objeto DateTime con manejo de errores
  try {
    $createdAt = new DateTime($createdAtRaw);
  } catch (Exception $e) {
    // Si falla, intentar con otro formato
    try {
      $createdAt = DateTime::createFromFormat('d/m/Y H:i:s', $createdAtRaw);
      if (!$createdAt) {
        return false;
      }
    } catch (Exception $e) {
      return false;
    }
  }

  // Filtrar por fecha de inicio (desde)
  if ($filterStart !== '') {
    $start = DateTime::createFromFormat('Y-m-d', $filterStart);
    if ($start && $createdAt < $start) {
      return false;
    }
  }

  // Filtrar por fecha de fin (hasta)
  if ($filterEnd !== '') {
    $end = DateTime::createFromFormat('Y-m-d', $filterEnd);
    if ($end) {
      $end->setTime(23, 59, 59);
      if ($createdAt > $end) {
        return false;
      }
    }
  }

  return true;
}));

$totalItems = count($filteredModals);
$totalPages = max(1, (int) ceil($totalItems / $itemsPerPage));
$currentPage = isset($_GET['page']) ? max(1, min($totalPages, intval($_GET['page']))) : 1;
$startIndex = ($currentPage - 1) * $itemsPerPage;
$endIndex = min($startIndex + $itemsPerPage, $totalItems);

// Construir la URL base para el paginador MANTENIENDO los filtros
$queryBase = [];
if ($filterStart !== '') {
    $queryBase['start_date'] = $filterStart;
}
if ($filterEnd !== '') {
    $queryBase['end_date'] = $filterEnd;
}
?>

<link rel="stylesheet" href="/Aaapumac/src/views/assets/css/aviso.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<div class="card card-rounded">
  <div class="card-body">
    <div class="d-sm-flex justify-content-between align-items-start">
      <div>
        <br><br><br>
        <h4 class="card-title card-title-dash" id="titulo-principal">Listado de
          <?php echo $answer['data']['title']; ?>
        </h4>
        <p class="card-subtitle card-subtitle-dash" id="subtitulo">
          <?php echo $answer['data']['subtitle']; ?>
        </p>
      </div>
    </div>
    <br>

<!-- Barra de filtrado minimalista -->
<div class="filter-bar">
  <form method="GET" class="filter-form">
    <input type="hidden" name="page" value="1">
    
    <div class="filter-group">
      <div class="filter-field">
        <label for="start_date" class="filter-label">Desde</label>
        <input type="date" id="start_date" name="start_date" class="filter-input"
          value="<?php echo htmlspecialchars($filterStart); ?>">
      </div>

      <div class="filter-separator">—</div>

      <div class="filter-field">
        <label for="end_date" class="filter-label">Hasta</label>
        <input type="date" id="end_date" name="end_date" class="filter-input"
          value="<?php echo htmlspecialchars($filterEnd); ?>">
      </div>

      <div class="filter-actions">
        <button type="submit" class="filter-btn filter-btn-primary">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M21 21L15 15M17 10C17 13.866 13.866 17 10 17C6.13401 17 3 13.866 3 10C3 6.13401 6.13401 3 10 3C13.866 3 17 6.13401 17 10Z"/>
          </svg>
          Filtrar
        </button>
        <a href="<?php echo strtok($_SERVER['REQUEST_URI'], '?'); ?>" class="filter-btn filter-btn-secondary">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
            <path d="M18 6L6 18M6 6L18 18"/>
          </svg>
          Limpiar
        </a>
      </div>
    </div>
  </form>
</div>
    <!-- Contenedor de cartas -->
    <div id="cardsContainer" class="row">
      <?php if ($totalItems === 0): ?>
        <div class="col-12">
          <div class="alert alert-info mb-0">No hay avisos para el rango de fechas seleccionado.</div>
        </div>
      <?php endif; ?>

      <?php
      for ($i = $startIndex; $i < $endIndex; $i++):
        $m = $filteredModals[$i];
      ?>
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-4 card-item">
          <div class="card h-100 shadow-sm">
            <!-- Imagen con enlace para nueva pestaña -->
            <div class="card-img-container position-relative" style="height: 200px; overflow: hidden;">
              <?php if ($m->getImage()): ?>
                <a href="<?php echo $m->getImage(); ?>" target="_blank" class="d-block h-100"
                  title="Abrir imagen en nueva pestaña">
                  <img src="<?php echo $m->getImage(); ?>" class="card-img-top img-expandable"
                    alt="<?php echo htmlspecialchars($m->getTitle()); ?>"
                    style="width: 100%; height: 100%; object-fit: cover; cursor: pointer;">
                  <div class="expand-overlay">
                    <span class="text-white bg-primary rounded-circle p-2">
                      <i class="fas fa-external-link-alt"></i>
                    </span>
                  </div>
                </a>
              <?php else: ?>
                <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 100%;">
                  <i class="fas fa-image fa-3x text-muted"></i>
                  <span class="text-muted ms-2">Sin imagen</span>
                </div>
              <?php endif; ?>

              <!-- Badge de estado -->
              <span class="position-absolute top-0 end-0 m-2">
                <?php
                switch ($m->getVisible()) {
                  case 0:
                    echo '<span class="badge bg-danger">Inactivo</span>';
                    break;
                  case 1:
                    echo '<span class="badge bg-success">Activo</span>';
                    break;
                }
                ?>
              </span>
            </div>

            <!-- Cuerpo de la carta -->
            <div class="card-body">
              <h5 class="card-title text-truncate" title="<?php echo htmlspecialchars($m->getTitle()); ?>">
                <?php echo htmlspecialchars($m->getTitle()); ?>
              </h5>

              <p class="card-text description-truncate" style="height: 60px; overflow: hidden;">
                <?php echo htmlspecialchars($m->getDescription()); ?>
              </p>

              <!-- Fechas -->
              <div class="card-dates mt-3">
                <small class="text-muted d-block">
                  <i class="far fa-calendar-plus"></i>
                  <strong>Creado:</strong>
                  <?php echo $m->getCreatedAt() ? date('d/m/Y H:i', strtotime($m->getCreatedAt())) : 'N/A'; ?>
                </small>
              </div>
              
              <!-- Ver archivo y descargar -->
              <div class="class-file mt-3 d-flex align-items-center flex-wrap gap-3">
                <?php if ($m->getArchivo()): ?>
                  <a href="<?php echo $m->getArchivo(); ?>" target="_blank"
                    class="d-inline-flex align-items-center text-primary text-decoration-none fw-semibold">
                    <i class="fas fa-file-pdf me-1"></i> Ver Archivo
                  </a>
                  <a href="<?php echo $m->getArchivo(); ?>" download
                    class="btn btn-sm d-inline-flex align-items-center text-primary">
                    <i class="fas fa-download me-1 text-primary"></i> Descargar PDF
                  </a>
                <?php else: ?>
                  <small class="text-muted d-inline-flex align-items-center">
                    <i class="fas fa-ban me-1"></i> No hay archivo disponible
                  </small>
                <?php endif; ?>
              </div>

              <!-- Enlace directo a la imagen -->
              <?php if ($m->getImage()): ?>
                <div class="mt-2">
                  <a href="<?php echo $m->getImage(); ?>" target="_blank"
                    class="btn btn-sm btn-link p-0 text-decoration-none" title="Abrir imagen en nueva pestaña">
                    <small><i class="fas fa-external-link-alt me-1"></i> Ver imagen completa</small>
                  </a>
                </div>
              <?php endif; ?>
            </div>
          </div>
        </div>
      <?php endfor; ?>
    </div>

    <!-- Paginador -->
    <?php if ($totalPages > 1): ?>
      <nav aria-label="Page navigation" class="mt-4">
        <ul class="pagination justify-content-center">
          <li class="page-item <?php echo $currentPage <= 1 ? 'disabled' : ''; ?>">
            <a class="page-link" href="?<?php echo http_build_query(array_merge($queryBase, ['page' => $currentPage - 1])); ?>"
              aria-label="Previous">
              <span aria-hidden="true">&laquo;</span>
            </a>
          </li>

          <?php
          $startPage = max(1, $currentPage - 2);
          $endPage = min($totalPages, $currentPage + 2);

          for ($page = $startPage; $page <= $endPage; $page++):
            ?>
            <li class="page-item <?php echo $page == $currentPage ? 'active' : ''; ?>">
              <a class="page-link" href="?<?php echo http_build_query(array_merge($queryBase, ['page' => $page])); ?>">
                <?php echo $page; ?>
              </a>
            </li>
          <?php endfor; ?>

          <li class="page-item <?php echo $currentPage >= $totalPages ? 'disabled' : ''; ?>">
            <a class="page-link" href="?<?php echo http_build_query(array_merge($queryBase, ['page' => $currentPage + 1])); ?>"
              aria-label="Next">
              <span aria-hidden="true">&raquo;</span>
            </a>
          </li>
        </ul>
        <p class="text-center text-muted mt-2">
          Mostrando <?php echo $totalItems > 0 ? $startIndex + 1 : 0; ?>-<?php echo $endIndex; ?> de <?php echo $totalItems; ?> elementos
        </p>
      </nav>
    <?php endif; ?>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="/Aaapumac/src/views/assets/js/aviso.js"></script>