<link rel="stylesheet" href="/Aaapumac/src/views/assets/css/content.css">

<!-- Minimal Header -->
<div class="minimal-header">
    <div class="header-content">
        <span class="header-badge">Bienvenido <?php echo $_SESSION['username']; ?> 
            <span class="role-badge">(<?php echo isset($_SESSION['role_name']) ? ucfirst($_SESSION['role_name']) : 'Usuario'; ?>)</span>
        </span>
        <h2 class="header-title">Asociación de Agentes Aduanales</h2>
        <p class="header-text">Puerto de Manzanillo</p>
    </div>
</div>
<!-- Stats Section -->
<div class="stats-section">
     <div class="col-lg-8 d-flex flex-column">
            <div class="col-12 grid-margin stretch-card">
              <div class="card card-rounded table-darkBGImg" style=" color: white; border-radius: 10px;">
                <div class="card-body">
                  <div class="col-sm-12">
                    <h3 class="text-white upgrade-info mb-3 text-center">
                      Recuerda que puedes crear un <span class="fw-bold">Ticket de servicio</span> para atender tu
                      petición.
                    </h3>
                  </div>
                  <div class="col-sm-12">
                    <h5 class="text-white mb-3 text-center">¡Estamos aquí para ayudarte con tus necesidades de
                      servicio!</h5>
                  </div>
                  <div class="col-sm-12 text-center">
                    <img src="/Aaapumac/src/views/assets/img/illustration/ticket.png" alt="Ticket Icon"
                      style="max-width: 500px; margin-bottom: 20px;">
                  </div>
                  <div class="container text-center">
                    <div class="row">
                      <div class="col align-self-center">
                        <a target="_blank" href="https://tickets.aaamzo.org.mx/"
                          style="background: none; color: #fff; border: 1px solid #ffff; border-radius: 25px; padding: 10px 20px; font-size: 16px; font-weight: 600; cursor: pointer; transition: background-color 0.3s, color 0.3s;"
                          onmouseover="this.style.backgroundColor='#3498db'; this.style.color='#fff';"
                          onmouseout="this.style.backgroundColor='transparent'; this.style.color='#ffff';">
                          <i class="mdi mdi-email-fast" style="font-size: 25px; margin-right: 8px;"></i> Generar
                          Ticket
                        </a>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
    </div>
<style>
    .stats-section {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    margin-top: 30px;
}
</style>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
// Timer Animation
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.timer').forEach(function (timerElement) {
        const from = parseInt(timerElement.getAttribute('data-from')) || 0;
        const to = parseInt(timerElement.getAttribute('data-to')) || parseInt(timerElement.textContent);
        const speed = parseInt(timerElement.getAttribute('data-speed'));
        const refreshInterval = parseInt(timerElement.getAttribute('data-refresh-interval'));
        let currentValue = from;
        const increment = (to - from) / (speed / refreshInterval);

        const timer = setInterval(() => {
            currentValue += increment;
            if (currentValue >= to) {
                clearInterval(timer);
                currentValue = to;
            }
            timerElement.textContent = Math.floor(currentValue);
        }, refreshInterval);
    });
});

// Form Submit with SweetAlert
document.getElementById('qr').addEventListener('submit', function (e) {
    e.preventDefault();
    Swal.fire({
        title: "¡Usuario Registrado!",
        text: "El usuario ha sido agregado exitosamente",
        icon: "success",
        confirmButtonText: 'Aceptar',
        confirmButtonColor: '#667eea'
    }).then((result) => {
        if (result.isConfirmed) {
            this.submit();
        }
    });
});
</script>