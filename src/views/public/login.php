<div class="container-scroller">
  <div class="container-fluid page-body-wrapper full-page-wrapper">
    <div class="content-wrapper d-flex align-items-stretch auth auth-img-bg"
      style="display: flex; align-items: stretch;">
      <div class="row flex-grow" style="display: flex; flex-grow: 1;">
        <div class="col-lg-6 d-flex align-items-center justify-content-center"
          style="display: flex; align-items: center; justify-content: center;">
          <div class="auth-form-transparent text-center p-3" style="padding: 1rem;">
            <div class="brand-logo">
              <a href="/Aaapumac/"> <img src="src/views/assets/img/illustration/imagotipo_logo.png" alt="logo"
                  style="max-width: 100%; height: auto;"> </a>
            </div>
            <span class="title-tag"
              style="color: #004080; font-weight: bold; font-size: 30px; text-transform: uppercase; letter-spacing: 5px;">¡Bienvenido!</span><br>
            <span class="title-tag"
              style="color: #007bff; font-size: 32px; font-weight: 700; margin: 15px 0;">Encantado de verte de
              nuevo</span>
            <form action="/Aaapumac/login/check" method="POST" class="pt-3" style="padding-top: 1rem; text-align: left;">
              <div class="form-group">
                <label for="exampleInputEmail">Usuario</label>
                <div class="input-group">
                  <div class="input-group-prepend bg-transparent">
                    <span class="input-group-text bg-transparent border-right-0" style="border-right: 0;">
                      <i class="ti-user text-primary"></i>
                    </span>
                  </div>
                  <input type="text" name="email" class="form-control form-control-lg border-left-0"
                    id="exampleInputEmail" placeholder="Introduce tu nombre de usuario" style="border-left: 0;">
                </div>
              </div>
              <div class="form-group">
                <label for="exampleInputPassword">Contraseña</label>
                <div class="input-group">
                  <div class="input-group-prepend bg-transparent">
                    <span class="input-group-text bg-transparent border-right-0" style="border-right: 0;">
                      <i class="ti-lock text-primary"></i>
                    </span>
                  </div>
                  <input type="password" name="password" class="form-control form-control-lg border-left-0"
                    id="exampleInputPassword" placeholder="Introduce tu contraseña" style="border-left: 0;">
                </div>
              </div>
              <div class="my-2 d-flex justify-content-between align-items-center"
                style="display: flex; justify-content: space-between; align-items: center; margin: 1rem 0;">
                <div class="form-check">
                  <label class="form-check-label text-muted">
                    <input type="checkbox" class="form-check-input">
                    Recordarme
                    <i class="input-helper"></i></label>
                </div>
                <a href="#" class="auth-link text-black" data-bs-toggle="modal"
                  data-bs-target="#staticBackdrop">¿Olvidaste tu contraseña?</a>
                <!-- Modal -->
                <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false"
                  tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                  <div class="modal-dialog">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h1 class="modal-title fs-5" id="staticBackdropLabel">Recuperar contraseña</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                      </div>
                      <div class="modal-body">
                        Ponte en contacto con el departamento de sistemas para recuperar tu contraseña, ¡Gracias!
                      </div>
                      <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Aceptar</button>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              <!-- Mostrar mensaje de error si hay alguno en la sesión -->
              <?php if (isset($_SESSION['message'])): ?>
                <div class="alert alert-danger" role="alert">
                  <?= $_SESSION['message'] ?>
                </div>
                <?php unset($_SESSION['message']); ?>
              <?php endif; ?>
              <div class="my-3" style="margin: 1rem 0;">
                <button type="submit" name="login_btn"
                  class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn"
                  style="display: block; width: 100%;">Iniciar sesión
                </button>
              </div>
              <div class="text-center mt-4 fw-light" style="text-align: center; margin-top: 1rem; font-weight: 300;">
                ¿No tienes una cuenta? <a href="/Aaapumac/contact" class="text-primary">Contáctanos</a>
              </div>
            </form>
          </div>
        </div>
        <div class="col-lg-6 login-half-bg d-flex flex-column"
          style="display: flex; flex-direction: column; position: relative; overflow: hidden;">
          <img class="img-responsive thick-green-border" src="/Aaapumac/src/views/assets/img/illustration/04.png" alt=""
            style="width: 100%; height: 100%; object-fit: cover; position: absolute;">
          <p class="text-white font-weight-medium text-center"
            style="color: white; font-weight: 500; text-align: center; margin: 0; position: absolute; bottom: 10px; width: 100%;">
            Copyright © 2021 All rights reserved.</p>
        </div>
      </div>
    </div>
    <!-- content-wrapper ends -->
  </div>
  <!-- page-body-wrapper ends -->
</div>