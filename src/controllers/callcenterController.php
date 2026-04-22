<?php
namespace App\Controllers;
use App\Repositories\callacenterRepository;

// Cargar AuthHelper directamente SIEMPRE
require_once __DIR__ . '/../utils/AuthHelper.php';

class callcenterController
{
    public static function Home()
    {
        \Utils\AuthHelper::requireAuth(5);
        return [
            'view' => 'callcenter/home.php',
            'scripts' => 'callcenter',
            'action' => 'content',
        ];
    }

    public static function Profile()
    {
        \Utils\AuthHelper::requireAuth(5);
        return [
            'view' => 'callcenter/home.php',
            'scripts' => 'callcenter',
            'action' => 'content',
            'data' => [
                'title' => 'Mi Perfil',
                'subtitle' => 'Actualiza tu información personal',
            ],
        ];
    }

    public static function Modals()
    {
        \Utils\AuthHelper::requireAuth(5);

        $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
        $perPage = isset($_GET['per_page']) ? (int) $_GET['per_page'] : 10;
        $search = trim($_GET['search'] ?? '');
        $page = max(1, $page);
        $allowedPerPage = [5, 10, 15, 25, 50, 100];
        if (!in_array($perPage, $allowedPerPage, true)) {
            $perPage = 10;
        }

        $countAvisos = callacenterRepository::countAvisos($search);
        $totalPages = max(1, (int) ceil($countAvisos / $perPage));
        if ($page > $totalPages) {
            $page = $totalPages;
        }

        // Obtener lista de avisos paginada
        $modalList = callacenterRepository::getModalList($page, $perPage, $search);

         return [
            'view' => 'callcenter/home.php',
            'scripts' => 'callcenter',
            'action' => 'modals',
            'data' => [
                'title' => 'Avisos',
                'subtitle' => 'Tienes ' . $countAvisos . ' avisos registrados',
                'button' => 'Agregar nuevo aviso',
                'icon' => 'mdi mdi-bell-ring-outline',
                'pagination' => [
                    'current_page' => $page,
                    'per_page' => $perPage,
                    'total' => $countAvisos,
                    'total_pages' => $totalPages,
                ],
                'search' => $search,
            ],
            'modal' => $modalList,
        ];
    }


    public static function Modal()
    {
        \Utils\AuthHelper::requireAuth(5);
        return [
            'view' => 'callcenter/home.php',
            'scripts' => 'callcenter',
            'action' => 'modal',
            'data' => [
                'title' => 'Editar aviso',
                'subtitle' => 'Nuevos avisos',
                'button' => 'Agregar nuevo aviso',
                'icon' => 'mdi mdi-bell-ring-outline',
            ],
            'modal' => callacenterRepository::getModalList(),
        ];
    }

    public static function EditarAviso()
    {
        \Utils\AuthHelper::requireAuth(5);
        $id = $_GET['id'];
        return [
            'view' => 'callcenter/home.php',
            'scripts' => 'callcenter',
            'action' => 'editarAviso',
            'data' => [
                'title' => 'Editar Aviso',
                'subtitle' => 'Modifica el aviso seleccionado',
                'button' => 'Actualizar aviso',
                'icon' => 'mdi mdi-bell-ring-outline',
            ],
            'aviso' => callacenterRepository::findAviso($id),
        ];
    }

