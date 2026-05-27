<div class="row justify-content-center">
    <div class="col-12 col-md-8 col-lg-6 col-xl-5">
        <div class="card shadow-sm border-0 rounded-4 mt-4 mb-4">
            <div class="card-header bg-white border-bottom-0 rounded-top-4">
                <div class="d-flex align-items-center">
                    <i class="mdi mdi-account-eye me-2 fs-3 text-primary"></i>
                    <div>
                        <h5 class="mb-0 fw-semibold">Información del Asociado</h5>
                        <small class="text-muted">User ID: <?= $user_id ?? 'No definido' ?></small>
                    </div>
                </div>
            </div>
            <div class="card-body bg-white">
                <?php if (isset($informacionExistente) && is_object($informacionExistente)): ?>
                    <ul class="list-group list-group-flush text-start ps-0">
                        <li class="list-group-item border-0 px-0 pb-2">
                            <div class="fw-bold text-dark mb-1">Nombre completo</div>
                            <div class="text-muted small"><?= htmlspecialchars($informacionExistente->getNombreCompleto() ?? $informacionExistente->nombre_completo ?? 'No especificado') ?></div>
                        </li>
                        <li class="list-group-item border-0 px-0 pb-2">
                            <div class="fw-bold text-dark mb-1">Correo electrónico</div>
                            <div class="text-muted small"><?= htmlspecialchars($informacionExistente->getCorreoElectronico() ?? $informacionExistente->correo_electronico ?? 'No especificado') ?></div>
                        </li>
                        <li class="list-group-item border-0 px-0 pb-2">
                            <div class="fw-bold text-dark mb-1">Teléfono</div>
                            <div class="text-muted small"><?= htmlspecialchars($informacionExistente->getTelefono() ?? $informacionExistente->telefono ?? 'No especificado') ?></div>
                        </li>
                        <li class="list-group-item border-0 px-0 pb-2">
                            <div class="fw-bold text-dark mb-1">Agencia aduanal</div>
                            <div class="text-muted small"><?= htmlspecialchars($informacionExistente->getAgenciaAduanal() ?? $informacionExistente->agencia_aduanal ?? 'No especificado') ?></div>
                        </li>
                        <li class="list-group-item border-0 px-0 pb-2">
                            <div class="fw-bold text-dark mb-1">Patente</div>
                            <div class="text-muted small"><?= htmlspecialchars($informacionExistente->getPatente() ?? $informacionExistente->patente ?? 'No especificado') ?></div>
                        </li>
                        <li class="list-group-item border-0 px-0 pb-2">
                            <div class="fw-bold text-dark mb-1">Razón social</div>
                            <div class="text-muted small"><?= htmlspecialchars($informacionExistente->getRazonSocial() ?? $informacionExistente->razon_social ?? 'No especificado') ?></div>
                        </li>
                        <li class="list-group-item border-0 px-0 pb-2">
                            <div class="fw-bold text-dark mb-1">Agente aduanal</div>
                            <div class="text-muted small"><?= htmlspecialchars($informacionExistente->getAgenteAduanal() ?? $informacionExistente->agente_aduanal ?? 'No especificado') ?></div>
                        </li>
                        <li class="list-group-item border-0 px-0">
                            <div class="fw-bold text-dark mb-1">Fecha de alta</div>
                            <div class="text-muted small"><?= htmlspecialchars($informacionExistente->getFecha() ?? $informacionExistente->fecha ?? 'No especificado') ?></div>
                        </li>
                    </ul>
                <?php else: ?>
                    <div class="alert alert-warning my-4 text-start">
                        <i class="mdi mdi-alert-circle me-2"></i>
                        No hay información general registrada para este asociado.
                        <small class="d-block mt-1">
                            User ID: <?= $user_id ?? 'No definido' ?>
                        </small>
                    </div>
                <?php endif; ?>
            </div>
            <div class="card-footer bg-white border-0 rounded-bottom-4 text-end">
                <a href="/Aaapumac/asociadoCoordinador/listadoPersonal" class="btn btn-light border">
                    <i class="mdi mdi-arrow-left me-1"></i> Volver al Listado
                </a>
            </div>
        </div>
    </div>
</div>