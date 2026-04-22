// =============================================
// CONFIGURACIÓN Y VARIABLES
// =============================================
let isUpdating = false;
let currentPage = 1;
let totalPages = 1;
let itemsPerPage = 10;
let allData = [];
let searchTerm = '';
let filteredData = [];
const API_BASE = '/Aaapumac/Gestion';
const LOADING_TIMEOUT = 30000;
const ACTION_TIMEOUT = 15000;

// =============================================
// UTILIDADES
// =============================================
const showGlobalLoading = show => {
    const overlay = document.getElementById('global-loading');
    if (overlay) overlay.style.display = show ? 'flex' : 'none';
};

const showNotification = (type, message, duration = 5000) => {
    document.querySelectorAll('.custom-notification').forEach(n => n.remove());
    
    const icons = {
        success: 'mdi-check-circle',
        error: 'mdi-alert-circle', 
        warning: 'mdi-alert',
        info: 'mdi-information'
    };
    
    const notification = document.createElement('div');
    notification.className = `alert alert-${type} alert-dismissible fade show custom-notification`;
    notification.innerHTML = `
        <div class="d-flex align-items-center">
            <i class="mdi ${icons[type] || 'mdi-bell'} me-2" style="font-size: 20px;"></i>
            <div class="flex-grow-1">${message}</div>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
    
    document.body.appendChild(notification);
    setTimeout(() => notification.remove(), duration);
};

const fetchWithTimeout = async (url, options = {}, timeout = LOADING_TIMEOUT) => {
    const controller = new AbortController();
    const timeoutId = setTimeout(() => controller.abort(), timeout);
    
    try {
        const response = await fetch(url, {
            ...options,
            signal: controller.signal,
            headers: { 'Cache-Control': 'no-cache', 'Pragma': 'no-cache', ...options.headers }
        });
        clearTimeout(timeoutId);
        return response;
    } catch (error) {
        clearTimeout(timeoutId);
        throw error;
    }
};

// =============================================
// FUNCIONES DE BÚSQUEDA
// =============================================
function performSearch() {
    searchTerm = document.getElementById('search-input').value.trim().toLowerCase();
    const clearBtn = document.getElementById('clear-search-btn');
    
    if (clearBtn) {
        clearBtn.style.display = searchTerm ? 'block' : 'none';
    }
    
    if (searchTerm) {
        // Filtrar datos locales
        filteredData = allData.filter(item => {
            const token = (item.Token || '').toLowerCase();
            const patente = (item.patente || '').toLowerCase();
            const nombre = (item.nombre_completo || '').toLowerCase();
            const folio = ((item.folios_aduana || '') + '').toLowerCase();
            
            return token.includes(searchTerm) || 
                   patente.includes(searchTerm) || 
                   nombre.includes(searchTerm) || 
                   folio.includes(searchTerm);
        });
        
        // Mostrar mensaje si no hay resultados
        const noResultsDiv = document.getElementById('search-no-results');
        const noDataDiv = document.getElementById('no-data');
        const searchTermDisplay = document.getElementById('search-term-display');
        
        if (filteredData.length === 0) {
            if (noResultsDiv) {
                noResultsDiv.style.display = 'block';
                if (searchTermDisplay) {
                    searchTermDisplay.textContent = searchTerm;
                }
            }
            if (noDataDiv) {
                noDataDiv.style.display = 'none';
            }
        } else {
            if (noResultsDiv) {
                noResultsDiv.style.display = 'none';
            }
            if (noDataDiv) {
                noDataDiv.style.display = 'none';
            }
        }
        
        // Renderizar datos filtrados
        currentPage = 1;
        totalPages = Math.ceil(filteredData.length / itemsPerPage);
        renderTableRows(getCurrentPageData());
        renderPagination();
        updateRecordsCounter();
        
    } else {
        // Si no hay término de búsqueda, mostrar todos los datos
        clearSearch();
    }
}

function clearSearch() {
    const searchInput = document.getElementById('search-input');
    const clearBtn = document.getElementById('clear-search-btn');
    const noResultsDiv = document.getElementById('search-no-results');
    
    if (searchInput) searchInput.value = '';
    if (clearBtn) clearBtn.style.display = 'none';
    if (noResultsDiv) noResultsDiv.style.display = 'none';
    
    searchTerm = '';
    filteredData = [...allData];
    
    // Volver a mostrar todos los datos
    currentPage = 1;
    totalPages = Math.ceil(allData.length / itemsPerPage);
    renderTableRows(getCurrentPageData());
    renderPagination();
    updateRecordsCounter();
}

// =============================================
// FUNCIONES DE PAGINACIÓN
// =============================================
function renderPagination() {
    const paginationContainer = document.getElementById('pagination-container');
    if (!paginationContainer) return;
    
    const dataLength = searchTerm && filteredData.length > 0 ? filteredData.length : allData.length;
    totalPages = Math.ceil(dataLength / itemsPerPage);
    
    if (totalPages <= 1) {
        paginationContainer.innerHTML = '';
        return;
    }
    
    let paginationHTML = `
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center mb-0">
    `;
    
    // Botón Anterior
    paginationHTML += `
        <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
            <a class="page-link" href="#" ${currentPage === 1 ? 'tabindex="-1"' : ''} onclick="changePage(${currentPage - 1})">
                <i class="mdi mdi-chevron-left"></i>
            </a>
        </li>
    `;
    
    // Mostrar números de página
    const maxVisiblePages = 5;
    let startPage = Math.max(1, currentPage - Math.floor(maxVisiblePages / 2));
    let endPage = Math.min(totalPages, startPage + maxVisiblePages - 1);
    
    if (endPage - startPage + 1 < maxVisiblePages) {
        startPage = Math.max(1, endPage - maxVisiblePages + 1);
    }
    
    for (let i = startPage; i <= endPage; i++) {
        paginationHTML += `
            <li class="page-item ${currentPage === i ? 'active' : ''}">
                <a class="page-link" href="#" onclick="changePage(${i})">${i}</a>
            </li>
        `;
    }
    
    // Botón Siguiente
    paginationHTML += `
        <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
            <a class="page-link" href="#" ${currentPage === totalPages ? 'tabindex="-1"' : ''} onclick="changePage(${currentPage + 1})">
                <i class="mdi mdi-chevron-right"></i>
            </a>
        </li>
    `;
    
    paginationHTML += `
            </ul>
        </nav>
        <div class="text-center mt-2">
            <small class="text-muted">
                Página ${currentPage} de ${totalPages} | 
                Mostrando ${getCurrentPageData().length} de ${dataLength} registros
                ${searchTerm ? '(búsqueda activa)' : ''}
            </small>
        </div>
    `;
    
    paginationContainer.innerHTML = paginationHTML;
}

function getCurrentPageData() {
    const startIndex = (currentPage - 1) * itemsPerPage;
    const endIndex = startIndex + itemsPerPage;
    
    if (searchTerm && filteredData.length > 0) {
        return filteredData.slice(startIndex, endIndex);
    }
    
    return allData.slice(startIndex, endIndex);
}

function changePage(page) {
    if (page < 1 || page > totalPages || page === currentPage) return;
    
    currentPage = page;
    renderTableRows(getCurrentPageData());
    renderPagination();
    updateItemsPerPageSelector();
    
    // Scroll suave hacia la tabla
    const table = document.getElementById('folios-table');
    if (table) {
        table.scrollIntoView({ behavior: 'smooth', block: 'start' });
    }
}

function updateItemsPerPageSelector() {
    const selector = document.getElementById('items-per-page');
    if (selector) {
        selector.value = itemsPerPage;
    }
}

function changeItemsPerPage(value) {
    itemsPerPage = parseInt(value);
    currentPage = 1;
    
    // Recalcular totalPages basado en si hay búsqueda o no
    const dataLength = searchTerm && filteredData.length > 0 ? filteredData.length : allData.length;
    totalPages = Math.ceil(dataLength / itemsPerPage);
    
    renderTableRows(getCurrentPageData());
    renderPagination();
    updateItemsPerPageSelector();
}

// =============================================
// FUNCIONES PRINCIPALES
// =============================================
async function loadTableData() {
    if (isUpdating) return;
    isUpdating = true;
    
    const elements = {
        tableBody: document.getElementById('table-body'),
        loading: document.getElementById('loading-spinner'),
        noData: document.getElementById('no-data'),
        errorMsg: document.getElementById('error-message')
    };
    
    // Reset UI
    elements.loading.style.display = 'flex';
    elements.noData.style.display = 'none';
    elements.errorMsg.style.display = 'none';
    elements.tableBody.innerHTML = '';
    
    // Ocultar mensaje de búsqueda sin resultados
    const noResultsDiv = document.getElementById('search-no-results');
    if (noResultsDiv) {
        noResultsDiv.style.display = 'none';
    }
    
    // Ocultar paginación mientras carga
    const paginationContainer = document.getElementById('pagination-container');
    if (paginationContainer) {
        paginationContainer.innerHTML = '';
    }
    
    try {
        const response = await fetchWithTimeout(`${API_BASE}/getFoliosAjax`);
        if (!response.ok) throw new Error(`Error HTTP ${response.status}`);
        
        const result = await response.json();
        elements.loading.style.display = 'none';
        
        if (result.success && result.data?.length > 0) {
            allData = result.data;
            filteredData = [...allData]; // Inicializar filteredData con todos los datos
            
            // Si hay búsqueda activa, aplicar filtro
            if (searchTerm) {
                filteredData = allData.filter(item => {
                    const token = (item.Token || '').toLowerCase();
                    const patente = (item.patente || '').toLowerCase();
                    const nombre = (item.nombre_completo || '').toLowerCase();
                    const folio = ((item.folios_aduana || '') + '').toLowerCase();
                    
                    return token.includes(searchTerm) || 
                           patente.includes(searchTerm) || 
                           nombre.includes(searchTerm) || 
                           folio.includes(searchTerm);
                });
            }
            
            const dataLength = searchTerm ? filteredData.length : allData.length;
            totalPages = Math.ceil(dataLength / itemsPerPage);
            
            // Asegurar que currentPage sea válido
            if (currentPage > totalPages) {
                currentPage = totalPages || 1;
            }
            
            renderTableRows(getCurrentPageData());
            renderPagination();
            updateItemsPerPageSelector();
            
            // Mostrar/ocultar mensajes según resultados
            if (searchTerm && filteredData.length === 0) {
                const searchTermDisplay = document.getElementById('search-term-display');
                if (noResultsDiv && searchTermDisplay) {
                    noResultsDiv.style.display = 'block';
                    searchTermDisplay.textContent = searchTerm;
                }
            } else if (dataLength === 0) {
                showNoData(elements.noData, result.message);
            }
            
        } else {
            showNoData(elements.noData, result.message);
            allData = [];
            filteredData = [];
            totalPages = 1;
            currentPage = 1;
            renderPagination();
        }
    } catch (error) {
        handleLoadError(error, elements);
        allData = [];
        filteredData = [];
        totalPages = 1;
        currentPage = 1;
        renderPagination();
    } finally {
        isUpdating = false;
    }
}

function updateRecordsCounter() {
    const counter = document.getElementById('records-counter');
    if (counter) {
        const dataLength = searchTerm && filteredData.length > 0 ? filteredData.length : allData.length;
        const start = (currentPage - 1) * itemsPerPage + 1;
        const end = Math.min(currentPage * itemsPerPage, dataLength);
        
        let counterText = `Mostrando ${start}-${end} de ${dataLength} registros`;
        if (searchTerm && filteredData.length > 0) {
            counterText += ` (filtrados de ${allData.length} totales)`;
        }
        
        counter.textContent = counterText;
    }
}

function renderTableRows(data) {
    const tableBody = document.getElementById('table-body');
    tableBody.innerHTML = '';
    
    if (data.length === 0) {
        const row = document.createElement('tr');
        row.innerHTML = `
            <td colspan="7" class="text-center py-4">
                <i class="mdi mdi-inbox-outline" style="font-size: 48px; color: #6c757d;"></i>
                <p class="mt-2">No hay datos para mostrar</p>
            </td>
        `;
        tableBody.appendChild(row);
        return;
    }
    
    data.forEach((pedimento, index) => {
        const row = document.createElement('tr');
        row.className = 'new-row';
        row.style.animationDelay = `${index * 0.05}s`;
        row.innerHTML = createTableRowHTML(pedimento);
        tableBody.appendChild(row);
    });
    
    updateRecordsCounter();
}

function createTableRowHTML(pedimento) {
    const folioAduana = pedimento.folios_aduana || '';
    const tokenEscaped = (pedimento.Token || '').replace(/'/g, "\\'");
    
    return `
        <td>
            <div class="dropdown">
                <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" 
                        data-bs-toggle="dropdown" aria-expanded="false">
                    Acciones
                </button>
                <ul class="dropdown-menu">
                    <li>
                        <a class="dropdown-item asignar-folio-btn" href="#" data-id="${pedimento.id}" data-token="${tokenEscaped}">
                            <i class="mdi mdi-plus-circle-outline text-success me-2"></i>
                            Asignar Folio
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item rechazar-folio-btn" href="#" data-id="${pedimento.id}" data-token="${tokenEscaped}">
                            <i class="mdi mdi-close-circle-outline text-danger me-2"></i>
                            Rechazar Folio
                        </a>
                    </li>
                </ul>
            </div>
        </td>
        <td><code>${pedimento.Token || ''}</code></td>
        <td>${pedimento.patente || ''}</td>
        <td>${pedimento.nombre_completo || ''}</td>
        <td>
            ${folioAduana ? 
                `<span class="badge bg-info">${folioAduana}</span>` : 
                '<span class="badge bg-secondary">Sin folio</span>'}
        </td>
        <td>${pedimento.fecha || ''}</td>
        <td>${getStatusBadge(pedimento.Estatus)}</td>
    `;
}

function getStatusBadge(status) {
    const statusMap = {
        '1': '<span class="badge bg-success">Activo</span>',
        '2': '<span class="badge bg-primary">Aduana</span>',
        '3': '<span class="badge bg-warning">Pendiente</span>'
    };
    return statusMap[status] || '<span class="badge bg-secondary">Desconocido</span>';
}

function showNoData(element, message) {
    element.style.display = 'block';
    element.innerHTML = `
        <i class="mdi mdi-inbox-outline" style="font-size: 48px; color: #6c757d;"></i>
        <p class="mt-2">${message || 'No hay folios registrados'}</p>
    `;
}

function handleLoadError(error, elements) {
    console.error('Error al cargar datos:', error);
    elements.loading.style.display = 'none';
    elements.errorMsg.style.display = 'block';
    
    let errorMessage = 'Error al cargar los datos';
    if (error.name === 'AbortError') {
        errorMessage = 'Tiempo de espera agotado. El servidor está tardando demasiado.';
    } else if (error.message.includes('Failed to fetch')) {
        errorMessage = 'Error de conexión. Verifica tu internet.';
    }
    
    elements.errorMsg.querySelector('p').textContent = errorMessage;
}

// =============================================
// FUNCIÓN PARA CERRAR MODALES (INFALIBLE)
// =============================================
function cerrarModalInfalible(modalId) {
    console.log(`Intentando cerrar modal: ${modalId}`);
    
    // Opción 1: Si jQuery está disponible, usarlo
    if (typeof $ !== 'undefined' && $.fn.modal) {
        $(`#${modalId}`).modal('hide');
        console.log(`Modal ${modalId} cerrado con jQuery`);
        return;
    }
    
    const modalElement = document.getElementById(modalId);
    if (!modalElement) {
        console.warn(`Modal ${modalId} no encontrado`);
        return;
    }
    
    // Opción 2: Bootstrap 5
    if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
        const modalInstance = bootstrap.Modal.getInstance(modalElement);
        if (modalInstance) {
            modalInstance.hide();
            console.log(`Modal ${modalId} cerrado con Bootstrap.getInstance()`);
        } else {
            // Si no hay instancia, crear una y cerrarla
            try {
                const newModal = new bootstrap.Modal(modalElement);
                newModal.hide();
                console.log(`Modal ${modalId} cerrado con nueva instancia Bootstrap`);
            } catch (error) {
                console.warn('Error con Bootstrap, usando método manual:', error);
                cerrarModalManual(modalElement);
            }
        }
    } else {
        // Opción 3: Método manual directo
        cerrarModalManual(modalElement);
    }
}

