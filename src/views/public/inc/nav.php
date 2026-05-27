<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Determinar la ruta del perfil según el tipo de usuario
$perfilUrl = "/Aaapumac/admin/profile"; // Por defecto

if (isset($_SESSION['logged']) && $_SESSION['logged'] === true) {
    // Usar id_role que es lo que guarda el LoginController
    if (isset($_SESSION['id_role'])) {
        switch ($_SESSION['id_role']) {
            case 1: // admin
                $perfilUrl = "/Aaapumac/admin/profile";
                break;
            case 2: // user (administrativo)
                $perfilUrl = "/Aaapumac/administrativo/profile";
                break;
            case 3: // user (TI)
                $perfilUrl = "/Aaapumac/ti/profile";
                break;
            case 4: // user (operativo)
                $perfilUrl = "/Aaapumac/operativo/profile";
                break;
            case 5: // user (callcenter)
                $perfilUrl = "/Aaapumac/callcenter/profile";
                break;
            case 9: // user (asociado)
                $perfilUrl = "/Aaapumac/asociado/profile";
                break;
            case 10: // user (asociadoCoordinador)
                $perfilUrl = "/Aaapumac/asociadoCoordinador/profile";
                break;
            case 11: // user (Gestion)
                $perfilUrl = "/Aaapumac/Gestion/profile";
                break;
            case 12: // user (asociado común)
                $perfilUrl = "/Aaapumac/asociadoComun/profile";
                break;
            default:
                $perfilUrl = "/Aaapumac/admin/profile";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AAAPUMAC</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="/Aaapumac/src/views/assets/css/nadvarPrincipal.css">
</head>
<body>
    <!-- TOP BAR AREA -->
    <section class="topbar-area">
        <div class="topbar-container">
            <div class="topbar-row">
                <div class="topbar-contact">
                    <ul>
                        <li>
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                            </svg>
                            <a href="tel:+523143311500">(+52) 314 33 11 500</a>
                        </li>
                        <li>
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                                <polyline points="22,6 12,13 2,6"></polyline>
                            </svg>
                            <a href="mailto:contacto@aaamzo.org.mx">contacto@aaamzo.org.mx</a>
                        </li>
                    </ul>
                </div>
                <div class="topbar-social">
                    <div class="social-icons">
                        <a href="https://www.facebook.com/Aaapumac" target="_blank">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="https://twitter.com/AAAPUMAC" target="_blank">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="https://www.instagram.com/aaapumac/" target="_blank">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" target="_blank">
                            <i class="fab fa-linkedin"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- HEADER NAV -->
    <div class="header-nav">
        <div class="nav-container">
            <!-- Logo -->
            <div class="site-logo">
                <a href="/Aaapumac/"><img src="/Aaapumac/src/views/assets/img/logo-aa.png" alt="Logo"></a>
            </div>

            <!-- MENÚ ESCRITORIO (visible en pantallas grandes) -->
            <nav class="desktop-menu">
                <div class="menu-items">
                    <ul>
                        <?php if (!isset($_SESSION['logged']) || $_SESSION['logged'] !== true): ?>
                        <?php else: ?>
                            <li class="has-submenu">
                                <button class="servicios-btn">Servicios en línea <i class="fas fa-chevron-down" style="margin-left:6px;font-size:13px;"></i></button>
                                <ul class="submenu">
                                    <li><a target="_blank" href="https://tickets.aaamzo.org.mx/">Envío de ticket</a></li>
                                    <li><a target="_blank" href="http://181.191.248.54/modulacion.aspx">Trazabilidad en Gestiones</a></li>
                                    <li><a target="_blank" href="http://lotus.aaamzo.org.mx/Bases/aaapumac/portuaria.nsf/navieras">Descargo DGA´s</a></li>
                                </ul>
                            </li>
                        <?php endif; ?>
                        <li><a href="/Aaapumac/public/jobs">Bolsa de Trabajo</a></li>
                        <li><a href="/Aaapumac/public/contact">Contacto</a></li>
                        <li><a href="/Aaapumac/public/capacitacion">Capacitación</a></li>
                        <li><a href="/Aaapumac/public/politica">Nuestra Política</a></li>
                        <li><a href="/Aaapumac/public/report">Reporte Antisoborno</a></li>
                        <?php if (!isset($_SESSION['logged']) || $_SESSION['logged'] !== true): ?>
                            <li>
                                <form action="/Aaapumac/login" method="get">
                                    <button type="submit" class="btn-primary login-btn">Iniciar Sesión</button>
                                </form>
                            </li>
                        <?php else: ?>
                            <li class="has-submenu">
                                <button class="welcome-btn">Bienvenido (<?php echo htmlspecialchars($_SESSION['username']); ?>)</button>
                                <ul class="submenu">
                                    <li><a href="<?php echo $perfilUrl; ?>">Perfil</a></li>
                                    <li><a href="/Aaapumac/login/logout">Cerrar Sesión</a></li>
                                </ul>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </nav>

            <!-- Botón Menú Móvil -->
            <button class="mobile-menu-btn" id="mobileMenuBtn">
                <i class="fas fa-bars"></i>
            </button>
        </div>
    </div>

    <!-- MENÚ MÓVIL (oculto inicialmente) -->
    <div class="mobile-menu" id="mobileMenu">
        <div class="mobile-menu-header">
            <div class="site-logo">
                <img src="/Aaapumac/src/views/assets/img/logo-aa.png" alt="Logo">
            </div>
            <button class="close-menu-btn" id="closeMenuBtn">
                <i class="fas fa-times"></i>
            </button>
        </div>
        
        <div class="mobile-menu-content">
            <nav class="mobile-menu-items">
                <ul>
                    <?php if (!isset($_SESSION['logged']) || $_SESSION['logged'] !== true): ?>
                    <?php else: ?>
                        <li>
                            <button class="menu-toggle-btn servicios-btn" style="width:100%;text-align:left;display:flex;align-items:center;justify-content:space-between;gap:8px;">
                                <span>Servicios en línea</span>
                            </button>
                            <ul class="mobile-submenu">
                                <li><a target="_blank" href="https://tickets.aaamzo.org.mx/">Envío de ticket</a></li>
                                <li><a target="_blank" href="http://181.191.248.54/modulacion.aspx">Trazabilidad en Gestiones</a></li>
                                <li><a target="_blank" href="http://lotus.aaamzo.org.mx/Bases/aaapumac/portuaria.nsf/navieras">Descargo DGA´s</a></li>
                            </ul>
                        </li>
                    <?php endif; ?>
                    
                    <li><a href="/Aaapumac/public/jobs">Bolsa de Trabajo</a></li>
                    <li><a href="/Aaapumac/public/contact">Contacto</a></li>
                    <li><a href="/Aaapumac/public/capacitacion">Capacitación</a></li>
                    <li><a href="/Aaapumac/public/politica">Nuestra Política</a></li>
                    <li><a href="/Aaapumac/public/report">Reporte Antisoborno</a></li>
                    
                    <?php if (!isset($_SESSION['logged']) || $_SESSION['logged'] !== true): ?>
                        <li>
                            <form action="/Aaapumac/login" method="get">
                                <button type="submit" class="btn-mobile-login">Iniciar Sesión</button>
                            </form>
                        </li>
                    <?php else: ?>
                        <li>
                            <button class="menu-toggle-btn welcome-toggle-btn">Bienvenido (<?php echo htmlspecialchars($_SESSION['username']); ?>)</button>
                            <ul class="mobile-submenu">
                                <li><a href="<?php echo $perfilUrl; ?>">Perfil</a></li>
                                <li><a href="/Aaapumac/login/logout">Cerrar Sesión</a></li>
                            </ul>
                        </li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </div>

    <!-- Overlay para móvil -->
    <div class="mobile-overlay" id="mobileOverlay"></div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
        // FUNCIONALIDAD MENÚ MÓVIL
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const closeMenuBtn = document.getElementById('closeMenuBtn');
        const mobileMenu = document.getElementById('mobileMenu');
        const mobileOverlay = document.getElementById('mobileOverlay');
        const menuToggleBtns = document.querySelectorAll('.menu-toggle-btn');

        // Abrir menú móvil
        mobileMenuBtn.addEventListener('click', () => {
            mobileMenu.classList.add('active');
            mobileOverlay.classList.add('active');
            document.body.style.overflow = 'hidden';
        });

        // Cerrar menú móvil
        function closeMobileMenu() {
            mobileMenu.classList.remove('active');
            mobileOverlay.classList.remove('active');
            document.body.style.overflow = 'auto';
            
            // Cerrar todos los submenús
            document.querySelectorAll('.mobile-submenu').forEach(submenu => {
                submenu.classList.remove('active');
            });
            
            document.querySelectorAll('.menu-toggle-btn').forEach(btn => {
                btn.classList.remove('active');
            });
        }

        closeMenuBtn.addEventListener('click', closeMobileMenu);
        mobileOverlay.addEventListener('click', closeMobileMenu);

        // Manejar submenús en móvil
        menuToggleBtns.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const submenu = this.nextElementSibling;
                
                // Cerrar otros submenús
                document.querySelectorAll('.mobile-submenu').forEach(otherSubmenu => {
                    if (otherSubmenu !== submenu) {
                        otherSubmenu.classList.remove('active');
                    }
                });
                
                document.querySelectorAll('.menu-toggle-btn').forEach(otherBtn => {
                    if (otherBtn !== this) {
                        otherBtn.classList.remove('active');
                    }
                });
                
                // Alternar este submenú
                submenu.classList.toggle('active');
                this.classList.toggle('active');
            });
        });

        // Cerrar menú al hacer clic en un enlace
        document.querySelectorAll('.mobile-menu-items a').forEach(link => {
            link.addEventListener('click', () => {
                closeMobileMenu();
            });
        });

        // Cerrar menú con tecla ESC
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape') {
                closeMobileMenu();
            }
        });

        // Tu código jQuery del chat
        $(document).ready(function () {
            $('#chat-popup').hide();
            $('#chat-alert').hide();

            // Función para mostrar u ocultar el chat al hacer clic en el icono
            $('#chat-icon').click(function () {
                $('#chat-popup').fadeToggle('fast');
                $('#chat-alert').fadeOut('fast');
            });

            // Función para cerrar el chat al hacer clic en la tache
            $(".close-btn").click(function () {
                $("#chat-popup").fadeOut('');
            });

            setTimeout(function () {
                $('#chat-alert').fadeIn();
            }, 5000);

            setTimeout(function () {
                $('#chat-alert').fadeOut('fast');
            }, 7000);

            // Función para enviar un mensaje al bot
            $("#send-btn").on("click", function () {
                var message = $("#data").val();
                $.ajax({
                    url: '../Aaapumac/src/views/public/inc/chat.php',
                    type: 'GET',
                    data: { message: message },
                    success: function (response) {
                        var userMessage = '<div class="user-inbox inbox"><div class="msg-header"><p>' + message + '</p></div></div>';
                        var botMessage = '<div class="bot-inbox inbox"><div class="icon"><i class="fas fa-user"></i></div><div class="msg-header"><p>' + response + '</p></div></div>';
                        $(".form").append(userMessage);
                        $(".form").append(botMessage);
                        $(".form").scrollTop($(".form")[0].scrollHeight);
                    }
                });
                $("#data").val('');
            });
        });
    </script>

    <!--====== OFF CANVAS START ======-->
    <?php include "src/views/modules/canva.php"; ?>
    <!--====== OFF CANVAS END ======-->
</body>
</html>