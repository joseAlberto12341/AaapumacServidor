<link rel="stylesheet" href="/Aaapumac/src/views/assets/css/job.css">
<section class="job-details-section section-gap">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="job-details-wrapper job-detalles">

                    <!-- Botón de regreso con flecha mejorado -->
                    <a href="javascript:history.back()" class="regreso">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <!-- Imagen grande a la izquierda con animación de aparición -->
                    <div class="job-image wow slideInLeft cotenedor-imagen">
                        <img src="<?php echo $answer['job']->getImage(); ?>" alt="Job Image" class="imagen-job">
                    </div>

                    <!-- Información a la derecha-->
                    <div class="job-details wow zoomIn contenedor-info">
                        <h3 class="title">
                            <?php echo $answer['job']->getTitle(); ?>
                        </h3>

                        <div class="info">
                            <strong class="label">Vacantes:</strong>
                            <span class="desc"><?php echo $answer['job']->getVacancy(); ?></span>
                        </div>

                        <div class="info">
                            <strong class="label">Responsabilidades:</strong>
                            <p class="desc responsabilidades">
                                <?php echo $answer['job']->getResponsabilities(); ?></p>
                        </div>

                        <div class="info">
                            <strong class="label">Estatus:</strong>
                            <span class="desc"><?php echo $answer['job']->getIdStatus(); ?></span>
                        </div>

                        <div class="info">
                            <strong class="label">Escolaridad:</strong>
                            <span class="desc"><?php echo $answer['job']->getEducation(); ?></span>
                        </div>

                        <div class="info">
                            <strong class="label">Experiencia:</strong>
                            <span class="desc"><?php echo $answer['job']->getExperience(); ?></span>
                        </div>

                        <div class="info">
                            <strong class="label">Locación:</strong>
                            <span class="desc"><?php echo $answer['job']->getLocation(); ?></span>
                        </div>

                        <div class="info">
                            <strong class="label">Salario:</strong>
                            <span class="desc">$<?php echo $answer['job']->getSalary(); ?></span>
                        </div>

                        <div class="info">
                            <strong class="label">Beneficios:</strong>
                            <span class="desc"><?php echo $answer['job']->getBenefits(); ?></span>
                        </div>
                        <div class="info">
                            <strong class="label">Contacto empresa:</strong>
                            <span class="desc"><?php if ($answer['job']->getContactoEmpresa()) { echo $answer['job']->getContactoEmpresa(); } else { echo "No disponible"; } ?></span>
                        </div>

                        <div class="info">
                            <strong class="label">Para más información:</strong>
                            <a href="mailto:bolsa@aaamzo.org.mx" class="contacto">
                                Contactar bolsa de trabajo
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Animaciones CSS -->
<style>
    @keyframes fadeInZoom {
        from {
            opacity: 0;
            transform: scale(0.8);
        }

        to {
            opacity: 1;
            transform: scale(1);
        }
    }

    .job-image img {
        transition: transform 0.5s ease;
    }

    .job-image img:hover {
        transform: scale(1.05);
    }
</style>