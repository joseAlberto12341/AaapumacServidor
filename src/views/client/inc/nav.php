<nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex align-items-top flex-row">
  <div style="background-color: #003366;" class="text-center navbar-brand-wrapper d-flex align-items-center justify-content-start">
    <div class="me-3">
      <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-bs-toggle="minimize">
        <span class="icon-menu"></span>
      </button>
    </div>
    <div>
      <a class="navbar-brand brand-logo" href="../">
        <img src="/Aaapumac/src/views/assets/img/logo-2.png" alt="logo" />
      </a>
      <a class="navbar-brand brand-logo-mini" href="/admin">
        <img src="/Aaapumac/src/views/assets/img/logo-aa.png" alt="logo" />
      </a>
    </div>
  </div>
  <div style="background-color: #4a90e2;" class="navbar-menu-wrapper d-flex align-items-top">
    <ul class="navbar-nav">
      <li class="nav-item font-weight-semibold d-none d-lg-block ms-0">
        <h1 class="welcome-text" style="color: #ffffff;">Buen día, <span
            class="text-black fw-bold"></span>
        </h1>
        <h3 class="welcome-sub-text" style="color: #ffffff;">Bienvenido a tu área de trabajo </h3>
      </li>
    </ul>
    <ul class="navbar-nav ms-auto">
      <li class="nav-item d-none d-lg-block">
        <div id="datepicker-popup" class="input-group date datepicker navbar-date-picker">
          <span class="input-group-addon input-group-prepend border-right">
            <span class="icon-calendar input-group-text calendar-icon"></span>
          </span>
          <input type="text" class="form-control">
        </div>
      </li>
      <li class="nav-item dropdown d-none d-lg-block user-dropdown">
        <a class="nav-link" id="UserDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
          <img class="img-xs rounded-circle" src="/Aaapumac/src/views/assets/images/faces/face8.jpg" alt="Profile image"> </a>

        <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
          <div class="dropdown-header text-center">
            <img class="img-md rounded-circle" src="/Aaapumac/src/views/assets/images/faces/face8.jpg" alt="Profile image">
            <p class="mb-1 mt-3 font-weight-semibold">Alejandro Mendoza</p>
            <p class="fw-light text-muted mb-0">amendoza@aaamzo.org.mx</p>
          </div>
          <a class="dropdown-item" href="/Aaapumac/client/profile"><i
              class="dropdown-item-icon mdi mdi-account-outline text-primary me-2"></i> My Profile <span
              class="badge badge-pill badge-danger">1</span></a>
          <a class="dropdown-item" href="/Aaapumac/client/logout"><i class="dropdown-item-icon mdi mdi-power text-primary me-2"></i>Sign
            Out</a>
        </div>
      </li>
    </ul>
    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
      data-bs-toggle="offcanvas">
      <span class="mdi mdi-menu"></span>
    </button>
  </div>
</nav>