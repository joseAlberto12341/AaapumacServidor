<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once (__DIR__ . '/../../../src/utils/config.php');
require_once (__DIR__ . '/../../../src/Controllers/LoginController.php');

use App\Controllers\LoginController;

if (isset($_POST['codigo_qr'])) {
    $codigo_qr_escaneado = $_POST['codigo_qr'];

    // Parsear los datos del código QR
    preg_match_all('/\[([^[]+)\[Ñ\[([^[]+)/', $codigo_qr_escaneado, $matches);

    if (!empty($matches[1]) && !empty($matches[2])) {
        $datos_usuario = array_combine($matches[1], $matches[2]);

        if (isset($datos_usuario['contrase}u00f1a'])) {
            $datos_usuario['contraseña'] = $datos_usuario['contrase}u00f1a'];
            unset($datos_usuario['contrase}u00f1a']);
        }

        if (isset($datos_usuario['usuario']) && isset($datos_usuario['contraseña'])) {
            $usuario = $datos_usuario['usuario'];
            $contraseña = $datos_usuario['contraseña'];

            // Usar PDO para preparar y ejecutar la consulta
            $sql = "SELECT * FROM usuarios WHERE usuario = :usuario";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':usuario', $usuario);
            $stmt->execute();
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($resultado) {
                if (password_verify($contraseña, $resultado['contraseña'])) {
                    session_start();
                    $_SESSION['logged'] = true;
                    $_SESSION['username'] = $resultado['usuario'];
                    $_SESSION['email'] = $resultado['email'];
                    $_SESSION['role'] = $resultado['role'];

                    header("Location: /");
                    exit();
                } else {
                    echo '<div class="message error">Error: Contraseña incorrecta.</div>';
                }
            } else {
                echo '<div class="message error">Error: Usuario no encontrado.</div>';
            }
        } else {
            echo '<div class="message error">Error: Datos del código QR incompletos.</div>';
        }
    } else {
        echo '<div class="message error">Error: Datos del código QR no válidos.</div>';
    }
} else {
    echo '<div class="message error">Error: Código QR no recibido.</div>';
}
?>