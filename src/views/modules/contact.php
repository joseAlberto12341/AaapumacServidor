<link rel="stylesheet" href="/Aaapumac/src/views/assets/css/contacto.css">
<section class="contact-section">
    <div class="container col-10">
        <div class="contact-inner wow fadeInUp">
            <div class="section-title-left wow slideInRight" data-wow-duration="1500ms" data-wow-delay="400ms">
                <span class="title-tag titulo-uno">
                    Para nosotros atenderte es prioridad
                </span>
                <h3 class="title titulo-dos">
                    Tenemos presencia cerca del puerto
                </h3>
            </div>

            <div class="row no-gutters align-items-center">
                <div class="col-lg-6 contenedor-mapa">
                    <div class="contact-map">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1333.118769684698!2d-104.28958050890178!3d19.08002998494151!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8424d5f4464e2955%3A0xa3eed2673c40351c!2sAsociaci%C3%B3n%20de%20Agentes%20Aduanales%20del%20Puerto%20de%20Manzanillo%20Colima%20A.C.%20(AAAPUMAC)!5e0!3m2!1ses-419!2smx!4v1690472639027!5m2!1ses-419!2smx"
                            width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="contact-form">
                        <div class="section-title text-center wow slideInLeft" data-wow-duration="1500ms"
                            data-wow-delay="400ms" id="section-title">
                            <span class="title-tag titulo-tres">
                                Déjanos tu mensaje
                            </span>
                            <h2 class="title titulo-cuatro">
                                No dude en contactar con nosotros
                            </h2>
                        </div>
                        
                        <!-- Formulario modificado para usar tu sistema -->
                        <!-- Nombre -->
                        <form method="POST"  action="/Aaapumac/correos/funcion-mail.php" id="contactForm">
                            <div class="row">
                                <div class="col-12">
                                    <div class="input mb-30 contenedor-nombre">
                                        <input type="text" class="form-control form-nombre" name="nombre"
                                            placeholder="Nombre completo" required>
                                        <span class="icon icono-nombre"><i class="far fa-user-circle"></i></span>
                                    </div>
                                </div>
                            <!-- Correo electronico-->
                                <div class="col-12">
                                    <div class="input mb-30 contenedor-correo">
                                        <input type="email" class="form-control formulario-email" name="email"
                                            placeholder="Correo electrónico" required>
                                        <span class="icon icono-email"><i class="far fa-envelope-open"></i></span>
                                    </div>
                                </div>
                            <!-- Asunto -->
                                <div class="col-12">
                                    <div class="input-group select mb-30">
                                        <select class="form-control formulario-asunto" name="asunto" required>
                                            <option value="" disabled selected>Selecciona un asunto</option>
                                            <option value="Idea creativa">Idea creativa</option>
                                            <option value="Asociarme con AAAPUMAC">Asociate con AAAPUMAC</option>
                                            <option value="Felicitaciones">Felicitaciones</option>
                                            <option value="Estrategia empresarial">Estrategia empresarial</option>
                                            <option value="Sugerencia">Sugerencia</option>
                                            <option value="Queja">Queja</option>
                                            <option value="Soluciones de TI">Soluciones de TI</option>
                                        </select>
                                        <span class="icon"><i class="fas fa-angle-down"></i></span>
                                    </div>
                                </div>
                                <!--Mensaje --> 
                                <div class="col-12">
                                    <div class="input textarea mb-30 contenedor-mensaje">
                                        <textarea class="form-control formulario-mensaje" name="mensaje" placeholder="Escribe aquí tu mensaje" rows="4" required></textarea>
                                        <span class="icon icono-mensaje"><i class="fas fa-pencil-alt"></i></span>
                                    </div>
                                </div>
                            <!--Boton guardar-->
                                <div class="col-12 wow fadeInUp contenedor-boton">
                                    <button type="submit" id="submitBtn" 
                                        onmouseover="this.style.backgroundColor='#3498db'; this.style.color='#fff';"
                                        onmouseout="this.style.backgroundColor='transparent'; this.style.color='#3498db';">
                                        <i class="far fa-paper-plane" id="enviarM"></i> Enviar mensaje
                                    </button>
                                    <div id="mensajeRespuesta"></div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="contact-info mt-40 informacion-contacto">
                <div class="widget contact-info-widget contactanos">
                    <h5 class="widget-title contacto-h5"> Contáctanos</h5>
                    <ul class="lista-contacto">
                        <li class="direccion-contacto">
                            <i class="fas fa-map-marker-alt" id="icono-direccion"></i>
                            Calle Uno Norte #12 Manzanillo, Colima MX
                        </li>
                        <li class="telefono-contacto">
                            <i class="fas fa-phone" id="icono-telefono"></i>
                            (+52) 314 33 115 00
                        </li>
                        <li>
                            <i class="far fa-envelope-open" id="icono-correo"></i>
                            contacto@aaamzo.org.mx
                        </li>
                    </ul>
                </div>
                <div class="widget associate-widget info-empresa">
                    <h5 class="widget-title" id="titulo-empresa">Asóciate con AAAPUMAC</h5>
                    <p class="texto-p">
                        Forma parte de nuestra comunidad y accede a beneficios exclusivos.
                    </p>
                    <p class="texto-p2">
                        Recuerda que puedes asociarte con nosotros. Déjanos un mensaje y en breve nos pondremos en
                        contacto contigo.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    // Manejar el envío del formulario con AJAX
    document.getElementById('contactForm').addEventListener('submit', function (e) {
        e.preventDefault(); // Evitar el envío tradicional del formulario

        const formData = new FormData(this);
        const submitBtn = document.getElementById('submitBtn');
        const mensajeRespuesta = document.getElementById('mensajeRespuesta');

        // Deshabilitar el botón de envío mientras se procesa
        submitBtn.disabled = true;
        submitBtn.innerText = 'Enviando...';

        fetch('/Aaapumac/correos/funcion-mail.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            mensajeRespuesta.innerHTML = `<span style="color: green;">${data}</span>`;
            document.getElementById('contactForm').reset(); // Resetear el formulario
        })
        .catch(error => {
            mensajeRespuesta.innerHTML = `<span style="color: red;">Ocurrió un error al enviar el mensaje. Por favor, inténtalo de nuevo.</span>`;
        })
        .finally(() => {
            // Rehabilitar el botón de envío
            submitBtn.disabled = false;
            submitBtn.innerText = 'Enviar mensaje';
        });
    });
</script>