// Script para toggle del sidebar
document.addEventListener('DOMContentLoaded', function() {
    const toggleBtn = document.querySelector('.toggle-btn');
    const sidebar = document.querySelector('.sidebar-modern');
    const body = document.body;

    if (toggleBtn) {
        toggleBtn.addEventListener('click', function() {
            sidebar.classList.toggle('minimized');
            body.classList.toggle('sidebar-minimized');
            
            // Cerrar todos los submenús cuando se minimiza
            if (sidebar.classList.contains('minimized')) {
                const submenus = document.querySelectorAll('.submenu');
                submenus.forEach(submenu => {
                    submenu.classList.remove('show');
                });
            }
        });
    }

    // Manejar submenús con Bootstrap Collapse
    const submenuLinks = document.querySelectorAll('.has-submenu > .nav-link');
    submenuLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            if (sidebar.classList.contains('minimized')) {
                e.preventDefault();
                return;
            }
            
            const target = this.getAttribute('data-bs-target');
            const submenu = document.querySelector(target);
            
            if (submenu) {
                // Cerrar otros submenús si están abiertos
                document.querySelectorAll('.submenu.show').forEach(openSubmenu => {
                    if (openSubmenu.id !== target.substring(1)) {
                        openSubmenu.classList.remove('show');
                    }
                });
            }
        });
    });

    // Activar link actual
    const currentPath = window.location.pathname;
    const navLinks = document.querySelectorAll('.nav-link, .nav-sublink');
    
    navLinks.forEach(link => {
        if (link.getAttribute('href') === currentPath) {
            link.classList.add('active');
            
            // Si es un sublink, abrir su submenú padre
            if (link.classList.contains('nav-sublink')) {
                const parentMenuItem = link.closest('.has-submenu');
                if (parentMenuItem) {
                    const parentLink = parentMenuItem.querySelector('.nav-link');
                    const submenuId = parentLink.getAttribute('data-bs-target');
                    const submenu = document.querySelector(submenuId);
                    if (submenu) {
                        submenu.classList.add('show');
                        parentLink.setAttribute('aria-expanded', 'true');
                    }
                }
            }
        }
    });
});