<?php

$title = $title ?? 'Seguimiento de Pedimentos';
$subtitle = $subtitle ?? 'Monitorea el estado de tus pedimentos en tiempo real';
$folio_buscado = $folio_buscado ?? '';
$token_buscado = $token_buscado ?? '';
$encontrado = $encontrado ?? false;
$mensaje_error = $mensaje_error ?? '';
$folio_info = $folio_info ?? null;
$pedimentos = $pedimentos ?? [];
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1><?= htmlspecialchars($title) ?></h1>
            <p class="text-muted"><?= htmlspecialchars($subtitle) ?></p>
            
            <!-- Filtro de búsqueda -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-search me-2"></i>Buscar Seguimiento
                    </h5>
                </div>
                <div class="card-body">
                    <form action="" method="get" id="formBuscarSeguimiento" class="row g-3">
                        <input type="hidden" name="action" value="seguimiento">
                        
                        <div class="col-md-6">
                            <label for="folio" class="form-label">
                                <i class="fas fa-file-alt me-2"></i>Folio
                            </label>
                            <input type="text" 
                                   class="form-control form-control-lg" 
                                   id="folio" 
                                   name="folio" 
                                   value="<?= htmlspecialchars($folio_buscado) ?>"
                                   placeholder="Ingrese el folio del pedimento">
                        </div>
                        
                        <div class="col-md-6">
                            <label for="token" class="form-label">
                                <i class="fas fa-key me-2"></i>Token
                            </label>
                            <input type="text" 
                                   class="form-control form-control-lg" 
                                   id="token" 
                                   name="token" 
                                   value="<?= htmlspecialchars($token_buscado) ?>"
                                   placeholder="Ingrese el token del pedimento">
                        </div>
                        
                        <div class="col-12">
                            <div class="d-flex align-items-center mt-3">
                                <button type="submit" class="btn btn-primary btn-lg me-3">
                                    <i class="fas fa-search me-2"></i>Buscar Seguimiento
                                </button>
                                <button type="button" class="btn btn-outline-secondary" onclick="limpiarBusqueda()">
                                    <i class="fas fa-times me-2"></i>Limpiar
                                </button>
                                <div class="ms-auto text-muted">
                                    <small><i class="fas fa-info-circle me-1"></i> Ingrese folio O token</small>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            
            <?php if (!empty($folio_buscado) || !empty($token_buscado)): ?>
                
                <?php if ($encontrado && isset($folio_info)): ?>
                    <!-- Información del folio -->
                    <div class="card mb-4 border-success">
                        <div class="card-header bg-success text-white">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-check-circle me-2"></i>Información del Pedimento
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <div class="info-box">
                                        <label class="text-muted small mb-1">Folio</label>
                                        <div class="fw-bold h5"><?= htmlspecialchars($folio_info->folio ?? '') ?></div>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="info-box">
                                        <label class="text-muted small mb-1">Token</label>
                                        <div class="fw-bold h5"><?= htmlspecialchars($folio_info->Token ?? '') ?></div>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="info-box">
                                        <label class="text-muted small mb-1">Folio Aduana</label>
                                        <div class="fw-bold h5">
                                            <span class="badge bg-info fs-6"><?= htmlspecialchars($folio_info->folios_aduana ?? '') ?></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <div class="info-box">
                                        <label class="text-muted small mb-1">Estatus</label>
                                        <div>
                                            <?php 
                                            $estatus_color = [
                                                '1' => 'warning',
                                                '2' => 'primary',
                                                '3' => 'danger',
                                                '4' => 'success'
                                            ];
                                            $estatus_text = [
                                                '1' => 'Pendiente',
                                                '2' => 'En Aduana',
                                                '3' => 'Rechazado',
                                                '4' => 'Completado'
                                            ];
                                            $estatus = $folio_info->Estatus ?? '';
                                            $color = $estatus_color[$estatus] ?? 'secondary';
                                            $texto = $estatus_text[$estatus] ?? 'Desconocido';
                                            ?>
                                            <span class="badge bg-<?= $color ?> fs-6"><?= $texto ?></span>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="col-md-4 mb-3">
                                    <label class="text-muted small mb-1">Agente Aduanal</label>
                                    <div class="fw-bold"><?= htmlspecialchars($folio_info->agente_aduanal ?? '') ?></div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="text-muted small mb-1">Cliente</label>
                                    <div class="fw-bold"><?= htmlspecialchars($folio_info->nombre_completo ?? '') ?></div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="text-muted small mb-1">Fecha de Creación</label>
                                    <div class="fw-bold"><?= htmlspecialchars($folio_info->fecha ?? '') ?> <?= htmlspecialchars($folio_info->Hora ?? '') ?></div>
                                </div>
                                
                                <div class="col-md-4 mb-3">
                                    <label class="text-muted small mb-1">Patente</label>
                                    <div class="fw-bold"><?= htmlspecialchars($folio_info->patente ?? '') ?></div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="text-muted small mb-1">Razón Social</label>
                                    <div class="fw-bold"><?= htmlspecialchars($folio_info->razon_social ?? '') ?></div>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label class="text-muted small mb-1">Agencia Aduanal</label>
                                    <div class="fw-bold"><?= htmlspecialchars($folio_info->agencia_aduanal ?? '') ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Tabla de pedimentos -->
                    <div class="card">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-list me-2"></i>Pedimentos Registrados
                                <span class="badge bg-secondary ms-2"><?= count($pedimentos ?? []) ?> total</span>
                            </h5>
                        </div>
                        <div class="card-body p-0">
                            <?php if (!empty($pedimentos)): ?>
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th>Pedimento</th>
                                                <th>Tipo Operación</th>
                                                <th>Clave Pedimento</th>
                                                <th class="text-center">CR</th>
                                                <th>Resultado</th>
                                                <th class="text-center">Última Actualización</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($pedimentos as $index => $pedimento): ?>
                                                <tr>
                                                    <td class="text-center">
                                                        <span class="badge bg-dark"><?= $index + 1 ?></span>
                                                    </td>
                                                    <td>
                                                        <div class="fw-bold"><?= htmlspecialchars($pedimento['pedimento'] ?? 'N/A') ?></div>
                                                    </td>
                                                    <td>
                                                        <span class="badge bg-info">
                                                            <?= htmlspecialchars($pedimento['tipo_operacion'] ?? 'No especificado') ?>
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <code><?= htmlspecialchars($pedimento['clave_pedimento'] ?? '') ?></code>
                                                    </td>
                                                    <td class="text-center">
                                                        <?php if (!empty($pedimento['cr'])): ?>
                                                            <span class="badge bg-success"><?= htmlspecialchars($pedimento['cr']) ?></span>
                                                        <?php else: ?>
                                                            <span class="text-muted">-</span>
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <div class="observaciones-container">
                                                            <?php if (!empty($pedimento['observaciones'])): ?>
                                                                <div class="alert  border mb-0 py-2 px-3">
                                                                    <div class="observacion-texto">
                                                                        <?= nl2br(strip_tags($pedimento['observaciones'])) ?>
                                                                    </div>
                                                                </div>
                                                            <?php else: ?>
                                                                <div class="text-muted fst-italic">
                                                                    Sin observaciones
                                                                </div>
                                                            <?php endif; ?>
                                                        </div>
                                                    </td>
                                                    <td class="text-center">
                                                        <small class="text-muted">
                                                            <?php if (!empty($pedimento['observacion_updated_at'])): ?>
                                                                <?= date('d/m/Y H:i', strtotime($pedimento['observacion_updated_at'])) ?>
                                                            <?php else: ?>
                                                                <span class="text-muted">No actualizado</span>
                                                            <?php endif; ?>
                                                        </small>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php else: ?>
                                <div class="text-center py-5">
                                    <div class="mb-3">
                                        <i class="fas fa-clipboard-list fa-3x text-muted"></i>
                                    </div>
                                    <h5 class="text-muted">No hay pedimentos registrados</h5>
                                    <p class="text-muted">Este folio no contiene pedimentos</p>
                                </div>
                            <?php endif; ?>
                        </div>
                        <?php if (!empty($pedimentos)): ?>
                            <div class="card-footer text-muted">
                                <div class="row">
                                    <div class="col-md-6">
                                        <small>
                                            <i class="fas fa-info-circle me-1"></i>
                                            Total de pedimentos: <strong><?= count($pedimentos) ?></strong>
                                        </small>
                                    </div>
                                    <div class="col-md-6 text-end">
                                        <small>
                                            <i class="fas fa-clock me-1"></i>
                                            Última actualización: <?= date('d/m/Y H:i', strtotime($folio_info->updated_at ?? 'now')) ?>
                                        </small>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                <?php else: ?>
                    <!-- No encontrado -->
                    <div class="card border-warning">
                        <div class="card-header bg-warning text-dark">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-exclamation-triangle me-2"></i>Resultado de la búsqueda
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="text-center py-4">
                                <div class="mb-3">
                                    <i class="fas fa-search fa-3x text-warning"></i>
                                </div>
                                <h4 class="text-warning mb-3">No se encontraron resultados</h4>
                                <p class="text-muted mb-4"><?= htmlspecialchars($mensaje_error ?? 'No se encontró ningún registro con los datos proporcionados') ?></p>
                                <div class="alert alert-info">
                                    <h6 class="alert-heading mb-2">
                                        <i class="fas fa-lightbulb me-2"></i>Sugerencias:
                                    </h6>
                                    <ul class="mb-0">
                                        <li>Verifica que el folio o token sean correctos</li>
                                        <li>Asegúrate de que el folio tenga un folio de aduana asignado</li>
                                        <li>Intenta buscar solo con uno de los campos (folio O token)</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                
            <?php else: ?>
                <!-- Instrucciones iniciales -->
                <div class="card border-info">
                    <div class="card-header bg-info text-white">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-info-circle me-2"></i>Instrucciones
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-8">
                                <h5>¿Cómo consultar el seguimiento?</h5>
                                <p>Para consultar el estado de tus pedimentos, sigue estos pasos:</p>
                                <ol>
                                    <li><strong>Ingresa el folio O el token</strong> en los campos correspondientes</li>
                                    <li>Haz clic en <strong>"Buscar Seguimiento"</strong></li>
                                    <li>Se mostrará la información completa del pedimento</li>
                                </ol>
                                <div class="alert  border mt-3">
                                    <h6 class="alert-heading">
                                        <i class="fas fa-exclamation-circle me-2 text-primary"></i>Nota importante
                                    </h6>
                                    <p class="mb-0">
                                        Solo se mostrarán los pedimentos que ya tengan un <strong>folio de aduana asignado</strong>. 
                                        Si no encuentras un pedimento, verifica con el administrador o espera a que se le asigne.
                                    </p>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card bg-light">
                                    <div class="card-body text-center">
                                        <h6>¿Dónde encontrar el folio/token?</h6>
                                        <p class="small text-muted">
                                            El folio se propociona al momento de que se crea el pedimento en el sistema.
                                            El token es un código único asociado a tu pedimento para seguimiento seguro.
                                            El cual puedes encontrar en la seccion de notificaciones
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Ejemplos de uso -->
                <div class="row mt-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title">
                                    <i class="fas fa-file-alt me-2 text-primary"></i>Búsqueda por Folio
                                </h6>
                                <p class="card-text small">
                                    Ejemplo: <code>FOL-2023-001</code> o <code>20231215-001</code>
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                                <h6 class="card-title">
                                    <i class="fas fa-key me-2 text-success"></i>Búsqueda por Token
                                </h6>
                                <p class="card-text small">
                                    Ejemplo: <code>AE234</code>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<script>