function cerrarModalManual(modalElement) {
    // Remover clases de Bootstrap
    modalElement.classList.remove('show');
    modalElement.setAttribute('aria-hidden', 'true');
    modalElement.style.display = 'none';
    
    // Restaurar body
    document.body.classList.remove('modal-open');
    document.body.style.overflow = '';
    document.body.style.paddingRight = '';
    
    // Remover backdrop
    const backdrop = document.querySelector('.modal-backdrop');
    if (backdrop) {
        backdrop.classList.remove('show');
        backdrop.remove();
    }
    
    // Forzar reflow
    void modalElement.offsetWidth;
    
    console.log('Modal cerrado manualmente');
}

// =============================================
// FUNCIONES DE MODALES
// =============================================
function openModal(id, token, modalType, focusElementId = null) {
    if (!id || id <= 0) {
        Swal.fire('Error', 'ID de pedimento inválido', 'error');
        return;
    }
    
    // Configurar valores según el tipo de modal
    if (modalType === 'asignar') {
        document.getElementById('asignar_pedimento_id').value = id;
        document.getElementById('asignar_modal_token_display').textContent = token || '-';
        document.getElementById('asignar_folio_aduana').value = '';
    } else if (modalType === 'rechazar') {
        document.getElementById('rechazar_pedimento_id').value = id;
        document.getElementById('motivo_rechazo').value = '';
    }
    
    try {
        const modalId = modalType === 'asignar' ? 'asignarFolioModal' : 'rechazarModal';
        const modalElement = document.getElementById(modalId);
        
        if (!modalElement) {
            console.error(`Modal ${modalId} no encontrado`);
            return;
        }
        
        // Asegurarse de cerrar cualquier modal abierto
        cerrarModalInfalible('asignarFolioModal');
        cerrarModalInfalible('rechazarModal');
        
        // Pequeña pausa antes de abrir el nuevo modal
        setTimeout(() => {
            const modal = bootstrap.Modal.getOrCreateInstance(modalElement);
            modal.show();
            
            if (focusElementId) {
                setTimeout(() => {
                    const element = document.getElementById(focusElementId);
                    if (element) element.focus();
                }, 300);
            }
        }, 50);
        
    } catch (error) {
        console.error('Error al mostrar modal:', error);
        Swal.fire('Error', 'No se pudo abrir el modal', 'error');
    }
}

