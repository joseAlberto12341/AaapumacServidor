<div class="container-scroller">


  <!-- partial -->
  <div class="container-fluid page-body-wrapper">

    <!-- partial:partials/_sidebar.html -->
    <?php include(VIEWS . '/admin/inc/sidebar.php'); ?>
    <!-- partial -->
    <div class="main-panel">
      <div class="content-wrapper">
        <?php include(VIEWS . '/admin/inc/' . $answer['action'] . '.php'); ?>
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