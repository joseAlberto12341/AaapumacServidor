<div class="container-scroller">
  <!-- partial:partials/_navbar.html -->
  
  <!-- partial -->
  <div class="container-fluid page-body-wrapper">

    <!-- partial:partials/_sidebar.html -->
    <?php include(VIEWS . '/asociadoCoordinador/inc/sidebar.php'); ?>
    <!-- partial -->
    <div class="main-panel">
      <div class="content-wrapper">
        <?php 

        
        // Extraer variables de 'data'
        if (isset($answer['data']) && is_array($answer['data'])) {
            extract($answer['data']);
            error_log("Variables extraídas de data");
        }
        
        // También extraer variables sueltas que no están en 'data'
        $additionalVars = array_diff_key($answer, array_flip(['view', 'scripts', 'action', 'data']));
        if (!empty($additionalVars)) {
            extract($additionalVars);
            error_log("Variables adicionales extraídas");
        }
        
       
        
        // Incluir la vista
        $viewPath = VIEWS . '/asociadoCoordinador/inc/' . ($answer['action'] ?? 'content') . '.php';
        if (file_exists($viewPath)) {
            include $viewPath;
        } else {
            echo "<div class='alert alert-danger'>Vista no encontrada: $viewPath</div>";
        }
        ?>
        <!-- content-wrapper ends -->
      </div>
    </div>
  </div>
</div>