// =============================================
// MANEJADORES DE FORMULARIOS
// =============================================
async function handleAsignarFolio() {
    const pedimentoId = document.getElementById('asignar_pedimento_id').value;
    const folio = document.getElementById('asignar_folio_aduana').value.trim();
    
    if (!folio) {
        Swal.fire('Error', 'Ingresa un folio válido', 'error');
        return;
    }
    
    const confirmResult = await Swal.fire({
        title: '¿Asignar folio?',
        text: `¿Asignar folio "${folio}"?`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Sí, asignar',
        cancelButtonText: 'Cancelar'
    });
    
    if (!confirmResult.isConfirmed) return;
    
    showGlobalLoading(true);
    
    try {
        const formData = new FormData();
        formData.append('pedimento_id', pedimentoId);
        formData.append('folio_aduana', folio);
        
        const response = await fetchWithTimeout(`${API_BASE}/agregaFolio`, {
            method: 'POST',
            body: formData
        }, ACTION_TIMEOUT);
        
        const data = await response.json();
        
        if (data.success) {
            // CERRAR MODAL PRIMERO, LUEGO MOSTRAR SweetAlert
            cerrarModalInfalible('asignarFolioModal');
            
            // Pequeño delay para asegurar que el modal se cerró
            setTimeout(async () => {
                await Swal.fire({ 
                    icon: 'success', 
                    title: '¡Éxito!', 
                    text: data.message, 
                    showConfirmButton: false,
                    timer: 1500 
                });
                
                if (data.notificacion_creada) {
                    showNotification('info', `Folio asignado al asociado (ID: ${data.user_id_asociado})`, 4000);
                }
                
                // Recargar datos
                loadTableData();
            }, 300);
            
        } else {
            Swal.fire('Error', data.message || 'Error desconocido', 'error');
        }
    } catch (error) {
        const errorMsg = error.name === 'AbortError' 
            ? 'El servidor tardó demasiado en responder.' 
            : 'Error de conexión';
        Swal.fire('Error', errorMsg, 'error');
    } finally {
        showGlobalLoading(false);
    }
}

