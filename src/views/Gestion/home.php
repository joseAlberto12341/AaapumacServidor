<div class="container-scroller">
  <!-- partial:partials/_navbar.html -->
  

  <!-- partial -->
  <div class="container-fluid page-body-wrapper">

    <!-- partial:partials/_sidebar.html -->
    <?php include(VIEWS . '/Gestion/inc/sidebar.php'); ?>
    <!-- partial -->
    <div class="main-panel">
      <div class="content-wrapper">
        <?php 
        // DEBUG: Verificar qué datos tenemos
        error_log("=== DEBUG home.php ===");
        error_log("¿Existe \$answer? " . (isset($answer) ? 'Sí' : 'No'));
        if (isset($answer)) {
            error_log("Answer keys: " . implode(', ', array_keys($answer)));
            if (isset($answer['data'])) {
                error_log("Data keys: " . implode(', ', array_keys($answer['data'])));
            }
        }
        error_log("Action: " . ($answer['action'] ?? 'N/A'));
        error_log("=== FIN DEBUG ===");
        
        // Extraer variables del array data para que estén disponibles en la vista
        if (isset($answer['data']) && is_array($answer['data'])) {
            extract($answer['data']);
            error_log("Variables extraídas del array data");
        }
        
        // Incluir la vista correspondiente
        $viewPath = VIEWS . '/Gestion/inc/' . ($answer['action'] ?? 'content') . '.php';
        if (file_exists($viewPath)) {
            error_log("Incluyendo vista: " . $viewPath);
            include $viewPath;
        } else {
            echo "<div class='alert alert-danger'>Vista no encontrada: $viewPath</div>";
            error_log("ERROR: Vista no encontrada: " . $viewPath);
        }
        ?>
        <!-- content-wrapper ends -->

        <!-- partial -->
      </div>
      <!-- partial:partials/_footer.html -->
     
    </div>
  </div>
  <!-- main-panel ends -->
</div>
<!-- page-body-wrapper ends -->
</div>
<!-- container-scroller -->