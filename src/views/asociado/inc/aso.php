<div class="content-wrapper">
  <div class="row">
    <div class="col-12 grid-margin">
      <div class="card">
        <div class="card-body">
          <div class="container" style="text-align: right;">
            <a><img src="/Aaapumac/src/views/assets/img/aaapumac.png" alt="Logo"></a>
          </div>
          
          <?php if (isset($informacionExistente) && is_object($informacionExistente) && $informacionExistente->exists()): ?>
            <!-- SI HAY INFORMACIÓN GENERAL -->
            <div class="alert alert-success">
              <i class="mdi mdi-check-circle me-2"></i>
              Información general encontrada y cargada correctamente.
            </div>
            
            <h4>Datos de Información General:</h4>
            <div class="row">
              <div class="col-md-6"> 
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Nombre completo:</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" 
                           value="<?= htmlspecialchars($informacionExistente->getNombreCompleto()) ?>" 
                           readonly />
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Patente:</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" 
                           value="<?= htmlspecialchars($informacionExistente->getPatente()) ?>" 
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
                           value="<?= htmlspecialchars($informacionExistente->getAgenciaAduanal()) ?>" 
                           readonly />
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Razón social:</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" 
                           value="<?= htmlspecialchars($informacionExistente->getRazonSocial()) ?>" 
                           readonly />
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Agente aduanal:</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" 
                           value="<?= htmlspecialchars($informacionExistente->getAgenteAduanal()) ?>" 
                           readonly />
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Teléfono:</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" 
                           value="<?= htmlspecialchars($informacionExistente->getTelefono()) ?>" 
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
                           value="<?= htmlspecialchars($informacionExistente->getCorreoElectronico()) ?>" 
                           readonly />
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Fecha:</label>
                  <div class="col-sm-9">
                    <?php
                      $fechaRaw = $informacionExistente->getFecha();
                      $fechaFormateada = 'No especificado';
                      if ($fechaRaw) {
                          $timestamp = strtotime($fechaRaw);
                          $fechaFormateada = $timestamp ? date('d/m/Y', $timestamp) : $fechaRaw;
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
            <!-- NO HAY INFORMACIÓN GENERAL -->
            <div class="alert alert-warning">
              <i class="mdi mdi-alert-circle me-2"></i>
              No tienes información general registrada en la base de datos.
              <br>
              <small>Contacta al administrador para completar tu información.</small>
            </div>
                
            <!-- Mostrar información básica del usuario -->
            <?php if (isset($usuarioInfo) && is_object($usuarioInfo)): ?>
            <h4>Datos Básicos del Usuario:</h4>
            <div class="row">
              <div class="col-md-6"> 
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Usuario:</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" 
                           value="<?= htmlspecialchars($usuarioInfo->getUsername()) ?>" 
                           readonly />
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Email:</label>
                  <div class="col-sm-9">
                    <input type="email" class="form-control" 
                           value="<?= htmlspecialchars($usuarioInfo->getEmail()) ?>" 
                           readonly />
                  </div>
                </div>
              </div>
            </div>
            <?php endif; ?>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>