// =============================================
// CONFIGURACIÓN DE EVENTOS
// =============================================
function setupEventListeners() {
    // Botón asignar folio
    const asignarBtn = document.getElementById('submit-asignar-folio-btn');
    if (asignarBtn) {
        // Eliminar event listeners anteriores
        const newAsignarBtn = asignarBtn.cloneNode(true);
        asignarBtn.parentNode.replaceChild(newAsignarBtn, asignarBtn);
        
        // Agregar nuevo event listener
        newAsignarBtn.addEventListener('click', handleAsignarFolio);
    }
    
    // Event Listeners para búsqueda
    const searchInput = document.getElementById('search-input');
    const searchBtn = document.getElementById('search-btn');
    const clearSearchBtn = document.getElementById('clear-search-btn');
    const clearSearchBtn2 = document.getElementById('clear-search-btn-2');
    
    // Buscar con botón
    if (searchBtn) {
        searchBtn.addEventListener('click', performSearch);
    }
    
    // Buscar con Enter
    if (searchInput) {
        searchInput.addEventListener('keypress', (e) => {
            if (e.key === 'Enter') {
                performSearch();
            }
        });
        
        // Mostrar/ocultar botón de limpiar
        searchInput.addEventListener('input', function() {
            const clearBtn = document.getElementById('clear-search-btn');
            if (clearBtn) {
                clearBtn.style.display = this.value.trim() ? 'block' : 'none';
            }
        });
    }
    
    // Limpiar búsqueda con botón X
    if (clearSearchBtn) {
        clearSearchBtn.addEventListener('click', clearSearch);
    }
    
    // Limpiar búsqueda desde mensaje de no resultados
    if (clearSearchBtn2) {
        clearSearchBtn2.addEventListener('click', clearSearch);
    }
    
    // Formulario rechazar folio
    document.getElementById('formRechazarFolio')?.addEventListener('submit', async (e) => {
        e.preventDefault();
        
        const pedimentoId = document.getElementById('rechazar_pedimento_id').value;
        const motivo = document.getElementById('motivo_rechazo').value.trim();
        
        if (!motivo) {
            Swal.fire('Error', 'Ingresa el motivo del rechazo', 'error');
            return;
        }
        
        const confirmResult = await Swal.fire({
            title: '¿Rechazar folio?',
            text: 'Esta acción no se puede deshacer',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, rechazar',
            cancelButtonText: 'Cancelar',
            confirmButtonColor: '#dc3545'
        });
        
        if (!confirmResult.isConfirmed) return;
        
        showGlobalLoading(true);
        
        try {
            const formData = new FormData();
            formData.append('pedimento_id', pedimentoId);
            formData.append('motivo_rechazo', motivo);
            
            const response = await fetchWithTimeout(`${API_BASE}/rechazarFolio`, {
                method: 'POST',
                body: formData
            }, ACTION_TIMEOUT);
            
            const data = await response.json();
            
            if (data.success) {
                // CERRAR MODAL PRIMERO
                cerrarModalInfalible('rechazarModal');
                
                // Pequeño delay
                setTimeout(async () => {
                    await Swal.fire({ 
                        icon: 'success', 
                        title: '¡Rechazado!', 
                        text: data.message, 
                        showConfirmButton: false,
                        timer: 1500 
                    });
                    
                    loadTableData();
                }, 300);
                
            } else {
                Swal.fire('Error', data.message || 'Error al rechazar', 'error');
            }
        } catch (error) {
            const errorMsg = error.name === 'AbortError' 
                ? 'El servidor tardó demasiado en responder.' 
                : 'Error de conexión';
            Swal.fire('Error', errorMsg, 'error');
        } finally {
            showGlobalLoading(false);
        }
    });
    
    // Botón reintentar
    document.getElementById('retry-btn')?.addEventListener('click', () => {
        loadTableData();
        showNotification('info', 'Recargando datos...', 2000);
    });
    
    // Enter en input de folio
    document.getElementById('asignar_folio_aduana')?.addEventListener('keypress', (e) => {
        if (e.key === 'Enter') {
            e.preventDefault();
            handleAsignarFolio();
        }
    });
    
    // Selector de items por página
    const itemsPerPageSelector = document.getElementById('items-per-page');
    if (itemsPerPageSelector) {
        itemsPerPageSelector.addEventListener('change', (e) => {
            changeItemsPerPage(e.target.value);
        });
    }
    
    // Limpiar formularios al cerrar modales
    ['asignarFolioModal', 'rechazarModal'].forEach(modalId => {
        document.getElementById(modalId)?.addEventListener('hidden.bs.modal', () => {
            const form = document.querySelector(`#${modalId} form`);
            if (form) form.reset();
            
            if (modalId === 'asignarFolioModal') {
                document.getElementById('asignar_modal_token_display').textContent = '-';
            }
        });
    });
    
    // Delegación de eventos para los botones del dropdown
    document.addEventListener('click', function(e) {
        // Botón Asignar Folio
        if (e.target.closest('.asignar-folio-btn')) {
            e.preventDefault();
            const btn = e.target.closest('.asignar-folio-btn');
            const id = btn.getAttribute('data-id');
            const token = btn.getAttribute('data-token');
            openModal(id, token, 'asignar', 'asignar_folio_aduana');
        }
        
        // Botón Rechazar Folio
        if (e.target.closest('.rechazar-folio-btn')) {
            e.preventDefault();
            const btn = e.target.closest('.rechazar-folio-btn');
            const id = btn.getAttribute('data-id');
            const token = btn.getAttribute('data-token');
            openModal(id, token, 'rechazar', 'motivo_rechazo');
        }
    });
}

