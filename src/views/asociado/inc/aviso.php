<div class="card card-rounded">
  <div class="card-body">
    <div class="d-sm-flex justify-content-between align-items-start">
      <div>
        <br><br><br>
        <h4 class="card-title card-title-dash"
          style="font-size: 42px; font-weight: 700; color: #0056b3; margin-bottom: 20px;">Listado de
          <?php echo $answer['data']['title']; ?>
        </h4>
        <p class="card-subtitle card-subtitle-dash"
          style="color: #007bff; font-size: 22px; font-weight: 700; margin: 15px 0;">
          <?php echo $answer['data']['subtitle']; ?>
        </p>
      </div>
    </div>
    <br>

    <!-- Modo visualización (Opcional) -->
    <div class="d-flex justify-content-between mb-3">
      <div class="view-options">
        <button id="gridView" class="btn btn-outline-primary btn-sm active">
          <i class="fas fa-th-large"></i> Red
        </button>
        <button id="listView" class="btn btn-outline-secondary btn-sm">
          <i class="fas fa-list"></i> Lista
        </button>
      </div>
      <div class="items-per-page">
        <select id="itemsPerPage" class="form-select form-select-sm w-auto">
          <option value="6">6 por página</option>
          <option value="12">12 por página</option>
          <option value="24">24 por página</option>
        </select>
      </div>
    </div>

    <!-- Contenedor de cartas -->
    <div id="cardsContainer" class="row">
      <?php 
      $itemsPerPage = 6; // Número de cartas por página
      $totalItems = count($answer['modal']);
      $totalPages = ceil($totalItems / $itemsPerPage);
      $currentPage = isset($_GET['page']) ? max(1, min($totalPages, intval($_GET['page']))) : 1;
      $startIndex = ($currentPage - 1) * $itemsPerPage;
      $endIndex = min($startIndex + $itemsPerPage, $totalItems);
      
      for ($i = $startIndex; $i < $endIndex; $i++):
        $m = $answer['modal'][$i];
      ?>
        <div class="col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-4 card-item">
          <div class="card h-100 shadow-sm">
            <!-- Imagen con enlace para nueva pestaña -->
            <div class="card-img-container position-relative" style="height: 200px; overflow: hidden;">
              <?php if ($m->getImage()): ?>
                <a href="<?php echo $m->getImage(); ?>" 
                   target="_blank" 
                   class="d-block h-100"
                   title="Abrir imagen en nueva pestaña">
                  <img src="<?php echo $m->getImage(); ?>" 
                       class="card-img-top img-expandable" 
                       alt="<?php echo htmlspecialchars($m->getTitle()); ?>"
                       style="width: 100%; height: 100%; object-fit: cover; cursor: pointer;">
                  <div class="expand-overlay position-absolute top-0 start-0 w-100 h-100 d-flex align-items-center justify-content-center" 
                       style="background: rgba(0,0,0,0.3); opacity: 0; transition: opacity 0.3s;">
                    <span class="text-white bg-primary rounded-circle p-2">
                      <i class="fas fa-external-link-alt"></i>
                    </span>
                  </div>
                </a>
              <?php else: ?>
                <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 100%;">
                  <i class="fas fa-image fa-3x text-muted"></i>
                  <span class="text-muted ms-2">Sin imagen</span>
                </div>
              <?php endif; ?>
              
              <!-- Badge de estado -->
              <span class="position-absolute top-0 end-0 m-2">
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
              </span>
            </div>

            <!-- Cuerpo de la carta -->
            <div class="card-body">
              <h5 class="card-title text-truncate" title="<?php echo htmlspecialchars($m->getTitle()); ?>">
                <?php echo htmlspecialchars($m->getTitle()); ?>
              </h5>
              
              <p class="card-text description-truncate" style="height: 60px; overflow: hidden;">
                <?php echo htmlspecialchars($m->getDescription()); ?>
              </p>
              
              <!-- Fechas -->
              <div class="card-dates mt-3">
                <small class="text-muted d-block">
                  <i class="far fa-calendar-plus"></i>
                  <strong>Creado:</strong> <?php echo $m->getCreatedAt() ? date('d/m/Y H:i', strtotime($m->getCreatedAt())) : 'N/A'; ?>
                </small>
                <small class="text-muted d-block">
                  <i class="far fa-calendar-check"></i>
                  <strong>Actualizado:</strong> <?php echo $m->getUpdatedAt() ? date('d/m/Y H:i', strtotime($m->getUpdatedAt())) : 'N/A'; ?>
                </small>
              </div>
              
              <!-- Enlace directo a la imagen (opcional, debajo de las fechas) -->
              <?php if ($m->getImage()): ?>
              <div class="mt-2">
                <a href="<?php echo $m->getImage(); ?>" 
                   target="_blank" 
                   class="btn btn-sm btn-link p-0 text-decoration-none"
                   title="Abrir imagen en nueva pestaña">
                  <small><i class="fas fa-external-link-alt me-1"></i> Ver imagen completa</small>
                </a>
              </div>
              <?php endif; ?>
            </div>
          </div>
        </div>
      <?php endfor; ?>
    </div>

    <!-- Paginador -->
    <?php if ($totalPages > 1): ?>
    <nav aria-label="Page navigation" class="mt-4">
      <ul class="pagination justify-content-center">
        <!-- Botón anterior -->
        <li class="page-item <?php echo $currentPage <= 1 ? 'disabled' : ''; ?>">
          <a class="page-link" href="?page=<?php echo $currentPage - 1; ?>" aria-label="Previous">
            <span aria-hidden="true">&laquo;</span>
          </a>
        </li>

        <!-- Números de página -->
        <?php 
        $startPage = max(1, $currentPage - 2);
        $endPage = min($totalPages, $currentPage + 2);
        
        for ($page = $startPage; $page <= $endPage; $page++):
        ?>
          <li class="page-item <?php echo $page == $currentPage ? 'active' : ''; ?>">
            <a class="page-link" href="?page=<?php echo $page; ?>">
              <?php echo $page; ?>
            </a>
          </li>
        <?php endfor; ?>

        <!-- Botón siguiente -->
        <li class="page-item <?php echo $currentPage >= $totalPages ? 'disabled' : ''; ?>">
          <a class="page-link" href="?page=<?php echo $currentPage + 1; ?>" aria-label="Next">
            <span aria-hidden="true">&raquo;</span>
          </a>
        </li>
      </ul>
      <p class="text-center text-muted mt-2">
        Mostrando <?php echo $startIndex + 1; ?>-<?php echo $endIndex; ?> de <?php echo $totalItems; ?> elementos
      </p>
    </nav>
    <?php endif; ?>
  </div>
