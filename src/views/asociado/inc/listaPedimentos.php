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
      <div><br>
        <a href="/Aaapumac/asociado/folioPedimentos" class="btn btn-primary">
          <i class="mdi mdi-plus"></i> <?php echo $answer['data']['button']; ?>
        </a>
      </div>
    </div>

    <!-- FORMULARIO DE BÚSQUEDA Y FILTROS -->
    <div class="row mb-4">
      <div class="col-md-12">
        <div class="card">
          <div class="card-body">
            <form id="searchForm" method="GET" class="row g-3">
              <input type="hidden" name="page" value="1">
              
              <div class="col-md-3">
                <input type="text" class="form-control" name="search" 
                       placeholder="Buscar folio, nombre o patente..." 
                       value="<?php echo htmlspecialchars($answer['data']['filters']['search'] ?? ''); ?>">
              </div>
              
              <div class="col-md-2">
                <select class="form-control" name="estatus">
                  <option value="">Todos los estatus</option>
                  <option value="1" <?php echo ($answer['data']['filters']['estatus'] ?? '') == '1' ? 'selected' : ''; ?>>Activo</option>
                  <option value="2" <?php echo ($answer['data']['filters']['estatus'] ?? '') == '2' ? 'selected' : ''; ?>>Aduana</option>
                </select>
              </div>
              
              <div class="col-md-2">
                <button type="submit" class="btn btn-danger w-100">
                  <i class="mdi mdi-magnify"></i> Buscar
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>

    <br>
    <div class="table-responsive">
      <table id="order-listing" class="table table-responsive table-hover table-bordered">
        <thead class="table-primary">
          <tr>
            <th>Acciones</th>
            <th>Folio</th>
            <th>Patente</th>
            <th>Nombre Completo</th>
            <th>Fecha</th>
            <th>Estatus</th>
            <th>PDF</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($answer['data']['listaPedimentos'])): ?>
            <?php foreach ($answer['data']['listaPedimentos'] as $pedimento): ?>
              <tr>
                <td>
                  <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle d-flex align-items-center" type="button"
                      id="dropdownMenuButton<?php echo $pedimento->id; ?>" data-bs-toggle="dropdown" aria-expanded="false">
                      <i class="mdi mdi-dots-vertical" style="font-size: 22px; margin-right: 6px;"></i> Acciones
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton<?php echo $pedimento->id; ?>">
                      <li>
                        <a href="/Aaapumac/asociado/verPedimento?id=<?php echo $pedimento->id; ?>" class="dropdown-item">
                          <i class="ti-eye text-gray"> </i> Ver
                        </a>
                      </li>
                      <li>
                        <a href="/Aaapumac/asociado/generarPDF?id=<?php echo $pedimento->id; ?>" 
                           class="dropdown-item" target="_blank">
                          <i class="mdi mdi-file-pdf text-danger"> </i> Generar PDF
                        </a>
                      </li>
                    </ul>
                  </div>
                </td>
                <td><?php echo htmlspecialchars($pedimento->folio); ?></td>
                <td><?php echo htmlspecialchars($pedimento->patente); ?></td>
                <td><?php echo htmlspecialchars($pedimento->nombre_completo); ?></td>
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
                <td>
                  <?php if (isset($pedimento->pdf_generado) && $pedimento->pdf_generado && !empty($pedimento->pdf_filename)): ?>
                    <span class="badge bg-success">Generado</span>
                  <?php else: ?>
                    <span class="badge bg-warning">No generado</span>
                    <a href="/Aaapumac/asociado/generarPDF?id=<?php echo $pedimento->id; ?>" 
                       class="btn btn-sm btn-primary" title="Generar PDF">
                      <i class="mdi mdi-file-pdf"></i> Generar
                    </a>
                  <?php endif; ?>
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
      
      <!-- PAGINACIÓN -->
    <!-- <?php if ($answer['data']['pagination']['total'] > 0): ?>
      <nav aria-label="Page navigation">
        <ul class="pagination justify-content-center mt-4">
          <?php
          $currentPage = $answer['data']['pagination']['page'];
          $totalPages = $answer['data']['pagination']['total_pages'];
          $perPage = $answer['data']['pagination']['per_page'];
          
          // Construir query string para mantener filtros
          $queryParams = http_build_query([
              'search' => $answer['data']['filters']['search'] ?? '',
              'estatus' => $answer['data']['filters']['estatus'] ?? '',
              'fecha_desde' => $answer['data']['filters']['fecha_desde'] ?? '',
              'fecha_hasta' => $answer['data']['filters']['fecha_hasta'] ?? '',
              'per_page' => $perPage
          ]);
          
          $baseUrl = "/Aaapumac/asociado/listaPedimentos?";
          
          // Botón Anterior
          if ($currentPage > 1):
          ?>
          <li class="page-item">
            <a class="page-link" 
               href="<?php echo $baseUrl . $queryParams . '&page=' . ($currentPage - 1); ?>">
              &laquo; Anterior
            </a>
          </li>
          <?php endif; ?>-->
          
          <!-- Números de página -->
           <!--
          <?php 
          $startPage = max(1, $currentPage - 2);
          $endPage = min($totalPages, $currentPage + 2);
          
          for ($i = $startPage; $i <= $endPage; $i++):
          ?>
          <li class="page-item <?php echo $i == $currentPage ? 'active' : ''; ?>">
            <a class="page-link" 
               href="<?php echo $baseUrl . $queryParams . '&page=' . $i; ?>">
              <?php echo $i; ?>
            </a>
          </li>
          <?php endfor; ?>-->
          
          <!-- Botón Siguiente -->
           <!--
          <?php if ($currentPage < $totalPages): ?>
          <li class="page-item">
            <a class="page-link" 
               href="<?php echo $baseUrl . $queryParams . '&page=' . ($currentPage + 1); ?>">
              Siguiente &raquo;
            </a>
          </li>
          <?php endif; ?>
        </ul>
      </nav>
          -->
      <!-- INFORMACIÓN DE PAGINACIÓN -->
       <!--
      <div class="text-center text-muted mt-2">
        Mostrando <?php echo count($answer['data']['listaPedimentos']); ?> de 
        <?php echo number_format($answer['data']['pagination']['total']); ?> registros
        (Página <?php echo $currentPage; ?> de <?php echo $totalPages; ?>)
      </div>
      <?php endif; ?>
    </div>
  </div>
</div>-->

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="Aaapumac/src/views/assets/js/listPedimentos.js"></script>