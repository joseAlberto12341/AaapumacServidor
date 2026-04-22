<div class="header-nav">
    <div class="container-fluid">
        <div class="nav-container">
            <!-- Site Logo -->
            <div class="site-logo">
                <a href="/Aaapumac/"><img src="/Aaapumac/src/views/assets/img/logo-aa.png" alt="Logo"></a>
            </div>

            <!-- Main Menu -->
            <div class="nav-menu d-lg-flex align-items-center">

                <!-- Navbar Close Icon -->
                <div class="navbar-close">
                    <div class="cross-wrap"><span></span><span></span></div>
                </div>

                <!-- Menu Items -->
                <div class="menu-items">
                    <ul>
                        <li class="has-submemu">
                            <a>Inicio</a>
                            <ul class="submenu">
                                <li><a href="/Aaapumac/">Público</a></li>
                                <li><a href="/Aaapumac/admin">Administrador</a></li>
                                <li><a href="/Aaapumac/client">Asociados</a></li>
                            </ul>
                        </li>

                        <li class="has-submemu">
                            <a>Calidad</a>
                            <ul class="submenu">
                                <li><a href="/Aaapumac/services-2.html">Services Two</a></li>
                                <li><a href="/Aaapumac/service-details.html">Service Details</a></li>
                            </ul>
                        </li>
                        <li class="has-submemu">
                            <a href="/Aaapumac/shop.html">Servicios en linea</a>
                            <ul class="submenu">
                                <li><a href="/Aaapumac/ticket">Envio de ticket</a></li>
                                <li><a href="/Aaapumac/product-details.html">Product Details</a></li>
                            </ul>
                        </li>
                        <li><a href="/Aaapumac/jobs">Bolsa de Trabajo</a></li>
                        <li><a href="/Aaapumac/public/politica">Nuestra Politica</a></li>
                      
                        <li><a href="/Aaapumac/contact">Contacto</a></li>
                        <li><a href="/Aaapumac/public/conocenos">Quienes somos</a></li>

                        <?php if (!isset($_SESSION['logged'])): ?>
                            <li>
                                <a href="/Aaapumac/login" class="btn btn-primary btn-rounded btn-fw">Iniciar Sesión</a>
                            </li>
                        <?php else: ?>
                            <li class="has-submenu">
                                <a href="/Aaapumac/admin">Bienvenido (<?php echo $_SESSION['username']; ?>)</a>
                                <ul class="submenu">
                                    <li><a href="/Aaapumac/admin/profile">Perfil</a></li>
                                    <li><a href="/Aaapumac/admin/services">Servicios</a></li>
                                    <li><a href="/Aaapumac/login/logout">Cerrar Sesión</a></li>
                                </ul>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
                <!-- Pushed Item -->
                <div class="nav-pushed-item"></div>
            </div>

            <!-- Navbar Extra  -->
            <div class="navbar-extra d-flex align-items-center">
                <!-- Social Link -->
                <div class="menu-social nav-push-item">
                    <div class="menu-social-link">
                        <a href="https://www.facebook.com/Aaapumac" target="_blank"><i class="fab fa-facebook-f"></i></a>
                        <a href="https://twitter.com/AAAPUMAC" target="_blank"><i class="fab fa-twitter"></i></a>
                        <a href="https://www.instagram.com/aaapumac/" target="_blank"><i class="fab fa-instagram"></i></a>
                        <a href="#" target="_blank"><i class="fab fa-linkedin"></i></a>
                    </div>
                </div>
                <!-- off canvas menu toggler-->
                <div class="offcanvas-toggler">
                    <span><span></span><span></span><span></span></span>
                </div>
                <!-- Navbar Toggler -->
                <div class="navbar-toggler">
                    <span></span><span></span><span></span>
                </div>
            </div>
        </div>
    </div>
</div>

<!--====== OFF CANVAS START ======-->
<?php include "src/views/modules/canva.php"; ?>
<!--====== OFF CANVAS END ======-->