<?php
// views/user/dashboard.php
?>
<div class="container">
    <h1>Dashboard Usuario</h1>
    <p>Bienvenido <?php echo $_SESSION['username'] ?? 'Usuario'; ?></p>
    <p>Rol: <?php echo $_SESSION['role_name'] ?? 'Usuario'; ?></p>
    
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Mi Perfil</h5>
                    <p class="card-text">Gestiona tu información personal</p>
                    <a href="/Aaapumac/user/profile" class="btn btn-primary">Ver Perfil</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Avisos</h5>
                    <p class="card-text">Consulta los últimos avisos</p>
                    <a href="/Aaapumac/user/modal" class="btn btn-primary">Ver Avisos</a>
                </div>
            </div>
        </div>
    </div>
</div>