<link rel="stylesheet" href="/Aaapumac/src/views/assets/css/modals.css">
<div class="card card-rounded">
  <div class="card-body">

    <!-- AGREGAR AQUÍ LOS MENSAJES DE ALERTA -->
    <?php if (isset($_SESSION['success'])): ?>
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <?php echo $_SESSION['success']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <?php echo $_SESSION['error']; ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      <?php unset($_SESSION['error']); ?>
    <?php endif; ?>
    <!-- FIN DE MENSAJES DE ALERTA -->

    <div class="d-sm-flex justify-content-between align-items-start">
      <div>
        <br><br><br>
        <h4 class="card-title card-title-dash" id="titulo-principal">
          Listado de
          <?php echo $answer['data']['title']; ?>
        </h4>
        <p class="card-subtitle card-subtitle-dash subtitulo">
          <?php echo $answer['data']['subtitle']; ?>
        </p>
      </div>
      <div>
        <button class="btn boton-guardar btn-lg text-white mb-0 me-0" type="button" data-bs-toggle="modal"
          data-bs-target="#modal-create-modal">
          <i class="<?php echo $answer['data']['icon']; ?>">&nbsp;</i>
          <?php echo $answer['data']['button']; ?>
        </button>
      </div>
    </div>
    <br>


    <?php
    $pagination = $answer['data']['pagination'] ?? null;
    $currentPage = $pagination['current_page'] ?? 1;
    $perPage = $pagination['per_page'] ?? 10;
    $totalPages = $pagination['total_pages'] ?? 1;
    $totalRows = $pagination['total'] ?? count($answer['modal']);
    $baseUrl = '/Aaapumac/callcenter/modals';
    $searchTerm = trim($_GET['search'] ?? '');
    $searchQuery = $searchTerm !== '' ? '&search=' . urlencode($searchTerm) : '';
    ?>
 <!-- Barra de filtrado por título mejorada -->
<form method="get" action="<?php echo $baseUrl; ?>" class="filtro-barra mb-4">
    <div class="filtro-grupo">
        <div class="filtro-input-wrapper">
            <i class="mdi mdi-magnify filtro-icono"></i>
            <input type="text" name="search" class="filtro-input" 
                   placeholder="Buscar por título..." 
                   value="<?php echo htmlspecialchars($searchTerm); ?>"
                   aria-label="Buscar documentos">
        </div>
        <div class="filtro-acciones">
            <button type="submit" class="btn-filtro btn-filtro-primary">
                <i class="mdi mdi-filter-outline"></i>
                <span>Filtrar</span>
            </button>
            <a href="<?php echo $baseUrl; ?>" class="btn-filtro btn-filtro-secondary">
                <i class="mdi mdi-close-circle-outline"></i>
                <span>Limpiar</span>
            </a>
        </div>
    </div>
    <input type="hidden" name="page" value="1">
</form>

<!-- Paginador mejorado -->
<div class="paginador-moderno">
    <form method="get" action="<?php echo $baseUrl; ?>" class="paginador-form">
        <div class="paginador-info">
            <i class="mdi mdi-table-rows"></i>
            <span>Mostrar</span>
        </div>
        <div class="paginador-selector">
            <select name="per_page" class="paginador-select" onchange="this.form.submit()" aria-label="Registros por página">
                <?php foreach ([5, 10, 15, 25, 50, 100] as $size): ?>
                    <option value="<?php echo $size; ?>" <?php echo $perPage == $size ? 'selected' : ''; ?>>
                        <?php echo $size; ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <span>registros por página</span>
        </div>
        <input type="hidden" name="page" value="1">
        <?php if ($searchTerm !== ''): ?>
            <input type="hidden" name="search" value="<?php echo htmlspecialchars($searchTerm); ?>">
        <?php endif; ?>
    </form>
