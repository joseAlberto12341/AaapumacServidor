<!-- observacionesFolio.php -->
<div class="container-fluid px-3 py-4">
  <!-- ALERTAS MINIMALISTAS -->
  <?php 
  if (session_status() === PHP_SESSION_NONE) {
      session_start();
  }
  
  if (isset($_SESSION['success_message'])): ?>
    <div class="alert bg-success bg-opacity-10 border-start border-success border-3 alert-dismissible fade show mb-4 border-0" role="alert">
      <div class="d-flex align-items-center">
        <i class="mdi mdi-check-circle text-success me-2"></i>
        <div class="flex-grow-1 small">
          <?php echo htmlspecialchars($_SESSION['success_message'] ?? ''); ?>
        </div>
        <button type="button" class="btn-close btn-close-sm" data-bs-dismiss="alert"></button>
      </div>
    </div>
    <?php unset($_SESSION['success_message']); ?>
  <?php endif; ?>

  <?php if (isset($_SESSION['error_message'])): ?>
    <div class="alert bg-danger bg-opacity-10 border-start border-danger border-3 alert-dismissible fade show mb-4 border-0" role="alert">
      <div class="d-flex align-items-center">
        <i class="mdi mdi-alert-circle text-danger me-2"></i>
        <div class="flex-grow-1 small">
          <?php echo htmlspecialchars($_SESSION['error_message'] ?? ''); ?>
        </div>
        <button type="button" class="btn-close btn-close-sm" data-bs-dismiss="alert"></button>
      </div>
    </div>
    <?php unset($_SESSION['error_message']); ?>
  <?php endif; ?>

  <!-- ENCABEZADO SIMPLIFICADO -->
  <div class="d-flex justify-content-between align-items-center mb-4">
    <div>
      <h2 class="h5 fw-medium text-gray-800 mb-1">
        <i class="<?php echo htmlspecialchars($icon ?? 'mdi mdi-note-text'); ?> me-2 text-muted"></i>
        <?php echo htmlspecialchars($title ?? 'Observaciones'); ?>
      </h2>
      <p class="text-muted small mb-0"><?php echo htmlspecialchars($subtitle ?? ''); ?></p>
    </div>
    <a href="/Aaapumac/Gestion/Folioaduana" class="btn btn-sm btn-outline-gray">
      <i class="mdi mdi-arrow-left me-1"></i>Atrás
  </a>
  </div>

  <?php if (isset($folio_data) && $folio_data): ?>
  <!-- PANEL DE INFORMACIÓN ULTRA MINIMALISTA -->
  <div class="row mb-4 g-3">
    <div class="col-lg-8">
      <div class="border rounded-3 p-3 bg-white">
        <div class="row g-3">
          <div class="col-md-6">
            <div class="mb-3">
              <span class="text-muted small d-block mb-1">Folio</span>
              <span class="fw-medium text-gray-800"><?php echo htmlspecialchars($folio_aduana ?? 'N/A'); ?></span>
            </div>
            <div class="mb-3">
              <span class="text-muted small d-block mb-1">Patente</span>
              <span class="fw-medium text-gray-800"><?php echo htmlspecialchars($folio_data->patente ?? 'N/A'); ?></span>
            </div>
            <div>
              <span class="text-muted small d-block mb-1">Fecha</span>
              <span class="fw-medium text-gray-800">
                <?php 
                if (isset($folio_data->fecha) && !empty($folio_data->fecha) && $folio_data->fecha != '0000-00-00') {
                    echo date('d/m/Y', strtotime($folio_data->fecha));
                } else {
                    echo 'N/A';
                }
                ?>
              </span>
            </div>
          </div>
          <div class="col-md-6 border-start">
            <div class="mb-3">
              <span class="text-muted small d-block mb-1">Nombre</span>
              <span class="fw-medium text-gray-800"><?php echo htmlspecialchars($folio_data->nombre_completo ?? 'N/A'); ?></span>
            </div>
            <div class="mb-3">
              <span class="text-muted small d-block mb-1">Agente aduanal</span>
              <span class="fw-medium text-gray-800"><?php echo htmlspecialchars($folio_data->agente_aduanal ?? 'N/A'); ?></span>
            </div>
            <div>
              <span class="text-muted small d-block mb-1">Razón social</span>
              <span class="fw-medium text-gray-800"><?php echo htmlspecialchars($folio_data->razon_social ?? 'N/A'); ?></span>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-4">
      <div class="border rounded-3 p-3 bg-white text-center">
        <div class="text-muted mb-2">
          <i class="mdi mdi-file-document-outline fs-4"></i>
        </div>
        <div class="h3 fw-bold text-gray-800 mb-1"><?php echo htmlspecialchars($total_pedimentos ?? 0); ?></div>
        <div class="text-muted small">Pedimentos</div>
      </div>
    </div>
  </div>

  <?php if (isset($pedimentos) && !empty($pedimentos)): ?>
  <!-- FORMULARIO MINIMALISTA -->
  <form id="observacionesForm" action="/Aaapumac/Gestion/guardarObservaciones" method="POST">
    <input type="hidden" name="folio_id" value="<?php echo htmlspecialchars($folio_id ?? ''); ?>">
    
    <div class="border rounded-3 bg-white overflow-hidden">
      <div class="p-3 border-bottom bg-light">
        <div class="d-flex justify-content-between align-items-center">
          <h6 class="fw-medium text-gray-800 mb-0">Resultados</h6>
          <div class="d-flex gap-2">
            <button type="reset" class="btn btn-sm btn-outline-gray">
              <i class="mdi mdi-undo me-1"></i>Limpiar
            </button>
            <button type="submit" class="btn btn-sm btn-gray-800">
              <i class="mdi mdi-content-save-outline me-1"></i>Guardar
            </button>
          </div>
        </div>
      </div>
      
      <div class="p-3">
        <div class="table-responsive">
          <table class="table table-borderless align-middle mb-0">
            <thead>
              <tr class="text-muted">
                <th class="fw-normal small text-uppercase pb-2">#</th>
                <th class="fw-normal small text-uppercase pb-2">Pedimento</th>
                <th class="fw-normal small text-uppercase pb-2">Tipo</th>
                <th class="fw-normal small text-uppercase pb-2">Clave</th>
                <th class="fw-normal small text-uppercase pb-2">CR</th>
                <th class="fw-normal small text-uppercase pb-2">Actual</th>
                <th class="fw-normal small text-uppercase pb-2" style="width: 40%;">Nueva</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($pedimentos as $pedimento): ?>
                <tr class="border-top">
                  <td class="text-muted small pt-3"><?php echo htmlspecialchars(($pedimento->index ?? 0) + 1); ?></td>
                  <td class="pt-3">
                    <input type="hidden" name="pedimento_index[]" value="<?php echo htmlspecialchars($pedimento->index ?? 0); ?>">
                    <span class="badge bg-gray-100 text-gray-700 fw-medium px-2 py-1">
                      <?php echo htmlspecialchars($pedimento->pedimento ?? 'N/A'); ?>
                    </span>
                  </td>
                  <td class="text-muted small pt-3"><?php echo htmlspecialchars($pedimento->tipo_operacion ?? 'N/A'); ?></td>
                  <td class="text-muted small pt-3"><?php echo htmlspecialchars($pedimento->clave_pedimento ?? 'N/A'); ?></td>
                  <td class="text-muted small pt-3"><?php echo htmlspecialchars($pedimento->CR ?? 'N/A'); ?></td>
                  <td class="pt-3">
                    <?php if (!empty($pedimento->observaciones)): ?>
                      <div class="observacion-actual bg-gray-50 p-2 rounded-2 border">
                        <small class="text-muted d-block mb-1">
                          <?php 
                          // Decodificar HTML y luego quitar las etiquetas
                          $observacionDecodificada = html_entity_decode($pedimento->observaciones ?? '', ENT_QUOTES | ENT_HTML5, 'UTF-8');
                          // QUITAR TODAS LAS ETIQUETAS HTML
                          $observacionSinTags = strip_tags($observacionDecodificada);
                          // Escapar caracteres especiales
                          $observacionLimpia = htmlspecialchars($observacionSinTags, ENT_QUOTES | ENT_HTML5, 'UTF-8');
                          // Mantener saltos de línea
                          echo nl2br($observacionLimpia);
                          ?>
                        </small>
                        <?php if (!empty($pedimento->observacion_updated_at)): ?>
                          <div class="text-muted extra-small">
                            <i class="mdi mdi-clock-outline me-1" style="font-size: 10px;"></i>
                            <?php 
                            $fecha_obs = $pedimento->observacion_updated_at;
                            if ($fecha_obs && $fecha_obs != '0000-00-00 00:00:00') {
                                echo date('d/m H:i', strtotime($fecha_obs));
                            }
                            ?>
                          </div>
                        <?php endif; ?>
                      </div>
                    <?php else: ?>
                      <span class="badge bg-gray-100 text-muted px-2 py-1">
                        <i class="mdi mdi-note-off-outline me-1" style="font-size: 12px;"></i>
                        Vacío
                      </span>
                    <?php endif; ?>
                  </td>
                  <td class="pt-3">
                    <div>
                      <textarea 
                        class="form-control form-control-sm border-gray-300 observaciones-input" 
                        name="observaciones[]" 
                        rows="2" 
                        placeholder="Escribe aquí..."
                        data-folio-id="<?php echo htmlspecialchars($folio_id ?? ''); ?>"
                        data-pedimento-index="<?php echo htmlspecialchars($pedimento->index ?? 0); ?>"
                        style="resize: none; font-size: 0.875rem;"
                      ><?php 
                        if (!empty($pedimento->observaciones)) {
                            // Para el textarea, decodificar HTML y quitar tags
                            $observacionParaTextarea = html_entity_decode($pedimento->observaciones ?? '', ENT_QUOTES | ENT_HTML5, 'UTF-8');
                            $observacionParaTextarea = strip_tags($observacionParaTextarea);
                            echo htmlspecialchars($observacionParaTextarea, ENT_QUOTES | ENT_HTML5, 'UTF-8');
                        }
                      ?></textarea>
                      <div class="d-flex justify-content-between align-items-center mt-1">
                        <small class="text-muted extra-small">
                          <span class="char-count" id="charCount<?php echo htmlspecialchars($pedimento->index ?? 0); ?>">
                            <?php 
                            if (!empty($pedimento->observaciones)) {
                                // Para el contador, usar texto sin tags
                                $observacionParaContar = html_entity_decode($pedimento->observaciones ?? '', ENT_QUOTES | ENT_HTML5, 'UTF-8');
                                $observacionParaContar = strip_tags($observacionParaContar);
                                echo strlen($observacionParaContar);
                            } else {
                                echo '0';
                            }
                            ?>/500
                          </span>
                        </small>
                        <button type="button" class="btn btn-xs btn-outline-gray btn-guardar-individual" 
                                data-folio-id="<?php echo htmlspecialchars($folio_id ?? ''); ?>"
                                data-pedimento-index="<?php echo htmlspecialchars($pedimento->index ?? 0); ?>">
                          <i class="mdi mdi-check" style="font-size: 12px;"></i>
                        </button>
                      </div>
                    </div>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </form>
  <?php elseif(isset($folio_data) && $folio_data && empty($pedimentos)): ?>
    <div class="border rounded-3 p-4 bg-white text-center">
      <div class="text-muted mb-3">
        <i class="mdi mdi-file-remove-outline fs-2 opacity-50"></i>
      </div>
      <h6 class="text-gray-700 mb-2">Sin pedimentos</h6>
      <p class="text-muted small mb-3">Este folio no contiene pedimentos registrados.</p>
      <button type="button" class="btn btn-sm btn-outline-gray" onclick="window.history.back()">
        <i class="mdi mdi-arrow-left me-1"></i>Volver
      </button>
    </div>
  <?php endif; ?>
  
  <?php else: ?>
    <div class="border rounded-3 p-4 bg-white text-center">
      <div class="text-danger mb-3">
        <i class="mdi mdi-alert-circle-outline fs-2 opacity-75"></i>
      </div>
      <h6 class="text-gray-700 mb-2">Folio no encontrado</h6>
      <p class="text-muted small mb-3">No se encontró la información solicitada.</p>
      <button type="button" class="btn btn-sm btn-outline-gray" onclick="window.history.back()">
        <i class="mdi mdi-arrow-left me-1"></i>Volver
      </button>
    </div>
  <?php endif; ?>
