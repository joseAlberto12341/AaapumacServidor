<?php
include_once __DIR__ . '/../../assets/phpqrcode/qrlib.php';

function generarCodigoQR($usuario, $contraseña, $email) {
    $codigo_qr = 'codigo_qr_' . $usuario . '.png';
    $ruta_qr = 'src/faces/qr_codes/' . $codigo_qr;

    // Datos del usuario a codificar en el QR
    $datos_usuario = json_encode(array('usuario' => $usuario, 'contraseña' => $contraseña, 'email' => $email, 'codigo_qr' => $codigo_qr));

    // Generar el código QR y guardar como imagen PNG
    QRcode::png($datos_usuario, $ruta_qr, 'L', 10);

    return $codigo_qr;
}
