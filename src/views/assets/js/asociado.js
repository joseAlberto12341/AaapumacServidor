// Función para verificar nuevas notificaciones periódicamente
function iniciarPollingNotificaciones() {
    // Verificar cada 30 segundos
    setInterval(() => {
        actualizarBadgeNotificaciones();
    }, 30000); // 30 segundos
    
    // Verificar inmediatamente al cargar
    actualizarBadgeNotificaciones();
}

// Función para actualizar el badge de notificaciones
function actualizarBadgeNotificaciones() {
    fetch('/Aaapumac/asociado/getNotificationCount')
        .then(response => response.json())
        .then(data => {
            const sidebarBadge = document.querySelector('.notification-badge');
            const notificacionesLink = document.querySelector('a[href*="Notificaciones"]');
            
            if (data.count > 0) {
                // Si no existe el badge, crearlo
                if (!sidebarBadge && notificacionesLink) {
                    const navIcon = notificacionesLink.querySelector('.nav-icon');
                    if (navIcon) {
                        const newBadge = document.createElement('span');
                        newBadge.className = 'notification-badge';
                        newBadge.textContent = data.count;
                        navIcon.appendChild(newBadge);
                    }
                } else if (sidebarBadge) {
                    // Actualizar badge existente
                    sidebarBadge.textContent = data.count;
                    sidebarBadge.style.display = 'flex';
                    
                    // Animación para notificaciones nuevas
                    if (parseInt(sidebarBadge.textContent) > parseInt(sidebarBadge.getAttribute('data-last-count') || 0)) {
                        sidebarBadge.classList.add('badge-pulse');
                        setTimeout(() => {
                            sidebarBadge.classList.remove('badge-pulse');
                        }, 2000);
                    }
                    sidebarBadge.setAttribute('data-last-count', data.count);
                }
            } else if (sidebarBadge) {
                // Ocultar badge si no hay notificaciones
                sidebarBadge.style.display = 'none';
            }
        })
        .catch(error => {
            console.error('Error al actualizar notificaciones:', error);
        });
}

// MANEJO CORREGIDO DEL SIDEBAR
function manejarSidebar() {
    const sidebar = document.getElementById('sidebar');
    const toggleBtn = document.querySelector('.toggle-btn');
    const body = document.body;
    
    if (toggleBtn && sidebar) {
        // Eliminar cualquier event listener previo
        const newToggleBtn = toggleBtn.cloneNode(true);
        toggleBtn.parentNode.replaceChild(newToggleBtn, toggleBtn);
        
        // Agregar nuevo event listener
        newToggleBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation(); // Importante: previene que Bootstrap interfiera
            
            // 1. Toggle de la clase CORRECTA en el sidebar
            sidebar.classList.toggle('minimized'); // ← ¡CAMBIADO A 'minimized'!
            
            // 2. Toggle de la clase en el body para el contenido principal
            body.classList.toggle('sidebar-minimized'); // Esta queda igual para el body
            
            // 3. Cambiar el ícono del botón
            const icon = this.querySelector('i');
            if (sidebar.classList.contains('minimized')) {
                icon.className = 'mdi mdi-chevron-right';
                
                // Cerrar submenús si están abiertos
                const submenus = document.querySelectorAll('.submenu');
                submenus.forEach(submenu => {
                    submenu.classList.remove('show');
                });
                
                // Forzar reflow para asegurar animación
                void sidebar.offsetWidth;
                
                console.log(' Sidebar MINIMIZADO');
            } else {
                icon.className = 'mdi mdi-menu';
                console.log(' Sidebar EXPANDIDO');
            }
            
            // Debug en consola
            console.log('Clases del sidebar:', sidebar.classList);
            console.log('Clases del body:', body.classList);
        });
        
        console.log(' Sidebar controller inicializado');
    } else {
        console.error(' No se encontraron elementos del sidebar');
        console.log('Sidebar encontrado:', sidebar);
        console.log('Toggle button encontrado:', toggleBtn);
    }
}

// ACTUALIZA la llamada en DOMContentLoaded
document.addEventListener('DOMContentLoaded', function() {
    iniciarPollingNotificaciones();
    manejarSidebar(); // ← Cambiado de manejarSubmenuSidebar() a manejarSidebar()
    
    // También verificar cuando el usuario vuelve a la pestaña
    document.addEventListener('visibilitychange', function() {
        if (!document.hidden) {
            actualizarBadgeNotificaciones();
        }
    });
});
// Iniciar polling cuando se cargue el DOM
document.addEventListener('DOMContentLoaded', function() {
    iniciarPollingNotificaciones();
    manejarSubmenuSidebar();
    
    // También verificar cuando el usuario vuelve a la pestaña
    document.addEventListener('visibilitychange', function() {
        if (!document.hidden) {
            actualizarBadgeNotificaciones();
        }
    });
    
    // Verificar cuando el usuario hace clic en cualquier lugar (opcional)
    document.addEventListener('click', function() {
        // Actualizar cada 5 minutos cuando el usuario está activo
        setTimeout(actualizarBadgeNotificaciones, 300000);
    });
});

// Hacer la función disponible globalmente
window.actualizarBadgeNotificaciones = actualizarBadgeNotificaciones;