</div>


    <div class="table-responsive tabla">
      <table id="order-listing-callcenter" class="table table-responsive table-hover table-bordered">
        <thead class="table-primary">
          <tr>
            <th>Acciones</th>
            <th>Titulo</th>
            <th>Descripción</th>
            <th>Imagen</th>
            <th>Archivo</th>
            <th>Estado</th>
            <th>Fechas</th>
            <th>Acciones Estado</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($answer['modal'] as $m): ?>
            <tr>
              <td>
                <div class="btn-group">
                  <button type="button" class="btn btn-warning btn-sm" title="Editar" data-bs-toggle="modal"
                    data-bs-target="#modal-edit-modal-<?php echo $m->getId(); ?>">
                    <i class="ti-pencil-alt"></i>
                  </button>
                </div>
              </td>
              <td class="description-cell"><?php echo htmlspecialchars($m->getTitle()); ?></td>

              <!--  SOLO ESTA CELDA DE DESCRIPCIÓN TIENE SALTO DE LÍNEA -->
              <td class="description-cell">
                <?php echo nl2br(htmlspecialchars($m->getDescription())); ?>
              </td>
              <!--  SOLO ESTA CELDA DE DESCRIPCIÓN TIENE SALTO DE LÍNEA -->

              <td>
                <?php if ($m->getImage()): ?>
                  <a href="<?php echo $m->getImage(); ?>" target="_blank">
                    <img src="<?php echo $m->getImage(); ?>" alt="Imagen" class="imagen-tabla">
                  </a>
                <?php else: ?>
                  <span class="text-muted">Sin imagen</span>
                <?php endif; ?>
              </td>
              <td>
                <?php if ($m->getArchivo()): ?>
                  <a href="<?php echo $m->getArchivo(); ?>" target="_blank" class="btn btn-sm btn-info">
                    <i class="mdi mdi-file-pdf"></i> Ver Archivo
                  </a>
                <?php else: ?>
                  <span class="text-muted">Sin archivo</span>
                <?php endif; ?>
              </td>
              <td>
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
              </td>
              <td>
                <small class="text-muted">
                  <strong>Creado originalmente:</strong>
                  <?php
                  echo $m->getCreatedAt() ? date('d/m/Y H:i', strtotime($m->getCreatedAt())) : 'N/A';
                  ?><br>

                  <strong>Última actualización:</strong>
                  <?php echo $m->getUpdatedAt() ? date('d/m/Y H:i', strtotime($m->getUpdatedAt())) : 'N/A'; ?><br>

                  <?php if ($m->getVisible() == 1): ?>
                    <?php
                    $updated = new DateTime($m->getUpdatedAt());
                    $now = new DateTime();
                    $diff = $now->diff($updated);
                    $hoursPassed = $diff->h + ($diff->days * 24);
                    $hoursLeft = 24 - $hoursPassed;
                    $expiresAt = clone $updated;
                    $expiresAt->add(new DateInterval('PT24H'));
                    ?>
                    <strong>Expira en:</strong>
                    <?php if ($hoursLeft > 0): ?>
                      <span class="badge bg-success" title="Expira: <?php echo $expiresAt->format('d/m/Y H:i'); ?>">
                        <?php echo $hoursLeft; ?> horas
                      </span><br>
                      <small><em>Hora exacta: <?php echo $expiresAt->format('d/m/Y H:i'); ?></em></small>
                    <?php else: ?>
                      <span class="badge bg-danger">¡Expirado!</span><br>
                      <small><em>Debe desactivarse en próxima verificación</em></small>
                    <?php endif; ?>
                  <?php endif; ?>
                </small>
              </td>
              <td>
                <form method="POST" action="/Aaapumac/callcenter/ToggleAvisoStatus" class="d-inline">
                  <input type="hidden" name="id" value="<?php echo $m->getId(); ?>">
                  <button type="submit"
                    class="btn btn-sm js-toggle-status <?php echo $m->getVisible() ? 'btn-warning' : 'btn-success'; ?>"
                    title="<?php echo $m->getVisible() ? 'Desactivar' : 'Activar'; ?>"
                    data-current-status="<?php echo (int) $m->getVisible(); ?>">
                    <i class="<?php echo $m->getVisible() ? 'ti-close' : 'ti-check'; ?>"></i>
                    <?php echo $m->getVisible() ? ' Desactivar' : ' Activar'; ?>
                  </button>
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>


    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
      <div>
        <small class="text-muted">
          Mostrando pagina <?php echo (int) $currentPage; ?> de <?php echo (int) $totalPages; ?>
          (total: <?php echo (int) $totalRows; ?> registros)
        </small>
      </div>
    </div>

    <?php if ($totalPages > 1): ?>
      <?php
      $window = 2;
      $startPage = max(1, $currentPage - $window);
      $endPage = min($totalPages, $currentPage + $window);
      ?>
      <nav aria-label="Paginacion de avisos" class="mt-3">
        <ul class="pagination justify-content-end mb-0">
          <li class="page-item <?php echo $currentPage <= 1 ? 'disabled' : ''; ?>">
            <a class="page-link"
              href="<?php echo $baseUrl; ?>?page=<?php echo max(1, $currentPage - 1); ?>&per_page=<?php echo (int) $perPage; ?><?php echo $searchQuery; ?>">Anterior</a>
          </li>

          <?php if ($startPage > 1): ?>
            <li class="page-item">
              <a class="page-link" href="<?php echo $baseUrl; ?>?page=1&per_page=<?php echo (int) $perPage; ?><?php echo $searchQuery; ?>">1</a>
            </li>
            <?php if ($startPage > 2): ?>
              <li class="page-item disabled"><span class="page-link">...</span></li>
            <?php endif; ?>
          <?php endif; ?>

          <?php for ($p = $startPage; $p <= $endPage; $p++): ?>
            <li class="page-item <?php echo $p === $currentPage ? 'active' : ''; ?>">
              <a class="page-link"
                href="<?php echo $baseUrl; ?>?page=<?php echo $p; ?>&per_page=<?php echo (int) $perPage; ?><?php echo $searchQuery; ?>"><?php echo $p; ?></a>
            </li>
          <?php endfor; ?>

          <?php if ($endPage < $totalPages): ?>
            <?php if ($endPage < $totalPages - 1): ?>
              <li class="page-item disabled"><span class="page-link">...</span></li>
            <?php endif; ?>
            <li class="page-item">
              <a class="page-link"
                href="<?php echo $baseUrl; ?>?page=<?php echo $totalPages; ?>&per_page=<?php echo (int) $perPage; ?><?php echo $searchQuery; ?>"><?php echo $totalPages; ?></a>
            </li>
          <?php endif; ?>

          <li class="page-item <?php echo $currentPage >= $totalPages ? 'disabled' : ''; ?>">
            <a class="page-link"
              href="<?php echo $baseUrl; ?>?page=<?php echo min($totalPages, $currentPage + 1); ?>&per_page=<?php echo (int) $perPage; ?><?php echo $searchQuery; ?>">Siguiente</a>
          </li>
        </ul>
      </nav>
    <?php endif; ?>
  </div>
