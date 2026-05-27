<?php
// Incluir el handler de anuncios
require_once UTILS . '/avisos.php';

// Crear instancia del handler
$anunciosHandler = new AnunciosHandler();
?>
<link rel="stylesheet" href="/Aaapumac/src/views/assets/css/banner.css">
<!-- SECCIÓN DEL BANNER PRINCIPAL -->
<section class="banner-section banner-section-three">
    <div class="banner-slider">
        <div class="single-banner">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <?php
                    $profileUrl = '/Aaapumac/public/contact';
                    $buttonText = 'Asóciate';

                    if (isset($_SESSION['logged']) && $_SESSION['logged'] === true) {
                        $buttonText = 'Servicios Web';
                        $roleId = $_SESSION['id_role'] ?? 0;

                        $profileRoutes = [
                            1 => 'admin/profile',
                            2 => 'administrativo/profile',
                            3 => 'ti/profile',
                            4 => 'operativo/profile',
                            5 => 'callcenter/profile',
                            6 => 'navieras_resintos/profile',
                            7 => 'juridico/profile',
                            8 => 'calidad/profile',
                            9 => 'asociado/profile',
                            10 => 'asociadoCoordinador/profile',
                            11 => 'Gestion/profile',
                            12 => 'asociadoComun/profile',
                        ];

                        $profileUrl = $profileRoutes[$roleId] ?? '/Aaapumac/';
                    }
                    ?>

                    <div class="col-md-4">
                        <div class="banner-content">
                            <span class="promo-text wow fadeInLeft asociacion" data-wow-duration="1500ms" data-wow-delay="400ms">
                                Asociación de Agentes Aduanales del Puerto de Manzanillo
                            </span>
                            <h1 class="wow slideInLeft" data-wow-duration="1500ms" data-wow-delay="500ms" id="titulo">
                                <span class="highlight">Impulsando</span> la <br>
                                competitividad <br> en nuestro puerto
                            </h1>
                            <ul class="btn-wrap" style="list-style: none; padding: 0; margin: 0;" id="botones">
                                <li class="wow fadeInUp" data-wow-duration="1500ms" data-wow-delay="500ms">
                                    <a href="https://tickets.aaamzo.org.mx/" target="_blank" class="main-btn main-btn-3" id="Boton-ticket">
                                        Generar Ticket
                                    </a>
                                </li>
                                <li class="wow fadeInUp" data-wow-duration="1500ms" data-wow-delay="500ms">
                                    <a href="<?php echo htmlspecialchars($profileUrl); ?>" class="main-btn main-btn-3" id="Boton-asociarse">
                                        <?php echo htmlspecialchars($buttonText); ?>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-md-8 mx-auto wow fadeInRight" id="carrusel">
                        <div id="carouselExampleIndicators" class="carousel slide carousel-fade" data-ride="carousel"
                            style="width: 100%; height: 100%; overflow: hidden;">
                            <ol class="carousel-indicators">
                                <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                                <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                                <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                            </ol>
                            <div class="carousel-inner" style="width: 100%; height: auto;">
                                <div class="carousel-item active">
                                    <img src="/Aaapumac/src/views/assets/img/illustration/1080.jpg"
                                        class="d-block w-100 h-100" alt="Imagen 1"
                                        style="object-fit: cover; width: auto; height: auto;">
                                </div>
                                <div class="carousel-item">
                                    <img src="/Aaapumac/src/views/assets/img/illustration/Puerto_AAAPUMAC.jpg"
                                        class="d-block w-100 h-100" alt="Imagen 3"
                                        style="object-fit: cover; width: auto; height: auto;">
                                </div>
                                <div class="carousel-item">
                                    <img src="/Aaapumac/src/views/assets/img/illustration/video-2.jpg"
                                        class="d-block w-100 h-100" alt="Imagen 4"
                                        style="object-fit: cover; width: auto; height: auto;">
                                </div>
                            </div>
                            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button"
                                data-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="sr-only">Previous</span>
                            </a>
                            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button"
                                data-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="sr-only">Next</span>
                            </a>
                        </div>
                    </div>
                </div>
                <div>&nbsp;</div>
            </div>
        </div>
    </div>
</section>

