<?php
//Import PHPMailer classes into the global namespace
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require '../vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST') {//verifica que el metodo de envio sea POST
    header("Location: /Aaapumac/public/report");
    exit;
}

// Validación de campos
$firstname = htmlspecialchars($_POST['firstname']);//los atributos sirven para limpiar que no tengan carateres especiales
$lastname = htmlspecialchars($_POST['lastname']);
$empresa = htmlspecialchars($_POST['empresa']);
$ocupacion = htmlspecialchars($_POST['ocupacion']);
$email = htmlspecialchars($_POST['email']);
$tel = htmlspecialchars($_POST['tel']);
$message = htmlspecialchars($_POST['message']);
$archivos = $_FILES['archivos'];

// Validar campos obligatorios
$camposObligatorios = [$firstname, $lastname, $email, $message];
foreach ($camposObligatorios as $campo) {
    if (empty($campo)) {
        die('Error: Todos los campos marcados como requeridos deben ser completados.');
    }
}

// Validar archivos (si se subieron)
$archivosAdjuntos = [];
if (isset($archivos) && !empty($archivos['name'][0])) {
    $totalArchivos = count($archivos['name']);
    
    // Configuración de archivos permitidos
    $extensionesPermitidas = ['pdf', 'doc', 'docx', 'jpg', 'jpeg', 'png', 'gif', 'txt', 'xls', 'xlsx'];
    $tamanoMaximo = 50 * 1024 * 1024; // 50MB
    $carpetaTemporal = sys_get_temp_dir(); // Carpeta temporal del sistema
    
    for ($i = 0; $i < $totalArchivos; $i++) {
        $nombreArchivo = $archivos['name'][$i];
        $tipoArchivo = $archivos['type'][$i];
        $tamanoArchivo = $archivos['size'][$i];
        $archivoTemporal = $archivos['tmp_name'][$i];
        $errorArchivo = $archivos['error'][$i];
        
        // Verificar si hubo error en la subida
        if ($errorArchivo !== UPLOAD_ERR_OK) {
            continue; // Saltar este archivo
        }
        
        // Verificar tamaño
        if ($tamanoArchivo > $tamanoMaximo) {
            die("Error: El archivo '$nombreArchivo' excede el tamaño máximo permitido de 50MB.");
        }
        
        // Verificar extensión
        $extension = strtolower(pathinfo($nombreArchivo, PATHINFO_EXTENSION));
        if (!in_array($extension, $extensionesPermitidas)) {
            die("Error: El archivo '$nombreArchivo' tiene una extensión no permitida.");
        }
        
        // Mover archivo a carpeta temporal
        $nuevoNombre = uniqid('adjunto_', true) . '.' . $extension;
        $rutaDestino = $carpetaTemporal . '/' . $nuevoNombre;
        
        if (move_uploaded_file($archivoTemporal, $rutaDestino)) {
            $archivosAdjuntos[] = [
                'ruta' => $rutaDestino,
                'nombre' => $nombreArchivo,
                'tipo' => $tipoArchivo
            ];
        }
    }
}

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer(true);

