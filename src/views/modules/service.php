<!-- Sección de Servicios -->
<section id="servicios" class="service-section shape-style-two service-line-shape section-gap grey-bg">
    <!-- Contenido de la sección de servicios -->
    <div class="container">
        <div class="section-title text-center both-border mb-50">
            <span class="title-tag">Nuestros Servicios</span>
            <h2 class="title">Brindamos gran <br> Variedad de Servicios</h2>
        </div>
        <div class="row service-boxes justify-content-center">
            <!-- Servicio: Operativo -->
            <div class="col-lg-3 col-sm-6 col-10  wow fadeInUp" data-wow-duration="2000ms" data-wow-delay="300ms">
                <div class="service-box-two">
                    <div class="icon">
                        <a href="#operativo" onclick="mostrarSeccion('operativo')"><i class="mdi mdi-truck"></i></a>
                    </div>
                    <h3><a href="#operativo" onclick="mostrarSeccion('operativo')">Operativo</a></h3>
                </div>
            </div>
            <!-- Servicio: Jurídico -->
            <div class="col-lg-3 col-sm-6 col-10  wow fadeInUp" data-wow-duration="2000ms" data-wow-delay="400ms">
                <div class="service-box-two">
                    <div class="icon">
                        <a href="#juridico" onclick="mostrarSeccion('juridico')"><i
                                class="mdi mdi-scale-balance"></i></a>
                    </div>
                    <h3><a href="#juridico" onclick="mostrarSeccion('juridico')">Jurídico</a></h3>
                </div>
            </div>
            <!-- Servicio: Arancelario -->
            <div class="col-lg-3 col-sm-6 col-10 wow fadeInUp" data-wow-duration="2000ms" data-wow-delay="500ms">
                <div class="service-box-two">
                    <div class="icon">
                        <a href="#arancelario" onclick="mostrarSeccion('arancelario')"><i
                                class="mdi mdi-magnify"></i></a>
                    </div>
                    <h3><a href="#arancelario" onclick="mostrarSeccion('arancelario')">Arancelario</a></h3>
                </div>
            </div>
            <!-- Servicio: Administrativo -->
            <div class="col-lg-3 col-sm-6 col-10  wow fadeInUp" data-wow-duration="2000ms" data-wow-delay="600ms">
                <div class="service-box-two">
                    <div class="icon">
                        <a href="#administrativo" onclick="mostrarSeccion('administrativo')"><i
                                class="mdi mdi-account-multiple"></i></a>
                    </div>
                    <h3><a href="#administrativo" onclick="mostrarSeccion('administrativo')">Administrativo</a></h3>
                </div>
            </div>
            <!-- Servicio: Call Center -->
            <div class="col-lg-3 col-sm-6 col-10 wow fadeInUp" data-wow-duration="2000ms" data-wow-delay="900ms">
                <div class="service-box-two">
                    <div class="icon">
                        <a href="#call" onclick="mostrarSeccion('call')"><i class="mdi mdi-phone"></i></a>
                    </div>
                    <h3><a href="#call" onclick="mostrarSeccion('call')">Call Center</a></h3>
                </div>
            </div>
        </div>
    </div>
    <!-- <div class="bg-animation-lines"
        style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: linear-gradient(135deg, rgba(0, 86, 179, 0.15) 25%, transparent 25%, transparent 50%, rgba(0, 86, 179, 0.15) 50%, rgba(0, 86, 179, 0.15) 75%, transparent 75%, transparent); background-size: 400% 400%; z-index: 1; pointer-events: none; animation: moveLines 10s linear infinite;">
    </div> -->
    <!--   <style>
        @keyframes moveLines {
            0% {
                background-position: 0 0;
            }

            100% {
                background-position: 100% 100%;
            }
        }

        .professional-bg-section img:hover {
            transform: scale(1);
        }
    </style> -->
    <style>
        /* Estilos para la sección de servicios */
        .service-section {
            padding: 80px 0;
            background: #f5f5f5;
        }

        .section-title {
            margin-bottom: 50px;
        }

        .service-box-two {
            background: #fff;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            padding: 30px;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            position: relative;
        }

        .service-box-two:hover {
            transform: translateY(-10px);
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
        }

        .service-box-two .icon {
            font-size: 50px;
            color: #007bff;
            margin-bottom: 20px;
        }

        .service-box-two .icon a {
            text-decoration: none;
            color: inherit;
            /* Mantener el color del ícono */
        }

        .service-box-two .icon a:hover {
            color: #0056b3;
        }

        .service-box-two:hover .icon i {
            color: #0056b3;
        }

        .service-box-two h3 {
            font-size: 22px;
            font-weight: 600;
            color: #333;
            margin-bottom: 15px;
        }

        .service-box-two a.service-link {
            color: #007bff;
            font-size: 18px;
            transition: color 0.3s ease;
        }

        .service-box-two a.service-link:hover {
            color: #0056b3;
        }

        .service-box-two .fal {
            font-size: 24px;
            transition: transform 0.3s ease;
        }

        .service-box-two a.service-link:hover .fal {
            transform: translateX(8px);
        }

        /* Estilos para la responsividad */
        @media (max-width: 767px) {
            .service-box-two {
                padding: 20px;
            }

            .service-box-two .icon {
                font-size: 40px;
            }

            .service-box-two h3 {
                font-size: 20px;
            }
        }
    </style>
