<div class="container-scroller">
  <!-- partial:partials/_navbar.html -->
  <?php include(VIEWS . '/client/inc/nav.php'); ?>
  <!-- partial -->
  <div class="container-fluid page-body-wrapper">

    <!-- partial:partials/_sidebar.html -->
    <?php include(VIEWS . '/client/inc/sidebar.php'); ?>
    <!-- partial -->
    <div class="main-panel">
      <div class="content-wrapper">
        <?php include(VIEWS . '/client/inc/' . $answer['action'] . '.php'); ?>
        <!-- content-wrapper ends -->
      </div>
      <!-- partial:partials/_footer.html -->
      <?php include(VIEWS . '/client/inc/footer.php'); ?>
      <!-- partial -->
    </div>
  </div>
  <!-- main-panel ends -->
</div>
<!-- page-body-wrapper ends -->
</div>
<!-- container-scroller -->