try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_OFF;
    $mail->isSMTP();
    $mail->Host = 'tickets.aaamzo.org.mx';
    $mail->SMTPAuth = true;
    $mail->Username = 'notifications@tickets.aaamzo.org.mx';
    $mail->Password = 'Aaamzo2023?';
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
    $mail->Port = 465;
    $mail->CharSet = 'UTF-8';

    //Recipients
    $mail->setFrom('notifications@tickets.aaamzo.org.mx', 'Formulario de Reporte AAAPUMAC');
    $mail->addAddress('notifications@tickets.aaamzo.org.mx', 'Sistema de Notificaciones');
    $mail->addCC('reporte.antisoborno@aaamzo.org.mx ', 'Reporte Antisoborno');
    $mail->addReplyTo($email, $firstname . ' ' . $lastname);

    // Adjuntar archivos
    foreach ($archivosAdjuntos as $archivo) {
        $mail->addAttachment($archivo['ruta'], $archivo['nombre']);
    }

    //Content
    $mail->isHTML(true);
    $mail->Subject = 'REPORTE URGENTE: Posible acto de soborno - ' . date('d/m/Y H:i:s');
    
    // Cuerpo del mensaje profesional
    $mail->Body = '
    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
            .container { max-width: 800px; margin: 0 auto; }
            .header { background: #dc3545; color: white; padding: 20px; text-align: center; }
            .content { padding: 30px; background: #f9f9f9; }
            .info-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 15px; margin: 20px 0; }
            .info-item { background: white; padding: 15px; border-radius: 5px; border-left: 4px solid #007bff; }
            .info-label { font-weight: bold; color: #dc3545; font-size: 14px; }
            .info-value { font-size: 16px; }
            .message-box { background: white; padding: 20px; border: 1px solid #ddd; border-radius: 5px; margin: 20px 0; }
            .footer { background: #343a40; color: white; padding: 15px; text-align: center; font-size: 12px; }
            .badge { background: #dc3545; color: white; padding: 3px 8px; border-radius: 12px; font-size: 12px; }
            .archivos { background: #e9ecef; padding: 15px; border-radius: 5px; margin: 15px 0; }
        </style>
    </head>
    <body>
        <div class="container">
            <div class="header">
                <h2> REPORTE DE POSIBLE ACTO DE SOBORNO</h2>
                <p><strong>AAAPUMAC - Sistema de Denuncias Antisoborno</strong></p>
                <p><span class="badge">CONFIDENCIAL</span> <span class="badge">URGENTE</span></p>
            </div>
            
            <div class="content">
                <h3>📋 Información del Denunciante</h3>
                <div class="info-grid">
                    <div class="info-item">
                        <div class="info-label">Nombre completo</div>
                        <div class="info-value">' . $firstname . ' ' . $lastname . '</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Empresa</div>
                        <div class="info-value">' . $empresa . '</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Ocupación</div>
                        <div class="info-value">' . $ocupacion . '</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Teléfono</div>
                        <div class="info-value">' . $tel . '</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Correo electrónico</div>
                        <div class="info-value">' . $email . '</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Fecha y hora del reporte</div>
                        <div class="info-value">' . date('d/m/Y H:i:s') . '</div>
                    </div>
                </div>
                
                <h3>📝 Descripción de los Hechos</h3>
                <div class="message-box">
                    ' . nl2br($message) . '
                </div>';
    
    // Mostrar archivos adjuntos si hay
    if (!empty($archivosAdjuntos)) {
        $mail->Body .= '
                <h3>📎 Archivos Adjuntos</h3>
                <div class="archivos">
                    <p><strong>Total de archivos adjuntos: ' . count($archivosAdjuntos) . '</strong></p>
                    <ul>';
        
        foreach ($archivosAdjuntos as $archivo) {
            $mail->Body .= '<li>' . htmlspecialchars($archivo['nombre']) . ' (' . round(filesize($archivo['ruta']) / 1024, 2) . ' KB)</li>';
        }
        
        $mail->Body .= '
                    </ul>
                </div>';
    }
    
    $mail->Body .= '
                <div style="background: #fff3cd; padding: 15px; border-radius: 5px; border: 1px solid #ffeaa7; margin-top: 20px;">
                    <h4>🔒 Información Confidencial</h4>
                    <p><strong>NOTA:</strong> Este reporte ha sido enviado de forma anónima y confidencial. La identidad del denunciante será protegida durante todo el proceso de investigación.</p>
                </div>
            </div>
            
            <div class="footer">
                <p><strong>AAAPUMAC - Sistema de Reportes Éticos</strong></p>
                <p>📧 reporte.antisoborno@aaamzo.org.mx | 📞 (314) 141-1386</p>
                <p>Calle Uno Norte #12, Fondeport, Manzanillo, Colima</p>
                <p><em>Este es un mensaje automático generado por el sistema de denuncias éticas.</em></p>
            </div>
        </div>
    </body>
    </html>';
    
    // Versión en texto plano
    $mail->AltBody = "REPORTE DE POSIBLE ACTO DE SOBORNO\n" .
                     str_repeat("=", 50) . "\n\n" .
                     "FECHA: " . date('d/m/Y H:i:s') . "\n" .
                     "DENUNCIANTE: " . $firstname . " " . $lastname . "\n" .
                     "EMPRESA: " . $empresa . "\n" .
                     "OCUPACIÓN: " . $ocupacion . "\n" .
                     "EMAIL: " . $email . "\n" .
                     "TELÉFONO: " . $tel . "\n" .
                     str_repeat("-", 30) . "\n" .
                     "DESCRIPCIÓN:\n" . $message . "\n\n";
    
    if (!empty($archivosAdjuntos)) {
        $mail->AltBody .= "ARCHIVOS ADJUNTOS (" . count($archivosAdjuntos) . "):\n";
        foreach ($archivosAdjuntos as $archivo) {
            $mail->AltBody .= "- " . $archivo['nombre'] . "\n";
        }
        $mail->AltBody .= "\n";
    }
    
    $mail->AltBody .= str_repeat("=", 50) . "\n" .
                      "AAAPUMAC - Sistema de Reportes Éticos\n" .
                      "reporte.antisoborno@aaamzo.org.mx\n" .
                      "Este mensaje es confidencial.";

    $mail->send();
    
    // Limpiar archivos temporales
    foreach ($archivosAdjuntos as $archivo) {
        if (file_exists($archivo['ruta'])) {
            unlink($archivo['ruta']);
        }
    }
    
    // Redirección con mensaje de éxito
    session_start();
    $_SESSION['reporte_exito'] = ' Su reporte ha sido enviado exitosamente. El departamento de ética lo revisará a la brevedad. Su identidad será protegida.';
    header("Location: /Aaapumac/public/report");
    exit();
    
} catch (Exception $e) {
    // Limpiar archivos temporales en caso de error
    foreach ($archivosAdjuntos as $archivo) {
        if (file_exists($archivo['ruta'])) {
            unlink($archivo['ruta']);
        }
    }
    
    session_start();
    $_SESSION['reporte_error'] = '❌ Error al enviar el reporte. Por favor, intente nuevamente o contacte directamente al departamento de ética.';
    header("Location: /Aaapumac/public/report");
    exit();
}