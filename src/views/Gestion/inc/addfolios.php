<link rel="stylesheet" href="/Aaapumac/src/views/assets/css/addfolios.css">
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

    <!-- BARRA DE BÚSQUEDA SIMPLE -->
    <div class="row mb-4">
      <div class="col-md-6">
        <div class="input-group">
          <input type="text" 
                 id="search-input" 
                 class="form-control" 
                 placeholder="Buscar por token, patente, nombre, folio..." 
                 aria-label="Buscar">
          <button class="btn btn-outline-secondary" type="button" id="clear-search-btn" style="display: none;">
            <i class="mdi mdi-close"></i>
          </button>
          <button class="btn btn-primary" type="button" id="search-btn">
            <i class="mdi mdi-magnify"></i> Buscar
          </button>
        </div>
        <small class="text-muted mt-2 d-block">
          <i class="mdi mdi-information-outline me-1"></i>
          Presiona Enter o haz clic en Buscar para filtrar resultados
        </small>
      </div>
    </div>

    <br>
    <div class="table-responsive">
      <table id="folios-table" class="table table-responsive table-hover table-bordered">
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
        <tbody id="table-body">
          <!-- La tabla se cargará dinámicamente con JavaScript -->
        </tbody>
      </table>

      <div id="pagination-container" class="mt-3"></div>

      <div class="d-flex justify-content-between align-items-center mt-3">
        <div id="records-counter" class="text-muted small">
          Mostrando 0-0 de 0 registros
        </div>

        <div class="d-flex align-items-center">
          <span class="me-2 small text-muted">Mostrar:</span>
          <select id="items-per-page" class="form-select form-select-sm" style="width: auto;">
            <option value="5">5</option>
            <option value="10" selected>10</option>
            <option value="20">20</option>
            <option value="50">50</option>
            <option value="100">100</option>
          </select>
          <span class="ms-2 small text-muted">por página</span>
        </div>
      </div>

      <div id="loading-spinner" class="text-center py-4">
        <div class="spinner-border text-primary" role="status">
          <span class="visually-hidden">Cargando...</span>
        </div>
        <p class="mt-2 text-muted">Cargando folios...</p>
      </div>
      <div id="no-data" class="text-center py-4" style="display: none;">
        <i class="mdi mdi-inbox-outline" style="font-size: 48px; color: #6c757d;"></i>
        <p class="mt-2">No hay folios registrados</p>
      </div>
      <div id="search-no-results" class="text-center py-4" style="display: none;">
        <i class="mdi mdi-magnify-close" style="font-size: 48px; color: #6c757d;"></i>
        <p class="mt-2">No se encontraron resultados para "<span id="search-term-display" class="fw-bold"></span>"</p>
        <button id="clear-search-btn-2" class="btn btn-outline-primary mt-2">
          <i class="mdi mdi-close-circle-outline me-1"></i>Limpiar búsqueda
        </button>
      </div>
      <div id="error-message" class="text-center py-4" style="display: none;">
        <i class="mdi mdi-alert-circle-outline" style="font-size: 48px; color: #dc3545;"></i>
        <p class="mt-2 text-danger">Error al cargar los datos</p>
        <button id="retry-btn" class="btn btn-primary mt-2">Reintentar</button>
      </div>
    </div>
  </div>
</div>

