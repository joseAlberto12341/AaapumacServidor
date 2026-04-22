  // Función para mostrar confirmación de bloqueo/desbloqueo
  function confirmJobAction(event) {
    event.preventDefault();

    const button = event.currentTarget;
    const jobId = button.getAttribute('data-id');
    const jobTitle = button.getAttribute('data-title');
    const action = button.getAttribute('data-action');

    const isLock = action === 'lock';
    const actionText = isLock ? 'bloquear' : 'desbloquear';
    const actionTitle = isLock ? 'Bloquear Empleo' : 'Desbloquear Empleo';
    const actionIcon = isLock ? 'warning' : 'success';
    const confirmButtonColor = isLock ? '#d33' : '#3085d6';

    Swal.fire({
      title: actionTitle,
      html: `¿Estás seguro que deseas <strong>${actionText}</strong> el empleo?<br><strong>"${jobTitle}"</strong>`,
      icon: actionIcon,
      showCancelButton: true,
      confirmButtonColor: confirmButtonColor,
      cancelButtonColor: '#6c757d',
      confirmButtonText: isLock ? 'Sí, bloquear' : 'Sí, desbloquear',
      cancelButtonText: 'Cancelar',
      reverseButtons: true
    }).then((result) => {
      if (result.isConfirmed) {
        // Usar parámetros GET en lugar de rutas
        const url = `/Aaapumac/administrativo/${action}?id=${jobId}`;
        window.location.href = url;
      }
    });
  }

  // Agregar event listeners a los botones de bloqueo/desbloqueo
  document.addEventListener('DOMContentLoaded', function () {
    // Event listeners para botones de bloqueo/desbloqueo
    const lockButtons = document.querySelectorAll('.lock-btn');
    const unlockButtons = document.querySelectorAll('.unlock-btn');

    lockButtons.forEach(button => {
      button.addEventListener('click', confirmJobAction);
    });

    unlockButtons.forEach(button => {
      button.addEventListener('click', confirmJobAction);
    });

    // Script para el formulario de creación
    const form = document.getElementById('trabajos');
    if (form) {
      form.addEventListener('submit', function (e) {
        e.preventDefault();
        Swal.fire({
          title: "Buen Trabajo!",
          text: "El Empleo ha sido agregado exitosamente!",
          icon: "success",
          confirmButtonText: 'Ok'
        }).then((result) => {
          if (result.isConfirmed) {
            this.submit();
          }
        });
      });
    }
  });