<!-- SECCIÓN DE COMUNICADOS -->
<section id="comunicado" class="comunicado-section section-gap">
    <div style="padding: 30px; max-width: 1800px; margin: auto; font-family: Arial, sans-serif;">
        <div style="text-align: center; margin-bottom: 50px;">
            <h2 style="font-size: 2.5rem; font-weight: bold; color: #343a40; text-transform: uppercase; margin-bottom: 10px;">
                <span style="border-bottom: 4px solid #007bff; padding: 0 10px;">Comunicados</span>
            </h2>
            <p style="font-size: 1.2rem; color: #6c757d; max-width: 650px; margin: 0 auto;">
                Mantente informado con los <span style="color: #007bff; font-weight: bold;">últimos anuncios</span> y
                novedades importantes.
            </p>

            <!-- Mostrar cuántos anuncios hay -->
            <div style="margin-top: 10px; font-size: 0.9rem; color: #28a745;">
                <strong><?php echo $anunciosHandler->total_anuncios; ?></strong> anuncio(s) activo(s)
                <?php if ($anunciosHandler->expirados['expirados'] > 0): ?>
                    <br>
                <?php endif; ?>
            </div>
        </div>

        <div class="row align-items-center justify-content-center wow slideInLeft" id="clientSlider">

            <?php if ($anunciosHandler->error): ?>
                <!-- ERROR DE CONEXIÓN -->
                <div class="col-12">
                    <div style="text-align: center; padding: 50px; color: #721c24; background-color: #f8d7da; border: 1px solid #f5c6cb; border-radius: 5px; margin: 20px;">
                        <h3>Error de conexión</h3>
                        <p>No se pueden cargar los anuncios en este momento.</p>
                        <p style="font-size: 0.9rem; color: #856404;">
                            <strong>Detalle técnico:</strong> <?php echo htmlspecialchars($anunciosHandler->error); ?>
                        </p>

                        <!-- Información de solución -->
                        <div style="margin-top: 20px; padding: 15px; background: #fff3cd; border-radius: 4px; text-align: left;">
                            <small style="color: #856404;">
                                <strong>Solución rápida:</strong><br>
                                1. Verifica que el Event Scheduler esté activo en MySQL<br>
                                2. Revisa la vista: <code>SELECT * FROM vista_anuncios_expirados</code><br>
                                3. Si hay problemas, ejecuta manualmente:<br>
                                <code style="display: block; background: #f8f9fa; padding: 5px; margin: 5px 0;">
                                    UPDATE aaamodal SET visible = 0 WHERE visible = 1 AND created_at < NOW() - INTERVAL 24 HOUR
                                        </code>
                            </small>
                        </div>

                        <p style="margin-top: 20px;">
                            <a href="javascript:location.reload()"
                                style="padding: 8px 15px; background: #dc3545; color: white; text-decoration: none; border-radius: 4px; margin-right: 10px;">
                                Reintentar
                            </a>
                            <a href="phpmyadmin"
                                style="padding: 8px 15px; background: #6c757d; color: white; text-decoration: none; border-radius: 4px;">
                                Ver base de datos
                            </a>
                        </p>
                    </div>
                </div>

            <?php elseif ($anunciosHandler->total_anuncios > 0): ?>

                <?php foreach ($anunciosHandler->anuncios as $fila): ?>
                    <?php
                    $imagen = htmlspecialchars($fila['image']);
                    $titulo = htmlspecialchars($fila['title']);
                    $descripcion = htmlspecialchars($fila['description']);
                    $fecha_creacion = $fila['created_at'];
                    $horas_pasadas = $fila['horas_pasadas'];
                    $horas_restantes = $fila['horas_restantes'];
                    $minutos_pasados = $anunciosHandler->getMinutosPasados($horas_pasadas);
                    $estilo_tiempo = $anunciosHandler->getEstiloTiempo($horas_restantes);
                    $icono_tiempo = $anunciosHandler->getIconoTiempo($horas_restantes);
                    ?>

                    <div class="<?php echo $anunciosHandler->col_class; ?> mb-4">
                        <div style="background-color: #fff; border-radius: 4px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); overflow: hidden; transition: transform 0.3s ease; height: 650px; min-height: 500px; <?php echo ($horas_pasadas < 1) ? 'border-left: 4px solid #28a745;' : ''; ?>">

                            <!-- Etiqueta NUEVO si tiene menos de 1 hora -->
                            <?php if ($horas_pasadas < 1): ?>
                                <div style="position: absolute; top: 10px; right: 10px; background: #28a745; color: white; padding: 5px 10px; border-radius: 3px; font-size: 0.8rem; font-weight: bold; z-index: 10;">
                                    NUEVO
                                </div>
                            <?php endif; ?>

                            <!-- Imagen -->
                            <img src="<?php echo $imagen; ?>" alt="<?php echo $titulo; ?>"
                                style="width: 100%; height: 350px; object-fit: cover; cursor: pointer;"
                                data-bs-toggle="modal"
                                data-bs-target="#imageModal"
                                onclick="document.getElementById('modalImage').src=this.src">

                            <!-- Contenido -->
                            <div style="padding: 10px; display: flex; flex-direction: column; height: calc(100% - 310px);">
                                <!-- Título con scroll -->
                                <div style="margin-bottom: 15px; max-height: 100px; overflow-y: auto; overflow-x: hidden; scrollbar-width: thin;"
                                    class="titulo-scroll">
                                    <h3 style="font-size: 1.8rem; color: #007bff; margin: 0; word-wrap: break-word; line-height: 1.3;">
                                        <?php echo $titulo; ?>
                                    </h3>
                                </div>

                                <!-- Descripción con scroll -->
                                <div style="flex: 1; overflow-y: auto; overflow-x: hidden; margin-bottom: 15px; max-height: 150px; scrollbar-width: thin;"
                                    class="descripcion-scroll">
                                    <p style="font-size: 1.1rem; color: #6c757d; margin: 0; word-wrap: break-word; line-height: 1.5;">
                                        <?php echo nl2br($descripcion); ?>
                                    </p>
                                </div>

                                <!-- Información de tiempo -->
                                <div style="border-top: 1px solid #eee; padding-top: 10px; margin-top: auto;">
                                    <small style="color: #6c757d;">
                                        Publicado: <?php echo date('d/m/Y H:i', strtotime($fecha_creacion)); ?>
                                        <br>
                                        Hace: <?php echo $anunciosHandler->getTiempoTranscurrido($horas_pasadas, $minutos_pasados); ?>
                                    </small>
                                    <br>
                                    <small style="<?php echo $estilo_tiempo; ?>">
                                        <?php echo $icono_tiempo; ?>
                                        <?php echo $anunciosHandler->getTiempoRestante($horas_restantes); ?>
                                    </small>
                                    <!-- Progreso de tiempo -->
                                    <div style="margin-top: 5px; height: 4px; background: #e9ecef; border-radius: 2px;">
                                        <div style="height: 100%; width: <?php echo $anunciosHandler->getProgresoWidth($horas_pasadas); ?>%; 
                   background: <?php echo $anunciosHandler->getProgresoColor($horas_restantes); ?>; 
                   border-radius: 2px;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php endforeach; ?>

            <?php else: ?>
                <!-- NO HAY ANUNCIOS -->
                <div class="col-12">
                    <div id="avisos-principal">
                        <div class="icono-aviso">
                            📢
                        </div>
                        <h3 style="color: #6c757d; margin-bottom: 15px;">
                            No hay anuncios activos
                        </h3>
                        <p class="leyenda-avisos">
                            Los anuncios tienen una duración de <strong>24 horas</strong>.<br>
                            Cuando se publique uno nuevo, aparecerá aquí automáticamente.
                        </p>
                    </div>
                </div>
            <?php endif; ?>

        </div>

        <!-- Nota informativa -->
        <?php if ($anunciosHandler->total_anuncios > 0): ?>
            <div style="text-align: center; margin-top: 30px; padding: 15px; background-color: #f8f9fa; border-radius: 5px; border-left: 4px solid #007bff;">
                <small style="color: #6c757d;">
                    <strong>Información del sistema:</strong>
                    Cada anuncio permanece visible durante 24 horas exactas.
                </small>
            </div>
        <?php endif; ?>

    </div>
