<link rel="stylesheet" href="/Aaapumac/src/views/assets/css/sidebar.css">
<link rel="stylesheet" href="/Aaapumac/src/views/assets/css/asociado.css">
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
                <a class="nav-link" href="/Aaapumac/asociado/profile">
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
                <a class="nav-link" href="/Aaapumac/asociado/serviJuri">
                    <div class="nav-icon gradient-purple">
                        <i class="mdi mdi-scale-balance"></i>
                    </div>
                    <span class="nav-text">Jurídico</span>
                </a>
            </li>

            <!-- Arancelario -->
            <li class="nav-item">
                <a class="nav-link" href="/Aaapumac/asociado/serviAran">
                    <div class="nav-icon gradient-purple">
                        <i class="mdi mdi-calculator"></i>
                    </div>
                    <span class="nav-text">Arancelario</span>
                </a>
            </li>
        
                       <!-- Arancelario -->
            <li class="nav-item">
                <a class="nav-link" href="/Aaapumac/asociado/Avisos">
                    <div class="nav-icon gradient-purple">
                        <i class="mdi mdi-calculator"></i>
                    </div>
                    <span class="nav-text">Avisos</span>
                </a>
            </li>

                       <!-- Arancelario -->
            <li class="nav-item">
                <a class="nav-link" href="/Aaapumac/asociado/contacto">
                    <div class="nav-icon gradient-purple">
                        <i class="mdi mdi-calculator"></i>
                    </div>
                    <span class="nav-text">Contactos</span>
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
                        <a class="nav-sublink" href="/Aaapumac/asociado/aso">
                            <div class="nav-subicon">
                                <i class="mdi mdi-account-circle"></i>
                            </div>
                            <span class="nav-subtext">Perfil</span>
                        </a>
                    </li>
                     
                    <!-- Entrega de pedimentos -->
                  <li class="nav-subitem">
                        <a class="nav-sublink" href="/Aaapumac/asociado/listaPedimentos">
                            <div class="nav-subicon">
                                <i class="mdi mdi-file-document-multiple"></i>
                            </div>
                            <span class="nav-subtext">Entrega de pedimentos</span>
                        </a>
                    </li> 
                    
                    <!-- Seguimiento -->
                  <li class="nav-subitem">
                        <a class="nav-sublink" href="/Aaapumac/asociado/seguimiento">
                            <div class="nav-subicon">
                                <i class="mdi mdi-chart-timeline"></i>
                            </div>
                            <span class="nav-subtext">Seguimiento</span>
                        </a>
                    </li>
                    
                    <!-- Pedimentos finalizados -->
                    <li class="nav-subitem">
                        <a class="nav-sublink" href="/Aaapumac/asociado/convenio">
                            <div class="nav-subicon">
                                <i class="mdi mdi-check-all"></i>
                            </div>
                            <span class="nav-subtext">Pedimentos finalizados</span>
                        </a>
                    </li>

                </ul>
            </li>

            <!-- NOTIFICACIONES -->
             <li class="nav-item">
                <a class="nav-link" href="/Aaapumac/asociado/Notificaciones" id="notificaciones-link">
                    <div class="nav-icon gradient-orange" style="position: relative;">
                        <i class="mdi mdi-bell"></i>
                        <?php
                        // Obtener contador de notificaciones no leídas
                        if (isset($_SESSION['id_user'])) {
                            $notificaciones_no_leidas = \App\Repositories\NotificationRepository::contarNoLeidas($_SESSION['id_user']);
                            if ($notificaciones_no_leidas > 0): ?>
                                <span class="notification-badge" style="position: absolute; top: 2px; right: 2px; min-width: 18px; height: 18px; padding: 0 5px; background: #ff5722; color: #fff; border-radius: 50%; font-size: 12px; display: flex; align-items: center; justify-content: center; box-shadow: 0 1px 4px rgba(0,0,0,0.15); z-index: 2;"><?php echo $notificaciones_no_leidas; ?></span>
                            <?php endif;
                        }
                        ?>
                    </div>
                    <span class="nav-text">Notificaciones</span>
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
<script src="/Aaapumac/src/views/assets/js/asociado.js"></script>