</div>

<div class="card card-rounded">
</div>

<!-- Modal nuevo Aviso -->
<div class="modal fade" id="modal-create-modal" tabindex="-1" aria-labelledby="ModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content" id="contenedor-modalAviso">
      <div class="modal-header" id="modal-headerAviso">
        <i class="mdi mdi-bell-plus" id="icono-altaAviso"></i>
        <h5 class="modal-title" id="ModalLabel"><strong>Agregar Nuevo Aviso</strong></h5>
        <button type="button" class="btn-close cerrar" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body cuerpo-modal-alta">
        <form method="post" id="avisos" action="/Aaapumac/callcenter/NewAviso" enctype="multipart/form-data">
          <div class="mb-3">
            <!--titulo-->
            <label for="title" class="form-label">Titulo</label>
            <div class="input-group">
              <span class="input-group-text"><i class="mdi mdi-format-size"></i></span>
              <input type="text" class="form-control titulo-modal" id="title" name="title" required placeholder="Titulo"
                aria-label="title">
            </div>
          </div>
          <!--descripcion-->
          <div class="mb-3">
            <label for="description" class="form-label">Descripción</label>
            <div class="input-group">
              <span class="input-group-text"><i class="mdi mdi-clipboard-text"></i></span>
              <input type="text" class="form-control descripcion-modal" id="description" name="description" required
                placeholder="Descripción" aria-label="description">
            </div>
          </div>
          <!--imagen-->
          <div class="mb-3">
            <label for="image" class="form-label">Imagen</label>
            <div class="input-group">
              <input type="file" class="form-control imagen-modal" id="image" name="image" required aria-label="image">
            </div>
          </div>
          <!--alta de archivo-->

          <div class="mb-3">
            <label for="archivo" class="form-label">Archivo PDF</label>
            <div class="input-group">
              <input type="file" class="form-control archivo-modal" id="archivo" name="archivo" required
                aria-label="archivo">
            </div>
          </div>
          <!--Estado del aviso-->
          <div class="mb-3">
            <label for="visible" class="form-label">Estado</label>
            <div class="input-group">
              <span class="input-group-text"><i class="mdi mdi-clipboard-check"></i></span>
              <select class="form-control estado-modal" id="visible" name="visible" required>
                <option value="1">Activo</option>
                <option value="0">Inactivo</option>
              </select>
            </div>
          </div>
          <!--botones-->
          <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            <button type="button" class="btn btn-danger" id="boton-cancelar" data-bs-dismiss="modal">Cancelar</button>
            <button type="submit" class="btn btn-primary" id="boton-guardar">Guardar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- Fin Modal nuevo Aviso -->

