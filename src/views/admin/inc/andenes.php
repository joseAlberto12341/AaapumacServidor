<div class="card " style="border-radius: 15px; box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);">
  <div class="card-body">
    <a href="javascript:history.back()" style="text-decoration: none; color: #007bff;">
      <i class="mdi mdi-arrow-left" style="font-size: 30px; margin-right: 10px;"></i>
      <span style="font-size: 18px;">Regresar</span>
    </a>
    <h2 class="text-center mb-4"
      style="color: #004080; font-weight: bold; font-size: 30px; text-transform: uppercase; letter-spacing: 3px;">
      Selecciona la Zona</h2>
    <div class="row">
      <div class="col-md-6 mb-4">
        <div class="card text-center"
          style="cursor: pointer; border-radius: 15px; transition: transform 0.3s, box-shadow 0.3s;" data-id="zonaNorte"
          onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0px 8px 15px rgba(0, 0, 0, 0.2)';"
          onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0px 4px 10px rgba(0, 0, 0, 0.1)';">
          <div class="card-body">
            <i class="mdi mdi-train-car" style="font-size: 50px; color: #004080;"></i>
            <h5 class="card-title" style="font-size: 1.75rem; font-weight: bold; color: #004080;">Zona Norte</h5>
            <p class="card-text" style="font-size: 1.2rem; color: #666;">Ver detalles de la Zona Norte.</p>
          </div>
        </div>
      </div>
      <div class="col-md-6 mb-4">
        <div class="card text-center"
          style="cursor: pointer; border-radius: 15px; transition: transform 0.3s, box-shadow 0.3s;"
          data-id="zonaSanpedrito"
          onmouseover="this.style.transform='scale(1.05)'; this.style.boxShadow='0px 8px 15px rgba(0, 0, 0, 0.2)';"
          onmouseout="this.style.transform='scale(1)'; this.style.boxShadow='0px 4px 10px rgba(0, 0, 0, 0.1)';">
          <div class="card-body">
            <i class="mdi mdi-ferry" style="font-size: 50px; color: #004080;"></i>
            <h5 class="card-title" style="font-size: 1.75rem; font-weight: bold; color: #004080;">Zona Sanpedrito</h5>
            <p class="card-text" style="font-size: 1.2rem; color: #666;">Ver detalles de la Zona Sanpedrito.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<div class="zona-info" id="zonaNorte" style="display: none;">
  <!-- contenido Zona Norte -->
  <?php if (empty($answer['andenN'])): ?>
    <div class="alert alert-info">
      No hay datos disponibles para mostrar en esta zona.
    </div>
  <?php else: ?>
    <!-- Aquí va el contenido de la tarjeta cuando hay datos -->
    <div class="card" style="border-radius: 15px; padding: 20px;">
      <?php foreach ($answer['andenN'] as $p): ?>
        <h3 class="mb-0 text-center"
          style="color: #004080; font-weight: bold; font-size: 30px; text-transform: uppercase; letter-spacing: 5px;">
          Bienvenido, Patente: <?php echo $p->getPatente() ?>!</h3>
        <h3 class="mb-0 text-center" style="color: #007bff; font-size: 32px; font-weight: 700; margin: 12px 0;">Detalles
          de Andenes: Zona Norte</h3>
        <div class="card-body">
          <div class="row">
            <!-- Tarjeta de Estatus -->
            <div class="col-md-4 mb-4">
              <div class="card text-center"
                style="border-radius: 10px; padding: 15px; background-color: #ffffff; box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1); height: 200px;">
                <i class="mdi mdi-information-outline" style="font-size: 40px; color: #007bff;"></i>
                <div class="card-body">
                  <h5 class="card-title">Estatus</h5>
                  <?php
                  $estatus = $p->getEstatus();
                  switch ($estatus) {
                    case 0:
                      $class = 'badge-secondary';
                      $text = 'Vacío';
                      break;
                    case 1:
                      $class = 'badge-success';
                      $text = 'Disponible';
                      break;
                    case 2:
                      $class = 'badge-warning';
                      $text = 'Revisión';
                      break;
                    case 3:
                      $class = 'badge-danger';
                      $text = 'Ocupado';
                      break;
                    default:
                      $class = 'badge-secondary';
                      $text = 'Desconocido';
                      break;
                  }
                  ?>
                  <span class="badge <?php echo $class; ?>"
                    style="font-size: 1rem; padding: 6px 12px; border-radius: 5px;"><?php echo $text ?></span>
                </div>
              </div>
            </div>
            <!-- Tarjeta de Dependiente -->
            <div class="col-md-4 mb-4">
              <div class="card text-center"
                style="border-radius: 10px; padding: 15px; background-color: #ffffff; box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1); height: 200px;">
                <i class="mdi mdi-account-outline" style="font-size: 40px; color: #007bff;"></i>
                <div class="card-body">
                  <h5 class="card-title">Dependiente</h5>
                  <p class="card-text"><?php echo $p->getNomDependiente() ?></p>
                </div>
              </div>
            </div>
            <!-- Tarjeta de Verificador -->
            <div class="col-md-4 mb-4">
              <div class="card text-center"
                style="border-radius: 10px; padding: 15px; background-color: #ffffff; box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1); height: 200px;">
                <i class="mdi mdi-check-circle-outline" style="font-size: 40px; color: #007bff;"></i>
                <div class="card-body">
                  <h5 class="card-title">Verificador</h5>
                  <p class="card-text"><?php echo $p->getNomVerificador() ?></p>
                </div>
              </div>
            </div>
            <!-- Tarjeta de Fecha de Llegada -->
            <div class="col-md-4 mb-4">
              <div class="card text-center"
                style="border-radius: 10px; padding: 15px; background-color: #ffffff; box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1); height: 200px;">
                <i class="mdi mdi-calendar" style="font-size: 40px; color: #007bff;"></i>
                <div class="card-body">
                  <h5 class="card-title">Fecha de Llegada</h5>
                  <p class="card-text"><?php echo $p->getEstatusFecha() ?></p>
                </div>
              </div>
            </div>
            <!-- Tarjeta de Hora de Llegada -->
            <div class="col-md-4 mb-4">
              <div class="card text-center"
                style="border-radius: 10px; padding: 15px; background-color: #ffffff; box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1); height: 200px;">
                <i class="mdi mdi-clock-outline" style="font-size: 40px; color: #007bff;"></i>
                <div class="card-body">
                  <h5 class="card-title">Hora de Llegada</h5>
                  <p class="card-text"><?php echo $p->getHoraLlegada() ?></p>
                </div>
              </div>
            </div>
            <!-- Tarjeta de Pedimentos -->
            <div class="col-md-4 mb-4">
              <div class="card text-center"
                style="border-radius: 10px; padding: 15px; background-color: #ffffff; box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1); height: 200px;">
                <i class="mdi mdi-file-document-outline" style="font-size: 40px; color: #007bff;"></i>
                <div class="card-body">
                  <h5 class="card-title">Pedimentos</h5>
                  <p class="card-text"><?php echo $p->getPedimento1() ?></p>
                  <p class="card-text"><?php echo $p->getPedimento2() ?></p>
                  <p class="card-text"><?php echo $p->getPedimento3() ?></p>
                </div>
              </div>
            </div>
            <!-- Tarjeta de Contenedores -->
            <div class="col-md-4 mb-4">
              <div class="card text-center"
                style="border-radius: 10px; padding: 15px; background-color: #ffffff; box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1); height: 200px;">
                <i class="mdi mdi-truck-outline" style="font-size: 40px; color: #007bff;"></i>
                <div class="card-body">
                  <h5 class="card-title">Contenedores</h5>
                  <p class="card-text"><?php echo $p->getContenedor1() ?></p>
                  <p class="card-text"><?php echo $p->getContenedor2() ?></p>
                  <p class="card-text"><?php echo $p->getContenedor3() ?></p>
                </div>
              </div>
            </div>
            <!-- Tarjeta de Observaciones -->
            <div class="col-md-12 mb-4">
              <div class="card text-center"
                style="border-radius: 10px; padding: 15px; background-color: #ffffff; box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);">
                <i class="mdi mdi-comment-outline" style="font-size: 40px; color: #007bff;"></i>
                <div class="card-body">
                  <h5 class="card-title">Observaciones</h5>
                  <p class="card-text"><?php echo $p->getObservaciones() ?></p>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endif; ?>
