
document.addEventListener('DOMContentLoaded', function() {
    // Cambiar cantidad por página
    document.getElementById('perPageSelect').addEventListener('change', function() {
        document.getElementById('searchForm').submit();
    });
    
    // Función para confirmar regeneración de PDF
    function confirmRegeneratePDF(event, pedimentoId, folio) {
        event.preventDefault();
        
        Swal.fire({
            title: 'Regenerar PDF',
            html: `¿Estás seguro que deseas regenerar el PDF para el folio:<br><strong>"${folio}"</strong>?<br><br><small class="text-warning">Se reemplazará el archivo anterior.</small>`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sí, regenerar',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = `/Aaapumac/asociado/generarPDF?id=${pedimentoId}`;
            }
        });
    }

    // Función para confirmar generación de PDF
    function confirmGeneratePDF(event, pedimentoId, folio) {
        event.preventDefault();
        
        Swal.fire({
            title: 'Generar PDF',
            html: `¿Estás seguro que deseas generar el PDF para el folio:<br><strong>"${folio}"</strong>?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sí, generar',
            cancelButtonText: 'Cancelar',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = `/Aaapumac/asociado/generarPDF?id=${pedimentoId}`;
            }
        });
    }

    // Agregar event listeners a los botones de PDF
    const regenerateButtons = document.querySelectorAll('.btn-warning');
    regenerateButtons.forEach(button => {
        if (button.getAttribute('href') && button.getAttribute('href').includes('generarPDF')) {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const href = this.getAttribute('href');
                const urlParams = new URLSearchParams(href.split('?')[1]);
                const pedimentoId = urlParams.get('id');
                const folio = this.closest('tr').querySelector('td:nth-child(2)').textContent.trim();
                confirmRegeneratePDF(e, pedimentoId, folio);
            });
        }
    });

    // Agregar event listeners a los botones de generar PDF
    const generateButtons = document.querySelectorAll('.btn-primary');
    generateButtons.forEach(button => {
        if (button.getAttribute('href') && button.getAttribute('href').includes('generarPDF')) {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const href = this.getAttribute('href');
                const urlParams = new URLSearchParams(href.split('?')[1]);
                const pedimentoId = urlParams.get('id');
                const folio = this.closest('tr').querySelector('td:nth-child(2)').textContent.trim();
                confirmGeneratePDF(e, pedimentoId, folio);
            });
        }
    });
});
