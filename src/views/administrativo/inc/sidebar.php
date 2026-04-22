<!-- sidebar.php -->
<link rel="stylesheet" href="/Aaapumac/src/views/assets/css/sidebar.css">
<link rel="stylesheet" href="/Aaapumac/src/views/assets/css/administrativo.css">

<!-- Botón hamburguesa -->
<button class="hamburger-btn" id="hamburgerBtn" type="button">
    <i class="mdi mdi-menu"></i>
</button>

<nav class="sidebar-modern" id="sidebar">
    <!-- Header del Sidebar -->
    <div class="sidebar-header">
        <div class="sidebar-brand">
            <a href="/Aaapumac/" class="brand-logo-full">
                <img src="/Aaapumac/src/views/assets/img/logoAaa.png" alt="AAAPUMAC" style="max-height: 42px; width: auto;" />
            </a>
        </div>
        <div class="sidebar-close-btn" id="sidebarCloseBtn">
            <i class="mdi mdi-close"></i>
        </div>
        <div class="sidebar-toggle">
            <button class="toggle-btn" type="button" data-bs-toggle="minimize">
                <i class="mdi mdi-menu"></i>
            </button>
        </div>
    </div>

    <!-- Menú de Navegación -->
    <div class="sidebar-menu">
        <ul class="nav-menu">
            <!-- Inicio -->
            <li class="nav-item">
                <a class="nav-link" href="/Aaapumac/administrativo/profile">
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
            
            <!-- Administrativo -->
            <li class="nav-category">
                <span class="category-title">Departamentos</span>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/Aaapumac/administrativo/jobs">
                    <div class="nav-icon gradient-blue">
                        <i class="mdi mdi-shield-crown-outline"></i>
                    </div>
                    <span class="nav-text">Bolsa de trabajo</span>
                </a>
            </li>
                        <li class="nav-item">
                <a class="nav-link" href="/Aaapumac/administrativo/convenio">
                    <div class="nav-icon gradient-blue">
                        <i class="mdi mdi-shield-crown-outline"></i>
                    </div>
                    <span class="nav-text">convenio</span>
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

<!-- Overlay para móvil -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const DESKTOP_BREAKPOINT = 760;
        const sidebar = document.getElementById('sidebar');
        const hamburgerBtn = document.getElementById('hamburgerBtn');
        const closeBtn = document.getElementById('sidebarCloseBtn');
        const overlay = document.getElementById('sidebarOverlay');
        const desktopToggleBtn = document.querySelector('.sidebar-toggle .toggle-btn');

        // Función para abrir sidebar
        function openSidebar() {
            sidebar.classList.add('show');
            if (overlay) overlay.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        // Función para cerrar sidebar
        function closeSidebar() {
            sidebar.classList.remove('show');
            if (overlay) overlay.classList.remove('active');
            document.body.style.overflow = '';
        }

        // Función para minimizar/expandir sidebar en escritorio
        function toggleDesktopSidebar() {
            sidebar.classList.toggle('sidebar-minimized');
            document.body.classList.toggle('sidebar-is-minimized', sidebar.classList.contains('sidebar-minimized'));
            closeSidebar();
        }

        // Accion principal del botón menú según resolución
        function handleMenuToggle(event) {
            event.preventDefault();

            if (window.innerWidth > DESKTOP_BREAKPOINT) {
                toggleDesktopSidebar();
                return;
            }

            if (sidebar.classList.contains('show')) {
                closeSidebar();
            } else {
                openSidebar();
            }
        }

        // Eventos
        if (hamburgerBtn) hamburgerBtn.addEventListener('click', handleMenuToggle);
        if (desktopToggleBtn) desktopToggleBtn.addEventListener('click', handleMenuToggle);
        if (closeBtn) closeBtn.addEventListener('click', closeSidebar);
        if (overlay) overlay.addEventListener('click', closeSidebar);

        // Cerrar al cambiar de orientación o tamaño
        window.addEventListener('resize', function () {
            if (window.innerWidth > DESKTOP_BREAKPOINT && sidebar.classList.contains('show')) {
                closeSidebar();
            }

            // En móvil no se usa estado minimizado
            if (window.innerWidth <= DESKTOP_BREAKPOINT) {
                sidebar.classList.remove('sidebar-minimized');
                document.body.classList.remove('sidebar-is-minimized');
            }
        });

        // Sincronizar estado inicial
        if (window.innerWidth > DESKTOP_BREAKPOINT && sidebar.classList.contains('sidebar-minimized')) {
            document.body.classList.add('sidebar-is-minimized');
        }
    });
</script>