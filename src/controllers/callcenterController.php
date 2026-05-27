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
        
        // Detectar si POST fue rechazado por exceder post_max_size
        if (empty($_POST) && empty($_FILES) && !empty($_SERVER['CONTENT_LENGTH'])) {
            $postMaxSize = ini_get('post_max_size');
            $uploadMaxFilesize = ini_get('upload_max_filesize');
            $_SESSION['error'] = "El tamaño total de la solicitud excede el límite del servidor. " .
                                "post_max_size=$postMaxSize, upload_max_filesize=$uploadMaxFilesize. " .
                                "Intente con archivos más pequeños o contacte al administrador.";
            header('Location: /Aaapumac/callcenter/modals');
            exit();
        }
        
        // ---------- PROCESAR IMAGEN (obligatoria, igual que antes) ----------
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

        // ---------- PROCESAR MÚLTIPLES ARCHIVOS PDF ----------
        $archivosPaths = [];
        if (isset($_FILES['archivos']) && !empty($_FILES['archivos']['name'][0])) {
            $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/Aaapumac/src/views/assets/files/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $totalFiles = count($_FILES['archivos']['name']);
            $maxSize = 10 * 1024 * 1024; // 10 MB por archivo

            for ($i = 0; $i < $totalFiles; $i++) {
                // Validar errores de subida
                if ($_FILES['archivos']['error'][$i] !== UPLOAD_ERR_OK) {
                    $errorCode = $_FILES['archivos']['error'][$i];
                    $errorMsg = "Error en el archivo " . htmlspecialchars($_FILES['archivos']['name'][$i]) . " (código: $errorCode)";
                    switch ($errorCode) {
                        case UPLOAD_ERR_INI_SIZE:
                        case UPLOAD_ERR_FORM_SIZE:
                            $errorMsg = "El archivo " . htmlspecialchars($_FILES['archivos']['name'][$i]) . " excede el tamaño máximo permitido.";
                            break;
                        case UPLOAD_ERR_PARTIAL:
                            $errorMsg = "El archivo " . htmlspecialchars($_FILES['archivos']['name'][$i]) . " se subió parcialmente.";
                            break;
                    }
                    $_SESSION['error'] = $errorMsg;
                    header('Location: /Aaapumac/callcenter/modals');
                    exit();
                }

                // Validar tamaño
                if ($_FILES['archivos']['size'][$i] > $maxSize) {
                    $_SESSION['error'] = "El archivo " . htmlspecialchars($_FILES['archivos']['name'][$i]) . " excede los 10MB";
                    header('Location: /Aaapumac/callcenter/modals');
                    exit();
                }

                // Validar tipo de contenido (MIME)
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $mime = finfo_file($finfo, $_FILES['archivos']['tmp_name'][$i]);
                finfo_close($finfo);
                
                // Lista ampliada de MIME aceptados (incluyendo text/plain por si viene como texto)
                $allowedMimes = ['application/pdf', 'application/x-pdf', 'text/plain', 'application/octet-stream'];
                if (!in_array($mime, $allowedMimes)) {
                    // Verificar firma manual como respaldo
                    $handle = fopen($_FILES['archivos']['tmp_name'][$i], 'rb');
                    $firstBytes = fread($handle, 1024);
                    fclose($handle);
                    if (strpos($firstBytes, '%PDF') === false && strpos($firstBytes, 'PDF') === false) {
                        $_SESSION['error'] = "El archivo " . htmlspecialchars($_FILES['archivos']['name'][$i]) . " no es un PDF válido (MIME: $mime)";
                        header('Location: /Aaapumac/callcenter/modals');
                        exit();
                    }
                }

                // Generar nombre único y mover archivo
                $originalName = $_FILES['archivos']['name'][$i];
                $fileExtension = pathinfo($originalName, PATHINFO_EXTENSION);
                $baseName = preg_replace('/[^a-zA-Z0-9_-]/', '', pathinfo($originalName, PATHINFO_FILENAME));
                $fileName = $baseName . '_' . uniqid() . '.' . $fileExtension;
                $uploadFile = $uploadDir . $fileName;

                // Evitar colisiones
                if (file_exists($uploadFile)) {
                    $fileName = $baseName . '_' . uniqid() . '_' . time() . '.' . $fileExtension;
                    $uploadFile = $uploadDir . $fileName;
                }

                if (move_uploaded_file($_FILES['archivos']['tmp_name'][$i], $uploadFile)) {
                    $archivosPaths[] = '/Aaapumac/src/views/assets/files/' . $fileName;
                } else {
                    $_SESSION['error'] = "Error al guardar el archivo " . htmlspecialchars($originalName) . ". Permisos insuficientes.";
                    header('Location: /Aaapumac/callcenter/modals');
                    exit();
                }
            }
        } else {
            // Si no se selecciona ningún archivo, puedes decidir si es obligatorio o no.
            // Aquí lo tratamos como opcional, pero si quieres que sea obligatorio, descomenta:
            // $_SESSION['error'] = "Debe seleccionar al menos un archivo PDF";
            // header('Location: /Aaapumac/callcenter/modals');
            // exit();
        }

        // Guardar el array de rutas como JSON en $_POST['archivo']
        $_POST['archivo'] = json_encode($archivosPaths);

        // Agregar fechas de creación y actualización
        $_POST['created_at'] = date('Y-m-d H:i:s');
        $_POST['updated_at'] = date('Y-m-d H:i:s');

        // Crear el aviso en la base de datos mediante el repositorio
        $aviso = callacenterRepository::addAviso();
        callacenterRepository::setAviso($aviso, $_POST);

        $_SESSION['success'] = "Aviso creado exitosamente con " . count($archivosPaths) . " archivo(s) adjunto(s).";
        header('Location: /Aaapumac/callcenter/modals');
        exit();
    }
}

   public static function ActualizarAviso()
{
    \Utils\AuthHelper::requireAuth(5);

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        
        // Detectar si POST fue rechazado por exceder post_max_size
        if (empty($_POST) && empty($_FILES) && !empty($_SERVER['CONTENT_LENGTH'])) {
            $postMaxSize = ini_get('post_max_size');
            $uploadMaxFilesize = ini_get('upload_max_filesize');
            $_SESSION['error'] = "El tamaño total de la solicitud excede el límite del servidor. " .
                                "post_max_size=$postMaxSize, upload_max_filesize=$uploadMaxFilesize. " .
                                "Intente con archivos más pequeños o contacte al administrador.";
            header('Location: /Aaapumac/callcenter/modals');
            exit();
        }
        
        $id = $_POST['id'];
        $avisoActual = callacenterRepository::findAviso($id);
        
        if (!$avisoActual) {
            $_SESSION['error'] = "El aviso no existe";
            header('Location: /Aaapumac/callcenter/modals');
            exit();
        }

        // ---------- PROCESAR IMAGEN (si se sube nueva) ----------
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
                // Eliminar imagen anterior si existe
                $oldImage = $avisoActual->getImage();
                if ($oldImage && file_exists($_SERVER['DOCUMENT_ROOT'] . $oldImage)) {
                    unlink($_SERVER['DOCUMENT_ROOT'] . $oldImage);
                }
                $_POST['image'] = '/Aaapumac/src/views/assets/img/modal/' . $imageName;
            } else {
                $_SESSION['error'] = "Error al subir la nueva imagen";
                header('Location: /Aaapumac/callcenter/modals');
                exit();
            }
        } else {
            // Mantener la imagen actual
            $_POST['image'] = $avisoActual->getImage();
        }

        // ---------- GESTIÓN DE MÚLTIPLES ARCHIVOS PDF ----------
        // Obtener array actual de archivos (el modelo ya decodifica JSON)
        $archivosActuales = $avisoActual->getArchivosArray();

        // 1. Eliminar archivos marcados por el usuario
        if (isset($_POST['eliminar_archivos']) && is_array($_POST['eliminar_archivos'])) {
            foreach ($_POST['eliminar_archivos'] as $ruta) {
                // Eliminar físicamente el archivo del servidor
                $fullPath = $_SERVER['DOCUMENT_ROOT'] . $ruta;
                if (file_exists($fullPath) && is_file($fullPath)) {
                    unlink($fullPath);
                }
                // Eliminar del array
                $key = array_search($ruta, $archivosActuales);
                if ($key !== false) {
                    unset($archivosActuales[$key]);
                }
            }
            // Reindexar array
            $archivosActuales = array_values($archivosActuales);
        }

        // 2. Agregar nuevos archivos (input name="nuevos_archivos[]")
        if (isset($_FILES['nuevos_archivos']) && !empty($_FILES['nuevos_archivos']['name'][0])) {
            $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/Aaapumac/src/views/assets/files/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $totalFiles = count($_FILES['nuevos_archivos']['name']);
            $maxSize = 10 * 1024 * 1024; // 10 MB

            for ($i = 0; $i < $totalFiles; $i++) {
                if ($_FILES['nuevos_archivos']['error'][$i] !== UPLOAD_ERR_OK) {
                    $_SESSION['error'] = "Error en nuevo archivo: " . htmlspecialchars($_FILES['nuevos_archivos']['name'][$i]);
                    header('Location: /Aaapumac/callcenter/modals');
                    exit();
                }
                if ($_FILES['nuevos_archivos']['size'][$i] > $maxSize) {
                    $_SESSION['error'] = "El archivo " . htmlspecialchars($_FILES['nuevos_archivos']['name'][$i]) . " excede 10MB";
                    header('Location: /Aaapumac/callcenter/modals');
                    exit();
                }

                // Validar MIME con finfo
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $mime = finfo_file($finfo, $_FILES['nuevos_archivos']['tmp_name'][$i]);
                finfo_close($finfo);
                
                $allowedMimes = ['application/pdf', 'application/x-pdf', 'text/plain', 'application/octet-stream'];
                if (!in_array($mime, $allowedMimes)) {
                    // Verificar firma PDF como respaldo
                    $handle = fopen($_FILES['nuevos_archivos']['tmp_name'][$i], 'rb');
                    $firstBytes = fread($handle, 1024);
                    fclose($handle);
                    if (strpos($firstBytes, '%PDF') === false && strpos($firstBytes, 'PDF') === false) {
                        $_SESSION['error'] = "El archivo " . htmlspecialchars($_FILES['nuevos_archivos']['name'][$i]) . " no es un PDF válido";
                        header('Location: /Aaapumac/callcenter/modals');
                        exit();
                    }
                }

                // Generar nombre único
                $originalName = $_FILES['nuevos_archivos']['name'][$i];
                $fileExtension = pathinfo($originalName, PATHINFO_EXTENSION);
                $baseName = preg_replace('/[^a-zA-Z0-9_-]/', '', pathinfo($originalName, PATHINFO_FILENAME));
                $fileName = $baseName . '_' . uniqid() . '.' . $fileExtension;
                $uploadFile = $uploadDir . $fileName;

                if (file_exists($uploadFile)) {
                    $fileName = $baseName . '_' . uniqid() . '_' . time() . '.' . $fileExtension;
                    $uploadFile = $uploadDir . $fileName;
                }

                if (move_uploaded_file($_FILES['nuevos_archivos']['tmp_name'][$i], $uploadFile)) {
                    $archivosActuales[] = '/Aaapumac/src/views/assets/files/' . $fileName;
                } else {
                    $_SESSION['error'] = "Error al guardar el archivo " . htmlspecialchars($originalName);
                    header('Location: /Aaapumac/callcenter/modals');
                    exit();
                }
            }
        }

        // Guardar el array actualizado como JSON en $_POST['archivo']
        $_POST['archivo'] = json_encode($archivosActuales);

        // ---------- MANEJO DE ESTADO Y FECHAS ----------
        $visibleChanged = false;
        if (isset($_POST['visible'])) {
            $currentVisible = $avisoActual->getVisible();
            $newVisible = (int)$_POST['visible'];
            $visibleChanged = ($currentVisible != $newVisible);
            
            // Si se está activando (de 0 a 1), reiniciar created_at (inicio del ciclo de 24h)
            if ($visibleChanged && $newVisible == 1) {
                $_POST['created_at'] = date('Y-m-d H:i:s');
            } else {
                // Mantener el created_at original si no cambia a activo
                $_POST['created_at'] = $avisoActual->getCreatedAt();
            }
        } else {
            $_POST['visible'] = $avisoActual->getVisible();
            $_POST['created_at'] = $avisoActual->getCreatedAt();
        }

        // Siempre actualizar updated_at
        $_POST['updated_at'] = date('Y-m-d H:i:s');

        // ---------- ACTUALIZAR EN BASE DE DATOS ----------
        $result = callacenterRepository::updateAviso($id, $_POST);

        if ($result) {
            $mensaje = "Aviso actualizado exitosamente.";
            if ($visibleChanged && $_POST['visible'] == 1) {
                $mensaje .= " El aviso ha sido reactivado, el contador de 24 horas se ha reiniciado.";
            }
            $_SESSION['success'] = $mensaje;
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