<!-- Modal Editar Aviso -->
<?php foreach ($answer['modal'] as $m): ?>
  <div class="modal fade" id="modal-edit-modal-<?php echo $m->getId(); ?>" tabindex="-1"
    aria-labelledby="EditModalLabel-<?php echo $m->getId(); ?>" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content" id="contenedor-editarAviso">
        <div class="modal-header header-modaleditarAviso">
          <i class="mdi mdi-bell-ring " id="icono-editarAviso"></i>
          <h5 class="modal-title" id="EditModalLabel-<?php echo $m->getId(); ?>"><strong>Editar Aviso</strong></h5>
          <button type="button" class="btn-close cerrarEditar" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" id="cuerpo-editar">
          <form method="post" id="edit-aviso-<?php echo $m->getId(); ?>" class="js-edit-aviso-form"
            action="/Aaapumac/callcenter/ActualizarAviso" enctype="multipart/form-data">
            <input type="hidden" name="id" value="<?php echo $m->getId(); ?>">

            <!--Titulo editar-->
            <div class="mb-3">
              <label for="title-<?php echo $m->getId(); ?>" class="form-label">Titulo</label>
              <div class="input-group">
                <span class="input-group-text"><i class="mdi mdi-format-size"></i></span>
                <input type="text" class="form-control editar-titulo" id="title-<?php echo $m->getId(); ?>" name="title"
                  required value="<?php echo htmlspecialchars($m->getTitle()); ?>" placeholder="Titulo">
              </div>
            </div>
            <!--descripcion editar-->
            <div class="mb-3">
              <label for="description-<?php echo $m->getId(); ?>" class="form-label">Descripción</label>
              <div class="input-group">
                <span class="input-group-text"><i class="mdi mdi-clipboard-text"></i></span>
                <input type="text" class="form-control editar-descripcion" id="description-<?php echo $m->getId(); ?>"
                  name="description" required value="<?php echo htmlspecialchars($m->getDescription()); ?>"
                  placeholder="Descripción">
              </div>
            </div>
            <!--imagen editar-->
            <div class="mb-3">
              <label for="image-<?php echo $m->getId(); ?>" class="form-label">Imagen</label>
              <div class="input-group">
                <input type="file" class="form-control editar-imagen" id="image-<?php echo $m->getId(); ?>" name="image">
              </div>
              <small class="text-muted">Imagen actual:
                <?php echo htmlspecialchars(basename($m->getImage() ?? '')); ?></small>
              <?php if ($m->getImage()): ?>
                <div>
                  <img src="<?php echo $m->getImage(); ?>" id="mostrarImegen-editar" alt="Imagen actual">
                </div>
              <?php endif; ?>
            </div>

            <!--editar archivo-->
            <div class="mb-3">
              <label for="archivo-<?php echo $m->getId(); ?>" class="form-label">Archivo PDF/Word</label>
              <div class="input-group">
                <input type="file" class="form-control editar-archivo" id="archivo-<?php echo $m->getId(); ?>"
                  name="archivo">
              </div>
              <?php if ($m->getArchivo()): ?>
                <small class="text-muted">
                  Archivo actual: <a href="<?php echo $m->getArchivo(); ?>" target="_blank">Ver archivo</a>
                </small>
              <?php else: ?>
                <small class="text-muted">No hay archivo subido</small>
              <?php endif; ?>
            </div>
            <!--estado editar-->
            <div class="mb-3">
              <label for="visible-<?php echo $m->getId(); ?>" class="form-label">Estado</label>
              <div class="input-group">
                <span class="input-group-text"><i class="mdi mdi-clipboard-check"></i></span>
                <select class="form-control estado-editar" id="visible-<?php echo $m->getId(); ?>" name="visible"
                  required>
                  <option value="1" <?php echo $m->getVisible() == 1 ? 'selected' : ''; ?>>Activo</option>
                  <option value="0" <?php echo $m->getVisible() == 0 ? 'selected' : ''; ?>>Inactivo</option>
                </select>
              </div>
              <small class="text-muted text-warning">
                <i class="ti-info-alt"></i> Al cambiar el estado, se actualizarán las fechas de creación y modificación.
              </small>
            </div>

            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
              <button type="button" class="btn btn-danger" data-bs-dismiss="modal"
                style="border-radius: 5px;">Cancelar</button>
              <button type="submit" class="btn btn-warning actualizar">Actualizar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
<?php endforeach; ?>
<!-- Fin Modal Editar Aviso -->

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="/Aaapumac/src/views/assets/js/avisos-modals.js"></script>