<?php
// Obtener datos de la respuesta
$title = $answer['data']['title'] ?? 'Notificaciones';
$subtitle = $answer['data']['subtitle'] ?? 'Tus notificaciones';
$notificaciones = $answer['data']['notificaciones'] ?? [];
$no_leidas = $answer['data']['no_leidas'] ?? 0;

// Contar notificaciones vistas
$vistas_count = count(array_filter($notificaciones, function($notif) {
    return $notif->is_read;
}));

// Obtener parámetros de paginación
$pagina_pendientes = isset($_GET['p_page']) ? max(1, intval($_GET['p_page'])) : 1;
$pagina_vistas = isset($_GET['v_page']) ? max(1, intval($_GET['v_page'])) : 1;
?>
<link rel="stylesheet" href="/Aaapumac/src/views/assets/css/notificaciones.css">
<div class="container-fluid px-0">
    <!-- Header limpio -->
    <div class="notification-header px-4 py-4 border-bottom">
        <div class="d-flex justify-content-between align-items-center">
            <div>
                <h1 class="h3 mb-1 text-dark">
                    <i class="mdi mdi-bell-outline text-primary me-2"></i>
                    <?php echo htmlspecialchars($title); ?>
                </h1>
                <p class="text-muted small mb-0">
                    <?php echo htmlspecialchars($subtitle); ?>
                    <?php if ($no_leidas > 0): ?>
                        <span class="badge bg-primary ms-2" id="header-badge"><?php echo $no_leidas; ?> nuevas</span>
                    <?php endif; ?>
                </p>
            </div>
            
            <!-- Botones de acción y depuración -->
            <div class="d-flex gap-2">
                <?php if ($no_leidas > 0): ?>
                    <button id="marcar-todas" class="btn btn-outline-primary btn-sm">
                        <i class="mdi mdi-check-all me-1"></i> Marcar todas
                    </button>
                <?php endif; ?>
                
        </div>
        
        <!-- Pestañas -->
        <div class="notification-tabs mt-3">
            <div class="nav nav-tabs border-0">
                <button class="nav-link active" id="pendientes-tab" data-bs-toggle="tab" data-bs-target="#pendientes" type="button">
                    <i class="mdi mdi-clock-outline me-1"></i>
                    Pendientes
                    <?php if ($no_leidas > 0): ?>
                        <span class="badge bg-primary ms-1" id="pendientes-badge"><?php echo $no_leidas; ?></span>
                    <?php endif; ?>
                </button>
                <button class="nav-link" id="vistas-tab" data-bs-toggle="tab" data-bs-target="#vistas" type="button">
                    <i class="mdi mdi-check-circle-outline me-1"></i>
                    Vistas
                    <?php if ($vistas_count > 0): ?>
                        <span class="badge bg-secondary ms-1" id="vistas-badge"><?php echo $vistas_count; ?></span>
                    <?php endif; ?>
                </button>
            </div>
        </div>
    </div>

    <!-- Contenido de pestañas -->
    <div class="tab-content">
        <!-- Pestaña Pendientes -->
        <div class="tab-pane fade show active" id="pendientes" role="tabpanel">
            <div class="notification-list px-4 py-3">
                <?php 
                // Separar notificaciones pendientes
                $pendientes = array_filter($notificaciones, function($notif) {
                    return !$notif->is_read;
                });
                
                // Configuración de paginación
                $pendientes_por_pagina = 10;
                $total_pendientes = count($pendientes);
                $total_paginas_pendientes = ceil($total_pendientes / $pendientes_por_pagina);
                $inicio_pendientes = ($pagina_pendientes - 1) * $pendientes_por_pagina;
                $pendientes_paginados = array_slice($pendientes, $inicio_pendientes, $pendientes_por_pagina);
                ?>
                
                <?php if (empty($pendientes)): ?>
                    <!-- Estado vacío para pendientes -->
                    <div class="text-center py-5">
                        <div class="mb-3">
                            <i class="mdi mdi-check-circle text-muted" style="font-size: 48px;"></i>
                        </div>
                        <h4 class="text-muted mb-2">Sin pendientes</h4>
                        <p class="text-muted small">Todas las notificaciones están vistas</p>
                    </div>
                <?php else: ?>
                    <!-- Notificaciones pendientes -->
                    <?php foreach ($pendientes_paginados as $notif): ?>
                        <div class="notification-item border-bottom py-3 notification-unread" data-id="<?php echo $notif->id; ?>">
                            <div class="d-flex">
                                <!-- Indicador de estado -->
                                <div class="me-3">
                                    <div class="unread-dot bg-primary"></div>
                                </div>
                                
                                <!-- Contenido -->
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-start mb-1">
                                        <h6 class="mb-0 text-dark">
                                            <?php echo htmlspecialchars($notif->title); ?>
                                        </h6>
                                        <span class="text-muted small">
                                            <?php echo date('d/m H:i', strtotime($notif->created_at)); ?>
                                        </span>
                                    </div>
                                    
                                    <p class="mb-2 text-muted small">
                                        <?php echo $notif->message; ?>
                                    </p>
                                    
                                    <!-- Mostrar tipo de notificación -->
                                    <?php if (!empty($notif->tipo)): ?>
                                        <div class="mb-2">
                                            <span class="badge bg-info"><?php echo htmlspecialchars($notif->tipo); ?></span>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <!-- Acciones mínimas -->
                                    <div class="mt-2">
                                        <button class="btn btn-link btn-sm text-decoration-none marcar-leida p-0 text-primary" 
                                                data-id="<?php echo $notif->id; ?>">
                                            <i class="mdi mdi-check me-1" style="font-size: 12px;"></i>
                                            Marcar como leída
                                        </button>
                                        
                                        <?php if ($notif->id_related_record): ?>
                                            <a href="/Aaapumac/asociado/verPedimento?id=<?php echo $notif->id_related_record; ?>" 
                                               class="btn btn-link btn-sm text-decoration-none p-0 text-muted ms-3">
                                                <i class="mdi mdi-link me-1" style="font-size: 12px;"></i>
                                                Ver pedimento
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    
                    <!-- Paginación para Pendientes -->
                    <?php if ($total_paginas_pendientes > 1): ?>
                        <div class="mt-4 pt-3 border-top">
                            <nav aria-label="Paginación de notificaciones pendientes">
                                <ul class="pagination justify-content-center pagination-sm mb-0">
                                    <!-- Botón Anterior -->
                                    <li class="page-item <?php echo $pagina_pendientes == 1 ? 'disabled' : ''; ?>">
                                        <a class="page-link text-muted" 
                                           href="?p_page=<?php echo $pagina_pendientes - 1; ?>&v_page=<?php echo $pagina_vistas; ?>" 
                                           <?php if ($pagina_pendientes == 1): ?>tabindex="-1" aria-disabled="true"<?php endif; ?>>
                                            <i class="mdi mdi-chevron-left" style="font-size: 14px;"></i>
                                        </a>
                                    </li>
                                    
                                    <!-- Números de página -->
                                    <?php 
                                    $max_paginas_mostrar = 5;
                                    $inicio_paginas = max(1, $pagina_pendientes - floor($max_paginas_mostrar / 2));
                                    $fin_paginas = min($total_paginas_pendientes, $inicio_paginas + $max_paginas_mostrar - 1);
                                    
                                    if ($inicio_paginas > 1): ?>
                                        <li class="page-item">
                                            <a class="page-link text-muted" href="?p_page=1&v_page=<?php echo $pagina_vistas; ?>">1</a>
                                        </li>
                                        <?php if ($inicio_paginas > 2): ?>
                                            <li class="page-item disabled">
                                                <span class="page-link">...</span>
                                            </li>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    
                                    <?php for ($i = $inicio_paginas; $i <= $fin_paginas; $i++): ?>
                                        <li class="page-item <?php echo $i == $pagina_pendientes ? 'active' : ''; ?>">
                                            <a class="page-link <?php echo $i == $pagina_pendientes ? 'text-white' : 'text-muted'; ?>" 
                                               href="?p_page=<?php echo $i; ?>&v_page=<?php echo $pagina_vistas; ?>">
                                                <?php echo $i; ?>
                                            </a>
                                        </li>
                                    <?php endfor; ?>
                                    
                                    <?php if ($fin_paginas < $total_paginas_pendientes): ?>
                                        <?php if ($fin_paginas < $total_paginas_pendientes - 1): ?>
                                            <li class="page-item disabled">
                                                <span class="page-link">...</span>
                                            </li>
                                        <?php endif; ?>
                                        <li class="page-item">
                                            <a class="page-link text-muted" href="?p_page=<?php echo $total_paginas_pendientes; ?>&v_page=<?php echo $pagina_vistas; ?>">
                                                <?php echo $total_paginas_pendientes; ?>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    
                                    <!-- Botón Siguiente -->
                                    <li class="page-item <?php echo $pagina_pendientes == $total_paginas_pendientes ? 'disabled' : ''; ?>">
                                        <a class="page-link text-muted" 
                                           href="?p_page=<?php echo $pagina_pendientes + 1; ?>&v_page=<?php echo $pagina_vistas; ?>" 
                                           <?php if ($pagina_pendientes == $total_paginas_pendientes): ?>tabindex="-1" aria-disabled="true"<?php endif; ?>>
                                            <i class="mdi mdi-chevron-right" style="font-size: 14px;"></i>
                                        </a>
                                    </li>
                                </ul>
                                
                                <!-- Información de página -->
                                <p class="text-center text-muted small mt-2 mb-0">
                                    Mostrando <?php echo count($pendientes_paginados); ?> de <?php echo $total_pendientes; ?> notificaciones pendientes
                                </p>
                            </nav>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
        
        <!-- Pestaña Vistas -->
        <div class="tab-pane fade" id="vistas" role="tabpanel">
            <div class="notification-list px-4 py-3">
                <?php 
                // Separar notificaciones vistas
                $vistas = array_filter($notificaciones, function($notif) {
                    return $notif->is_read;
                });
                
                // Configuración de paginación
                $vistas_por_pagina = 10;
                $total_vistas = count($vistas);
                $total_paginas_vistas = ceil($total_vistas / $vistas_por_pagina);
                $inicio_vistas = ($pagina_vistas - 1) * $vistas_por_pagina;
                $vistas_paginados = array_slice($vistas, $inicio_vistas, $vistas_por_pagina);
                ?>
                
                <?php if (empty($vistas)): ?>
                    <!-- Estado vacío para vistas -->
                    <div class="text-center py-5">
                        <div class="mb-3">
                            <i class="mdi mdi-eye-off text-muted" style="font-size: 48px;"></i>
                        </div>
                        <h4 class="text-muted mb-2">Sin notificaciones vistas</h4>
                        <p class="text-muted small">No hay notificaciones marcadas como vistas</p>
                    </div>
                <?php else: ?>
                    <!-- Notificaciones vistas -->
                    <?php foreach ($vistas_paginados as $notif): ?>
                        <div class="notification-item border-bottom py-3" data-id="<?php echo $notif->id; ?>">
                            <div class="d-flex">
                                <!-- Indicador de estado -->
                                <div class="me-3">
                                    <div class="read-icon text-muted">
                                        <i class="mdi mdi-check" style="font-size: 14px;"></i>
                                    </div>
                                </div>
                                
                                <!-- Contenido -->
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-start mb-1">
                                        <h6 class="mb-0 text-dark">
                                            <?php echo htmlspecialchars($notif->title); ?>
                                        </h6>
                                        <span class="text-muted small">
                                            <?php echo date('d/m H:i', strtotime($notif->created_at)); ?>
                                        </span>
                                    </div>
                                    
                                    <p class="mb-2 text-muted small">
                                        <?php echo $notif->message; ?>
                                    </p>
                                    
                                    <!-- Mostrar tipo de notificación -->
                                    <?php if (!empty($notif->tipo)): ?>
                                        <div class="mb-2">
                                            <span class="badge bg-secondary"><?php echo htmlspecialchars($notif->tipo); ?></span>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <!-- Acciones mínimas -->
                                    <div class="mt-2">
                                        <?php if ($notif->id_related_record): ?>
                                            <a href="/Aaapumac/asociado/verPedimento?id=<?php echo $notif->id_related_record; ?>" 
                                               class="btn btn-link btn-sm text-decoration-none p-0 text-muted">
                                                <i class="mdi mdi-link me-1" style="font-size: 12px;"></i>
                                                Ver pedimento
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                    
                    <!-- Paginación para Vistas -->
                    <?php if ($total_paginas_vistas > 1): ?>
                        <div class="mt-4 pt-3 border-top">
                            <nav aria-label="Paginación de notificaciones vistas">
                                <ul class="pagination justify-content-center pagination-sm mb-0">
                                    <!-- Botón Anterior -->
                                    <li class="page-item <?php echo $pagina_vistas == 1 ? 'disabled' : ''; ?>">
                                        <a class="page-link text-muted" 
                                           href="?p_page=<?php echo $pagina_pendientes; ?>&v_page=<?php echo $pagina_vistas - 1; ?>" 
                                           <?php if ($pagina_vistas == 1): ?>tabindex="-1" aria-disabled="true"<?php endif; ?>>
                                            <i class="mdi mdi-chevron-left" style="font-size: 14px;"></i>
                                        </a>
                                    </li>
                                    
                                    <!-- Números de página -->
                                    <?php 
                                    $max_paginas_mostrar = 5;
                                    $inicio_paginas = max(1, $pagina_vistas - floor($max_paginas_mostrar / 2));
                                    $fin_paginas = min($total_paginas_vistas, $inicio_paginas + $max_paginas_mostrar - 1);
                                    
                                    if ($inicio_paginas > 1): ?>
                                        <li class="page-item">
                                            <a class="page-link text-muted" href="?p_page=<?php echo $pagina_pendientes; ?>&v_page=1">1</a>
                                        </li>
                                        <?php if ($inicio_paginas > 2): ?>
                                            <li class="page-item disabled">
                                                <span class="page-link">...</span>
                                            </li>
                                        <?php endif; ?>
                                    <?php endif; ?>
                                    
                                    <?php for ($i = $inicio_paginas; $i <= $fin_paginas; $i++): ?>
                                        <li class="page-item <?php echo $i == $pagina_vistas ? 'active' : ''; ?>">
                                            <a class="page-link <?php echo $i == $pagina_vistas ? 'text-white' : 'text-muted'; ?>" 
                                               href="?p_page=<?php echo $pagina_pendientes; ?>&v_page=<?php echo $i; ?>">
                                                <?php echo $i; ?>
                                            </a>
                                        </li>
                                    <?php endfor; ?>
                                    
                                    <?php if ($fin_paginas < $total_paginas_vistas): ?>
                                        <?php if ($fin_paginas < $total_paginas_vistas - 1): ?>
                                            <li class="page-item disabled">
                                                <span class="page-link">...</span>
                                            </li>
                                        <?php endif; ?>
                                        <li class="page-item">
                                            <a class="page-link text-muted" href="?p_page=<?php echo $pagina_pendientes; ?>&v_page=<?php echo $total_paginas_vistas; ?>">
                                                <?php echo $total_paginas_vistas; ?>
                                            </a>
                                        </li>
                                    <?php endif; ?>
                                    
                                    <!-- Botón Siguiente -->
                                    <li class="page-item <?php echo $pagina_vistas == $total_paginas_vistas ? 'disabled' : ''; ?>">
                                        <a class="page-link text-muted" 
                                           href="?p_page=<?php echo $pagina_pendientes; ?>&v_page=<?php echo $pagina_vistas + 1; ?>" 
                                           <?php if ($pagina_vistas == $total_paginas_vistas): ?>tabindex="-1" aria-disabled="true"<?php endif; ?>>
                                            <i class="mdi mdi-chevron-right" style="font-size: 14px;"></i>
                                        </a>
                                    </li>
                                </ul>
                                
                                <!-- Información de página -->
                                <p class="text-center text-muted small mt-2 mb-0">
                                    Mostrando <?php echo count($vistas_paginados); ?> de <?php echo $total_vistas; ?> notificaciones vistas
                                </p>
                            </nav>
                        </div>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Marcar notificación como leída
    document.querySelectorAll('.marcar-leida').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const notifId = this.getAttribute('data-id');
            const button = this;
            
            markNotificationAsRead(notifId, button);
        });
    });
    
    // Marcar todas como leídas
    const marcarTodasBtn = document.getElementById('marcar-todas');
    if (marcarTodasBtn) {
        marcarTodasBtn.addEventListener('click', function() {
            markAllNotificationsAsRead();
        });
    }
    
    // Función para marcar notificación como leída
    function markNotificationAsRead(notifId, button) {
        // Mostrar indicador de carga
        const originalText = button.innerHTML;
        button.innerHTML = '<i class="mdi mdi-loading mdi-spin me-1"></i> Procesando...';
        button.disabled = true;
        
        fetch('/Aaapumac/asociado/MarcarLeida', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'notificacion_id=' + notifId
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                // Obtener el elemento de la notificación
                const item = button.closest('.notification-item');
                const notificationData = {
                    id: notifId,
                    title: item.querySelector('h6').textContent,
                    message: item.querySelector('p').textContent,
                    time: item.querySelector('.text-muted.small').textContent,
                    tipo: item.querySelector('.badge')?.textContent || null,
                    related_record: item.querySelector('a[href*="verPedimento"]')?.getAttribute('href')?.match(/id=(\d+)/)?.[1]
                };
                
                // 1. Eliminar de Pendientes con animación
                item.style.opacity = '0.5';
                item.style.transition = 'all 0.3s ease';
                
                setTimeout(() => {
                    item.style.transform = 'translateX(-100%)';
                    item.style.opacity = '0';
                    
                    setTimeout(() => {
                        item.remove();
                        
                        // 2. Agregar a Vistas
                        addNotificationToViewed(notificationData);
                        
                        // 3. Actualizar contadores y paginación
                        updateAllCountersAndPagination();
                        
                        // 4. Verificar si quedan pendientes
                        checkIfEmptyPendientes();
                    }, 300);
                }, 200);
                
                // Mostrar mensaje de éxito
                showToast('Notificación marcada como leída', 'success');
            } else {
                // Restaurar botón
                button.innerHTML = originalText;
                button.disabled = false;
                showToast('Error al marcar como leída', 'error');
            }
        })
        .catch(error => {
            // Restaurar botón
            button.innerHTML = originalText;
            button.disabled = false;
            showToast('Error de conexión', 'error');
            console.error('Error:', error);
        });
    }
    
    // Función para agregar notificación a la pestaña Vistas
    function addNotificationToViewed(notification) {
        const vistasContainer = document.querySelector('#vistas .notification-list');
        const emptyState = vistasContainer.querySelector('.text-center.py-5');
        
        // Si hay estado vacío, eliminarlo
        if (emptyState) {
            emptyState.remove();
        }
        
        // Crear elemento HTML para la notificación vista
        const viewedItem = document.createElement('div');
        viewedItem.className = 'notification-item border-bottom py-3';
        viewedItem.setAttribute('data-id', notification.id);
        
        let tipoBadge = '';
        if (notification.tipo) {
            tipoBadge = `<div class="mb-2">
                <span class="badge bg-secondary">${notification.tipo}</span>
            </div>`;
        }
        
        let verPedimentoLink = '';
        if (notification.related_record) {
            verPedimentoLink = `
                <a href="/Aaapumac/asociado/verPedimento?id=${notification.related_record}" 
                   class="btn btn-link btn-sm text-decoration-none p-0 text-muted">
                    <i class="mdi mdi-link me-1" style="font-size: 12px;"></i>
                    Ver pedimento
                </a>
            `;
        }
        
        viewedItem.innerHTML = `
            <div class="d-flex">
                <div class="me-3">
                    <div class="read-icon text-muted">
                        <i class="mdi mdi-check" style="font-size: 14px;"></i>
                    </div>
                </div>
                
                <div class="flex-grow-1">
                    <div class="d-flex justify-content-between align-items-start mb-1">
                        <h6 class="mb-0 text-dark">${escapeHtml(notification.title)}</h6>
                        <span class="text-muted small">${notification.time}</span>
                    </div>
                    
                    <p class="mb-2 text-muted small">${notification.message}</p>
                    
                    ${tipoBadge}
                    
                    <div class="mt-2">
                        ${verPedimentoLink}
                    </div>
                </div>
            </div>
        `;
        
        // Agregar al inicio de la lista de Vistas
        const firstNotification = vistasContainer.querySelector('.notification-item');
        if (firstNotification) {
            vistasContainer.insertBefore(viewedItem, firstNotification);
        } else {
            vistasContainer.appendChild(viewedItem);
        }
        
        // Animación de entrada
        viewedItem.style.opacity = '0';
        viewedItem.style.transform = 'translateY(-20px)';
        setTimeout(() => {
            viewedItem.style.transition = 'all 0.3s ease';
            viewedItem.style.opacity = '1';
            viewedItem.style.transform = 'translateY(0)';
        }, 10);
    }
    
    // Función para actualizar todos los contadores y paginación
    function updateAllCountersAndPagination() {
        // Actualizar contador en header
        const headerBadge = document.getElementById('header-badge');
        const pendientesBadge = document.getElementById('pendientes-badge');
        const vistasBadge = document.getElementById('vistas-badge');
        
        fetch('/Aaapumac/asociado/getNotificationCount')
            .then(res => res.json())
            .then(data => {
                // Actualizar badge en header
                if (headerBadge) {
                    if (data.count > 0) {
                        headerBadge.textContent = data.count + ' nuevas';
                        headerBadge.style.display = 'inline-block';
                    } else {
                        headerBadge.style.display = 'none';
                    }
                }
                
                // Actualizar badge de pendientes
                if (pendientesBadge) {
                    if (data.count > 0) {
                        pendientesBadge.textContent = data.count;
                        pendientesBadge.style.display = 'inline-block';
                    } else {
                        pendientesBadge.style.display = 'none';
                    }
                }
                
                // Actualizar badge de vistas
                const vistaItems = document.querySelectorAll('#vistas .notification-item');
                if (vistasBadge) {
                    vistasBadge.textContent = vistaItems.length;
                } else if (vistaItems.length > 0) {
                    const newBadge = document.createElement('span');
                    newBadge.id = 'vistas-badge';
                    newBadge.className = 'badge bg-secondary ms-1';
                    newBadge.textContent = vistaItems.length;
                    document.getElementById('vistas-tab').appendChild(newBadge);
                }
                
                // Actualizar botón "Marcar todas"
                if (marcarTodasBtn && data.count === 0) {
                    marcarTodasBtn.style.display = 'none';
                }
                
                // Actualizar badge en sidebar
                const sidebarBadge = document.querySelector('.notification-badge');
                if (sidebarBadge) {
                    if (data.count > 0) {
                        sidebarBadge.textContent = data.count;
                        sidebarBadge.style.display = 'flex';
                    } else {
                        sidebarBadge.style.display = 'none';
                    }
                }
                
                // Actualizar paginación de pendientes
                updatePagination('pendientes', data.count);
            })
            .catch(error => {
                console.error('Error al actualizar contadores:', error);
            });
    }
    
    // Función para actualizar paginación
    function updatePagination(tipo, totalNuevo) {
        if (tipo === 'pendientes') {
            const pendientesContainer = document.querySelector('#pendientes .notification-list');
            const paginationContainer = pendientesContainer.querySelector('.border-top');
            
            if (paginationContainer) {
                const itemsPerPage = 10;
                const totalPages = Math.ceil(totalNuevo / itemsPerPage);
                const currentPage = <?php echo $pagina_pendientes; ?>;
                
                // Si solo queda una página o menos, eliminar paginación
                if (totalPages <= 1) {
                    paginationContainer.remove();
                } else {
                    // Actualizar información de página
                    const infoText = paginationContainer.querySelector('p.text-center');
                    if (infoText) {
                        const currentItems = document.querySelectorAll('#pendientes .notification-item').length;
                        infoText.textContent = `Mostrando ${currentItems} de ${totalNuevo} notificaciones pendientes`;
                    }
                }
            }
        }
    }
    
    // Función para verificar si quedan pendientes
    function checkIfEmptyPendientes() {
        const pendientesContainer = document.querySelector('#pendientes .notification-list');
        const pendientesItems = pendientesContainer.querySelectorAll('.notification-item');
        const emptyState = pendientesContainer.querySelector('.text-center.py-5');
        
        if (pendientesItems.length === 0 && !emptyState) {
            // Mostrar estado vacío
            const emptyHtml = `
                <div class="text-center py-5">
                    <div class="mb-3">
                        <i class="mdi mdi-check-circle text-muted" style="font-size: 48px;"></i>
                    </div>
                    <h4 class="text-muted mb-2">Sin pendientes</h4>
                    <p class="text-muted small">Todas las notificaciones están vistas</p>
                </div>
            `;
            pendientesContainer.innerHTML = emptyHtml;
        }
    }
    
    // Función para marcar todas como leídas
    function markAllNotificationsAsRead() {
        if (marcarTodasBtn) {
            const originalText = marcarTodasBtn.innerHTML;
            marcarTodasBtn.innerHTML = '<i class="mdi mdi-loading mdi-spin me-1"></i> Procesando...';
            marcarTodasBtn.disabled = true;
        }
        
        fetch('/Aaapumac/asociado/MarcarTodasLeidas', {
            method: 'POST'
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                // Obtener todas las notificaciones pendientes
                const pendientesItems = document.querySelectorAll('#pendientes .notification-item');
                const vistasContainer = document.querySelector('#vistas .notification-list');
                const emptyStateVistas = vistasContainer.querySelector('.text-center.py-5');
                
                // Si hay estado vacío en Vistas, eliminarlo
                if (emptyStateVistas) {
                    emptyStateVistas.remove();
                }
                
                // Mover cada notificación pendiente a Vistas
                pendientesItems.forEach((item, index) => {
                    setTimeout(() => {
                        const notificationData = {
                            id: item.getAttribute('data-id'),
                            title: item.querySelector('h6').textContent,
                            message: item.querySelector('p').textContent,
                            time: item.querySelector('.text-muted.small').textContent,
                            tipo: item.querySelector('.badge')?.textContent || null,
                            related_record: item.querySelector('a[href*="verPedimento"]')?.getAttribute('href')?.match(/id=(\d+)/)?.[1]
                        };
                        
                        // Animación de salida
                        item.style.opacity = '0.5';
                        item.style.transition = 'all 0.3s ease';
                        
                        setTimeout(() => {
                            item.style.transform = 'translateX(-100%)';
                            item.style.opacity = '0';
                            
                            setTimeout(() => {
                                // Agregar a Vistas
                                addNotificationToViewed(notificationData);
                            }, 300);
                        }, 200);
                    }, index * 100); // Delay escalonado
                });
                
                // Esperar a que se completen las animaciones
                setTimeout(() => {
                    // Limpiar pendientes
                    const pendientesContainer = document.querySelector('#pendientes .notification-list');
                    pendientesContainer.innerHTML = `
                        <div class="text-center py-5">
                            <div class="mb-3">
                                <i class="mdi mdi-check-circle text-muted" style="font-size: 48px;"></i>
                            </div>
                            <h4 class="text-muted mb-2">Sin pendientes</h4>
                            <p class="text-muted small">Todas las notificaciones están vistas</p>
                        </div>
                    `;
                    
                    // Actualizar contadores
                    updateAllCountersAndPagination();
                    
                    // Mostrar mensaje de éxito
                    showToast('Todas las notificaciones han sido marcadas como leídas', 'success');
                    
                    if (marcarTodasBtn) {
                        marcarTodasBtn.style.display = 'none';
                    }
                }, (pendientesItems.length * 100) + 1000);
            } else {
                if (marcarTodasBtn) {
                    marcarTodasBtn.innerHTML = originalText;
                    marcarTodasBtn.disabled = false;
                }
                showToast('Error al marcar todas como leídas', 'error');
            }
        })
        .catch(error => {
            if (marcarTodasBtn) {
                marcarTodasBtn.innerHTML = originalText;
                marcarTodasBtn.disabled = false;
            }
            showToast('Error de conexión', 'error');
            console.error('Error:', error);
        });
    }
    
    // Función para escapar HTML
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
    
    // Función para mostrar toast notifications
    function showToast(message, type = 'success') {
        // Crear contenedor de toast si no existe
        let toastContainer = document.getElementById('toast-container');
        if (!toastContainer) {
            toastContainer = document.createElement('div');
            toastContainer.id = 'toast-container';
            toastContainer.style.cssText = 'position: fixed; top: 20px; right: 20px; z-index: 9999;';
            document.body.appendChild(toastContainer);
        }
        
        // Crear toast
        const toastId = 'toast-' + Date.now();
        const toastHtml = `
            <div id="${toastId}" class="toast align-items-center text-white bg-${type === 'success' ? 'success' : 'danger'} border-0" 
                 role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="mdi mdi-${type === 'success' ? 'check-circle' : 'alert-circle'} me-2"></i>
                        ${message}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        `;
        
        toastContainer.insertAdjacentHTML('afterbegin', toastHtml);
        
        // Mostrar toast
        const toastElement = document.getElementById(toastId);
        const toast = new bootstrap.Toast(toastElement, {
            delay: 3000
        });
        toast.show();
        
        // Eliminar toast después de ocultarse
        toastElement.addEventListener('hidden.bs.toast', function() {
            this.remove();
        });
    }
    
    // Función para verificar nuevas notificaciones automáticamente
    function checkForNewNotifications() {
        fetch('/Aaapumac/asociado/getNotificationCount')
            .then(res => res.json())
            .then(data => {
                const currentBadge = document.getElementById('pendientes-badge');
                const currentCount = currentBadge ? parseInt(currentBadge.textContent) || 0 : 0;
                
                if (data.count > currentCount) {
                    // Hay nuevas notificaciones
                    console.log(`Nuevas notificaciones: ${data.count - currentCount}`);
                    
                    // Actualizar badge
                    if (currentBadge) {
                        currentBadge.textContent = data.count;
                    }
                    
                    // Mostrar notificación si estamos en otra pestaña
                    const activeTab = document.querySelector('.nav-link.active');
                    if (activeTab && activeTab.id === 'vistas-tab') {
                        showToast(`Tienes ${data.count - currentCount} nueva(s) notificación(es)`, 'info');
                    }
                }
            })
            .catch(error => {
                console.error('Error verificando notificaciones:', error);
            });
    }
    
    // Verificar nuevas notificaciones cada 30 segundos
    setInterval(checkForNewNotifications, 30000);
    
    // Hacer las funciones disponibles globalmente
    window.markNotificationAsRead = markNotificationAsRead;
    window.markAllNotificationsAsRead = markAllNotificationsAsRead;
    window.updateAllCountersAndPagination = updateAllCountersAndPagination;
    window.showToast = showToast;
});
</script>