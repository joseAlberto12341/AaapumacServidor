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
                <a class="nav-link" href="/Aaapumac/admin/profile">
                    <div class="nav-icon">
                        <i class="mdi mdi-view-dashboard"></i>
                    </div>
                    <span class="nav-text">Inicio</span>
                </a>
            </li>

            <!-- Administrativo -->
            <li class="nav-category">
                <span class="category-title">Departamentos</span>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/Aaapumac/admin/serviAdmi">
                    <div class="nav-icon gradient-blue">
                        <i class="mdi mdi-shield-crown-outline"></i>
                    </div>
                    <span class="nav-text">Administrativo</span>
                </a>
            </li>

            <!-- Arancelario -->
            <li class="nav-item">
                <a class="nav-link" href="/Aaapumac/admin/serviAran">
                    <div class="nav-icon gradient-purple">
                        <i class="mdi mdi-window-shutter-cog"></i>
                    </div>
                    <span class="nav-text">Arancelario</span>
                </a>
            </li>

            <!-- Sistemas -->
            <li class="nav-item">
                <a class="nav-link" href="/Aaapumac/admin/serviTi">
                    <div class="nav-icon gradient-teal">
                        <i class="mdi mdi-monitor-cellphone-star"></i>
                    </div>
                    <span class="nav-text">Sistemas TI</span>
                </a>
            </li>

            <!-- Operativo -->
            <li class="nav-item">
                <a class="nav-link" href="/Aaapumac/admin/serviOpe">
                    <div class="nav-icon gradient-orange">
                        <i class="mdi mdi-human-dolly"></i>
                    </div>
                    <span class="nav-text">Operativo</span>
                </a>
            </li>

            <!-- Call Center -->
            <li class="nav-item">
                <a class="nav-link" href="/Aaapumac/admin/serviCall">
                    <div class="nav-icon gradient-green">
                        <i class="mdi mdi-phone-plus"></i>
                    </div>
                    <span class="nav-text">Call Center</span>
                </a>
            </li>

            <!-- Navieras -->
            <li class="nav-item">
                <a class="nav-link" href="/Aaapumac/admin/serviNavi">
                    <div class="nav-icon gradient-cyan">
                        <i class="mdi mdi-ferry"></i>
                    </div>
                    <span class="nav-text">Navieras y Recintos</span>
                </a>
            </li>

            <!-- Jurídico -->
            <li class="nav-item">
                <a class="nav-link" href="/Aaapumac/admin/serviJuri">
                    <div class="nav-icon gradient-red">
                        <i class="mdi mdi-scale-balance"></i>
                    </div>
                    <span class="nav-text">Jurídico</span>
                </a>
            </li>

            <!-- Calidad -->
            <li class="nav-item">
                <a class="nav-link" href="/Aaapumac/admin/serviCali">
                    <div class="nav-icon gradient-pink">
                        <i class="mdi mdi-bookmark-check"></i>
                    </div>
                    <span class="nav-text">Calidad</span>
                </a>
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
        });
    }

    // Activar link actual
    const currentPath = window.location.pathname;
    const navLinks = document.querySelectorAll('.nav-link');
    
    navLinks.forEach(link => {
        if (link.getAttribute('href') === currentPath) {
            link.classList.add('active');
        }
    });
});
</script>