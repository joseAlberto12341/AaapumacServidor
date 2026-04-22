<a href="/Aaapumac/asociadoCoordinador/listadoPersonal">Regresar</a>
<br></br>
<div class="content-wrapper">
  <div class="row">
    <div class="col-12 grid-margin">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title"><?php echo $answer['data']['title']; ?></h4>
          
          <!-- MOSTRAR MENSAJES DE ERROR/ÉXITO -->
          <?php if (isset($_SESSION['error_message'])): ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
              <i class="mdi mdi-alert-circle-outline"></i>
              <?php echo $_SESSION['error_message']; ?>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['error_message']); ?>
          <?php endif; ?>

          <?php if (isset($_SESSION['success_message'])): ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              <i class="mdi mdi-check-circle-outline"></i>
              <?php echo $_SESSION['success_message']; ?>
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            <?php unset($_SESSION['success_message']); ?>
          <?php endif; ?>

          <form method="post" id="informacionGeneral" enctype="multipart/form-data"
            action="/Aaapumac/asociadoCoordinador/informacionGeneral">
            
            <!-- CAMPO OCULTO CON EL USER_ID - ¡ESENCIAL! -->
            <input type="hidden" name="user_id" value="<?php echo $answer['user_id']; ?>">
            
            <p class="card-description">
              <?php echo $answer['data']['subtitle']; ?>
            </p>
            
            <!-- CARGAR DATOS EXISTENTES SI HAY -->
            <?php 
            $infoExistente = $answer['informacionExistente'] ?? null;
            $patente = $infoExistente ? $infoExistente->getPatente() : '';
            $agente_aduanal = $infoExistente ? $infoExistente->getAgenteAduanal() : '';
            $razon_social = $infoExistente ? $infoExistente->getRazonSocial() : '';
            $telefono = $infoExistente ? $infoExistente->getTelefono() : '';
            $nombre_completo = $infoExistente ? $infoExistente->getNombreCompleto() : '';
            $correo_electronico = $infoExistente ? $infoExistente->getCorreoElectronico() : '';
            $agencia_aduanal = $infoExistente ? $infoExistente->getAgenciaAduanal() : '';
            $fecha = $infoExistente ? $infoExistente->getFecha() : '';
            ?>

            <div class="row">
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Patente</label>
                  <div class="col-sm-9">
                    <!-- CORREGIDO: type="text" en lugar de type="number" -->
                    <input type="text" class="form-control" name="patente" id="patente"
                      placeholder="Número de Patente" value="<?php echo htmlspecialchars($patente); ?>" required />
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Agente aduanal</label>
                  <div class="col-sm-9">
                    <input type="text" class="form-control" name="agente_aduanal" id="agente_aduanal"
                      placeholder="Agente Aduanal" value="<?php echo htmlspecialchars($agente_aduanal); ?>" required />
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Razon social</label>
                  <div class="col-sm-9">
                    <input class="form-control" type="text" name="razon_social" id="razon_social"
                      placeholder="Razón Social" value="<?php echo htmlspecialchars($razon_social); ?>" required />
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Telefono</label>
                  <div class="col-sm-9">
                    <input class="form-control" type="tel" name="telefono" id="telefono"
                      placeholder="Teléfono" value="<?php echo htmlspecialchars($telefono); ?>" required />
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Nombre completo</label>
                  <div class="col-sm-9">
                    <input type="text" name="nombre_completo" id="nombre_completo" class="form-control"
                      placeholder="Nombre completo" value="<?php echo htmlspecialchars($nombre_completo); ?>" required />
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Correo electronico</label>
                  <div class="col-sm-9">
                    <input type="email" name="correo_electronico" id="correo_electronico" class="form-control"
                      placeholder="Correo electronico" value="<?php echo htmlspecialchars($correo_electronico); ?>" required />
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Agencia aduanal</label>
                  <div class="col-sm-9">
                    <input type="text" name="agencia_aduanal" id="agencia_aduanal" class="form-control"
                      placeholder="Agencia aduanal" value="<?php echo htmlspecialchars($agencia_aduanal); ?>" required />
                  </div>
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group row">
                  <label class="col-sm-3 col-form-label">Fecha de alta</label>
                  <div class="col-sm-9">
                    <input type="date" name="fecha" id="fecha" class="form-control"
                      placeholder="Fecha de alta" value="<?php echo htmlspecialchars($fecha); ?>" required />
                  </div>
                </div>
              </div>
            </div>

            <button type="submit" class="btn btn-primary mb-2">
              <?php echo $answer['data']['button']; ?>
            </button>
          </form>
          
          <script>
            document.getElementById('informacionGeneral').addEventListener('submit', function (e) {
              e.preventDefault();

              const campos = [
                'patente',
                'agente_aduanal',
                'razon_social',
                'telefono',
                'nombre_completo',
                'correo_electronico',
                'agencia_aduanal',
                'fecha'
              ];

              let problemas = [];

              campos.forEach(campo => {
                const elemento = document.getElementById(campo);
                if (elemento) {
                  const valor = elemento.value;
                  if (!valor.trim()) {
                    problemas.push(`${campo} (requerido pero vacío)`);
                  }
                } else {
                  problemas.push(`${campo} (elemento no existe)`);
                }
              });

              if (problemas.length > 0) {
                alert('Errores:\n' + problemas.join('\n'));
              } else {
                // Mostrar confirmación antes de enviar
                if (confirm('¿Estás seguro de que deseas guardar la información general?')) {
                  this.submit();
                }
              }
            });
          </script>
        </div>
      </div>
    </div>
  </div>
</div>