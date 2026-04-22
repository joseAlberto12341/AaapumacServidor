document.addEventListener('DOMContentLoaded', function () {
  bindToggleStatusButtons();
  bindCreateAvisoForm();
  bindEditAvisoForms();
  injectAvisoStyles();
});

function bindToggleStatusButtons() {
  const toggleButtons = document.querySelectorAll('.js-toggle-status');

  toggleButtons.forEach(function (button) {
    button.addEventListener('click', function (event) {
      event.preventDefault();

      const currentStatus = Number(button.dataset.currentStatus || 0);
      const action = currentStatus ? 'desactivar' : 'activar';

      Swal.fire({
        title: '¿Cambiar estado?',
        html: '¿Deseas <strong>' + action + '</strong> este aviso?<br><br>' +
          '<small><strong>Nota:</strong> Al cambiar el estado, se actualizarán las fechas de creación y modificación.</small>',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: currentStatus ? '#ffc107' : '#28a745',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sí, ' + action,
        cancelButtonText: 'Cancelar',
        width: '500px'
      }).then(function (result) {
        if (!result.isConfirmed) {
          return;
        }

        const originalHTML = button.innerHTML;
        button.innerHTML = '<i class="ti-reload spinner"></i> Procesando...';
        button.disabled = true;

        const form = button.closest('form');
        if (form) {
          form.submit();
        }

        setTimeout(function () {
          button.innerHTML = originalHTML;
          button.disabled = false;
        }, 3000);
      });
    });
  });
}

function bindCreateAvisoForm() {
  const avisosForm = document.getElementById('avisos');
  if (!avisosForm) {
    return;
  }

  avisosForm.addEventListener('submit', function (event) {
    event.preventDefault();

    Swal.fire({
      title: 'Buen Trabajo!',
      text: 'El Aviso ha sido agregado exitosamente!',
      icon: 'success',
      confirmButtonText: 'Ok'
    }).then(function (result) {
      if (result.isConfirmed) {
        avisosForm.submit();
      }
    });
  });
}

function bindEditAvisoForms() {
  const editForms = document.querySelectorAll('.js-edit-aviso-form');

  editForms.forEach(function (form) {
    const visibleSelect = form.querySelector('select[name="visible"]');
    const initialVisible = visibleSelect ? visibleSelect.value : null;

    form.addEventListener('submit', function (event) {
      event.preventDefault();

      const currentVisible = visibleSelect ? visibleSelect.value : null;
      const visibleChanged = initialVisible !== null && currentVisible !== initialVisible;

      let message = '¿Deseas actualizar este aviso?';
      if (visibleChanged) {
        message = '¿Deseas actualizar este aviso?<br><br><small><strong>Importante:</strong> Al cambiar el estado, se actualizarán las fechas de creación y modificación.</small>';
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
      }).then(function (result) {
        if (!result.isConfirmed) {
          return;
        }

        if (visibleChanged) {
          Swal.fire({
            title: 'Actualizando...',
            html: 'Actualizando aviso y fechas de creación/modificación',
            icon: 'info',
            showConfirmButton: false,
            allowOutsideClick: false,
            allowEscapeKey: false,
            didOpen: function () {
              Swal.showLoading();
            }
          });
        }

        form.submit();
      });
    });
  });
}

function injectAvisoStyles() {
  if (document.getElementById('avisos-inline-style')) {
    return;
  }

  const style = document.createElement('style');
  style.id = 'avisos-inline-style';
  style.textContent = [
    '.spinner {',
    '  animation: spin 1s linear infinite;',
    '  display: inline-block;',
    '  margin-right: 5px;',
    '}',
    '@keyframes spin {',
    '  0% { transform: rotate(0deg); }',
    '  100% { transform: rotate(360deg); }',
    '}',
    '.badge {',
    '  font-size: 0.85em;',
    '  padding: 0.4em 0.7em;',
    '  font-weight: 600;',
    '}',
    'td small {',
    '  font-size: 0.8rem;',
    '  line-height: 1.2;',
    '}',
    '.text-muted.text-warning {',
    '  color: #ffc107 !important;',
    '  font-size: 0.8rem;',
    '  display: block;',
    '  margin-top: 5px;',
    '}',
    '.btn-group .btn-sm {',
    '  margin-right: 5px;',
    '}'
  ].join('\n');

  document.head.appendChild(style);
}
