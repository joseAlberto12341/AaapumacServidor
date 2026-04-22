<div class="modal fade" id="mainModal" tabindex="-1" role="dialog" aria-labelledby="mainModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mainModalLabel">Avisos y Alertas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="carouselMainIndicators" class="carousel slide" data-ride="carousel">
                    <ol class="carousel-indicators">
                        <?php foreach ($answer['modal'] as $key): ?>
                            <li data-target="#carouselMainIndicators" data-slide-to="<?php echo $key->getId(); ?>" <?php if ($key->getId() == 1) {
                                   echo 'class="active"';
                               } else
                                   echo ''; ?>></li>
                        <?php endforeach; ?>
                    </ol>
                    <div class="carousel-inner">
                        <?php
                        foreach ($answer['modal'] as $key) {
                            ?>
                            <div class="carousel-item <?php
                            if ($key->getId() == 1) {
                                echo 'active';
                            } else
                                echo '' ?>">
                                    <img class="d-block w-100"
                                        src="/Aaapumac/src/views/assets/img/modal/<?php echo $key->getImage(); ?>">
                                <div class="carousel-caption d-none d-md-block">
                                    <!-- <h5><?php echo $key->getTitle(); ?></h5>
                                    <p><?php echo $key->getDescription(); ?></p> -->
                                </div>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                    <a class="carousel-control-prev" href="#carouselMainIndicators" role="button" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Anterior</span>
                    </a>
                    <a class="carousel-control-next" href="#carouselMainIndicators" role="button" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Siguiente</span>
                    </a>
                </div>
                <!--
                <a href="http://web.aaamzo.org.mx/antisoborno.php" target="_blank"><img style="width:100%" src="/views/assets/img/modal/Antisoborno.png" /></a>
                -->
            </div>
            <!--
            <div class="modal-footer">
                <p>Para mayor información, <a href="http://web.aaamzo.org.mx/antisoborno.php" target="_blank">aquí.</a></p>
            </div>
            -->
        </div>
    </div>
</div>