</div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<script>
  // Función para mostrar/ocultar descripción completa
  document.querySelectorAll('.toggle-description').forEach(button => {
    button.addEventListener('click', function() {
      const cardBody = this.closest('.card-footer').previousElementSibling;
      const description = cardBody.querySelector('.description-truncate');
      
      if (description.style.height === '60px') {
        description.style.height = 'auto';
        this.innerHTML = '<i class="fas fa-ellipsis-h"></i> Menos info';
      } else {
        description.style.height = '60px';
        this.innerHTML = '<i class="fas fa-ellipsis-h"></i> Más info';
      }
    });
  });

  // Efecto hover para imágenes
  document.querySelectorAll('.card-img-container').forEach(container => {
    const overlay = container.querySelector('.expand-overlay');
    
    if (overlay) {
      container.addEventListener('mouseenter', () => {
        overlay.style.opacity = '1';
      });
      
      container.addEventListener('mouseleave', () => {
        overlay.style.opacity = '0';
      });
    }
  });

  // Cambiar vista entre grid y lista
  document.getElementById('gridView').addEventListener('click', function() {
    document.getElementById('listView').classList.remove('active', 'btn-primary');
    document.getElementById('listView').classList.add('btn-outline-secondary');
    this.classList.remove('btn-outline-primary');
    this.classList.add('active', 'btn-primary');
    
    document.querySelectorAll('.card-item').forEach(card => {
      card.classList.remove('col-12');
      card.classList.add('col-xl-4', 'col-lg-4', 'col-md-6', 'col-sm-12');
    });
  });

  document.getElementById('listView').addEventListener('click', function() {
    document.getElementById('gridView').classList.remove('active', 'btn-primary');
    document.getElementById('gridView').classList.add('btn-outline-primary');
    this.classList.remove('btn-outline-secondary');
    this.classList.add('active', 'btn-primary');
    
    document.querySelectorAll('.card-item').forEach(card => {
      card.classList.remove('col-xl-4', 'col-lg-4', 'col-md-6', 'col-sm-12');
      card.classList.add('col-12');
    });
  });

  // Cambiar items por página
  document.getElementById('itemsPerPage').addEventListener('change', function() {
    const itemsPerPage = this.value;
    window.location.href = window.location.pathname + '?page=1&per_page=' + itemsPerPage;
  });

  // Función para forzar abrir en nueva pestaña incluso si se hace clic en la imagen directamente
  document.querySelectorAll('.img-expandable').forEach(img => {
    img.addEventListener('click', function(e) {
      // Si la imagen está dentro de un enlace, no hacer nada adicional
      if (this.closest('a')) {
        return;
      }
      
      // Si la imagen NO está dentro de un enlace, buscar el enlace más cercano o crear uno
      const cardImgContainer = this.closest('.card-img-container');
      const link = cardImgContainer.querySelector('a');
      
      if (link) {
        e.preventDefault();
        window.open(link.href, '_blank');
      }
    });
  });

  // Estilos adicionales
  const style = document.createElement('style');
  style.textContent = `
    .card {
      transition: transform 0.3s, box-shadow 0.3s;
      border: 1px solid #e0e0e0;
    }
    .card:hover {
      transform: translateY(-5px);
      box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
    .card-img-container:hover .expand-overlay {
      opacity: 1 !important;
    }
    .description-truncate {
      transition: height 0.3s ease;
    }
    .pagination .page-item.active .page-link {
      background-color: #0056b3;
      border-color: #0056b3;
    }
    .card-title {
      color: #0056b3;
      font-weight: 600;
    }
    .card-dates small {
      font-size: 0.85rem;
    }
    .badge {
      font-size: 0.8em;
      padding: 0.4em 0.8em;
    }
    .view-options .btn {
      min-width: 100px;
    }
    .img-expandable {
      cursor: pointer;
    }
    .card-img-container a {
      text-decoration: none;
      color: inherit;
    }
    .card-img-container a:hover {
      text-decoration: none;
    }
    .expand-overlay {
      pointer-events: none;
    }
  `;
  document.head.appendChild(style);

  // Tu código original de SweetAlert (mantenido)
  function confirmToggleStatus(event, button, id, currentStatus) {
    event.preventDefault();
    
    const newStatus = currentStatus ? 'inactivo' : 'activo';
    const action = currentStatus ? 'desactivar' : 'activar';
    
    Swal.fire({
      title: '¿Cambiar estado?',
      html: `¿Deseas <strong>${action}</strong> este aviso?<br><br>
             <small><strong>Nota:</strong> Al cambiar el estado, se actualizarán las fechas de creación y modificación.</small>`,
      icon: 'question',
      showCancelButton: true,
      confirmButtonColor: currentStatus ? '#ffc107' : '#28a745',
      cancelButtonColor: '#6c757d',
      confirmButtonText: `Sí, ${action}`,
      cancelButtonText: 'Cancelar',
      width: '500px'
    }).then((result) => {
      if (result.isConfirmed) {
        const originalHTML = button.innerHTML;
        button.innerHTML = '<i class="ti-reload spinner"></i> Procesando...';
        button.disabled = true;
        
        const form = button.closest('form');
        form.submit();
        
        setTimeout(() => {
          button.innerHTML = originalHTML;
          button.disabled = false;
        }, 3000);
      }
    });
    
    return false;
  }
</script>