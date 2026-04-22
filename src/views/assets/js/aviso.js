// Esperar a que el DOM esté completamente cargado
document.addEventListener('DOMContentLoaded', function() {
  
  // Función para mostrar/ocultar descripción completa
  function initializeDescriptionToggles() {
    document.querySelectorAll('.toggle-description').forEach(button => {
      button.addEventListener('click', function() {
        const cardBody = this.closest('.card-footer').previousElementSibling;
        const description = cardBody.querySelector('.description-truncate');
        
        if (description.style.height === '60px' || !description.style.height) {
          description.style.height = 'auto';
          this.innerHTML = '<i class="fas fa-ellipsis-h"></i> Menos info';
        } else {
          description.style.height = '60px';
          this.innerHTML = '<i class="fas fa-ellipsis-h"></i> Más info';
        }
      });
    });
  }
  
  // Efecto hover para imágenes
  function initializeImageHoverEffect() {
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
  }
  
  // Cambiar vista entre grid y lista
  function initializeViewToggles() {
    const gridViewBtn = document.getElementById('gridView');
    const listViewBtn = document.getElementById('listView');
    
    if (gridViewBtn && listViewBtn) {
      gridViewBtn.addEventListener('click', function() {
        listViewBtn.classList.remove('active', 'btn-primary');
        listViewBtn.classList.add('btn-outline-secondary');
        this.classList.remove('btn-outline-primary');
        this.classList.add('active', 'btn-primary');
        
        document.querySelectorAll('.card-item').forEach(card => {
          card.classList.remove('col-12');
          card.classList.add('col-xl-4', 'col-lg-4', 'col-md-6', 'col-sm-12');
        });
      });
      
      listViewBtn.addEventListener('click', function() {
        gridViewBtn.classList.remove('active', 'btn-primary');
        gridViewBtn.classList.add('btn-outline-primary');
        this.classList.remove('btn-outline-secondary');
        this.classList.add('active', 'btn-primary');
        
        document.querySelectorAll('.card-item').forEach(card => {
          card.classList.remove('col-xl-4', 'col-lg-4', 'col-md-6', 'col-sm-12');
          card.classList.add('col-12');
        });
      });
    }
  }
  
  // Cambiar items por página
  function initializeItemsPerPage() {
    const itemsPerPageSelect = document.getElementById('itemsPerPage');
    if (itemsPerPageSelect) {
      itemsPerPageSelect.addEventListener('change', function() {
        const itemsPerPage = this.value;
        window.location.href = window.location.pathname + '?page=1&per_page=' + itemsPerPage;
      });
    }
  }
  
  // Función para forzar abrir en nueva pestaña en imágenes
  function initializeImageLinks() {
    document.querySelectorAll('.img-expandable').forEach(img => {
      img.addEventListener('click', function(e) {
        // Si la imagen está dentro de un enlace, no hacer nada adicional
        if (this.closest('a')) {
          return;
        }
        
        // Buscar el enlace más cercano
        const cardImgContainer = this.closest('.card-img-container');
        const link = cardImgContainer.querySelector('a');
        
        if (link) {
          e.preventDefault();
          window.open(link.href, '_blank');
        }
      });
    });
  }
  
  // SweetAlert para cambiar estado
  window.confirmToggleStatus = function(event, button, id, currentStatus) {
    event.preventDefault();
    
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
  };
  
  // Inicializar todas las funcionalidades
  initializeDescriptionToggles();
  initializeImageHoverEffect();
  initializeViewToggles();
  initializeItemsPerPage();
  initializeImageLinks();
});