<!-- MODAL PARA ASIGNAR FOLIO -->
<div class="modal fade" id="asignarFolioModal" tabindex="-1" aria-labelledby="asignarFolioModalLabel"
  aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content"
      style="border: none; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);">

      <div class="modal-header border-0"
        style="background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%); padding: 24px 24px 16px;">
        <div class="w-100">
          <div class="d-flex align-items-center justify-content-between mb-2">
            <div class="d-flex align-items-center">
              <div class="icon-container me-3"
                style="width: 40px; height: 40px; background: linear-gradient(135deg, #28a745 0%, #20c997 100%); border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                <i class="mdi mdi-check-circle-outline text-white" style="font-size: 20px;"></i>
              </div>
              <div>
                <h5 class="modal-title mb-0" style="font-weight: 600; color: #2d3748; font-size: 1.25rem;"
                  id="asignar_modal_title">
                  Asignar Folio Aduana
                </h5>
                <p class="text-muted mb-0" style="font-size: 0.875rem; margin-top: 4px;">
                  <i class="mdi mdi-key me-1" style="font-size: 14px;"></i>
                  Token: <span id="asignar_modal_token_display" class="fw-medium text-dark">-</span>
                </p>
              </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
              style="opacity: 0.4; transform: scale(0.9); transition: all 0.2s;">
            </button>
          </div>
        </div>
      </div>

      <div class="modal-body p-4" style="background: #fff;">
        <form id="formAsignarFolio">
          <input type="hidden" id="asignar_pedimento_id" name="pedimento_id" value="">

          <div class="mb-4">
            <label for="asignar_folio_aduana" class="form-label d-flex align-items-center justify-content-between mb-3">
              <span
                style="font-weight: 500; color: #4a5568; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 0.5px;">
                <i class="mdi mdi-text-box-outline me-2" style="color: #28a745;"></i>
                Folio Aduana
              </span>
              <span class="text-danger" style="font-size: 0.75rem;">Requerido *</span>
            </label>

            <div class="input-group">
              <input type="text" class="form-control" id="asignar_folio_aduana" name="folio_aduana"
                placeholder="Ingresa el número de folio" required style="border: 2px solid #e2e8f0; 
                            border-radius: 10px; 
                            padding: 14px 16px;
                            font-size: 1rem;
                            color: #2d3748;
                            transition: all 0.3s ease;
                            height: 52px;">
              <span class="input-group-text bg-transparent border-0 position-absolute"
                style="right: 16px; top: 50%; transform: translateY(-50%); z-index: 10;">
                <i class="mdi mdi-pencil-outline text-muted" style="font-size: 18px;"></i>
              </span>
            </div>

            <div class="mt-3 d-flex align-items-start">
              <i class="mdi mdi-information-outline me-2 mt-1" style="color: #a0aec0; font-size: 16px;"></i>
              <p class="mb-0 text-muted" style="font-size: 0.85rem; line-height: 1.4;">
                El folio será asociado permanentemente al token seleccionado.
                <br>Asegúrate de ingresar el número correctamente.
              </p>
            </div>
          </div>
        </form>
      </div>

      <div class="modal-footer border-0 p-4" style="background: #f8fafc; border-top: 1px solid #edf2f7 !important;">
        <div class="w-100 d-flex gap-3">
          <button type="button" class="btn btn-lg flex-fill" data-bs-dismiss="modal" style="background: white; 
                         border: 2px solid #e2e8f0; 
                         color: #4a5568;
                         font-weight: 500;
                         border-radius: 10px;
                         padding: 12px;
                         transition: all 0.3s ease;">
            <i class="mdi mdi-close me-2"></i>
            Cancelar
          </button>
          <button type="button" id="submit-asignar-folio-btn" class="btn btn-lg flex-fill" style="background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
                         border: none;
                         color: white;
                         font-weight: 500;
                         border-radius: 10px;
                         padding: 12px;
                         box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);
                         transition: all 0.3s ease;">
            <i class="mdi mdi-check-circle-outline me-2"></i>
            <span class="btn-text">Asignar Folio</span>
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- MODAL DE CONFIRMACIÓN PARA RECHAZAR -->
<div class="modal fade" id="rechazarModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Rechazar Folio</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p>¿Estás seguro que deseas rechazar este folio de aduana?</p>
        <form id="formRechazarFolio">
          <input type="hidden" id="rechazar_pedimento_id" name="pedimento_id" value="">
          <div class="mb-3">
            <label for="motivo_rechazo" class="form-label">Motivo del rechazo</label>
            <textarea class="form-control" id="motivo_rechazo" name="motivo_rechazo" rows="3" required></textarea>
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="submit" form="formRechazarFolio" class="btn btn-danger">Rechazar</button>
      </div>
    </div>
  </div>
</div>

<!-- LOADING OVERLAY GLOBAL -->
<div id="global-loading" class="loading-overlay">
  <div class="text-center">
    <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;"></div>
    <p class="mt-2">Procesando...</p>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="/Aaapumac/src/views/assets/js/addfolios.js"></script>