</div>

<!-- MODAL MINIMALISTA -->
<div class="modal fade" id="confirmModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-sm">
    <div class="modal-content border-0 shadow-sm">
      <div class="modal-body p-4">
        <div class="text-center mb-3">
          <div class="text-primary mb-3">
            <i class="mdi mdi-check-circle fs-2"></i>
          </div>
          <h6 class="fw-medium text-gray-800 mb-2">¿Guardar cambios?</h6>
          <p class="text-muted small mb-0">Se guardarán todas las observaciones modificadas.</p>
        </div>
        <div class="d-flex gap-2 justify-content-center">
          <button type="button" class="btn btn-sm btn-outline-gray px-3" data-bs-dismiss="modal">No</button>
          <button type="button" class="btn btn-sm btn-gray-800 px-3" id="confirmSave">Sí</button>
        </div>
      </div>
    </div>
  </div>
</div>

<style>
/* ESTILOS MINIMALISTAS */
:root {
  --gray-50: #f9fafb;
  --gray-100: #918F8F;
  --gray-200: #e5e7eb;
  --gray-300: #d1d5db;
  --gray-400: #9ca3af;
  --gray-500: #6b7280;
  --gray-600: #4b5563;
  --gray-700: #374151;
  --gray-800: #1f2937;
  --gray-900: #111827;
}