</section><br>

<!-- Sección de Información: Operativo -->
<section id="operativo" class="wcu-section section-gap" style="display: none;">
    <div class="container">
        <!-- Contenido de la sección de información-->
        <div class="row align-items-center justify-content-center">
            <div class="col-lg-6 col-md-10">
                <div class="wcu-video wow flipInX" data-wow-duration="1500ms" data-wow-delay="400ms">
                    <div class="video-poster-one bg-img-c"
                        style="background-image: url(src/views/assets/img/servicios/ope.jpg);">
                    </div>
                    <div class="video-poster-two bg-img-c"
                        style="background-image: url(src/views/assets/img/valores/3.png);">
                        <!-- <a href="https://www.youtube.com/watch?v=fEErySYqItI" class="popup-video">
                            <i class="fas fa-play"></i>
                        </a> -->
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-10 wow flipInX" data-wow-duration="1500ms" data-wow-delay="600ms">
                <div class="wcu-text-two">
                    <div class="section-title left-border mb-40"
                        style="border-left: 5px solid #007bff; padding-left: 15px;">
                        <h2 class="title" style="color: #333; font-weight: bold;">Operativo</h2>
                    </div>
                    <p style="color: #555; font-size: 1rem; line-height: 1.6;">
                        Brindar asesoría y gestión a nuestros Asociados con la Comunidad Portuaria en materia de Comercio Exterior, creando procedimientos y acuerdos que permitan agilizar el despacho de la mercancía por este Puerto de Manzanillo, proporcionando los siguientes servicios:
                    </p>
                    <ul class="wcu-list clearfix" style="list-style: none; padding: 0; margin: 20px 0;">
                        <li style="margin-bottom: 10px; font-size: 1rem;">
                            <i class="far fa-check-circle"
                                style="color: #007bff; margin-right: 8px; font-size: 1.5rem;"></i> Atender consultas operativas
                            de nuestros Asociados
                        </li>
                        <li style="margin-bottom: 10px; font-size: 1rem;">
                            <i class="far fa-check-circle"
                                style="color: #007bff; margin-right: 8px; font-size: 1.5rem;"></i>Solventar consultas a los Asociados cuando se presentan en las plataformas de Primer Reconocimiento
                        </li>
                        <li style="margin-bottom: 10px; font-size: 1rem;">
                            <i class="far fa-check-circle"
                                style="color: #007bff; margin-right: 8px; font-size: 1.5rem;"></i>Asistencia al Asociado en reuniones Operativas con la Aduana de Manzanillo
                        </li>
                        <li style="margin-bottom: 10px; font-size: 1rem;">
                            <i class="far fa-check-circle"
                                style="color: #007bff; margin-right: 8px; font-size: 1.5rem;"></i>Apoyo en aperturas de contenedores por Multidependientes AAAPUMAC en Plataformas de Primer Reconocimiento en San Pedrito, Zona Norte y Recintos Fiscalizados para operaciones de importación y exportación
                        </li>
                        <li style="margin-bottom: 10px; font-size: 1rem;">
                            <i class="far fa-check-circle"
                                style="color: #007bff; margin-right: 8px; font-size: 1.5rem;"></i>Notificaciones de Reconocimientos Aduaneros en Recintos Fiscalizados y Recintos Fiscalizados Estratégicos (RFE) vía telefónica
                        </li>
                        <li style="margin-bottom: 10px; font-size: 1rem;">
                            <i class="far fa-check-circle"
                                style="color: #007bff; margin-right: 8px; font-size: 1.5rem;"></i>Apoyo y coordinación con la Agencia Aduanal para la revisión y liberación de pedimentos M3 en las plataformas de San Pedrito y Zona Norte
                        </li>
                        <li style="margin-bottom: 10px; font-size: 1rem;">
                            <i class="far fa-check-circle"
                                style="color: #007bff; margin-right: 8px; font-size: 1.5rem;"></i> Recepción de pedimentos para modulación de Exportación, Tránsitos e Importación por Ferrocarril, RFE, ubicado en el edificio de Gestiones Portuarias
                        </li>
                        <li style="margin-bottom: 10px; font-size: 1rem;">
                            <i class="far fa-check-circle"
                                style="color: #007bff; margin-right: 8px; font-size: 1.5rem;"></i>Sistema de trazabilidad de pedimentos de importación por ferrocarril, exportación, Recinto Fiscalizado Estratégico (RFE), en el módulo de gestiones portuarias
                        </li>
                        <li style="margin-bottom: 10px; font-size: 1rem;">
                            <i class="far fa-check-circle"
                                style="color: #007bff; margin-right: 8px; font-size: 1.5rem;"></i>Asistencia en la intervención de Multidependiente en PROFEPA para tratar temas relacionados con la mejora en procesos del despacho aduanero a través del Ticket de Servicio
                        </li>
                    </ul>
                    <!--    <div style="text-align: center;">
                        <a href="#" class="btn"
                            style="background-color: #007bff; color: #fff; padding: 12px 24px; border-radius: 50px; text-decoration: none; font-weight: bold; border: 2px solid #007bff; transition: background-color 0.3s, color 0.3s, border-color 0.3s; display: inline-flex; align-items: center; justify-content: center;line-height: 1.5;"
                            onmouseover="this.style.backgroundColor='#0056b3'; this.style.borderColor='#0056b3';"
                            onmouseout="this.style.backgroundColor='#007bff'; this.style.borderColor='#007bff';">
                            <i class="fa fa-arrow-right" style="margin-right: 8px;"></i> Ver Más
                        </a>
                    </div> -->
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Sección de Información: juridico -->
<section id="juridico" class="wcu-section section-gap" style="display: none;">
    <div class="container">
        <!-- Contenido de la sección de información-->
        <div class="row align-items-center justify-content-center">
            <div class="col-lg-6 col-md-10">
                <div class="wcu-video wow flipInX" data-wow-duration="1500ms" data-wow-delay="400ms">
                    <div class="video-poster-one bg-img-c"
                        style="background-image: url(src/views/assets/img/servicios/juri.jpg);">
                    </div>
                    <div class="video-poster-two bg-img-c"
                        style="background-image: url(src/views/assets/img/valores/6.png);">
                        <!-- <a href="https://www.youtube.com/watch?v=fEErySYqItI" class="popup-video">
                            <i class="fas fa-play"></i>
                        </a> -->
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-10 wow flipInX" data-wow-duration="1500ms" data-wow-delay="600ms">
                <div class="wcu-text-two">
                    <div class="section-title left-border mb-40"
                        style="border-left: 5px solid #007bff; padding-left: 15px;">
                        <h2 class="title" style="color: #333; font-weight: bold;">Jurídico</h2>
                    </div>
                    <p style="color: #555; font-size: 1rem; line-height: 1.6;">
                        El objetivo es satisfacer en tiempo y forma los requerimientos que surjan en materia de Comercio Exterior a nuestros Asociados, a través de servicios de asesoría, gestión y difusión de la normatividad vigente.
                    </p>
                    <ul class="wcu-list clearfix" style="list-style: none; padding: 0; margin: 20px 0;">
                        <li style="margin-bottom: 10px; font-size: 1rem;">
                            <i class="far fa-check-circle"
                                style="color: #007bff; margin-right: 8px; font-size: 1.5rem;"></i>Solicitud de Ingreso a los convenios para la no presentación de garantías ante Navieras.
                        </li>
                        <li style="margin-bottom: 10px; font-size: 1rem;">
                            <i class="far fa-check-circle"
                                style="color: #007bff; margin-right: 8px; font-size: 1.5rem;"></i>Solicitud de justificaciones ante la Aduana.
                        </li>
                        <li style="margin-bottom: 10px; font-size: 1rem;">
                            <i class="far fa-check-circle"
                                style="color: #007bff; margin-right: 8px; font-size: 1.5rem;"></i>Solicitud de liberaciones del prevalidador de la CAAAREM.
                        </li>
                        <li style="margin-bottom: 10px; font-size: 1rem;">
                            <i class="far fa-check-circle"
                                style="color: #007bff; margin-right: 8px; font-size: 1.5rem;"></i>Solicitud de Reportes de Mesa de Ayuda a través de la CAAAREM.
                        </li>
                        <li style="margin-bottom: 10px; font-size: 1rem;">
                            <i class="far fa-check-circle"
                                style="color: #007bff; margin-right: 8px; font-size: 1.5rem;"></i> Revisión de Formulario Múltiple de Pago de Comercio Exterior mediante línea de captura.
                        </li>
                        <li style="margin-bottom: 10px; font-size: 1rem;">
                            <i class="far fa-check-circle"
                                style="color: #007bff; margin-right: 8px; font-size: 1.5rem;"></i>Presencia de Multidependiente Jurídico en plataforma de San Pedrito y Gestiones Portuarias.
                        </li>
                        <li style="margin-bottom: 10px; font-size: 1rem;">
                            <i class="far fa-check-circle"
                                style="color: #007bff; margin-right: 8px; font-size: 1.5rem;"></i>Solicitud de elaboración de escritos de pruebas y alegatos derivados de Procedimientos Administrativos.
                        </li>
                        <li style="margin-bottom: 10px; font-size: 1rem;">
                            <i class="far fa-check-circle"
                                style="color: #007bff; margin-right: 8px; font-size: 1.5rem;"></i> Solicitud de elaboración de Recursos de Revocación.
                        </li>
                        <li style="margin-bottom: 10px; font-size: 1rem;">
                            <i class="far fa-check-circle"
                                style="color: #007bff; margin-right: 8px; font-size: 1.5rem;"></i>Seguimiento a notificaciones de Actas de Inicio de PAMA's, retenciones o incidencias simples.
                        </li>
                        <li style="margin-bottom: 10px; font-size: 1rem;">
                            <i class="far fa-check-circle"
                                style="color: #007bff; margin-right: 8px; font-size: 1.5rem;"></i>Seguimientos a notificaciones de oficios de liberacion de mercancias derivado de Procedimientos Administrativos iniciados por la Autoridad Aduanera.
                        </li>
                        <li style="margin-bottom: 10px; font-size: 1rem;">
                            <i class="far fa-check-circle"
                                style="color: #007bff; margin-right: 8px; font-size: 1.5rem;"></i>Seguimiento en el trámite de revisión de operaciones bajo la clave de pedimento "A3".
                        </li>
                        <li style="margin-bottom: 10px; font-size: 1rem;">
                            <i class="far fa-check-circle"
                                style="color: #007bff; margin-right: 8px; font-size: 1.5rem;"></i>Seguimiento de inmovilización de contenedores por Autoridades Coordinadas.
                        </li>
                        <li style="margin-bottom: 10px; font-size: 1rem;">
                            <i class="far fa-check-circle"
                                style="color: #007bff; margin-right: 8px; font-size: 1.5rem;"></i>Seguimiento a Abandono de Mercancías.
                        </li>
                        <li style="margin-bottom: 10px; font-size: 1rem;">
                            <i class="far fa-check-circle"
                                style="color: #007bff; margin-right: 8px; font-size: 1.5rem;"></i>Seguimiento para la revisión de incidencias de incumplimiento de etiquetado.
                        </li>
                        <li>
                            <i class="far fa-check-circle"
                                style="color: #007bff; margin-right: 8px; font-size: 1.5rem;"></i>Solicitud de citas con el área de Asuntos Legales de la Aduana y usuarios.
                        </li>
                    </ul>
                    <!-- <div style="text-align: center;">
                        <a href="#" class="btn"
                            style="background-color: #007bff; color: #fff; padding: 12px 24px; border-radius: 50px; text-decoration: none; font-weight: bold; border: 2px solid #007bff; transition: background-color 0.3s, color 0.3s, border-color 0.3s; display: inline-flex; align-items: center; justify-content: center;line-height: 1.5;"
                            onmouseover="this.style.backgroundColor='#0056b3'; this.style.borderColor='#0056b3';"
                            onmouseout="this.style.backgroundColor='#007bff'; this.style.borderColor='#007bff';">
                            <i class="fa fa-arrow-right" style="margin-right: 8px;"></i> Ver Más
                        </a>
                    </div> -->
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Sección de Información: arancelario -->
<section id="arancelario" class="wcu-section section-gap" style="display: none;">
    <div class="container">
        <!-- Contenido de la sección de información-->
        <div class="row align-items-center justify-content-center">
            <div class="col-lg-6 col-md-10">
                <div class="wcu-video wow flipInX" data-wow-duration="1500ms" data-wow-delay="400ms">
                    <div class="video-poster-one bg-img-c"
                        style="background-image: url(src/views/assets/img/servicios/aran.jpg);"></div>
                    <div class="video-poster-two bg-img-c"
                        style="background-image: url(src/views/assets/img/valores/03.png);">
                        <!-- <a href="https://www.youtube.com/watch?v=fEErySYqItI" class="popup-video">
                            <i class="fas fa-play"></i>
                        </a> -->
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-10 wow flipInX" data-wow-duration="1500ms" data-wow-delay="600ms">
                <div class="wcu-text-two">
                    <div class="section-title left-border mb-40"
                        style="border-left: 5px solid #007bff; padding-left: 15px;">
                        <h2 class="title" style="color: #333; font-weight: bold;">Arancelario</h2>
                    </div>
                    <p style="color: #555; font-size: 1rem; line-height: 1.6;">
                        Nuestro objetivo es proporcionar a todos los Asociados de manera simple y precisa la Clasificación Arancelaria de las mercancías y hacer de conocimiento los criterios y/o lineamientos que la autoridad aduanera determine en materia Arancelaria:
                    </p>
                    <ul class="wcu-list clearfix" style="list-style: none; padding: 0; margin: 20px 0;">
                        <li style="margin-bottom: 10px; font-size: 1rem;">
                            <i class="far fa-check-circle"
                                style="color: #007bff; margin-right: 8px; font-size: 1.5rem;"></i>Atención y seguimiento oportuno en asesoría de clasificación arancelaria a consultas realizadas por Ticket de Servicio.
                        </li>
                        <li style="margin-bottom: 10px; font-size: 1rem;">
                            <i class="far fa-check-circle"
                                style="color: #007bff; margin-right: 8px; font-size: 1.5rem;"></i> Atender y asesorar a los Asociados de manera personalizada
                        </li>
                        <li style="margin-bottom: 10px; font-size: 1rem;">
                            <i class="far fa-check-circle"
                                style="color: #007bff; margin-right: 8px; font-size: 1.5rem;"></i> Asistencia en plataforma San Pedrito y Zona Norte para dar seguimiento oportuno con la Autoridad Aduanera derivado de alguna irregularidad en la clasificación arancelaria.
                        </li>
                        <li style="margin-bottom: 10px; font-size: 1rem;">
                            <i class="far fa-check-circle"
                                style="color: #007bff; margin-right: 8px; font-size: 1.5rem;"></i> Ofrecer base de datos a través del portal web para la consulta de mercancías en general.
                        </li>
                        <li style="margin-bottom: 10px; font-size: 1rem;">
                            <i class="far fa-check-circle"
                                style="color: #007bff; margin-right: 8px; font-size: 1.5rem;"></i> Desarrollar Análisis mercancias en controversia.
                        </li>
                        <li style="margin-bottom: 10px; font-size: 1rem;">
                            <i class="far fa-check-circle"
                                style="color: #007bff; margin-right: 8px; font-size: 1.5rem;"></i> Asesoría y gestion con la Autoridad Aduanera en solicitudes de Juntas Tecnicas Previas y de Irregularidad conforme la RGCE 3.7.7.
                        </li>
                        <li style="margin-bottom: 10px; font-size: 1rem;">
                            <i class="far fa-check-circle"
                                style="color: #007bff; margin-right: 8px; font-size: 1.5rem;"></i> Ofrecer capacitaciones mensuales a los clasificadores via Teams.
                        </li>
                        <li style="margin-bottom: 10px; font-size: 1rem;">
                            <i class="far fa-check-circle"
                                style="color: #007bff; margin-right: 8px; font-size: 1.5rem;"></i> Entrega de muestras correctas y oficios.
                        </li>
                    </ul>
                    <!-- <div style="text-align: center;">
                        <a href="#" class="btn"
                            style="background-color: #007bff; color: #fff; padding: 12px 24px; border-radius: 50px; text-decoration: none; font-weight: bold; border: 2px solid #007bff; transition: background-color 0.3s, color 0.3s, border-color 0.3s; display: inline-flex; align-items: center; justify-content: center;line-height: 1.5;"
                            onmouseover="this.style.backgroundColor='#0056b3'; this.style.borderColor='#0056b3';"
                            onmouseout="this.style.backgroundColor='#007bff'; this.style.borderColor='#007bff';">
                            <i class="fa fa-arrow-right" style="margin-right: 8px;"></i> Ver Más
                        </a>
                    </div> -->
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Sección de Información: administrativo -->
<section id="administrativo" class="wcu-section section-gap" style="display: none;">
    <div class="container">
        <!-- Contenido de la sección de información-->
        <div class="row align-items-center justify-content-center">
            <div class="col-lg-6 col-md-10">
                <div class="wcu-video wow flipInX" data-wow-duration="1500ms" data-wow-delay="400ms"
                    style="background-color: #ffffff; padding: 15px; border-radius: 8px;">
                    <div class="video-poster-one bg-img-c"
                        style="background-image: url(src/views/assets/img/servicios/admi.png); background-color: #ffffff;">
                    </div>
                    <div class="video-poster-two bg-img-c"
                        style="background-image: url(src/views/assets/img/valores/05.png);">
                        <!--  <a href="https://www.youtube.com/watch?v=fEErySYqItI" class="popup-video">
                            <i class="fas fa-play"></i>
                        </a> -->
                    </div>
                </div>
            </div>

            <div class="col-lg-6 col-md-10 wow flipInX" data-wow-duration="1500ms" data-wow-delay="600ms">
                <div class="wcu-text-two">
                    <div class="section-title left-border mb-40"
                        style="border-left: 5px solid #007bff; padding-left: 15px;">
                        <h2 class="title" style="color: #333; font-weight: bold;">Administrativo</h2>
                    </div>
                    <p style="color: #555; font-size: 1rem; line-height: 1.6;">
                    El objetivo es brindar servicios de valor agregado que ayuden a nuestros asociados a mejorar sus procesos administrativos y proporcionen a sus colaboradores y familiares beneficios únicos mediante los convenios realizados entre la Asociación y proveedores de servicios e instituciones.
                    </p>
                    <ul class="wcu-list clearfix" style="list-style: none; padding: 0; margin: 20px 0;">
                        <li style="margin-bottom: 10px; font-size: 1rem;">
                            <i class="far fa-check-circle"
                                style="color: #007bff; margin-right: 8px; font-size: 1.5rem;"></i>Administración del Auditorio “Benito Guerrero Herrera” para talleres, reuniones de trabajo, capacitaciones y conferencias.
                        </li>
                        <li style="margin-bottom: 10px; font-size: 1rem;">
                            <i class="far fa-check-circle"
                                style="color: #007bff; margin-right: 8px; font-size: 1.5rem;"></i> Concertación de convenios con Universidades, Proveedores y/o Prestadores de Servicios para colaboradores de Agencias Aduanales asociados.
                        </li>
                        <li style="margin-bottom: 10px; font-size: 1rem;">
                            <i class="far fa-check-circle"
                                style="color: #007bff; margin-right: 8px; font-size: 1.5rem;"></i> Servicio de captación de C.V.  para bolsa         de trabajo.
                        </li>
                    </ul>
                    <!-- <div style="text-align: center;">
                        <a href="#" class="btn"
                            style="background-color: #007bff; color: #fff; padding: 12px 24px; border-radius: 50px; text-decoration: none; font-weight: bold; border: 2px solid #007bff; transition: background-color 0.3s, color 0.3s, border-color 0.3s; display: inline-flex; align-items: center; justify-content: center;line-height: 1.5;"
                            onmouseover="this.style.backgroundColor='#0056b3'; this.style.borderColor='#0056b3';"
                            onmouseout="this.style.backgroundColor='#007bff'; this.style.borderColor='#007bff';">
                            <i class="fa fa-arrow-right" style="margin-right: 8px;"></i> Ver Más
                        </a>
                    </div> -->
                </div>
            </div>

        </div>
    </div>
