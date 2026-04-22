<?php
// Inicia la sesión si no está activa
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

error_reporting(E_ALL);
ini_set('display_errors', 1);

// Incluye el archivo de configuración primero
include ('config.php');


// Verifica si se ha enviado el formulario
if (isset($_POST['register'])) {
    // Obtiene los datos del formulario
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password_hash = password_hash($password, PASSWORD_BCRYPT);

    // Prepara la consulta para verificar si el correo electrónico ya está registrado
    $query = $connection->prepare("SELECT * FROM aaausers WHERE EMAIL=:email");
    $query->bindParam("email", $email, PDO::PARAM_STR);
    $query->execute();

    // Verifica si el correo electrónico ya está registrado
    if ($query->rowCount() > 0) {
        echo '<p class="error">¡La dirección de correo electrónico ya está registrada!</p>';
    } else {
        // Si el correo electrónico no está registrado, inserta el nuevo usuario en la base de datos
        $query = $connection->prepare("INSERT INTO aaausers(USERNAME, PASSWORD, EMAIL) VALUES (:username, :password_hash, :email)");
        $query->bindParam("username", $username, PDO::PARAM_STR);
        $query->bindParam("password_hash", $password_hash, PDO::PARAM_STR);
        $query->bindParam("email", $email, PDO::PARAM_STR);
        $result = $query->execute();

        // Verifica si la inserción fue exitosa
        if ($result) {
            echo '<p class="success">¡Tu registro fue exitoso!</p>';
        } else {
            echo '<p class="error">¡Algo salió mal!</p>';
        }
    }
}
?>


<!--<form class="pt-3" method="post" action="registration.php">
    !-- Aquí van los campos del formulario (nombre de usuario, correo electrónico, contraseña, etc.) --
    <div class="form-group">
        <label for="username">Nombre de usuario</label>
        <input type="text" class="form-control" id="username" name="username" required>
    </div>
    <div class="form-group">
        <label for="email">Correo electrónico</label>
        <input type="email" class="form-control" id="email" name="email" required>
    </div>
    <div class="form-group">
        <label for="password">Contraseña</label>
        <input type="password" class="form-control" id="password" name="password" required>
    </div>
    <!-- Botón para enviar el formulario --
    <button type="submit" class="btn btn-secondary" name="register">Regístrate</button>
</form>