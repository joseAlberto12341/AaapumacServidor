
<div class="content-wrapper">
  <div class="row">
    <div class="col-12 grid-margin">
      <div class="card">
        <div class="card-body">
          <div class="container" style="text-align: right;">
            <a><img src="/Aaapumac/src/views/assets/img/aaapumac.png" alt="Logo"></a>
          </div>
          <h4 class="card-title">Mi Perfil</h4>
          <p class="card-description">
            Información Personal
          </p>
          
          <?php if (isset($informacionExistente) && is_object($informacionExistente)): ?>
            <!-- SI HAY INFORMACIÓN -->
            <div class="row">
              <div class="col-md-6"> 
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Nombre completo:</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" 
                           value="<?= htmlspecialchars($informacionExistente->getNombreCompleto() ?? $informacionExistente->nombre_completo ?? 'No especificado') ?>" 
                           readonly />
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Patente:</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" 
                           value="<?= htmlspecialchars($informacionExistente->getPatente() ?? $informacionExistente->patente ?? 'No especificado') ?>" 
                           readonly />
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Agencia aduanal:</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" 
                           value="<?= htmlspecialchars($informacionExistente->getAgenciaAduanal() ?? $informacionExistente->agencia_aduanal ?? 'No especificado') ?>" 
                           readonly />
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Razón social:</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" 
                           value="<?= htmlspecialchars($informacionExistente->getRazonSocial() ?? $informacionExistente->razon_social ?? 'No especificado') ?>" 
                           readonly />
                  </div>
                </div>
              </div>
            </div>

            <!-- MÁS CAMPOS -->
            <div class="row">
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Agente aduanal:</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" 
                           value="<?= htmlspecialchars($informacionExistente->getAgenteAduanal() ?? $informacionExistente->agente_aduanal ?? 'No especificado') ?>" 
                           readonly />
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Teléfono:</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" 
                           value="<?= htmlspecialchars($informacionExistente->getTelefono() ?? $informacionExistente->telefono ?? 'No especificado') ?>" 
                           readonly />
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Correo electrónico:</label>
                  <div class="col-sm-9">
                    <input type="email" class="form-control" 
                           value="<?= htmlspecialchars($informacionExistente->getCorreoElectronico() ?? $informacionExistente->correo_electronico ?? 'No especificado') ?>" 
                           readonly />
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Fecha:</label>
                  <div class="col-sm-9">
                    <?php
                      $fechaRaw = $informacionExistente->getFecha() ?? $informacionExistente->fecha ?? null;
                      $fechaFormateada = 'No especificado';
                      if ($fechaRaw && $fechaRaw !== 'No especificado') {
                          $timestamp = strtotime($fechaRaw);
                          $fechaFormateada = date('d/m/Y', $timestamp);
                      }
                    ?>
                    <input type="text" class="form-control" 
                           value="<?= htmlspecialchars($fechaFormateada) ?>" 
                           readonly />
                  </div>
                </div>
              </div>
            </div>

          <?php else: ?>
            <!-- NO HAY INFORMACIÓN -->
            <div class="alert alert-warning">
              <i class="mdi mdi-alert-circle me-2"></i>
              No tienes información general registrada.
              <br>
              <small>Contacta al administrador para completar tu información.</small>
            </div>
            
            <!-- Mostrar al menos la información básica del usuario -->
            <?php if (isset($usuarioInfo) && is_object($usuarioInfo)): ?>
            <div class="row">
              <div class="col-md-6"> 
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Usuario:</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" 
                           value="<?= htmlspecialchars($usuarioInfo->getUsername() ?? $usuarioInfo->username ?? 'No especificado') ?>" 
                           readonly />
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Email:</label>
                  <div class="col-sm-9">
                    <input type="email" class="form-control" 
                           value="<?= htmlspecialchars($usuarioInfo->getEmail() ?? $usuarioInfo->email ?? 'No especificado') ?>" 
                           readonly />
                  </div>
                </div>
              </div>
            </div>
            <?php endif; ?>
            
          <?php endif; ?>
            
            <?php if (isset($informacionExistente) && is_object($informacionExistente)): ?>
              <a href="/Aaapumac/asociadoCoordinador/informacionGeneral?id=<?= $user_id ?>" class="btn btn-warning">
                <i class="mdi mdi-pencil me-1"></i> Editar Información
              </a>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>