</section>

<!-- Sección de Información: callcenter -->
<section id="call" class="wcu-section section-gap" style="display: none;">
    <div class="container">
        <!-- Contenido de la sección de información -->
        <div class="row align-items-center justify-content-center">
            <div class="col-lg-6 col-md-10">
                <div class="wcu-video wow flipInX" data-wow-duration="1500ms" data-wow-delay="400ms">
                    <div class="video-poster-one bg-img-c"
                        style="background-image: url(src/views/assets/img/servicios/calll.jpg);"></div>
                    <div class="video-poster-two bg-img-c"
                        style="background-image: url(src/views/assets/img/valores/06.png);">
                        <!-- <a href="https://www.youtube.com/watch?v=fEErySYqItI" class="popup-video">
                            <i class="fas fa-play"></i>
                        </a> -->
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-10 wow flipInX" data-wow-duration="1500ms" data-wow-delay="600ms">
                <div class="wcu-text-two">
                    <div class="section-title left-border mb-40"
                        style="border-left: 5px solid #007bff; padding-left: 15px;">
                        <h2 class="title" style="color: #333; font-weight: bold;">Callcenter</h2>
                    </div>
                    <p style="color: #555; font-size: 1rem; line-height: 1.6;">
                        El objetivo es atender las solicitudes de apoyo y consultas de los Asociados, fungiendo como intermediario ante los diferentes Actores Portuarios en el seguimiento y la gestión a sus requerimientos, así como la reasignación de ticket de servicios derivadas de las consultas operativas, jurídicas y de clasificación arancelarias que sean solicitados por los Asociados. Otorgando los siguientes servicios
                    </p>
                    <ul class="wcu-list clearfix" style="list-style: none; padding: 0; margin: 20px 0;">
                        <li style="margin-bottom: 10px; font-size: 1rem;">
                            <i class="far fa-check-circle"
                                style="color: #007bff; margin-right: 8px; font-size: 1.5rem;"></i> Emisión de boletines, comunicados y circulares.
                        </li>
                        <li style="margin-bottom: 10px; font-size: 1rem;">
                            <i class="far fa-check-circle"
                                style="color: #007bff; margin-right: 8px; font-size: 1.5rem;"></i> Gestión para Constancias Temporal de Importación (DGA)
                        </li>
                        <li style="margin-bottom: 10px; font-size: 1rem;">
                            <i class="far fa-check-circle"
                                style="color: #007bff; margin-right: 8px; font-size: 1.5rem;"></i> Atención y seguimiento oportuno de las solicitudes de apoyo a las consultas de los Asociados a través del Ticket de Servicio.
                        </li>
                        <li style="margin-bottom: 10px; font-size: 1rem;">
                            <i class="far fa-check-circle"
                                style="color: #007bff; margin-right: 8px; font-size: 1.5rem;"></i>Brindar asesoría a los Asociados inherentes a las operaciones de Comercio Exterior
                        </li>
                        <li style="margin-bottom: 10px; font-size: 1rem;">
                            <i class="far fa-check-circle"
                                style="color: #007bff; margin-right: 8px; font-size: 1.5rem;"></i> Recepción y seguimiento a solicitudes de programación de Revisión Aduana-SEMAR mediante Ticket de Servicio.
                        </li>
                        <li>
                            <i class="far fa-check-circle"
                                style="color: #007bff; margin-right: 8px; font-size: 1.5rem;"></i> Coordinación y seguimiento a solicitudes de programación de Revisión de COFEPRIS, Aduana- SEMAR.
                        </li>
                        <li>
                            <i class="far fa-check-circle"
                                style="color: #007bff; margin-right: 8px; font-size: 1.5rem;"></i>Notificación de programación para revisión con SEDENA
                        </li>
                    </ul>
                    <!-- <div style="text-align: center;">
                        <a href="#" class="btn"
                            style="background-color: #007bff; color: #fff; padding: 12px 24px; border-radius: 50px; text-decoration: none; font-weight: bold; border: 2px solid #007bff; transition: background-color 0.3s, color 0.3s, border-color 0.3s; display: inline-flex; align-items: center; justify-content: center; line-height: 1.5;"
                            onmouseover="this.style.backgroundColor='#0056b3'; this.style.borderColor='#0056b3';"
                            onmouseout="this.style.backgroundColor='#007bff'; this.style.borderColor='#007bff';">
                            <i class="fa fa-arrow-right" style="margin-right: 8px;"></i> Ver Más
                        </a>
                    </div> -->
                </div>
            </div>

        </div>
    </div>
</section>

<script>
    /* Manejar el clic en los enlaces de servicio */
    document.querySelectorAll('.service-link').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();

            const target = this.getAttribute('href');
            document.querySelector(target).scrollIntoView({
                behavior: 'smooth'
            });

            // Mostrar la sección correspondiente al ID después del desplazamiento
            mostrarSeccion(target.substring(1));
        });
    });

    /* Función para mostrar la sección correspondiente */
    function mostrarSeccion(id) {
        // Ocultar todas las secciones
        document.querySelectorAll('.wcu-section').forEach(seccion => {
            seccion.style.display = 'none';
        });
        /*  Mostrar la sección correspondiente al ID */
        document.getElementById(id).style.display = 'block';
    }
</script>