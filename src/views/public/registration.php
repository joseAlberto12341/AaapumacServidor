<?php
include ('config.php');
session_start();
if (isset($_POST['register'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password_hash = password_hash($password, PASSWORD_BCRYPT);
    $query = $connection->prepare("SELECT * FROM aaausers WHERE EMAIL=:email");
    $query->bindParam(":email", $email, PDO::PARAM_STR);
    $query->execute();
    if ($query->rowCount() > 0) {
        // Envía una alerta si la dirección de correo electrónico ya está registrada
        echo "<script>alert('¡La dirección de correo electrónico ya está registrada!'); window.history.go(-1);</script>";
    } else {
        $query = $connection->prepare("INSERT INTO aaausers(USERNAME, PASSWORD, EMAIL) VALUES (:username, :password_hash, :email)");
        $query->bindParam(":username", $username, PDO::PARAM_STR);
        $query->bindParam(":password_hash", $password_hash, PDO::PARAM_STR);
        $query->bindParam(":email", $email, PDO::PARAM_STR);
        $result = $query->execute();
        if ($result) {
            // Envía una alerta si el registro fue exitoso
            echo "<script>alert('¡Tu registro fue exitoso!'); window.history.go(-1);</script>";
        } else {
            // Envía una alerta si algo salió mal
            echo "<script>alert('¡Algo salió mal!'); window.history.go(-1);</script>";
        }
    }
}
?>