.bg-gray-50 { background-color: var(--gray-50) !important; }
.bg-gray-100 { background-color: var(--gray-100) !important; }
.bg-gray-800 { background-color: var(--gray-800) !important; color: white !important; }
.bg-gray-800:hover { background-color: var(--gray-900) !important; }

.text-gray-800 { color: var(--gray-800) !important; }
.border-gray-300 { border-color: var(--gray-300) !important; }

.btn-outline-gray {
  border-color: var(--gray-300);
  color: var(--gray-600);
}
.btn-outline-gray:hover {
  background-color: var(--gray-100);
  border-color: var(--gray-400);
  color: var(--gray-800);
}

.btn-gray-800 {
  background-color: var(--gray-800);
  border-color: var(--gray-800);
  color: white;
}
.btn-gray-800:hover {
  background-color: var(--gray-900);
  border-color: var(--gray-900);
}

.btn-sm { padding: 0.25rem 0.75rem; font-size: 0.875rem; }
.btn-xs { padding: 0.125rem 0.5rem; font-size: 0.75rem; }

.extra-small { font-size: 0.75rem; }

.table-borderless > :not(caption) > * > * {
  border: none;
  padding: 0.5rem 0.75rem;
}

.table thead th {
  font-weight: 400;
  letter-spacing: 0.3px;
  border-bottom: 1px solid var(--gray-200);
}

