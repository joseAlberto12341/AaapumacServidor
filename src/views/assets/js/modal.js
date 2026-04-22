 // Función para confirmar cambio de estado
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
        // Cambiar texto del botón mientras se procesa
        const originalHTML = button.innerHTML;
        button.innerHTML = '<i class="ti-reload spinner"></i> Procesando...';
        button.disabled = true;

        // Enviar formulario
        const form = button.closest('form');
        form.submit();

        // Después de 3 segundos, restaurar botón (por si hay error)
        setTimeout(() => {
          button.innerHTML = originalHTML;
          button.disabled = false;
        }, 3000);
      }
    });

    return false;
  }

  // Alerta para agregar nuevo aviso
  const avisosForm = document.getElementById('avisos');
  if (avisosForm) {
    avisosForm.addEventListener('submit', function (e) {
      e.preventDefault();
      Swal.fire({
        title: "Buen Trabajo!",
        text: "El Aviso ha sido agregado exitosamente!",
        icon: "success",
        confirmButtonText: 'Ok'
      }).then((result) => {
        if (result.isConfirmed) {
          this.submit();
        }
      });
    });
  }

  // Alerta de confirmación para actualizar avisos
  <?php foreach ($answer['modal'] as $m): ?>
    const editForm = document.getElementById('edit-aviso-<?php echo $m->getId(); ?>');
    if (editForm) {
      editForm.addEventListener('submit', function (e) {
        e.preventDefault();

        // Verificar si el estado está cambiando
        const currentVisible = <?php echo $m->getVisible(); ?>;
        const formVisible = this.querySelector('select[name="visible"]').value;
        const visibleChanged = (currentVisible != formVisible);

        let message = "¿Deseas actualizar este aviso?";
        if (visibleChanged) {
          message = "¿Deseas actualizar este aviso?<br><br><small><strong>Importante:</strong> Al cambiar el estado, se actualizarán las fechas de creación y modificación.</small>";
        }

        Swal.fire({
          title: '¿Estás seguro?',
          html: message,
          icon: visibleChanged ? 'warning' : 'question',
          showCancelButton: true,
          confirmButtonColor: '#ffc107',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Sí, actualizar',
          cancelButtonText: 'Cancelar',
          width: visibleChanged ? '550px' : '450px'
        }).then((result) => {
          if (result.isConfirmed) {
            // Mostrar loading si cambia el estado
            if (visibleChanged) {
              Swal.fire({
                title: 'Actualizando...',
                html: 'Actualizando aviso y fechas de creación/modificación',
                icon: 'info',
                showConfirmButton: false,
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                  Swal.showLoading();
                }
              });
            }
            // Enviar formulario
            this.submit();
          }
        });
      });
    }
  <?php endforeach; ?>

  // Estilo para el spinner
  const style = document.createElement('style');
  style.textContent = `
    .spinner {
      animation: spin 1s linear infinite;
      display: inline-block;
      margin-right: 5px;
    }
    @keyframes spin {
      0% { transform: rotate(0deg); }
      100% { transform: rotate(360deg); }
    }
    .badge {
      font-size: 0.85em;
      padding: 0.4em 0.7em;
      font-weight: 600;
    }
    td small {
      font-size: 0.8rem;
      line-height: 1.2;
    }
    .text-muted.text-warning {
      color: #ffc107 !important;
      font-size: 0.8rem;
      display: block;
      margin-top: 5px;
    }
    .btn-group .btn-sm {
      margin-right: 5px;
    }
  `;
  document.head.appendChild(style);