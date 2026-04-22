<link rel="stylesheet" href="/Aaapumac/src/views/assets/css/sidebar.css">
<link rel="stylesheet" href="/Aaapumac/src/views/assets/css/Gestion.css">
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
                <a class="nav-link" href="/Aaapumac/Gestion/profile">
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
                <a class="nav-link" href="/Aaapumac/Gestion/serviJuri">
                    <div class="nav-icon gradient-purple">
                        <i class="mdi mdi-scale-balance"></i>
                    </div>
                    <span class="nav-text">Jurídico</span>
                </a>
            </li>

            <!-- Arancelario -->
            <li class="nav-item">
                <a class="nav-link" href="/Aaapumac/Gestion/serviAran">
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
                    <!-- Entrega de pedimentos -->
                    <li class="nav-subitem">
                        <a class="nav-sublink" href="/Aaapumac/Gestion/addfolios">
                            <div class="nav-subicon">
                                <i class="mdi mdi-file-document-multiple"></i>
                            </div>
                            <span class="nav-subtext">Entrega de pedimentos</span>
                        </a>
                    </li>
                    
                    <!-- Folios aduana -->
                    <li class="nav-subitem">
                        <a class="nav-sublink" href="/Aaapumac/Gestion/Folioaduana">
                            <div class="nav-subicon">
                                <i class="mdi mdi-folder-outline"></i>
                            </div>
                            <span class="nav-subtext">Folios aduana</span>
                        </a>
                    </li>
                    
                    <!-- Folios rechazados -->
                    <li class="nav-subitem">
                        <a class="nav-sublink" href="/Aaapumac/Gestion/convenio">
                            <div class="nav-subicon">
                                <i class="mdi mdi-file-cancel-outline"></i>
                            </div>
                            <span class="nav-subtext">Folios rechazados</span>
                        </a>
                    </li>
                    
                    <!-- Folios finalizados -->
                    <li class="nav-subitem">
                        <a class="nav-sublink" href="/Aaapumac/Gestion/convenio">
                            <div class="nav-subicon">
                                <i class="mdi mdi-file-check-outline"></i>
                            </div>
                            <span class="nav-subtext">Folios finalizados</span>
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

<script src="/Aaapumac/src/views/assets/js/Gestion.js"></script>