// Limpiar búsqueda
function limpiarBusqueda() {
    window.location.href = '?action=seguimiento';
}

// Auto-focus en el primer campo
document.addEventListener('DOMContentLoaded', function() {
    const folioInput = document.getElementById('folio');
    const tokenInput = document.getElementById('token');
    
    // Si ambos están vacíos, enfocar el campo de folio
    if (!folioInput.value && !tokenInput.value) {
        folioInput.focus();
    }
});

// Validación simple del formulario
document.getElementById('formBuscarSeguimiento').addEventListener('submit', function(e) {
    const folio = document.getElementById('folio').value.trim();
    const token = document.getElementById('token').value.trim();
    
    if (!folio && !token) {
        e.preventDefault();
        alert('Por favor, ingrese al menos un folio o token para buscar');
        document.getElementById('folio').focus();
        return false;
    }
    
    // Si ambos están llenos, usar solo uno (prioridad a folio)
    if (folio && token) {
        document.getElementById('token').value = '';
    }
});
</script>

<style>
.container-fluid {
    padding: 20px;
}

.card {
    border-radius: 10px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    margin-bottom: 20px;
}

.card-header {
    border-radius: 10px 10px 0 0 !important;
    padding: 15px 20px;
}

.info-box {
    padding: 10px;
    border-radius: 8px;
    background-color: #f8f9fa;
    border-left: 4px solid #0d6efd;
}

.table th {
    background-color: #f8f9fa;
    font-weight: 600;
    border-bottom: 2px solid #dee2e6;
    padding: 15px 12px;
}

.table td {
    padding: 15px 12px;
    vertical-align: middle;
}

.observaciones-container {
    max-width: 400px;
    min-width: 300px;
}

.observacion-texto {
    font-size: 0.9rem;
    line-height: 1.5;
}

.badge {
    font-weight: 500;
    padding: 5px 10px;
    border-radius: 6px;
}

.btn-lg {
    padding: 12px 24px;
    font-weight: 500;
}

.form-control-lg {
    padding: 12px 16px;
    font-size: 1rem;
}

.text-muted small {
    font-size: 0.85rem;
}

@media (max-width: 768px) {
    .table-responsive {
        font-size: 0.9rem;
    }
    
    .card-body {
        padding: 15px;
    }
    
    .btn-lg {
        width: 100%;
        margin-bottom: 10px;
    }
    
    .observaciones-container {
        max-width: 100%;
        min-width: auto;
    }
}
</style>