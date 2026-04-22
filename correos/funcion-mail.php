<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader (created by composer, not included with PHPMailer)
require '../vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header("Location: /Aaapumac/public/contact");
    exit;
}

$nombre = htmlspecialchars($_POST['nombre']);
$email = htmlspecialchars($_POST['email']);
$asunto = htmlspecialchars($_POST['asunto']);
$mensaje = htmlspecialchars($_POST['mensaje']);

// Validar campos vacíos
if (empty($nombre) || empty($email) || empty($asunto) || empty($mensaje)) {
    exit('Todos los campos son obligatorios. <br><a href="/Aaapumac/public/contact"><-Volver</a></br>');
} // ← CIERRA el if de validación

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_OFF;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host = 'tickets.aaamzo.org.mx';                     //Set the SMTP server to send through
    $mail->SMTPAuth = true;                                   //Enable SMTP authentication
    $mail->Username = 'notifications@tickets.aaamzo.org.mx';                     //SMTP username
    $mail->Password = 'Aaamzo2023?';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port = 465;
    $mail->CharSet = 'UTF-8';                                //para soportar caracteres especiales

    //Recipients
    $mail->setFrom('notifications@tickets.aaamzo.org.mx', 'Formulario de contacto AAAPUMAC');
    $mail->addAddress('notifications@tickets.aaamzo.org.mx', 'Contacto');     //Add a recipient

    $mail->addReplyTo($email, $nombre);

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = 'Nuevo mensaje de contacto: ' . $asunto;

    // CORREGIR: Problema con comillas
    $mail->Body = '
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nuevo mensaje de contacto - AAAPUMAC</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background: #ffffff;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #004080, #007bff);
            color: white;
            padding: 30px 20px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }
        .header p {
            margin: 10px 0 0;
            opacity: 0.9;
            font-size: 14px;
        }
        .logo { 
            margin-bottom: 15px;
        }
        .logo-img {
            max-height: 50px;
        }
        .content {
            padding: 30px;
        }
        .message-card {
            background: #f8f9fa;
            border-left: 4px solid #007bff;
            padding: 20px;
            margin-bottom: 25px;
            border-radius: 0 4px 4px 0;
        }
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 15px;
            margin-bottom: 25px;
        }
        .info-item {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 6px;
            border: 1px solid #eaeaea;
        }
        .info-label {
            font-weight: 600;
            color: #004080;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 5px;
        }
        .info-value {
            font-size: 14px;
            color: #333;
        }
        .message-container {
            background: #fff;
            border: 1px solid #eaeaea;
            border-radius: 6px;
            padding: 20px;
            margin-top: 20px;
        }
        .message-container h3 {
            color: #004080;
            margin-top: 0;
            font-size: 16px;
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 10px;
        }
        .message-content {
            font-size: 14px;
            line-height: 1.8;
            color: #555;
            white-space: pre-line;
        }
        .footer {
            background: #f8f9fa;
            padding: 20px;
            text-align: center;
            border-top: 1px solid #eaeaea;
            font-size: 12px;
            color: #666;
        }
        .footer p {
            margin: 5px 0;
        }
        .badge {
            display: inline-block;
            padding: 4px 12px;
            background: #e7f1ff;
            color: #004080;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            margin-left: 10px;
        }
        .timestamp {
            color: #888;
            font-size: 12px;
            text-align: right;
            margin-bottom: 20px;
        }
        .action-button {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 25px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            font-weight: 600;
            font-size: 14px;
        }
        .action-button:hover {
            background: #0056b3;
        }
        @media (max-width: 600px) {
            .container {
                margin: 10px;
            }
            .content {
                padding: 20px;
            }
            .info-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="logo">
                <!-- Reemplaza con tu logo -->
                <div style="font-size: 24px; font-weight: bold;">AAAPUMAC</div>
            </div>
            <h1>📨 Nuevo mensaje de contacto</h1>
            <p>Formulario web - Asociación de Agentes Aduanales del Puerto de Manzanillo</p>
        </div>
        
        <div class="content">
            <div class="timestamp">
                📅 Recibido: ' . date('d/m/Y H:i:s') . '
            </div>
            
            <div class="message-card">
                <h2 style="margin: 0 0 10px 0; color: #004080;">Has recibido un nuevo mensaje del formulario de contacto</h2>
                <p style="margin: 0; color: #666;">Un visitante del sitio web ha enviado una consulta que requiere tu atención.</p>
            </div>
            
            <div class="info-grid">
                <div class="info-item">
                    <div class="info-label">👤 Nombre completo</div>
                    <div class="info-value">' . $nombre . '</div>
                </div>
                <div class="info-item">
                    <div class="info-label">📧 Correo electrónico</div>
                    <div class="info-value">
                        ' . $email . '
                        <a href="mailto:' . $email . '" style="color: #007bff; text-decoration: none; margin-left: 10px;">↗ Responder</a>
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-label">🏷️ Asunto</div>
                    <div class="info-value">
                        ' . $asunto . '
                        <span class="badge">Nuevo</span>
                    </div>
                </div>
                <div class="info-item">
                    <div class="info-label">📅 Fecha de envío</div>
                    <div class="info-value">' . date('d/m/Y') . ' a las ' . date('H:i:s') . '</div>
                </div>
            </div>
            
            <div class="message-container">
                <h3>📝 Mensaje del contacto:</h3>
                <div class="message-content">' . nl2br($mensaje) . '</div>
            </div>
            
            <div style="text-align: center; margin-top: 30px;">
                <a href="mailto:' . $email . '?subject=Re: ' . urlencode($asunto) . '" class="action-button">
                    ✉ Responder a ' . explode(' ', $nombre)[0] . '
                </a>
            </div>
        </div>
        
        <div class="footer">
            <p><strong>AAAPUMAC - Asociación de Agentes Aduanales del Puerto de Manzanillo Colima A.C.</strong></p>
            <p>Calle Uno Norte #12, Manzanillo, Colima, México</p>
            <p>📞 (+52) 314 33 115 00 | 📧 contacto@aaamzo.org.mx</p>
            <p style="margin-top: 15px; color: #999; font-size: 11px;">
                Este es un mensaje automático generado por el formulario de contacto del sitio web.
                Por favor, no responda directamente a este correo.
            </p>
        </div>
    </div>
</body>
</html>
';
    $mail->AltBody = "Nombre: {$nombre}\nCorreo: {$email}\nAsunto: {$asunto}\nMensaje: {$mensaje}";

 $mail->send();
echo '
<div id="toast-success" style="position: fixed; top: 20px; right: 20px; background: #003366; color: white; padding: 15px 25px; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); font-family: Arial, sans-serif; z-index: 9999; animation: slideIn 0.3s ease, fadeOut 0.3s ease 1.7s forwards; max-width: 350px;">
    <div style="display: flex; align-items: center; gap: 10px;">
        <span style="font-size: 22px;">✓</span>
        <div>
            <h4 style="margin: 0 0 5px 0; font-size: 16px; color: white; text-align: center;">¡Mensaje enviado!</h4>
            <p style="margin: 0; font-size: 14px; opacity: 0.9;">Gracias por contactarnos, te responderemos lo antes posible.</p>
        </div>
    </div>
</div>

<style>
@keyframes slideIn {
    from {
        transform: translateX(100%);
        opacity: 0;
    }
    to {
        transform: translateX(0);
        opacity: 1;
    }
}

@keyframes fadeOut {
    to {
        opacity: 0;
        transform: translateY(-10px);
    }
}
</style>

<script>
// Eliminar el toast después de 2 segundos
setTimeout(function() {
    var toast = document.getElementById("toast-success");
    if(toast) {
        toast.style.animation = "slideIn 0.10s ease, fadeOut 0.10s ease 5.7s forwards";
        setTimeout(function() {
            if(toast.parentNode) toast.remove();
        }, 5000);
    }
}, 2000);
</script>
';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}


?>