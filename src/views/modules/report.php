<link rel="stylesheet" href="/Aaapumac/src/views/assets/css/report.css">
<section class="contact-section">
    <div class="container col-10">
        <div class="contact-inner">
            <div class="contact-container">
                <!-- Sección de Título -->
                <div class="section-title-left wow slideInRight" data-wow-duration="1500ms" data-wow-delay="400ms">
                    <span class="title-tag">
                        ¿Quieres reportar un acto de soborno en AAAPUMAC?
                    </span>
                    <h3 class="title">
                        Para nosotros atenderte es prioridad
                    </h3>
                </div>
                <!-- Sección de Información de Contacto -->
                <div class="contact-info-content-right contenedor-info-soborno wow slideInLeft"
                    data-wow-duration="1500ms" data-wow-delay="400ms">
                    <ul class="about-list">
                        <li id="numero">
                            <i class="mdi mdi-phone" id="phone"></i>
                            <a href="tel:+3143311500" class="num">
                                (314) 141-1386
                            </a>
                        </li>
                        <li id="correo">
                            <i class="mdi mdi-email corr"></i>
                            <a href="mailto:reporte.antisoborno@aaamzo.org.mx" id="emal">
                                reporte.antisoborno@aaamzo.org.mx
                            </a>
                        </li>
                        <li class="calle">
                            <i class="mdi mdi-map-marker" id="call"></i>
                            <span class="calle-texto">
                                28219, Calle 1 Nte. 12, Fondeport, Manzanillo, Colima
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
            <!-- Mostrar mensajes de éxito/error -->
            <?php if (isset($_SESSION['reporte_exito'])): ?>
                <div class="alert alert-success">
                    <?php echo $_SESSION['reporte_exito']; ?>
                </div>
                <?php unset($_SESSION['reporte_exito']); endif; ?>

            <?php if (isset($_SESSION['reporte_error'])): ?>
                <div class="alert alert-danger">
                    <?php echo $_SESSION['reporte_error']; ?>
                </div>
                <?php unset($_SESSION['reporte_error']); endif; ?>
            <!-- Formulario de Contacto -->
            <form action="/Aaapumac/correos/phpmailer.php" name="mail" id="mail" method="POST"
                enctype="multipart/form-data">
                <div id="contenedor-principal" class="row">
                    <!-- Nombre -->
                    <div class="col-lg-6 mb-4 wow fadeInUp">
                        <div class="form-group nombre">
                            <i class="mdi mdi-account" id="icono-nombre"></i>
                            <input id="firstname" name="firstname" type="text" placeholder="Nombre"
                                onkeypress="return soloLetras(event)">
                        </div>
                    </div>
                    <!-- Apellido -->
                    <div class="col-lg-6 mb-4 wow fadeInUp">
                        <div class="form-group apellido">
                            <i class="mdi mdi-account" id="apelli"></i>
                            <input id="lastname" name="lastname" type="text" placeholder="Apellido"
                                onkeypress="return soloLetras(event)">
                        </div>
                    </div>
                    <!-- Empresa -->
                    <div class="col-lg-6 mb-4 wow fadeInUp">
                        <div class="form-group contenedor-empresa" style="position: relative;">
                            <i class="mdi mdi-office-building icono-empresa"></i>
                            <input id="empresa" name="empresa" type="text" placeholder="Empresa"
                                onkeypress="return soloLetras(event)">
                        </div>
                    </div>
                    <!-- Ocupación -->
                    <div class="col-lg-6 mb-4 wow fadeInUp">
                        <div class="form-group contenedor-ocupacion">
                            <i class="mdi mdi-briefcase icono-ocupacion"></i>
                            <input id="ocupacion" name="ocupacion" type="text" placeholder="Ocupación"
                                onkeypress="return soloLetras(event)">
                        </div>
                    </div>
                    <!-- Correo -->
                    <div class="col-lg-6 mb-4 wow fadeInUp">
                        <div class="form-group conte-correo">
                            <i class="mdi mdi-email iconno-correo"></i>
                            <input type="email" id="email" name="email" placeholder="Correo" maxlength="50">
                        </div>
                    </div>
                    <!-- Teléfono -->
                    <div class="col-lg-6 mb-4 wow fadeInUp">
                        <div class="form-group contenedor-telefono">
                            <i class="mdi mdi-phone icono-telefono"></i>
                            <input id="tel" name="tel" type="tel" placeholder="Teléfono" maxlength="15">
                        </div>
                    </div>
                    <!-- Descripción -->
                    <div class="col-12 mb-4 wow fadeInUp">
                        <div class="form-group contenedor-descrip">
                            <i class="mdi mdi-text-box" id="icono-descrip"></i>
                            <textarea id="message" name="message"
                                placeholder="Aquí deberá exponer detallada y coherentemente los hechos, por ejemplo: ¿Cuándo y dónde ocurrieron?, ¿Quién incurrió en un posible acto de soborno y quiénes más pueden hallarse involucrados?, ¿Quién más puede poseer información al respecto? y ¿Quién sabrá que el reporte fue remitido?"
                                required></textarea>
                            <small class="aportar-evidencia">Adicionalmente, deberá aportar evidencia respecto a los
                                hechos denunciados.</small>
                        </div>
                    </div>
                    <!--Abjuntar archivos-->
                    <div class="col-12 wow fadeInUp">
                        <div class="form-group contenedor-archivos">
                            <label for="archivos">Adjuntar
                                Archivo</label>
                            <input type="file" name="archivos[]" id="archivos" multiple class="adjuntos-archivos">
                        </div>
                    </div>
                    <!-- Captcha -->
                </div>

                <div class="col-12 wow fadeInUp contenedor-boton-enviar">
                    <button type="submit" id="boton-submi"
                        onmouseover="this.style.backgroundColor='#3498db'; this.style.color='#fff';"
                        onmouseout="this.style.backgroundColor='transparent'; this.style.color='#3498db';">
                        <i class="far fa-paper-plane" class="icono-boton"></i> Enviar mensaje
                    </button>
                </div>
                <div class="col-12 text-left wow fadeInUp contenedor-info-soborno">
                    <small class="Texto-privacidad">La reserva sobre la identidad del denunciante será
                        mantenida durante el transcurso de toda la investigación y aún con posterioridad a su
                        cierre. La información de contacto es de carácter confidencial y no será divulgada bajo
                        ninguna circunstancia.</small>
                </div>

                <!-- Sección de Información de Contacto -->
                <div class="contact-info-content-right contenedor-info-soborno-bajo wow slideInLeft"
                    data-wow-duration="1500ms" data-wow-delay="400ms">
                    <ul class="about-list-bajo">
                        <li id="numero-bajo">
                            <i class="mdi mdi-phone" id="phone-bajo"></i>
                            <a href="tel:+3143311500" class="num-bajo">
                                (314) 141-1386
                            </a>
                        </li>
                        <li id="correo-bajo">
                            <i class="mdi mdi-email corr-bajo"></i>
                            <a href="mailto:reporte.antisoborno@aaamzo.org.mx" id="emal-bajo">
                                reporte.antisoborno@aaamzo.org.mx
                            </a>
                        </li>
                        <li class="calle-bajo">
                            <i class="mdi mdi-map-marker" id="call-bajo"></i>
                            <span class="calle-texto-bajo">
                                28219, Calle 1 Nte. 12, Fondeport, Manzanillo, Colima
                            </span>
                        </li>
                    </ul>
                </div>
                <input type="hidden" name="_next" value="http://localhost">
            </form>
        </div>
    </div>
</section>