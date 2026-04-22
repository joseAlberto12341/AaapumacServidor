<section class="video-section-two"
    style="background-image: url(src/views/assets/img/video-bg/video-2.jpg); display: flex; align-items: center; padding: 50px 0;">
    <div class="container">
        <div class="row align-items-center">
            <!-- Video Button Section -->
            <div class="col-lg-6" style="text-align: center; position: relative;">
                <a class="paly-icon popup-video play-btn" href="https://youtu.be/uZ3uGkMquaA?si=sHLfHh3BPuiu-VaO"
                    style="display: inline-block; width: 100px; height: 100px; background-color: rgba(255, 255, 255, 0.15); border-radius: 50%; text-align: center; line-height: 100px; color: #fff; font-size: 40px; text-decoration: none; position: relative;">
                    <i class="fas fa-play"></i>
                    <!-- Waves Animation -->
                    <span
                        style="position: absolute; width: 100%; height: 100%; top: 0; left: 0; background: rgba(255, 255, 255, 0.3); border-radius: 50%; animation: pulsate 1.5s infinite;"></span>
                    <span
                        style="position: absolute; width: 100%; height: 100%; top: 0; left: 0; background: rgba(255, 255, 255, 0.2); border-radius: 50%; animation: pulsate 1.5s infinite 0.5s;"></span>
                    <span
                        style="position: absolute; width: 100%; height: 100%; top: 0; left: 0; background: rgba(255, 255, 255, 0.1); border-radius: 50%; animation: pulsate 1.5s infinite 1s;"></span>
                </a>
            </div>
            <!-- Information Section -->
            <div class="col-lg-6 wow fadeInRight" data-wow-duration="1500ms" data-wow-delay="400ms"
                style="text-align: left;">
                <h2 style="font-size: 36px; color: #fff; margin-bottom: 20px;">
                    AAAPUMAC te presenta las nuevas noticias
                </h2>
                <p style="font-size: 18px; color: #eee;">
                    Mantente al día con las últimas noticias y actualizaciones a través de nuestros videos informativos.
                    Te brindamos contenido relevante, de alta calidad y accesible desde cualquier lugar.
                </p>
            </div>
        </div>
    </div>
    <div class="line-shape-one">
        <img src="src/views/assets/img/lines/12.png" alt="Line" class="wow zoomIn" data-wow-duration="2000ms"
            data-wow-delay="500ms">
    </div>
    <div class="line-shape-two">
        <img src="src/views/assets/img/lines/11.png" alt="Line" class="wow zoomIn" data-wow-duration="2000ms"
            data-wow-delay="800ms">
    </div>
</section>

<!-- Keyframes para la animación -->
<style>
    @keyframes pulsate {
        0% {
            transform: scale(1);
            opacity: 1;
        }

        100% {
            transform: scale(1.5);
            opacity: 0;
        }
    }
</style>

<script>
    // SOLUCIÓN DEFINITIVA - Previene apertura duplicada
    document.addEventListener('DOMContentLoaded', function () {
        // 1. Primero, desactiva el comportamiento por defecto de TODOS los enlaces con clase popup-video
        var videoLinks = document.querySelectorAll('.popup-video');

        videoLinks.forEach(function (link) {
            // Eliminar cualquier evento click existente para evitar duplicados
            var newLink = link.cloneNode(true);
            link.parentNode.replaceChild(newLink, link);

            // Añadir nuevo manejador de evento
            newLink.addEventListener('click', function (e) {
                // Prevenir COMPLETAMENTE el comportamiento por defecto
                e.preventDefault();
                e.stopPropagation();
                e.stopImmediatePropagation();

                console.log('Video clickeado - previniendo duplicación');

                // Verificar si ya hay un modal de video abierto
                var existingModal = document.querySelector('.video-modal-active');
                if (existingModal) {
                    console.log('Ya hay un video abierto, ignorando click');
                    return false;
                }

                // Marcar que estamos abriendo un modal
                document.body.classList.add('video-modal-active');

                // Aquí va tu código para abrir el video
                // DEPENDE DE QUÉ LIBRERÍA USES:

                // Opción A: Si usas Magnific Popup
                // if (typeof $.magnificPopup !== 'undefined') {
                //     $.magnificPopup.open({
                //         items: {
                //             src: newLink.href
                //         },
                //         type: 'iframe'
                //     });
                // }

                // Opción B: Si usas Fancybox
                // if (typeof $.fancybox !== 'undefined') {
                //     $.fancybox.open({
                //         src: newLink.href,
                //         type: 'iframe'
                //     });
                // }

                // Opción C: Si no usas librería, aquí un método simple
                abrirVideoSimple(newLink.href);

                // Remover la marca después de 2 segundos
                setTimeout(function () {
                    document.body.classList.remove('video-modal-active');
                }, 2000);

                return false;
            }, true);
        });

        // Función simple para abrir video (si no usas librería)
        function abrirVideoSimple(url) {
            // Convertir cualquier enlace de YouTube a formato embed
            let embedUrl = url;
            try {
                var yt;
                if (url.includes('youtu.be/')) {
                    yt = new URL(url);
                    var videoId = yt.pathname.replace('/', '');
                    embedUrl = `https://www.youtube.com/embed/${videoId}`;
                    if (yt.searchParams) {
                        let allowed = ['autoplay', 'rel', 'controls', 'start', 'end', 'loop', 'playlist'];
                        yt.searchParams.forEach(function (value, key) {
                            if (allowed.includes(key)) embedUrl += `&${key}=${value}`;
                        });
                    }
                } else if (url.includes('youtube.com/watch')) {
                    yt = new URL(url);
                    var videoId = yt.searchParams.get('v');
                    embedUrl = `https://www.youtube.com/embed/${videoId}`;
                    yt.searchParams.forEach(function (value, key) {
                        if (key !== 'v') embedUrl += `&${key}=${value}`;
                    });
                }
                if (!embedUrl.includes('autoplay=1')) {
                    embedUrl += (embedUrl.includes('?') ? '&' : '?') + 'autoplay=1';
                }
            } catch (e) {
                embedUrl = url;
            }
            // Crear modal simple con el embed
            var modal = document.createElement('div');
            modal.style.cssText = 'position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.8); z-index: 9999; display: flex; justify-content: center; align-items: center;';
            modal.innerHTML = `
    <div style="position: relative; width: 90%; max-width: 800px;">
        <button style="position: absolute; top: -40px; right: 0; background: #f00; color: white; border: none; padding: 1px 15px; cursor: pointer; z-index: 10000; border-radius: 5px;">x</button>
        <iframe width="100%" height="450" src="${embedUrl}" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
    </div>   
`;
            // Añadir al body
            document.body.appendChild(modal);
            // Botón para cerrar
            modal.querySelector('button').addEventListener('click', function () {
                document.body.removeChild(modal);
                document.body.classList.remove('video-modal-active');
            });
            // Cerrar al hacer click fuera del video
            modal.addEventListener('click', function (e) {
                if (e.target === modal) {
                    document.body.removeChild(modal);
                    document.body.classList.remove('video-modal-active');
                }
            });
        }
    });

    // Añade este CSS para evitar scroll cuando el modal está abierto
    var style = document.createElement('style');
    style.textContent = `
    body.video-modal-active {
        overflow: hidden;
    }
`;
    document.head.appendChild(style);
</script>