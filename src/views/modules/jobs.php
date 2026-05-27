<?php
// Las variables vienen en $answer directamente
$jobs = isset($answer['jobs']) ? $answer['jobs'] : [];
$pagination = isset($answer['pagination']) ? $answer['pagination'] : [
    'current_page' => 1, 
    'total_pages' => 1, 
    'total_records' => 0, 
    'limit' => 6
];
?>
<link rel="stylesheet" href="/Aaapumac/src/views/assets/css/jobs.css">
<section class="job-list-area-section" id="Seccion-titulo">
    <div class="container col-10 wow fadeInUp">
        <div class="row">
            <div class="col-lg-12">
                <div class="contact-inner">
                    <span class="title-tag">
                        ¡CONOCE LAS VACANTES DISPONIBLES QUE TENEMOS PARA TI!
                    </span>
                    <h3 class="title h3">
                       ENVIANOS TU CV PARA FORMAR PARTE DE NOSOTROS
                    </h3><br>

                    <!-- Info superior con contador -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="alert alert-info d-flex justify-content-between align-items-center">
                                <span>
                                    <i class="fas fa-info-circle" id="icono-contador"></i> 
                                    Mostrando <strong><?php echo count($jobs); ?></strong> de <strong><?php echo $pagination['total_records']; ?></strong> vacantes activas
                                </span>
                                <span class="badge">
                                    Página <?php echo $pagination['current_page']; ?> de <?php echo $pagination['total_pages']; ?>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="job-list-wrapper">
                        <div class="row">
                            <?php if (!empty($jobs)): ?>
                                <?php foreach ($jobs as $j): ?>
                                    <div class="col-lg-4 col-md-6 col-sm-12">
                                        <div class="job-card">                                          
                                            <div class="job-image-box">
                                                <img src="<?php echo $j->getImage(); ?>" alt="Job Image">
                                                <div class="job-overlay">
                                                    <div class="job-hover-content">
                                                        <p><?php echo $j->getResponsabilities(); ?></p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="job-text">
                                                <h4 class="job-title">
                                                    <a href='/aaapumac/public/job?id=<?php echo $j->getId(); ?>'>
                                                        <?php echo $j->getTitle(); ?>
                                                    </a>
                                                </h4>
                                                <p class="job-details"><i class="fas fa-calendar-alt"></i> <strong>Fecha Límite:</strong> <?php echo $j->getDeadline(); ?></p>
                                                <p class="job-details"><i class="fas fa-graduation-cap"></i>
                                                    <strong>Escolaridad:</strong> <?php echo $j->getEducation(); ?>
                                                </p>
                                                <p class="job-details"><i class="fas fa-briefcase"></i>
                                                    <strong>Experiencia:</strong> <?php echo $j->getWorkexperience(); ?> año(s)
                                                </p>
                                                <p class="job-details" id="responsabilidades"><i class="fas fa-pen-alt"></i>
                                                    <strong>Responsabilidades:</strong> <?php echo $j->getResponsabilities(); ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="col-12">
                                    <p style="font-size:18px; color:#888; text-align: center; padding: 50px;">
                                        <i class="fas fa-folder-open" style="font-size: 48px; color: #ccc; display: block; margin-bottom: 20px;"></i>
                                        No hay vacantes disponibles en este momento.
                                    </p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <!-- PAGINADOR -->
                    <?php if (!empty($jobs) && $pagination['total_pages'] > 1): ?>
                    <div class="row">
                        <div class="col-12">
                            <nav aria-label="Page navigation">
                                <ul class="pagination justify-content-center">
                                    
                                    <!-- Botón Anterior -->
                                    <li class="page-item <?php echo $pagination['current_page'] <= 1 ? 'disabled' : ''; ?>">
                                        <a class="page-link" href="?e=public&a=jobs&page=<?php echo $pagination['current_page'] - 1; ?>" 
                                           aria-label="Previous" <?php echo $pagination['current_page'] <= 1 ? 'tabindex="-1"' : ''; ?>>
                                            <span aria-hidden="true">&laquo;</span>
                                            <span class="sr-only">Anterior</span>
                                        </a>
                                    </li>
                                    
                                    <!-- Números de página -->
                                    <?php 
                                    $startPage = max(1, $pagination['current_page'] - 2);
                                    $endPage = min($pagination['total_pages'], $pagination['current_page'] + 2);
                                    
                                    for ($i = $startPage; $i <= $endPage; $i++): 
                                    ?>
                                        <li class="page-item <?php echo $i == $pagination['current_page'] ? 'active' : ''; ?>">
                                            <a class="page-link" href="?e=public&a=jobs&page=<?php echo $i; ?>"><?php echo $i; ?></a>
                                        </li>
                                    <?php endfor; ?>
                                    
                                    <!-- Botón Siguiente -->
                                    <li class="page-item <?php echo $pagination['current_page'] >= $pagination['total_pages'] ? 'disabled' : ''; ?>">
                                        <a class="page-link" href="?e=public&a=jobs&page=<?php echo $pagination['current_page'] + 1; ?>" 
                                           aria-label="Next" <?php echo $pagination['current_page'] >= $pagination['total_pages'] ? 'tabindex="-1"' : ''; ?>>
                                            <span aria-hidden="true">&raquo;</span>
                                            <span class="sr-only">Siguiente</span>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                            
                            <!-- Información de resultados -->
                            <div class="text-center text-muted mt-2" style="font-size: 14px;">
                                Mostrando <?php echo count($jobs); ?> de <?php echo $pagination['total_records']; ?> vacantes
                                | Página <?php echo $pagination['current_page']; ?> de <?php echo $pagination['total_pages']; ?>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .pagination .page-item.active .page-link {
        background-color: #007bff;
        border-color: #007bff;
        color: white;
    }
    
    .pagination .page-link {
        color: #007bff;
        cursor: pointer;
    }
    
    .pagination .disabled .page-link {
        color: #6c757d;
        pointer-events: none;
        cursor: not-allowed;
    }
    
    .alert-info {
        background-color: #e3f2fd;
        border-color: #b8daff;
        color: #004085;
    }
</style>