.observaciones-input {
  border: 1px solid var(--gray-300);
  border-radius: 0.375rem;
  transition: all 0.15s ease;
  font-size: 0.875rem;
  padding: 0.375rem 0.5rem;
}

.observaciones-input:focus {
  border-color: var(--gray-400);
  box-shadow: 0 0 0 2px rgba(156, 163, 175, 0.1);
  outline: none;
}

.badge {
  font-weight: 500;
  letter-spacing: 0.3px;
}

/* ANIMACIONES SUAVES */
.fade-in {
  animation: fadeIn 0.2s ease;
}

@keyframes fadeIn {
  from { opacity: 0; transform: translateY(2px); }
  to { opacity: 1; transform: translateY(0); }
}

/* SCROLLBAR MINIMALISTA */
::-webkit-scrollbar {
  width: 6px;
  height: 6px;
}

::-webkit-scrollbar-track {
  background: var(--gray-100);
}

::-webkit-scrollbar-thumb {
  background: var(--gray-300);
  border-radius: 3px;
}

::-webkit-scrollbar-thumb:hover {
  background: var(--gray-400);
}
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
  // Contador de caracteres minimalista
  $('.observaciones-input').each(function() {
    const index = $(this).data('pedimento-index');
    updateCharCount(this, index);
    
    $(this).on('input', function() {
      const idx = $(this).data('pedimento-index');
      updateCharCount(this, idx);
      $(this).closest('tr').addClass('fade-in');
    });
  });
  
  function updateCharCount(textarea, index) {
    const currentLength = textarea.value.length;
    const maxLength = 500;
    const charCount = $('#charCount' + index);
    
    charCount.text(currentLength + '/' + maxLength);
    
    if (currentLength > maxLength) {
      charCount.addClass('text-danger');
      textarea.value = textarea.value.substring(0, maxLength);
      $(textarea).addClass('border-danger');
    } else if (currentLength > (maxLength * 0.9)) {
      charCount.removeClass('text-danger').addClass('text-warning');
      $(textarea).removeClass('border-danger');
    } else {
      charCount.removeClass('text-danger text-warning').addClass('text-muted');
      $(textarea).removeClass('border-danger');
    }
  }
  
  // Función para quitar tags HTML (simplificada)
  function stripHtmlTags(text) {
    return text.replace(/<[^>]*>/g, '');
  }
  
  // Guardado individual minimalista
  $('.btn-guardar-individual').click(function() {
    const btn = $(this);
    const folioId = btn.data('folio-id');
    const pedimentoIndex = btn.data('pedimento-index');
    const textarea = btn.closest('td').find('textarea');
    let observacion = textarea.val().trim();
    
    // Quitar tags HTML antes de enviar
    observacion = stripHtmlTags(observacion);
    
    if (!observacion) {
      // Notificación minimalista
      const toast = $(`
        <div class="position-fixed top-3 end-3 p-2 bg-gray-800 text-white rounded-2 shadow-sm small fade-in" style="z-index: 1060; max-width: 200px;">
          <div class="d-flex align-items-center">
            <i class="mdi mdi-information me-2"></i>
            <span>Escribe algo primero</span>
          </div>
        </div>
      `);
      $('body').append(toast);
      setTimeout(() => toast.remove(), 2000);
      return;
    }
    
    // Mostrar estado de carga
    const originalHtml = btn.html();
    btn.html('<span class="spinner-border spinner-border-sm"></span>');
    btn.prop('disabled', true);
    
    // Enviar por AJAX
    $.ajax({
      url: '/Aaapumac/Gestion/guardarObservacionIndividualJson',
      type: 'POST',
      data: {
        folio_id: folioId,
        pedimento_index: pedimentoIndex,
        observacion: observacion
      },
      success: function(response) {
        if (response.success) {
          // Actualizar observación actual
          const currentObsDiv = btn.closest('tr').find('.observacion-actual');
          
          // Escapar HTML para mostrar como texto plano
          const observacionSegura = observacion
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/\n/g, '<br>');
          
          const newContent = `
            <small class="text-muted d-block mb-1">
              ${observacionSegura}
            </small>
            <div class="text-muted extra-small">
              <i class="mdi mdi-clock-outline me-1" style="font-size: 10px;"></i>
              Ahora
            </div>
          `;
          
          if (currentObsDiv.length) {
            currentObsDiv.html(newContent).addClass('fade-in');
          } else {
            btn.closest('tr').find('td:nth-child(6)').html(`
              <div class="observacion-actual bg-gray-50 p-2 rounded-2 border fade-in">
                ${newContent}
              </div>
            `);
          }
          
          // Actualizar contador
          $('#charCount' + pedimentoIndex).text(observacion.length + '/500');
          
          // Notificación de éxito minimalista
          const toast = $(`
            <div class="position-fixed top-3 end-3 p-2 bg-gray-800 text-white rounded-2 shadow-sm small fade-in" style="z-index: 1060; max-width: 200px;">
              <div class="d-flex align-items-center">
                <i class="mdi mdi-check-circle me-2"></i>
                <span>Guardado</span>
              </div>
            </div>
          `);
          $('body').append(toast);
          setTimeout(() => toast.remove(), 1500);
        }
      },
      error: function() {
        const toast = $(`
          <div class="position-fixed top-3 end-3 p-2 bg-danger text-white rounded-2 shadow-sm small fade-in" style="z-index: 1060; max-width: 200px;">
            <div class="d-flex align-items-center">
              <i class="mdi mdi-alert-circle me-2"></i>
              <span>Error de conexión</span>
            </div>
          </div>
        `);
        $('body').append(toast);
        setTimeout(() => toast.remove(), 2000);
      },
      complete: function() {
        btn.html('<i class="mdi mdi-check" style="font-size: 12px;"></i>');
        setTimeout(() => btn.prop('disabled', false), 500);
      }
    });
  });
  
  // Validación del formulario principal
  $('#observacionesForm').on('submit', function(e) {
    e.preventDefault();
    
    let changedCount = 0;
    $('textarea[name="observaciones[]"]').each(function() {
      const originalValue = $(this).data('original-value') || '';
      const currentValue = stripHtmlTags($(this).val().trim());
      if (currentValue !== originalValue.trim()) {
        changedCount++;
      }
    });
    
    if (!changedCount) {
      const toast = $(`
        <div class="position-fixed top-3 end-3 p-2 bg-gray-800 text-white rounded-2 shadow-sm small fade-in" style="z-index: 1060; max-width: 200px;">
          <div class="d-flex align-items-center">
            <i class="mdi mdi-information me-2"></i>
            <span>Sin cambios</span>
          </div>
        </div>
      `);
      $('body').append(toast);
      setTimeout(() => toast.remove(), 2000);
      return;
    }
    
    $('.modal-body p').text(`${changedCount} observación(es) modificada(s)`);
    $('#confirmModal').modal('show');
  });
  
  // Confirmar guardado
  $('#confirmSave').click(function() {
    const saveBtn = $(this);
    saveBtn.html('<span class="spinner-border spinner-border-sm me-1"></span>');
    saveBtn.prop('disabled', true);
    
    $('#confirmModal').modal('hide');
    $('#observacionesForm')[0].submit();
  });
  
  // Guardar valores originales (sin tags HTML)
  $('textarea[name="observaciones[]"]').each(function() {
    const currentValue = $(this).val();
    const cleanValue = stripHtmlTags(currentValue);
    $(this).data('original-value', cleanValue);
  });
  
  // Reset minimalista
  $('#observacionesForm button[type="reset"]').click(function() {
    $('textarea[name="observaciones[]"]').each(function() {
      const originalValue = $(this).data('original-value') || '';
      $(this).val(originalValue);
      const index = $(this).data('pedimento-index');
      updateCharCount(this, index);
    });
    
    const toast = $(`
      <div class="position-fixed top-3 end-3 p-2 bg-gray-800 text-white rounded-2 shadow-sm small fade-in" style="z-index: 1060; max-width: 200px;">
        <div class="d-flex align-items-center">
          <i class="mdi mdi-check me-2"></i>
          <span>Cambios limpiados</span>
        </div>
      </div>
    `);
    $('body').append(toast);
    setTimeout(() => toast.remove(), 1500);
  });
});
</script>