</section>

<!-- MODAL PARA IMAGEN -->
<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-body text-center">
                <img id="modalImage" src="" alt="Imagen ampliada"
                    style="width: 100%; height: auto; max-height: 80vh; object-fit: contain;">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>


<!-- SCRIPTS -->
<script>
    // Recargar automáticamente cada 30 minutos
    setTimeout(function() {
        console.log('Actualizando anuncios...');
        location.reload();
    }, 1800000);

    function formatearTiempo(horas, minutos) {
        let texto = '';
        if (horas > 0) texto += horas + ' hora' + (horas !== 1 ? 's' : '');
        if (minutos > 0) {
            if (texto !== '') texto += ' ';
            texto += minutos + ' minuto' + (minutos !== 1 ? 's' : '');
        }
        return texto;
    }

    // Verificar el estado del Event Scheduler
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Sistema de anuncios cargado');
        console.log('Event Scheduler configurado para limpiar cada hora');
        console.log('Total anuncios activos: <?php echo $anunciosHandler->total_anuncios; ?>');
        console.log('Clase de columna aplicada: <?php echo $anunciosHandler->col_class; ?>');
        <?php if ($anunciosHandler->expirados['expirados'] > 0): ?>
            console.warn('Anuncios pendientes de limpieza: <?php echo $anunciosHandler->expirados['expirados']; ?>');
        <?php endif; ?>
    });
</script>