// =============================================
// INICIALIZACIÓN
// =============================================
async function verificarTablaNotificaciones() {
    try {
        const response = await fetch(`${API_BASE}/debugNotificaciones`);
        const data = await response.json();
        
        if (!data.tabla_existe) {
            showNotification('warning', 
                'La tabla de notificaciones no existe. Las notificaciones no se enviarán a los asociados.', 
                8000);
        }
    } catch (error) {
        console.error('Error verificando tabla:', error);
    }
}

document.addEventListener('DOMContentLoaded', function() {
    if (typeof bootstrap === 'undefined') {
        alert('Error: Bootstrap no se cargó correctamente.');
        return;
    }
    
    // Configurar eventos
    setupEventListeners();
    
    // Cargar datos iniciales
    setTimeout(loadTableData, 500);
    
    // Verificar notificaciones
    setTimeout(verificarTablaNotificaciones, 1000);
    
    // Recarga automática
    setInterval(() => !document.hidden && loadTableData(), 60000);
    
    // Recargar al enfocar ventana
    let isWindowFocused = true;
    window.addEventListener('focus', () => {
        if (!isWindowFocused) {
            loadTableData();
            isWindowFocused = true;
        }
    });
    
    window.addEventListener('blur', () => {
        isWindowFocused = false;
    });
});

// =============================================
// FUNCIONES GLOBALES
// =============================================
// Hacer las funciones disponibles globalmente
window.asignarFolio = function(id, token) {
    openModal(id, token, 'asignar', 'asignar_folio_aduana');
};

window.rechazarFolio = function(id, token) {
    openModal(id, token, 'rechazar', 'motivo_rechazo');
};

// Funciones de paginación disponibles globalmente
window.changePage = changePage;
window.changeItemsPerPage = changeItemsPerPage;

// Funciones de búsqueda disponibles globalmente
window.performSearch = performSearch;
window.clearSearch = clearSearch;

// Función de debug
window.verificarModal = function(modalId) {
    const modal = document.getElementById(modalId);
    console.log(`Modal ${modalId}:`, modal);
    console.log('Está visible?', modal?.classList.contains('show'));
    console.log('Instancia Bootstrap:', bootstrap.Modal.getInstance(modal));
};