</div>

<div class="zona-info" id="zonaSanpedrito" style="display: none;">
  <?php if (!empty($answer['andenS'])): ?>
    <div class="card" style="border-radius: 15px; padding: 20px;">
      <?php foreach ($answer['andenS'] as $s): ?>
        <h3 class="mb-0 text-center"
          style="color: #004080; font-weight: bold; font-size: 30px; text-transform: uppercase; letter-spacing: 5px;">
          Bienvenido, Patente: <?php echo $s->getPatente() ?>!</h3>
        <h3 class="mb-0 text-center" style="color: #007bff; font-size: 32px; font-weight: 700; margin: 12px 0;">Detalles
          de
          Andenes: Zona San Pedrito</h3>
        <div class="card-body">
          <div class="row">
            <!-- Tarjeta de Estatus -->
            <div class="col-md-4 mb-4">
              <div class="card text-center"
                style="border-radius: 10px; padding: 15px; background-color: #ffffff; box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1); height: 200px;">
                <i class="mdi mdi-information-outline" style="font-size: 40px; color: #007bff;"></i>
                <div class="card-body">
                  <h5 class="card-title">Estatus</h5>
                  <?php
                  $estatus = $s->getEstatus();
                  switch ($estatus) {
                    case 0:
                      $class = 'badge-secondary';
                      $text = 'Vacío';
                      break;
                    case 1:
                      $class = 'badge-success';
                      $text = 'Disponible';
                      break;
                    case 2:
                      $class = 'badge-warning';
                      $text = 'Revisión';
                      break;
                    case 3:
                      $class = 'badge-danger';
                      $text = 'Ocupado';
                      break;
                    default:
                      $class = 'badge-secondary';
                      $text = 'Desconocido';
                      break;
                  }
                  ?>
                  <span class="badge <?php echo $class; ?>"
                    style="font-size: 1rem; padding: 6px 12px; border-radius: 5px;"><?php echo $text ?></span>
                </div>
              </div>
            </div>
            <!-- Tarjeta de Dependiente -->
            <div class="col-md-4 mb-4">
              <div class="card text-center"
                style="border-radius: 10px; padding: 15px; background-color: #ffffff; box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1); height: 200px;">
                <i class="mdi mdi-account-outline" style="font-size: 40px; color: #007bff;"></i>
                <div class="card-body">
                  <h5 class="card-title">Dependiente</h5>
                  <p class="card-text"><?php echo $s->getNomDependiente() ?></p>
                </div>
              </div>
            </div>
            <!-- Tarjeta de Verificador -->
            <div class="col-md-4 mb-4">
              <div class="card text-center"
                style="border-radius: 10px; padding: 15px; background-color: #ffffff; box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1); height: 200px;">
                <i class="mdi mdi-check-circle-outline" style="font-size: 40px; color: #007bff;"></i>
                <div class="card-body">
                  <h5 class="card-title">Verificador</h5>
                  <p class="card-text"><?php echo $s->getNomVerificador() ?></p>
                </div>
              </div>
            </div>
            <!-- Tarjeta de Fecha de Llegada -->
            <div class="col-md-4 mb-4">
              <div class="card text-center"
                style="border-radius: 10px; padding: 15px; background-color: #ffffff; box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1); height: 200px;">
                <i class="mdi mdi-calendar" style="font-size: 40px; color: #007bff;"></i>
                <div class="card-body">
                  <h5 class="card-title">Fecha de Llegada</h5>
                  <p class="card-text"><?php echo $s->getEstatusFecha() ?></p>
                </div>
              </div>
            </div>
            <!-- Tarjeta de Hora de Llegada -->
            <div class="col-md-4 mb-4">
              <div class="card text-center"
                style="border-radius: 10px; padding: 15px; background-color: #ffffff; box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1); height: 200px;">
                <i class="mdi mdi-clock-outline" style="font-size: 40px; color: #007bff;"></i>
                <div class="card-body">
                  <h5 class="card-title">Hora de Llegada</h5>
                  <p class="card-text"><?php echo $s->getHoraLlegada() ?></p>
                </div>
              </div>
            </div>
            <!-- Tarjeta de Pedimentos -->
            <div class="col-md-4 mb-4">
              <div class="card text-center"
                style="border-radius: 10px; padding: 15px; background-color: #ffffff; box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1); height: 200px;">
                <i class="mdi mdi-file-document-outline" style="font-size: 40px; color: #007bff;"></i>
                <div class="card-body">
                  <h5 class="card-title">Pedimentos</h5>
                  <p class="card-text"><?php echo $s->getPedimento1() ?></p>
                  <p class="card-text"><?php echo $s->getPedimento2() ?></p>
                  <p class="card-text"><?php echo $s->getPedimento3() ?></p>
                </div>
              </div>
            </div>
            <!-- Tarjeta de Contenedores -->
            <div class="col-md-4 mb-4">
              <div class="card text-center"
                style="border-radius: 10px; padding: 15px; background-color: #ffffff; box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1); height: 200px;">
                <i class="mdi mdi-truck-outline" style="font-size: 40px; color: #007bff;"></i>
                <div class="card-body">
                  <h5 class="card-title">Contenedores</h5>
                  <p class="card-text"><?php echo $s->getContenedor1() ?></p>
                  <p class="card-text"><?php echo $s->getContenedor2() ?></p>
                  <p class="card-text"><?php echo $s->getContenedor3() ?></p>
                </div>
              </div>
            </div>
            <!-- Tarjeta de Observaciones -->
            <div class="col-md-12 mb-4">
              <div class="card text-center"
                style="border-radius: 10px; padding: 15px; background-color: #ffffff; box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);">
                <i class="mdi mdi-comment-outline" style="font-size: 40px; color: #007bff;"></i>
                <div class="card-body">
                  <h5 class="card-title">Observaciones</h5>
                  <p class="card-text"><?php echo $s->getObservaciones() ?></p>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
  <?php else: ?>
    <div class="alert alert-info mt-5">
      No hay datos disponibles para mostrar.
    </div>
  <?php endif; ?>
</div>

<script>
  document.querySelectorAll('.card[data-id]').forEach(card => {
    card.addEventListener('click', function () {
      // Ocultar toda la información previamente mostrada
      document.querySelectorAll('.zona-info').forEach(info => info.style.display = 'none');

      // Mostrar la información correspondiente a la zona seleccionada
      const zonaId = this.getAttribute('data-id');
      document.getElementById(zonaId).style.display = 'block';
    });
  });
</script>