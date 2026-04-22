<link rel="stylesheet" href="/Aaapumac/src/views/assets/css/sidebar.css">
<nav class="sidebar-modern" id="sidebar">
    <!-- Header del Sidebar -->
    <div class="sidebar-header">
        <div class="sidebar-toggle">
            <button class="toggle-btn" type="button" data-bs-toggle="minimize">
                <i class="mdi mdi-menu"></i>
            </button>
        </div>
        <div class="sidebar-brand">
            <a href="/Aaapumac/" class="brand-logo-full">
                <img src="/Aaapumac/src/views/assets/img/logo-2.png" alt="AAAPUMAC" />
            </a>
        </div>
    </div>

    <!-- Menú de Navegación -->
    <div class="sidebar-menu">
        <ul class="nav-menu">
            <!-- Inicio -->
            <li class="nav-item">
                <a class="nav-link" href="/Aaapumac/asociadoCoordinador/profile">
                    <div class="nav-icon">
                        <i class="mdi mdi-view-dashboard"></i>
                    </div>
                    <span class="nav-text">Inicio</span>
                </a>
            </li>

            <!-- Separador -->
            <li class="nav-category">
                <span class="category-title">Departamentos</span>
            </li>

            <!-- Jurídico -->
            <li class="nav-item">
                <a class="nav-link" href="/Aaapumac/asociadoCoordinador/serviJuri">
                    <div class="nav-icon gradient-purple">
                        <i class="mdi mdi-scale-balance"></i>
                    </div>
                    <span class="nav-text">Jurídico</span>
                </a>
            </li>

            <!-- Arancelario -->
            <li class="nav-item">
                <a class="nav-link" href="/Aaapumac/asociadoCoordinador/serviAran">
                    <div class="nav-icon gradient-purple">
                        <i class="mdi mdi-calculator"></i>
                    </div>
                    <span class="nav-text">Arancelario</span>
                </a>
            </li>

            <!-- Operativo (con submenú) -->
            <li class="nav-item has-submenu" id="operativo-menu">
                <a class="nav-link" href="#" data-bs-toggle="collapse" data-bs-target="#submenu-operativo">
                    <div class="nav-icon gradient-blue">
                        <i class="mdi mdi-cogs"></i>
                    </div>
                    <span class="nav-text">Operativo</span>
                    <div class="submenu-arrow">
                        <i class="mdi mdi-chevron-down"></i>
                    </div>
                </a>
                <ul class="submenu collapse" id="submenu-operativo">
                    <!-- Perfil -->
                    <li class="nav-subitem">
                        <a class="nav-sublink" href="/Aaapumac/asociadoCoordinador/aso">
                            <div class="nav-subicon">
                                <i class="mdi mdi-account-circle"></i>
                            </div>
                            <span class="nav-subtext">Perfil</span>
                        </a>
                    </li>
                    
                    <!-- Entrega de pedimentos gestiones -->
                    <li class="nav-subitem">
                        <a class="nav-sublink" href="/Aaapumac/asociadoCoordinador/convenio">
                            <div class="nav-subicon">
                                <i class="mdi mdi-file-document-multiple"></i>
                            </div>
                            <span class="nav-subtext">Entrega de pedimentos gestiones</span>
                        </a>
                    </li>
                    
                    <!-- Seguimiento -->
                    <li class="nav-subitem">
                        <a class="nav-sublink" href="/Aaapumac/asociadoCoordinador/convenio">
                            <div class="nav-subicon">
                                <i class="mdi mdi-chart-timeline"></i>
                            </div>
                            <span class="nav-subtext">Seguimiento</span>
                        </a>
                    </li>
                    
                    <!-- Pedimentos finalizados -->
                    <li class="nav-subitem">
                        <a class="nav-sublink" href="/Aaapumac/asociadoCoordinador/convenio">
                            <div class="nav-subicon">
                                <i class="mdi mdi-check-all"></i>
                            </div>
                            <span class="nav-subtext">Pedimentos finalizados</span>
                        </a>
                    </li>
                    
                    <!-- Contacto Aaapumac -->
                    <li class="nav-subitem">
                        <a class="nav-sublink" href="/Aaapumac/asociadoCoordinador/convenio">
                            <div class="nav-subicon">
                                <i class="mdi mdi-contacts"></i>
                            </div>
                            <span class="nav-subtext">Contacto Aaapumac</span>
                        </a>
                    </li>
                                        
                    <!--  Gestion de personal -->
                    <li class="nav-subitem">
                        <a class="nav-sublink" href="/Aaapumac/asociadoCoordinador/listadoPersonal">
                            <div class="nav-subicon">
                                <i class="mdi mdi-contacts"></i>
                            </div>
                            <span class="nav-subtext">Gestion de personal</span>
                        </a>
                    </li>
                </ul>
            </li>

            <!-- Logout -->
            <li class="nav-item">
                <a href="/Aaapumac/login/logout" class="nav-link">
                    <div class="nav-icon gradient-red">
                        <i class="mdi mdi-power"></i>
                    </div>
                    <span class="nav-text">Cerrar Sesión</span>
                </a>
            </li>
        </ul>
    </div>
</nav>

<style>
/* Estilos para submenú */
.nav-item.has-submenu .nav-link {
    position: relative;
}

.submenu-arrow {
    position: absolute;
    right: 20px;
    top: 50%;
    transform: translateY(-50%);
    transition: transform 0.3s ease;
    color: rgba(255, 255, 255, 0.7);
}

.nav-item.has-submenu .nav-link[aria-expanded="true"] .submenu-arrow {
    transform: translateY(-50%) rotate(180deg);
}

.submenu {
    list-style: none;
    padding-left: 0;
    background-color: rgba(0, 0, 0, 0.05);
    border-radius: 0 0 8px 8px;
    margin: 0;
    overflow: hidden;
}

.nav-subitem {
    padding: 0;
}

.nav-sublink {
    display: flex;
    align-items: center;
    padding: 12px 20px 12px 60px;
    color: #495057;
    text-decoration: none;
    transition: all 0.3s;
    position: relative;
}

.nav-sublink:hover {
    background-color: rgba(0, 0, 0, 0.05);
    color: #ffffff;
}

.nav-subicon {
    width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 12px;
    color: #6c757d;
}

.nav-sublink:hover .nav-subicon {
    color: #ffffff;
}

.nav-subtext {
    font-size: 14px;
    font-weight: 400;
    line-height: 1.3;
}

/* Ajustar el padding cuando el sidebar está minimizado */
.sidebar-modern:not(.sidebar-minimized) .submenu {
    margin-left: 20px;
    margin-right: 20px;
    margin-bottom: 5px;
}

/* Cuando el sidebar está minimizado, ocultar el submenú */
.sidebar-modern.sidebar-minimized .submenu {
    display: none !important;
}

/* Colores para los iconos */
.gradient-blue {
    background: linear-gradient(135deg, #1e88e5, #0d47a1);
    color: white;
}

.gradient-purple {
    background: linear-gradient(135deg, #8e24aa, #4a148c);
    color: white;
}

.gradient-red {
    background: linear-gradient(135deg, #f44336, #c62828);
    color: white;
}

.nav-icon {
    position: relative;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    border-radius: 8px;
}

/* Ajustes para textos largos */
.nav-sublink .nav-subtext {
    white-space: normal;
    word-wrap: break-word;
}
</style>

<script>
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
</script>