   public static function NewAviso()
{
    \Utils\AuthHelper::requireAuth(5);
    
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        
        // Procesar la imagen (igual que antes)
        $imagePath = '';
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/Aaapumac/src/views/assets/img/modal/';

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            $fileType = $_FILES['image']['type'];

            if (!in_array($fileType, $allowedTypes)) {
                $_SESSION['error'] = "Solo se permiten archivos de imagen (JPEG, PNG, GIF, WEBP)";
                header('Location: /Aaapumac/callcenter/modals');
                exit();
            }

            $originalName = $_FILES['image']['name'];
            $fileExtension = pathinfo($originalName, PATHINFO_EXTENSION);
            $baseName = preg_replace('/[^a-zA-Z0-9_-]/', '', pathinfo($originalName, PATHINFO_FILENAME));
            $imageName = $baseName . '_' . uniqid() . '.' . $fileExtension;
            $uploadFile = $uploadDir . $imageName;

            if (file_exists($uploadFile)) {
                $imageName = $baseName . '_' . uniqid() . '_' . time() . '.' . $fileExtension;
                $uploadFile = $uploadDir . $imageName;
            }

            if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                $imagePath = '/Aaapumac/src/views/assets/img/modal/' . $imageName;
                $_POST['image'] = $imagePath;
            } else {
                $_SESSION['error'] = "Error al subir la imagen. Verifique los permisos del servidor.";
                header('Location: /Aaapumac/callcenter/modals');
                exit();
            }
        } else {
            $_SESSION['error'] = "Debe seleccionar una imagen válida";
            header('Location: /Aaapumac/callcenter/modals');
            exit();
        }

        // Procesar el archivo PDF/Documento
        $filePath = '';
        if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/Aaapumac/src/views/assets/files/';

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            // ========== VALIDACIÓN MUY FLEXIBLE ==========
            $tempFile = $_FILES['archivo']['tmp_name'];
            $isValid = false;
            $detectedType = "Desconocido";
            $realMime = null;
            $fileContent = null;

            // 1. Validar tamaño máximo (10MB)
            $maxSize = 10 * 1024 * 1024;
            if ($_FILES['archivo']['size'] > $maxSize) {
                $_SESSION['error'] = "El archivo no debe exceder los 10MB";
                header('Location: /Aaapumac/callcenter/modals');
                exit();
            }

            // 2. Verificar que el archivo temporal existe
            if (!file_exists($tempFile) || !is_readable($tempFile)) {
                $_SESSION['error'] = "Error al leer el archivo temporal";
                header('Location: /Aaapumac/callcenter/modals');
                exit();
            }

            // 3. Leer los primeros bytes para análisis
            $handle = fopen($tempFile, 'rb');
            $firstBytes = fread($handle, 1024);
            fclose($handle);
            
            // Verificar firma PDF estándar
            if (substr($firstBytes, 0, 5) === '%PDF-') {
                $isValid = true;
                $detectedType = "PDF estándar (firma %PDF-)";
            }
            // Verificar si es PDF pero con contenido de texto (como el tuyo)
            elseif (strpos($firstBytes, '%PDF') !== false || 
                    strpos($firstBytes, 'PDF') !== false ||
                    strpos($firstBytes, '===== Page') !== false) {
                $isValid = true;
                $detectedType = "PDF en formato texto detectado";
            }
            // Verificar si es Word
            elseif (substr($firstBytes, 0, 2) === 'PK') {
                $isValid = true;
                $detectedType = "Word (.docx) - formato ZIP";
            }
            elseif (substr($firstBytes, 0, 8) === "\xD0\xCF\x11\xE0\xA1\xB1\x1A\xE1") {
                $isValid = true;
                $detectedType = "Word (.doc) - formato OLE";
            }
            
            // 4. Verificar con finfo (MIME real)
            if (function_exists('finfo_open')) {
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $realMime = finfo_file($finfo, $tempFile);
                
                // Lista ampliada de MIME aceptados
                $allowedMimes = [
                    'application/pdf',
                    'application/x-pdf',
                    'application/octet-stream',
                    'text/plain',        // Importante para tu archivo
                    'text/html',
                    'application/vnd.adobe.pdf',
                    'application/acrobat',
                    'application/msword',
                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                    'application/zip'
                ];
                
                if (in_array($realMime, $allowedMimes)) {
                    $isValid = true;
                    $detectedType = "MIME: $realMime";
                }
            }
            
            // 5. Verificar por extensión como último recurso
            if (!$isValid) {
                $extension = strtolower(pathinfo($_FILES['archivo']['name'], PATHINFO_EXTENSION));
                $allowedExtensions = ['pdf', 'doc', 'docx', 'txt'];
                
                if (in_array($extension, $allowedExtensions)) {
                    // Si la extensión es pdf o txt, aceptarlo
                    if ($extension === 'pdf' || $extension === 'txt') {
                        $isValid = true;
                        $detectedType = "Archivo con extensión .$extension aceptado";
                    }
                }
            }
            
            // 6. Validación final
            if (!$isValid) {
                $errorMsg = "No es un archivo válido. ";
                $errorMsg .= "Tipo detectado: $detectedType. ";
                $errorMsg .= "Solo se permiten archivos PDF o Word.";
                
                if ($realMime) {
                    $errorMsg .= " MIME real: $realMime";
                }
                
                $_SESSION['error'] = $errorMsg;
                
                error_log("Archivo rechazado: " . $_FILES['archivo']['name'] . 
                          " - MIME navegador: " . $_FILES['archivo']['type'] . 
                          " - MIME real: " . ($realMime ?? 'no detectado') . 
                          " - Primeros bytes: " . bin2hex(substr($firstBytes, 0, 20)));
                
                header('Location: /Aaapumac/callcenter/modals');
                exit();
            }
            
            // ========== FIN DE VALIDACIÓN ==========
            
            // Guardar información de depuración
            $_SESSION['upload_debug'] = "Archivo validado: $detectedType";
            
            // Generar nombre único
            $originalName = $_FILES['archivo']['name'];
            $fileExtension = pathinfo($originalName, PATHINFO_EXTENSION);
            $baseName = preg_replace('/[^a-zA-Z0-9_-]/', '', pathinfo($originalName, PATHINFO_FILENAME));
            $fileName = $baseName . '_' . uniqid() . '.' . $fileExtension;
            $uploadFile = $uploadDir . $fileName;
            
            if (file_exists($uploadFile)) {
                $fileName = $baseName . '_' . uniqid() . '_' . time() . '.' . $fileExtension;
                $uploadFile = $uploadDir . $fileName;
            }
            
            if (move_uploaded_file($_FILES['archivo']['tmp_name'], $uploadFile)) {
                $filePath = '/Aaapumac/src/views/assets/files/' . $fileName;
                $_POST['archivo'] = $filePath;
            } else {
                $_SESSION['error'] = "Error al subir el archivo. Verifique los permisos del servidor.";
                header('Location: /Aaapumac/callcenter/modals');
                exit();
            }
        } else {
            $errorCode = $_FILES['archivo']['error'] ?? 'No definido';
            $_SESSION['error'] = "Debe seleccionar un archivo válido. Error: $errorCode";
            header('Location: /Aaapumac/callcenter/modals');
            exit();
        }

        // Agregar fechas de creación
        $_POST['created_at'] = date('Y-m-d H:i:s');
        $_POST['updated_at'] = date('Y-m-d H:i:s');

        $aviso = callacenterRepository::addAviso();
        callacenterRepository::setAviso($aviso, $_POST);

        $_SESSION['success'] = "Aviso creado exitosamente";
        header('Location: /Aaapumac/callcenter/modals');
        exit();
    }
}

    public static function ActualizarAviso()
    {
        \Utils\AuthHelper::requireAuth(5);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];

            $avisoActual = callacenterRepository::findAviso($id);

            if (!$avisoActual) {
                $_SESSION['error'] = "El aviso no existe";
                header('Location: /Aaapumac/callcenter/modals');
                exit();
            }

            // Procesar la nueva imagen si se subió
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/Aaapumac/src/views/assets/img/modal/';

                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }

                $originalName = $_FILES['image']['name'];
                $fileExtension = pathinfo($originalName, PATHINFO_EXTENSION);
                $baseName = pathinfo($originalName, PATHINFO_FILENAME);
                $imageName = $baseName . '_' . uniqid() . '.' . $fileExtension;
                $uploadFile = $uploadDir . $imageName;

                if (file_exists($uploadFile)) {
                    $imageName = $baseName . '_' . uniqid() . '.' . $fileExtension;
                    $uploadFile = $uploadDir . $imageName;
                }

                if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                    // Eliminar la imagen anterior si existe
                    if ($avisoActual->getImage()) {
                        $oldImagePath = $_SERVER['DOCUMENT_ROOT'] . $avisoActual->getImage();
                        if (file_exists($oldImagePath) && is_file($oldImagePath)) {
                            unlink($oldImagePath);
                        }
                    }
                    $imagePath = '/Aaapumac/src/views/assets/img/modal/' . $imageName;
                    $_POST['image'] = $imagePath;
                }
            } else {
                $_POST['image'] = $avisoActual->getImage();
            }

            // Procesar el nuevo archivo si se subió - Usando 'archivo'
            if (isset($_FILES['archivo']) && $_FILES['archivo']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/Aaapumac/src/views/assets/files/';

                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }

                $allowedFileTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
                $fileType = $_FILES['archivo']['type'];

                if (!in_array($fileType, $allowedFileTypes)) {
                    $_SESSION['error'] = "Solo se permiten archivos PDF o Word";
                    header('Location: /Aaapumac/callcenter/modals');
                    exit();
                }

                $maxSize = 10 * 1024 * 1024; // 10MB
                if ($_FILES['archivo']['size'] > $maxSize) {
                    $_SESSION['error'] = "El archivo no debe exceder los 10MB";
                    header('Location: /Aaapumac/callcenter/modals');
                    exit();
                }

                $originalName = $_FILES['archivo']['name'];
                $fileExtension = pathinfo($originalName, PATHINFO_EXTENSION);
                $baseName = pathinfo($originalName, PATHINFO_FILENAME);
                $fileName = $baseName . '_' . uniqid() . '.' . $fileExtension;
                $uploadFile = $uploadDir . $fileName;

                if (file_exists($uploadFile)) {
                    $fileName = $baseName . '_' . uniqid() . '.' . $fileExtension;
                    $uploadFile = $uploadDir . $fileName;
                }

                if (move_uploaded_file($_FILES['archivo']['tmp_name'], $uploadFile)) {
                    // Eliminar el archivo anterior si existe
                    if ($avisoActual->getArchivo()) {
                        $oldFilePath = $_SERVER['DOCUMENT_ROOT'] . $avisoActual->getArchivo();
                        if (file_exists($oldFilePath) && is_file($oldFilePath)) {
                            unlink($oldFilePath);
                        }
                    }
                    $filePath = '/Aaapumac/src/views/assets/files/' . $fileName;
                    $_POST['archivo'] = $filePath;
                }
            } else {
                // Mantener el archivo actual si no se subió nuevo
                $_POST['archivo'] = $avisoActual->getArchivo();
            }

            // Verificar si el estado visible está cambiando
            $visibleChanged = false;
            if (isset($_POST['visible'])) {
                $currentVisible = $avisoActual->getVisible();
                $newVisible = $_POST['visible'];
                $visibleChanged = ($currentVisible != $newVisible);
            }

            if ($visibleChanged) {
                $_POST['created_at'] = date('Y-m-d H:i:s');
            }

            $_POST['updated_at'] = date('Y-m-d H:i:s');

            $result = callacenterRepository::updateAviso($id, $_POST);

            if ($result) {
                $_SESSION['success'] = "Aviso actualizado exitosamente";
            } else {
                $_SESSION['error'] = "Error al actualizar el aviso";
            }

            header('Location: /Aaapumac/callcenter/modals');
            exit();
        }
    }
    public static function ToggleAvisoStatus()
    {
        \Utils\AuthHelper::requireAuth(5);

        $isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];

            $avisoActual = callacenterRepository::findAviso($id);

            if (!$avisoActual) {
                if ($isAjax) {
                    echo json_encode(['success' => false, 'message' => 'El aviso no existe']);
                    exit();
                }
                $_SESSION['error'] = "El aviso no existe";
                header('Location: /Aaapumac/callcenter/modals');
                exit();
            }

            $newStatus = $avisoActual->getVisible() ? 0 : 1;
            $result = callacenterRepository::changeAvisoStatus($id, $newStatus);

            if ($result) {
                $statusText = $newStatus ? 'activado' : 'desactivado';

                // Mensaje especial cuando se reactiva
                if ($newStatus == 1) {
                    $message = "✅ Aviso reactivado exitosamente. ";
                    $message .= "El contador de 24 horas se ha reiniciado. ";
                    $message .= "Se desactivará automáticamente en 24 horas.";
                } else {
                    $message = "Aviso desactivado exitosamente.";
                }

                if ($isAjax) {
                    echo json_encode([
                        'success' => true,
                        'message' => $message,
                        'new_status' => $newStatus,
                        'reset_counter' => ($newStatus == 1) // Indica si se reinició contador
                    ]);
                    exit();
                }

                $_SESSION['success'] = $message;
            } else {
                // Manejo de error...
            }

            if (!$isAjax) {
                header('Location: /Aaapumac/callcenter/modals');
                exit();
            }
        }
    }

    public static function ForceUpdateDates()
    {
        \Utils\AuthHelper::requireAuth(5);

        // Solo aceptar AJAX
        $isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
            strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest';

        if (!$isAjax || $_SERVER['REQUEST_METHOD'] != 'POST') {
            header('HTTP/1.1 403 Forbidden');
            exit();
        }

        // Leer datos JSON
        $input = json_decode(file_get_contents('php://input'), true);
        $id = $input['id'] ?? null;
        $updateCreatedAt = $input['update_created_at'] ?? false;

        if (!$id) {
            echo json_encode([
                'success' => false,
                'message' => 'ID requerido'
            ]);
            exit();
        }

        // Obtener el aviso actual
        $avisoActual = callacenterRepository::findAviso($id);

        if (!$avisoActual) {
            echo json_encode([
                'success' => false,
                'message' => 'Aviso no encontrado'
            ]);
            exit();
        }

        // Preparar datos de actualización
        $updateData = [
            'updated_at' => date('Y-m-d H:i:s')
        ];

        if ($updateCreatedAt) {
            $updateData['created_at'] = date('Y-m-d H:i:s');
        }

        // Actualizar fechas directamente en la base de datos
        $result = callacenterRepository::updateDates($id, $updateData);

        if ($result) {
            echo json_encode([
                'success' => true,
                'message' => $updateCreatedAt
                    ? 'Fechas created_at y updated_at actualizadas'
                    : 'Fecha updated_at actualizada'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Error al actualizar fechas'
            ]);
        }
        exit();
    }
        public static function convenio()
    {
        \Utils\AuthHelper::requireAuth(5);
        return [
            'view' => 'callcenter/home.php',
            'scripts' => 'callcenter',
            'action' => 'convenio',
            'data' => [
                'title' => 'Convenios',
                'subtitle' => 'Consulta nuestros convenios y beneficios exclusivos para asociados',
                'button' => 'Ver convenios disponibles',
                'icon' => 'mdi mdi-handshake-outline',
            ],
        ];
    }
}
?>